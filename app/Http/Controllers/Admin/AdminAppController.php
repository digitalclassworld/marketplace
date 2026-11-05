<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AppFeature;
use App\Models\AppSetting;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminAppController extends Controller
{
    /**
     * Display the App Management studio.
     */
    public function index(Request $request): View
    {
        $platform = $request->query('platform', 'android');

        $setting = AppSetting::firstOrCreate(
            ['platform' => $platform],
            [
                'app_name'          => 'Digital Class',
                'package_name'      => 'com.digitalclass.app',
                'bundle_id'         => 'com.digitalclass.app',
                'description'       => 'Your complete educational ecosystem - Courses, Services, Marketplace and Institute Management.',
                'short_description' => 'Learn. Teach. Grow. All in one app - Digital Class.',
                'current_version'   => 'v2.4.0',
                'status'            => 'Live',
                'total_downloads'   => 90540,
                'active_users'      => 12840,
                'rating'            => 4.6,
                'crash_rate'        => 0.8,
                'last_released_at'  => Carbon::parse('2026-10-12 10:30:00'),
            ]
        );

        $features = AppFeature::orderBy('order_index')->get();

        $kpi = [
            'total_downloads'  => '90,540',
            'downloads_growth' => '+28%',
            'downloads_sub'    => '+18,240 this month',
            'active_users'     => '12,840',
            'users_growth'     => '+35%',
            'users_sub'        => '28% of total downloads',
            'rating'           => '4.6 / 5',
            'rating_sub'       => '+0.3 this month',
            'crash_rate'       => '0.8%',
            'crash_growth'     => '+42%',
            'crash_sub'        => 'Last 30 days',
            'current_version'  => 'v2.4.0',
            'version_sub'      => 'Current Live Version',
            'last_updated'     => '12 Oct 2026',
            'last_updated_time'=> '10:30 AM',
        ];

        return view('admin.app.index', [
            'setting'  => $setting,
            'platform' => $platform,
            'features' => $features,
            'kpi'      => $kpi,
        ]);
    }

    /**
     * Update Basic App Information.
     */
    public function updateInfo(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'platform'          => 'required|string',
            'app_name'          => 'required|string|max:50',
            'package_name'      => 'nullable|string|max:100',
            'bundle_id'         => 'nullable|string|max:100',
            'description'       => 'nullable|string|max:200',
            'short_description' => 'nullable|string|max:80',
        ]);

        $setting = AppSetting::firstOrCreate(['platform' => $validated['platform']]);
        $setting->update($validated);

        return redirect()->route('admin.app.index', ['platform' => $validated['platform']])
            ->with('success', 'App information and configuration updated successfully!');
    }

    /**
     * Toggle individual feature module on/off in real-time.
     */
    public function toggleFeature(Request $request, int $id): JsonResponse|RedirectResponse
    {
        $feature = AppFeature::findOrFail($id);
        $feature->is_enabled = !$feature->is_enabled;
        $feature->save();

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success'    => true,
                'feature_id' => $feature->id,
                'key'        => $feature->key,
                'is_enabled' => $feature->is_enabled,
                'message'    => "Feature '{$feature->name}' is now " . ($feature->is_enabled ? 'enabled' : 'disabled') . '.',
            ]);
        }

        return redirect()->back()->with('success', "Feature '{$feature->name}' updated.");
    }

    /**
     * Schedule or Publish a new App release version.
     */
    public function publishVersion(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'platform'    => 'required|string',
            'version'     => 'nullable|string',
            'action_type' => 'nullable|string', // 'schedule' or 'publish'
        ]);

        $setting = AppSetting::firstOrCreate(['platform' => $validated['platform']]);

        $newVersion = $validated['version'] ?: 'v2.4.1';
        $setting->current_version = $newVersion;
        $setting->last_released_at = Carbon::now();
        $setting->status = 'Live';
        $setting->save();

        return redirect()->route('admin.app.index', ['platform' => $validated['platform']])
            ->with('success', "Version {$newVersion} published successfully to {$setting->platform} store!");
    }
}
