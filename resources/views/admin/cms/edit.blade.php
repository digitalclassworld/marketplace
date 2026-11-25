@extends('admin.layouts.admin')

@section('title', 'Edit Blog Post - ' . $post->title)

@section('styles')
<style>
    .cms-form-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 1.35rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.03);
    }

    .editor-toolbar {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-bottom: none;
        border-radius: 8px 8px 0 0;
        padding: 0.5rem 0.75rem;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 0.5rem;
    }
    .editor-toolbar button {
        background: transparent;
        border: none;
        color: #475569;
        font-size: 0.85rem;
        padding: 0.25rem 0.45rem;
        border-radius: 4px;
        transition: background-color 0.15s ease;
    }
    .editor-toolbar button:hover {
        background: #e2e8f0;
        color: #0f172a;
    }

    .editor-body {
        border: 1px solid #e2e8f0;
        border-radius: 0 0 8px 8px;
        padding: 1rem;
        min-height: 320px;
        outline: none;
        font-size: 0.9rem;
        line-height: 1.7;
        background: #ffffff;
    }

    .tag-chip {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        background: #eff6ff;
        color: #1d4ed8;
        font-size: 0.75rem;
        font-weight: 600;
        padding: 0.25rem 0.6rem;
        border-radius: 20px;
        margin-right: 0.35rem;
        margin-bottom: 0.35rem;
    }
    .tag-chip .remove-tag {
        cursor: pointer;
        font-size: 0.8rem;
    }
    .tag-chip .remove-tag:hover {
        color: #dc2626;
    }

    .char-count {
        font-size: 0.72rem;
        color: #94a3b8;
    }
</style>
@endsection

@section('content')
<div class="container-fluid px-4 py-3">

    {{-- Form element enclosing both columns --}}
    <form action="{{ route('admin.cms.update', $post->id) }}" method="POST" id="editPostForm" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <input type="hidden" name="status" id="postStatusInput" value="{{ $post->status }}">

        {{-- Breadcrumb & Top Header --}}
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
            <div>
                <div class="d-flex align-items-center gap-1.5 text-muted small mb-1">
                    <a href="{{ route('admin.cms.index') }}" class="text-decoration-none text-muted">
                        <i class="fa-solid fa-arrow-left me-1"></i> Blog & CMS
                    </a>
                    <span>&gt;</span>
                    <span class="text-dark fw-semibold">Edit Post #{{ $post->id }}</span>
                </div>
                <h1 class="h3 fw-bold text-dark mb-1">Edit Blog Post</h1>
                <p class="text-muted small mb-0">Update content, SEO tags, or publication settings.</p>
            </div>

            <div class="d-flex align-items-center gap-2">
                {{-- View Live --}}
                <a href="{{ route('blog.show', $post->slug) }}" target="_blank" class="btn btn-outline-info px-3 py-2 fw-medium shadow-sm">
                    <i class="fa-regular fa-eye me-1.5"></i> View Live
                </a>

                {{-- Back button --}}
                <a href="{{ route('admin.cms.index') }}" class="btn btn-white border bg-white text-secondary px-3 py-2 fw-medium shadow-sm">
                    <i class="fa-solid fa-arrow-left me-1 text-muted"></i> Back
                </a>

                {{-- Save Changes button --}}
                <div class="btn-group shadow-sm">
                    <button type="button" class="btn btn-primary px-3 py-2 fw-medium" style="background-color: #0066ff; border-color: #0066ff;" onclick="submitPostWithStatus('{{ $post->status }}')">
                        <i class="fa-regular fa-floppy-disk me-1.5"></i> Save Changes
                    </button>
                    <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" style="background-color: #005ce6; border-color: #005ce6;" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="visually-hidden">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0" style="font-size: 0.8rem;">
                        <li><a class="dropdown-item py-1.5" href="javascript:void(0)" onclick="submitPostWithStatus('Published')">Set as Published</a></li>
                        <li><a class="dropdown-item py-1.5" href="javascript:void(0)" onclick="submitPostWithStatus('Draft')">Set as Draft</a></li>
                        <li><a class="dropdown-item py-1.5" href="javascript:void(0)" onclick="submitPostWithStatus('Scheduled')">Schedule Publication</a></li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- Main 2-Column Split --}}
        <div class="row g-3">
            {{-- LEFT COLUMN (~70%) --}}
            <div class="col-xl-8 col-lg-7 col-12">
                <div class="cms-form-card mb-3">
                    {{-- Title --}}
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <label class="form-label small fw-bold text-dark mb-0">Title <span class="text-danger">*</span></label>
                            <span class="char-count" id="titleCount">{{ strlen($post->title) }}/200</span>
                        </div>
                        <input type="text" name="title" id="postTitle" class="form-control"
                               value="{{ old('title', $post->title) }}"
                               placeholder="Enter post title..." required maxlength="200"
                               oninput="updateTitleMeta(this.value)">
                    </div>

                    {{-- Slug --}}
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <label class="form-label small fw-bold text-dark mb-0">Slug <span class="text-danger">*</span></label>
                        </div>
                        <div class="input-group">
                            <input type="text" name="slug" id="postSlug" class="form-control font-monospace"
                                   value="{{ old('slug', $post->slug) }}" required oninput="updateUrlPreview(this.value)">
                            <button type="button" class="btn btn-outline-secondary" onclick="generateSlugFromTitle()">
                                Generate
                            </button>
                        </div>
                        <div class="text-muted small mt-1" style="font-size: 0.72rem;">
                            URL: <span class="text-primary font-monospace" id="urlPreview">{{ url('/blog/' . $post->slug) }}</span>
                        </div>
                    </div>

                    {{-- Excerpt / Short Description --}}
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <label class="form-label small fw-bold text-dark mb-0">Excerpt / Short Description</label>
                            <span class="char-count" id="excerptCount">{{ strlen($post->excerpt ?? '') }}/300</span>
                        </div>
                        <textarea name="excerpt" id="postExcerpt" rows="2" class="form-control" maxlength="300"
                                  oninput="document.getElementById('excerptCount').innerText = this.value.length + '/300'">{{ old('excerpt', $post->excerpt) }}</textarea>
                    </div>

                    {{-- Content Rich Editor --}}
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <label class="form-label small fw-bold text-dark mb-0">Content <span class="text-danger">*</span></label>
                            <span class="text-muted small" style="font-size: 0.72rem;">Supports full HTML & headings</span>
                        </div>

                        {{-- Toolbar --}}
                        <div class="editor-toolbar">
                            <select class="form-select form-select-sm border-0 bg-transparent text-secondary py-0 pe-4" style="width: 110px; font-size: 0.8rem;" onchange="formatBlock(this.value)">
                                <option value="p">Paragraph</option>
                                <option value="h2">Heading 2</option>
                                <option value="h3">Heading 3</option>
                                <option value="h4">Heading 4</option>
                            </select>
                            <span class="text-muted">|</span>
                            <button type="button" title="Bold" onclick="document.execCommand('bold')"><strong>B</strong></button>
                            <button type="button" title="Italic" onclick="document.execCommand('italic')"><em>I</em></button>
                            <button type="button" title="Underline" onclick="document.execCommand('underline')"><u>U</u></button>
                            <button type="button" title="Strikethrough" onclick="document.execCommand('strikeThrough')"><s>S</s></button>
                            <span class="text-muted">|</span>
                            <button type="button" title="Bullet List" onclick="document.execCommand('insertUnorderedList')"><i class="fa-solid fa-list-ul"></i></button>
                            <button type="button" title="Numbered List" onclick="document.execCommand('insertOrderedList')"><i class="fa-solid fa-list-ol"></i></button>
                            <button type="button" title="Blockquote" onclick="document.execCommand('formatBlock', false, 'blockquote')"><i class="fa-solid fa-quote-left"></i></button>
                            <span class="text-muted">|</span>
                            <button type="button" title="Link" onclick="addLink()"><i class="fa-solid fa-link"></i></button>
                            <button type="button" title="Undo" onclick="document.execCommand('undo')"><i class="fa-solid fa-rotate-left"></i></button>
                            <button type="button" title="Redo" onclick="document.execCommand('redo')"><i class="fa-solid fa-rotate-right"></i></button>
                        </div>

                        {{-- Hidden textarea synced with contenteditable --}}
                        <textarea name="content" id="hiddenContent" style="display: none;">{{ old('content', $post->content) }}</textarea>

                        {{-- Visual Editor Box --}}
                        <div class="editor-body" id="richEditor" contenteditable="true" oninput="syncEditorContent()">
                            {!! old('content', $post->content) !!}
                        </div>

                        <div class="d-flex justify-content-between text-muted small mt-1.5" style="font-size: 0.72rem;">
                            <span id="editorStats">Word Count: Calculating...</span>
                            <span class="badge bg-light text-secondary border px-2 py-1">Views: {{ number_format($post->views) }}</span>
                        </div>
                    </div>
                </div>

                {{-- SEO Settings Card --}}
                <div class="cms-form-card">
                    <h6 class="fw-bold text-dark mb-3 fs-6">SEO Settings</h6>

                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <label class="form-label small fw-bold text-dark mb-0">Meta Title</label>
                            <span class="char-count" id="metaTitleCount">{{ strlen($post->meta_title ?? '') }}/60</span>
                        </div>
                        <input type="text" name="meta_title" id="metaTitle" class="form-control"
                               value="{{ old('meta_title', $post->meta_title) }}" maxlength="60"
                               oninput="document.getElementById('metaTitleCount').innerText = this.value.length + '/60'">
                    </div>

                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <label class="form-label small fw-bold text-dark mb-0">Meta Description</label>
                            <span class="char-count" id="metaDescCount">{{ strlen($post->meta_description ?? '') }}/160</span>
                        </div>
                        <textarea name="meta_description" id="metaDesc" rows="2" class="form-control" maxlength="160"
                                  oninput="document.getElementById('metaDescCount').innerText = this.value.length + '/160'">{{ old('meta_description', $post->meta_description) }}</textarea>
                    </div>

                    <div class="mb-2">
                        <label class="form-label small fw-bold text-dark mb-1">Focus Keyword</label>
                        <input type="text" name="focus_keyword" class="form-control" value="{{ old('focus_keyword', $post->focus_keyword) }}">
                        <span class="text-muted" style="font-size: 0.72rem;">Primary keyword for search engines.</span>
                    </div>
                </div>
            </div>

            {{-- RIGHT COLUMN (~30%) --}}
            <div class="col-xl-4 col-lg-5 col-12">
                {{-- 1. Featured Image Card --}}
                <div class="cms-form-card mb-3">
                    <h6 class="fw-bold text-dark mb-2.5 fs-6">Featured Image</h6>
                    <input type="hidden" name="featured_image" id="featuredImageUrl" value="{{ old('featured_image', $post->featured_image) }}">
                    <input type="file" name="featured_image_file" id="featuredImageFileInput" class="d-none" accept="image/*" onchange="previewSelectedImage(this)">

                    {{-- Image Preview --}}
                    <div class="position-relative mb-2 rounded-3 overflow-hidden border">
                        <img id="imagePreview" src="{{ $post->featured_image_url }}" alt="Featured Preview" class="w-100" style="height: 160px; object-fit: cover;">
                        <div class="position-absolute bottom-0 start-0 end-0 bg-dark bg-opacity-75 text-white p-2 text-center" id="imageOverlayTitle" style="font-size: 0.8rem; font-weight: 700;">
                            {{ $post->title }}
                        </div>
                    </div>

                    <div class="d-flex align-items-center gap-2 mb-2">
                        <button type="button" class="btn btn-primary btn-sm flex-grow-1" style="font-size: 0.75rem; background-color: #0066ff;" onclick="document.getElementById('featuredImageFileInput').click()">
                            <i class="fa-solid fa-arrow-up-from-bracket me-1"></i> Upload New Image
                        </button>
                        <button type="button" class="btn btn-outline-secondary btn-sm" style="font-size: 0.75rem;" onclick="promptImageChange()" title="Or paste image URL">
                            <i class="fa-solid fa-link"></i> URL
                        </button>
                        <button type="button" class="btn btn-outline-danger btn-sm" style="font-size: 0.75rem;" onclick="removeImage()">
                            <i class="fa-regular fa-trash-can"></i>
                        </button>
                    </div>

                    <div class="text-muted" style="font-size: 0.7rem;">
                        Recommended: 1200 x 630 px (JPG/PNG/WebP)<br>
                        Selected: <span class="font-monospace text-secondary" id="selectedImageFileName">{{ basename($post->featured_image ?: 'default.jpg') }}</span>
                    </div>
                </div>

                {{-- 2. Categories Card --}}
                <div class="cms-form-card mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-2.5">
                        <h6 class="fw-bold text-dark mb-0 fs-6">Category <span class="text-danger">*</span></h6>
                    </div>

                    <div class="row g-2" style="font-size: 0.8rem;">
                        @php
                            $catList = ['Technology', 'Business', 'Marketing', 'Education', 'Tutorials', 'Career', 'News & Updates', 'Others'];
                            $currentCat = old('category', $post->category);
                        @endphp
                        @foreach($catList as $catItem)
                            <div class="col-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="category" value="{{ $catItem }}" id="cat_{{ Str::slug($catItem) }}" {{ $currentCat === $catItem ? 'checked' : '' }}>
                                    <label class="form-check-label text-dark" for="cat_{{ Str::slug($catItem) }}">{{ $catItem }}</label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- 3. Tags Card --}}
                <div class="cms-form-card mb-3">
                    <h6 class="fw-bold text-dark mb-2 fs-6">Tags</h6>
                    @php
                        $tagsStr = is_array($post->tags) ? implode(',', $post->tags) : ($post->tags ?? '');
                    @endphp
                    <input type="hidden" name="tags" id="tagsHiddenInput" value="{{ $tagsStr }}">

                    <div id="tagsContainer" class="mb-2">
                        {{-- Injected dynamically by JS --}}
                    </div>

                    <input type="text" id="tagInput" class="form-control form-control-sm"
                           placeholder="Type tag & press Enter..." onkeydown="handleTagKey(event)">
                    <span class="text-muted" style="font-size: 0.7rem;">Press Enter to add tags.</span>
                </div>

                {{-- 4. Publication Settings --}}
                <div class="cms-form-card mb-3">
                    <h6 class="fw-bold text-dark mb-2.5 fs-6">Publish Status</h6>

                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="status_radio" id="statusPub" value="Published" {{ $post->status === 'Published' ? 'checked' : '' }} onchange="updatePostStatus('Published')">
                        <label class="form-check-label small fw-semibold text-success" for="statusPub">
                            <i class="fa-solid fa-circle-check me-1"></i> Published
                        </label>
                    </div>

                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="status_radio" id="statusDraft" value="Draft" {{ $post->status === 'Draft' ? 'checked' : '' }} onchange="updatePostStatus('Draft')">
                        <label class="form-check-label small fw-semibold text-secondary" for="statusDraft">
                            <i class="fa-regular fa-file-lines me-1"></i> Draft
                        </label>
                    </div>

                    <div class="form-check mb-3">
                        <input class="form-check-input" type="radio" name="status_radio" id="statusSched" value="Scheduled" {{ $post->status === 'Scheduled' ? 'checked' : '' }} onchange="updatePostStatus('Scheduled')">
                        <label class="form-check-label small fw-semibold text-primary" for="statusSched">
                            <i class="fa-regular fa-calendar-clock me-1"></i> Scheduled
                        </label>
                    </div>

                    <div class="form-check form-switch mb-2">
                        <input class="form-check-input" type="checkbox" name="is_featured" value="1" id="isFeatured" {{ $post->is_featured ? 'checked' : '' }}>
                        <label class="form-check-label small fw-semibold text-dark" for="isFeatured">Featured Post</label>
                    </div>

                    <div class="form-check form-switch mb-0">
                        <input class="form-check-input" type="checkbox" name="allow_comments" value="1" id="allowComments" {{ $post->allow_comments ? 'checked' : '' }}>
                        <label class="form-check-label small fw-semibold text-dark" for="allowComments">Allow Comments</label>
                    </div>
                </div>

                {{-- 5. Delete Action --}}
                <div class="cms-form-card border-danger border-opacity-25 bg-danger bg-opacity-10">
                    <h6 class="fw-bold text-danger mb-1 fs-6">Danger Zone</h6>
                    <p class="small text-muted mb-2.5" style="font-size: 0.72rem;">Permanently delete this blog article from the marketplace.</p>
                    <button type="button" class="btn btn-danger btn-sm w-100" onclick="if(confirm('Are you sure you want to delete this blog post?')) document.getElementById('deletePostForm').submit();">
                        <i class="fa-regular fa-trash-can me-1"></i> Delete This Post
                    </button>
                </div>
            </div>
        </div>
    </form>

    <form action="{{ route('admin.cms.destroy', $post->id) }}" method="POST" id="deletePostForm" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
</div>

@push('scripts')
<script>
    let activeTags = {!! json_encode(is_array($post->tags) ? $post->tags : array_filter(explode(',', (string)$post->tags))) !!};

    function syncEditorContent() {
        const editor = document.getElementById('richEditor');
        const hidden = document.getElementById('hiddenContent');
        if (editor && hidden) {
            hidden.value = editor.innerHTML;
            const text = editor.innerText || '';
            const words = text.trim() ? text.trim().split(/\s+/).length : 0;
            const chars = text.length;
            const stats = document.getElementById('editorStats');
            if (stats) stats.innerText = `Words: ${words} | Characters: ${chars}`;
        }
    }

    function formatBlock(tag) {
        document.execCommand('formatBlock', false, tag);
    }

    function addLink() {
        const url = prompt('Enter link URL:', 'https://');
        if (url) {
            document.execCommand('createLink', false, url);
        }
    }

    function updateTitleMeta(val) {
        document.getElementById('titleCount').innerText = val.length + '/200';
        const overlay = document.getElementById('imageOverlayTitle');
        if (overlay) overlay.textContent = val || 'Blog Preview';
    }

    function updateUrlPreview(slug) {
        const base = '{{ url("/blog") }}/';
        document.getElementById('urlPreview').innerText = base + slug;
    }

    function generateSlugFromTitle() {
        const title = document.getElementById('postTitle').value;
        const slug = title.toLowerCase()
            .replace(/[^\w\s-]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-')
            .trim();
        document.getElementById('postSlug').value = slug;
        updateUrlPreview(slug);
    }

    function previewSelectedImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('imagePreview').src = e.target.result;
                const filenameEl = document.getElementById('selectedImageFileName');
                if (filenameEl) filenameEl.textContent = input.files[0].name;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function promptImageChange() {
        const url = prompt('Enter featured image URL:', document.getElementById('featuredImageUrl').value);
        if (url) {
            document.getElementById('featuredImageUrl').value = url;
            document.getElementById('imagePreview').src = url;
        }
    }

    function removeImage() {
        document.getElementById('featuredImageUrl').value = '';
        document.getElementById('imagePreview').src = 'https://placehold.co/1200x630?text=Upload+Featured+Image';
    }

    function handleTagKey(event) {
        if (event.key === 'Enter') {
            event.preventDefault();
            const val = event.target.value.trim();
            if (val && !activeTags.includes(val)) {
                activeTags.push(val);
                renderTags();
                event.target.value = '';
            }
        }
    }

    function removeTag(el, tag) {
        activeTags = activeTags.filter(t => t !== tag);
        renderTags();
    }

    function renderTags() {
        const container = document.getElementById('tagsContainer');
        if (!container) return;
        container.innerHTML = '';
        activeTags.forEach(t => {
            const span = document.createElement('span');
            span.className = 'tag-chip';
            span.innerHTML = `${t} <span class="remove-tag" onclick="removeTag(this, '${t}')">&times;</span>`;
            container.appendChild(span);
        });
        document.getElementById('tagsHiddenInput').value = activeTags.join(',');
    }

    function updatePostStatus(status) {
        document.getElementById('postStatusInput').value = status;
    }

    function submitPostWithStatus(status) {
        document.getElementById('postStatusInput').value = status;
        syncEditorContent();
        document.getElementById('editPostForm').submit();
    }

    document.addEventListener('DOMContentLoaded', function() {
        renderTags();
        syncEditorContent();
    });
</script>
@endpush
@endsection

