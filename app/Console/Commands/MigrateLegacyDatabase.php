<?php

namespace App\Console\Commands;

use App\Services\Migration\LegacyMigrationManager;
use App\Services\Migration\LegacySqlParser;
use Illuminate\Console\Command;

class MigrateLegacyDatabase extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'marketplace:migrate-legacy
                            {--dry-run : Run in simulation mode without committing changes}
                            {--limit= : Limit the number of records per table (useful for testing)}
                            {--entity=all : Target entity (all, users, tutors, affiliates, courses, curriculums, leads)}
                            {--file= : Custom path to the legacy SQL dump file}
                            {--force : Force live migration without interactive confirmation prompt}';

    /**
     * The console command description.
     */
    protected $description = 'Intelligently migrates legacy data from digitix_elm SQL dump into the new marketplace platform';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $dryRun = $this->option('dry-run');
        $limit = $this->option('limit') ? (int)$this->option('limit') : null;
        $entity = strtolower($this->option('entity') ?: 'all');
        $filePath = $this->option('file');

        $mode = $dryRun ? 'dry_run' : 'live';

        $this->newLine();
        $this->line('========================================================================');
        $this->info(' DIGITAL CLASS MARKETPLACE - LEGACY DATABASE MIGRATION ENGINE');
        $this->line('========================================================================');
        $this->line(" Execution Mode : " . ($dryRun ? '<fg=yellow;options=bold>DRY RUN (Simulation - Zero Database Modification)</>' : '<fg=green;options=bold>LIVE MIGRATION (Writing to MySQL Database)</>'));
        $this->line(" Target Entity  : <fg=cyan>{$entity}</>");
        $this->line(" Record Limit   : " . ($limit ? "<fg=yellow>{$limit} per entity</>" : "<fg=green>ALL RECORDS</>"));
        $this->line('========================================================================');
        $this->newLine();

        if (!$dryRun && !$this->option('force') && !$this->confirm('You are about to execute LIVE migration into the production marketplace database. Do you wish to proceed?', true)) {
            $this->warn('Migration aborted by user.');
            return 0;
        }

        try {
            $parser = new LegacySqlParser($filePath);
            $this->comment("Source SQL Dump: " . $parser->getFilePath() . " (" . round(filesize($parser->getFilePath()) / (1024 * 1024), 2) . " MB)");

            $manager = new LegacyMigrationManager($mode, $parser);

            // Connect Artisan CLI logger
            $manager->setLogger(function (string $message, string $type = 'info') {
                $timestamp = date('H:i:s');
                match ($type) {
                    'error' => $this->error("[{$timestamp}] {$message}"),
                    'warn' => $this->warn("[{$timestamp}] {$message}"),
                    'success' => $this->info("[{$timestamp}] <fg=green;options=bold>✓ {$message}</>"),
                    default => $this->line("[{$timestamp}] {$message}"),
                };
            });

            $this->newLine();
            $result = $manager->execute($limit, $entity);

            $this->newLine();
            $this->line('========================================================================');
            $this->info(' MIGRATION RESULTS SUMMARY');
            $this->line('========================================================================');

            $tableRows = [];
            foreach ($result['stats'] as $ent => $s) {
                $tableRows[] = [
                    ucfirst($ent),
                    number_format($s['processed']),
                    number_format($s['migrated']),
                    number_format($s['duplicates']),
                    number_format($s['skipped']),
                ];
            }

            $this->table(
                ['Entity', 'Processed', 'Migrated', 'Duplicates Linked', 'Skipped/Orphan'],
                $tableRows
            );

            $this->newLine();
            $this->line("Batch Code        : <fg=cyan>{$result['batch_code']}</>");
            $this->line("Total Migrated    : <fg=green;options=bold>" . number_format($result['total_migrated']) . " records</>");
            $this->line("Total Duplicates  : <fg=yellow>" . number_format($result['total_duplicates']) . " records linked to existing</>");
            $this->line("Time Elapsed      : {$result['elapsed_seconds']} seconds");
            $this->line('========================================================================');
            $this->newLine();

            if ($dryRun) {
                $this->info('DRY RUN COMPLETE. No data was modified in the database. Safe to run live.');
            } else {
                $this->info('LIVE MIGRATION COMPLETE. All legacy records successfully committed!');
            }

            return 0;

        } catch (\Throwable $e) {
            $this->newLine();
            $this->error('MIGRATION FAILED: ' . $e->getMessage());
            $this->line($e->getTraceAsString());
            return 1;
        }
    }
}
