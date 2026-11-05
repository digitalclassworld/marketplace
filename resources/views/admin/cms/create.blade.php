@extends('admin.layouts.admin')

@section('title', 'Create Blog Post - Super Admin')

@section('styles')
<style>
    /* Styling matching screenshot 2 pixel-for-pixel */
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
        min-height: 280px;
        outline: none;
        font-size: 0.88rem;
        line-height: 1.6;
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
    <form action="{{ route('admin.cms.store') }}" method="POST" id="createPostForm">
        @csrf
        <input type="hidden" name="status" id="postStatusInput" value="Published">

        {{-- Breadcrumb & Top Header matching screenshot 2 --}}
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
            <div>
                <div class="d-flex align-items-center gap-1.5 text-muted small mb-1">
                    <a href="{{ route('admin.cms.index') }}" class="text-decoration-none text-muted">
                        <i class="fa-solid fa-arrow-left me-1"></i> Blog & CMS
                    </a>
                    <span>&gt;</span>
                    <span class="text-dark fw-semibold">Create Blog Post</span>
                </div>
                <h1 class="h3 fw-bold text-dark mb-1">Create Blog Post</h1>
                <p class="text-muted small mb-0">Write and publish engaging content for your audience.</p>
            </div>

            <div class="d-flex align-items-center gap-2">
                {{-- Back button --}}
                <a href="{{ route('admin.cms.index') }}" class="btn btn-white border bg-white text-secondary px-3 py-2 fw-medium shadow-sm">
                    <i class="fa-solid fa-arrow-left me-1 text-muted"></i> Back
                </a>

                {{-- Save as Draft button --}}
                <button type="button" class="btn btn-white border bg-white text-secondary px-3 py-2 fw-medium shadow-sm" onclick="submitPostWithStatus('Draft')">
                    <i class="fa-regular fa-floppy-disk me-1.5 text-muted"></i> Save as Draft
                </button>

                {{-- Publish button --}}
                <div class="btn-group shadow-sm">
                    <button type="button" class="btn btn-primary px-3 py-2 fw-medium" style="background-color: #0066ff; border-color: #0066ff;" onclick="submitPostWithStatus('Published')">
                        <i class="fa-regular fa-paper-plane me-1.5"></i> Publish
                    </button>
                    <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" style="background-color: #005ce6; border-color: #005ce6;" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="visually-hidden">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0" style="font-size: 0.8rem;">
                        <li><a class="dropdown-item py-1.5" href="javascript:void(0)" onclick="submitPostWithStatus('Published')">Publish Immediately</a></li>
                        <li><a class="dropdown-item py-1.5" href="javascript:void(0)" onclick="submitPostWithStatus('Scheduled')">Schedule Publication</a></li>
                        <li><a class="dropdown-item py-1.5" href="javascript:void(0)" onclick="submitPostWithStatus('Draft')">Save as Draft</a></li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- Main 2-Column Split matching screenshot 2 --}}
        <div class="row g-3">
            {{-- LEFT COLUMN (~70%) --}}
            <div class="col-xl-8 col-lg-7 col-12">
                <div class="cms-form-card mb-3">
                    {{-- Title --}}
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <label class="form-label small fw-bold text-dark mb-0">Title <span class="text-danger">*</span></label>
                            <span class="char-count" id="titleCount">32/200</span>
                        </div>
                        <input type="text" name="title" id="postTitle" class="form-control"
                               value="Top 10 AI Tools for Students in 2026"
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
                                   value="top-10-ai-tools-for-students-2026" required oninput="updateUrlPreview(this.value)">
                            <button type="button" class="btn btn-outline-secondary" onclick="generateSlugFromTitle()">
                                Generate
                            </button>
                        </div>
                        <div class="text-muted small mt-1" style="font-size: 0.72rem;">
                            URL: <span class="text-primary font-monospace" id="urlPreview">https://digitalclass.in/blog/top-10-ai-tools-for-students-2026</span>
                        </div>
                    </div>

                    {{-- Excerpt / Short Description --}}
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <label class="form-label small fw-bold text-dark mb-0">Excerpt / Short Description <span class="text-danger">*</span></label>
                            <span class="char-count" id="excerptCount">110/300</span>
                        </div>
                        <textarea name="excerpt" id="postExcerpt" rows="2" class="form-control" maxlength="300"
                                  oninput="document.getElementById('excerptCount').innerText = this.value.length + '/300'">Discover the best AI tools that can help students learn faster, create better content and improve productivity in 2026.</textarea>
                    </div>

                    {{-- Content Rich Editor --}}
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <label class="form-label small fw-bold text-dark mb-0">Content <span class="text-danger">*</span></label>
                            <button type="button" class="btn btn-sm btn-primary py-0.5 px-2 fw-semibold d-flex align-items-center gap-1" style="font-size: 0.72rem; background-color: #0066ff;" onclick="writeWithAi()">
                                <i class="fa-solid fa-wand-magic-sparkles"></i> Write with AI
                            </button>
                        </div>

                        {{-- Toolbar --}}
                        <div class="editor-toolbar">
                            <select class="form-select form-select-sm border-0 bg-transparent text-secondary py-0 pe-4" style="width: 105px; font-size: 0.8rem;">
                                <option>Paragraph</option>
                                <option>Heading 1</option>
                                <option>Heading 2</option>
                                <option>Heading 3</option>
                            </select>
                            <span class="text-muted">|</span>
                            <button type="button" title="Bold" onclick="document.execCommand('bold')"><strong>B</strong></button>
                            <button type="button" title="Italic" onclick="document.execCommand('italic')"><em>I</em></button>
                            <button type="button" title="Underline" onclick="document.execCommand('underline')"><u>U</u></button>
                            <button type="button" title="Strikethrough" onclick="document.execCommand('strikeThrough')"><s>S</s></button>
                            <span class="text-muted">|</span>
                            <button type="button" title="Bullet List" onclick="document.execCommand('insertUnorderedList')"><i class="fa-solid fa-list-ul"></i></button>
                            <button type="button" title="Numbered List" onclick="document.execCommand('insertOrderedList')"><i class="fa-solid fa-list-ol"></i></button>
                            <button type="button" title="Blockquote"><i class="fa-solid fa-quote-left"></i></button>
                            <span class="text-muted">|</span>
                            <button type="button" title="Link" onclick="addLink()"><i class="fa-solid fa-link"></i></button>
                            <button type="button" title="Image" onclick="alert('Insert image link.')"><i class="fa-regular fa-image"></i></button>
                            <button type="button" title="Table" onclick="alert('Table widget.')"><i class="fa-solid fa-table"></i></button>
                            <button type="button" title="Code"><i class="fa-solid fa-code"></i></button>
                            <button type="button" title="Undo" onclick="document.execCommand('undo')"><i class="fa-solid fa-rotate-left"></i></button>
                            <button type="button" title="Redo" onclick="document.execCommand('redo')"><i class="fa-solid fa-rotate-right"></i></button>
                        </div>

                        {{-- Hidden textarea synced with contenteditable --}}
                        <textarea name="content" id="hiddenContent" style="display: none;"></textarea>

                        {{-- Visual Editor Box matching screenshot 2 --}}
                        <div class="editor-body" id="richEditor" contenteditable="true" oninput="syncEditorContent()">
                            <p>Artificial Intelligence is changing the way students learn, research and create. In 2026, there are many powerful AI tools that can save time, improve productivity and help you achieve better results.</p>
                            <p>In this blog, we will explore the Top 10 AI tools for students that are easy to use and can make your study journey smarter.</p>
                        </div>

                        <div class="d-flex justify-content-between text-muted small mt-1.5" style="font-size: 0.72rem;">
                            <span id="editorStats">Words: 126 | Characters: 780</span>
                            <span class="text-success"><i class="fa-solid fa-circle-check me-1"></i> Autosaved draft</span>
                        </div>
                    </div>
                </div>

                {{-- SEO Settings Card matching screenshot 2 --}}
                <div class="cms-form-card">
                    <h6 class="fw-bold text-dark mb-3 fs-6">SEO Settings</h6>

                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <label class="form-label small fw-bold text-dark mb-0">Meta Title</label>
                            <span class="char-count" id="metaTitleCount">52/60</span>
                        </div>
                        <input type="text" name="meta_title" id="metaTitle" class="form-control"
                               value="Top 10 AI Tools for Students in 2026 | Digital Class" maxlength="60"
                               oninput="document.getElementById('metaTitleCount').innerText = this.value.length + '/60'">
                    </div>

                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <label class="form-label small fw-bold text-dark mb-0">Meta Description</label>
                            <span class="char-count" id="metaDescCount">120/160</span>
                        </div>
                        <textarea name="meta_description" id="metaDesc" rows="2" class="form-control" maxlength="160"
                                  oninput="document.getElementById('metaDescCount').innerText = this.value.length + '/160'">Explore the best AI tools for students in 2026. Learn how these tools can help you study better, create content, and improve productivity.</textarea>
                    </div>

                    <div class="mb-2">
                        <label class="form-label small fw-bold text-dark mb-1">Focus Keyword</label>
                        <input type="text" name="focus_keyword" class="form-control" value="AI tools for students">
                        <span class="text-muted" style="font-size: 0.72rem;">Use a primary keyword for better SEO ranking.</span>
                    </div>
                </div>
            </div>

            {{-- RIGHT COLUMN (~30%) --}}
            <div class="col-xl-4 col-lg-5 col-12">
                {{-- 1. Featured Image Card matching screenshot 2 --}}
                <div class="cms-form-card mb-3">
                    <h6 class="fw-bold text-dark mb-2.5 fs-6">Featured Image</h6>
                    <input type="hidden" name="featured_image" id="featuredImageUrl" value="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=1200&auto=format&fit=crop&q=80">

                    {{-- Image Preview --}}
                    <div class="position-relative mb-2 rounded-3 overflow-hidden border">
                        <img id="imagePreview" src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=1200&auto=format&fit=crop&q=80" alt="Featured Preview" class="w-100" style="height: 160px; object-fit: cover;">
                        <div class="position-absolute bottom-0 start-0 end-0 bg-dark bg-opacity-75 text-white p-2 text-center" style="font-size: 0.8rem; font-weight: 700;">
                            Top 10 AI Tools for Students in 2026
                        </div>
                    </div>

                    <div class="d-flex align-items-center gap-2 mb-2">
                        <button type="button" class="btn btn-outline-primary btn-sm flex-grow-1" style="font-size: 0.75rem;" onclick="promptImageChange()">
                            <i class="fa-solid fa-arrow-up-from-bracket me-1"></i> Change Image
                        </button>
                        <button type="button" class="btn btn-outline-danger btn-sm" style="font-size: 0.75rem;" onclick="removeImage()">
                            <i class="fa-regular fa-trash-can me-1"></i> Remove
                        </button>
                    </div>

                    <div class="text-muted" style="font-size: 0.7rem;">
                        Recommended size: 1200 x 630 px (JPG/PNG)<br>
                        File: <span class="font-monospace text-secondary">ai-tools-students-2026.jpg (350 KB)</span>
                    </div>
                </div>

                {{-- 2. Categories Card matching screenshot 2 --}}
                <div class="cms-form-card mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-2.5">
                        <h6 class="fw-bold text-dark mb-0 fs-6">Categories <span class="text-danger">*</span></h6>
                        <a href="javascript:void(0)" class="text-primary text-decoration-none" style="font-size: 0.75rem;" onclick="alert('Category manager.')">Manage Categories</a>
                    </div>

                    <div class="row g-2" style="font-size: 0.8rem;">
                        <div class="col-6">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="category" value="Technology" id="catTech" checked>
                                <label class="form-check-label text-dark" for="catTech">Technology</label>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="category" value="Marketing" id="catMkt">
                                <label class="form-check-label text-dark" for="catMkt">Marketing</label>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="category" value="Education" id="catEdu">
                                <label class="form-check-label text-dark" for="catEdu">Education</label>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="category" value="Teaching" id="catTeach">
                                <label class="form-check-label text-dark" for="catTeach">Tutorials</label>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="category" value="Career" id="catCareer">
                                <label class="form-check-label text-dark" for="catCareer">Career</label>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="category" value="Trends" id="catTrends">
                                <label class="form-check-label text-dark" for="catTrends">News & Updates</label>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="category" value="Business" id="catBiz">
                                <label class="form-check-label text-dark" for="catBiz">Business</label>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="category" value="Others" id="catOther">
                                <label class="form-check-label text-dark" for="catOther">Others</label>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- 3. Tags Card matching screenshot 2 --}}
                <div class="cms-form-card mb-3">
                    <h6 class="fw-bold text-dark mb-2 fs-6">Tags</h6>
                    <input type="hidden" name="tags" id="tagsHiddenInput" value="AI,Students,Education,Productivity,Tools">

                    <div id="tagsContainer" class="mb-2">
                        <span class="tag-chip">AI <span class="remove-tag" onclick="removeTag(this, 'AI')">&times;</span></span>
                        <span class="tag-chip">Students <span class="remove-tag" onclick="removeTag(this, 'Students')">&times;</span></span>
                        <span class="tag-chip">Education <span class="remove-tag" onclick="removeTag(this, 'Education')">&times;</span></span>
                        <span class="tag-chip">Productivity <span class="remove-tag" onclick="removeTag(this, 'Productivity')">&times;</span></span>
                        <span class="tag-chip">Tools <span class="remove-tag" onclick="removeTag(this, 'Tools')">&times;</span></span>
                    </div>

                    <input type="text" id="tagInput" class="form-control form-control-sm" placeholder="Type and press enter..." onkeydown="handleTagKey(event)">
                </div>

                {{-- 4. Publish Settings Card matching screenshot 2 --}}
                <div class="cms-form-card">
                    <h6 class="fw-bold text-dark mb-2.5 fs-6">Publish Settings</h6>

                    {{-- Status Radios --}}
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-dark mb-1">Status</label>
                        <div class="form-check mb-1">
                            <input class="form-check-input" type="radio" name="publish_choice" id="choiceImmediate" value="Published" checked onchange="toggleSchedule(false)">
                            <label class="form-check-label text-dark" for="choiceImmediate">Publish Immediately</label>
                        </div>
                        <div class="form-check mb-1">
                            <input class="form-check-input" type="radio" name="publish_choice" id="choiceDraft" value="Draft" onchange="toggleSchedule(false)">
                            <label class="form-check-label text-dark" for="choiceDraft">Save as Draft</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="publish_choice" id="choiceSchedule" value="Scheduled" onchange="toggleSchedule(true)">
                            <label class="form-check-label text-dark" for="choiceSchedule">Schedule for Later</label>
                        </div>
                    </div>

                    {{-- Publish Date & Time --}}
                    <div class="mb-3" id="scheduleBox">
                        <label class="form-label small fw-bold text-dark mb-1">Publish Date</label>
                        <div class="row g-2">
                            <div class="col-7">
                                <input type="date" name="published_date" class="form-control form-control-sm" value="2026-10-30">
                            </div>
                            <div class="col-5">
                                <input type="time" name="published_time" class="form-control form-control-sm" value="10:30">
                            </div>
                        </div>
                    </div>

                    {{-- Checkboxes --}}
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" name="allow_comments" value="1" id="allowCommentsCheck" checked>
                        <label class="form-check-label fw-bold text-dark" for="allowCommentsCheck" style="font-size: 0.8rem;">
                            Allow Comments
                        </label>
                        <div class="text-muted" style="font-size: 0.7rem;">Let users comment on this post.</div>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="is_featured" value="1" id="isFeaturedCheck">
                        <label class="form-check-label fw-bold text-dark" for="isFeaturedCheck" style="font-size: 0.8rem;">
                            Make this a Featured Post
                        </label>
                        <div class="text-muted" style="font-size: 0.7rem;">Show on homepage and featured sections.</div>
                    </div>
                </div>
            </div>
        </div>
    </form>

</div>

@push('scripts')
<script>
    let activeTags = ['AI', 'Students', 'Education', 'Productivity', 'Tools'];

    function syncEditorContent() {
        const html = document.getElementById('richEditor').innerHTML;
        document.getElementById('hiddenContent').value = html;
        const text = document.getElementById('richEditor').innerText;
        const words = text.trim() ? text.trim().split(/\s+/).length : 0;
        document.getElementById('editorStats').innerText = `Words: ${words} | Characters: ${text.length}`;
    }

    function updateTitleMeta(title) {
        document.getElementById('titleCount').innerText = `${title.length}/200`;
        const slug = title.toLowerCase()
            .replace(/[^\w ]+/g, '')
            .replace(/ +/g, '-');
        document.getElementById('postSlug').value = slug;
        updateUrlPreview(slug);
        document.getElementById('metaTitle').value = `${title} | Digital Class`;
        document.getElementById('metaTitleCount').innerText = `${title.length + 16}/60`;
    }

    function updateUrlPreview(slug) {
        document.getElementById('urlPreview').innerText = `https://digitalclass.in/blog/${slug}`;
    }

    function generateSlugFromTitle() {
        const title = document.getElementById('postTitle').value;
        const slug = title.toLowerCase()
            .replace(/[^\w ]+/g, '')
            .replace(/ +/g, '-');
        document.getElementById('postSlug').value = slug;
        updateUrlPreview(slug);
    }

    function writeWithAi() {
        const editor = document.getElementById('richEditor');
        editor.innerHTML += `
            <h2>Key Advantages of AI in Academic Learning</h2>
            <ul>
                <li><strong>24/7 Virtual Tutoring:</strong> Clarify academic concepts whenever needed without waiting for faculty office hours.</li>
                <li><strong>Personalized Revision Plans:</strong> Generate tailored practice quizzes focused on weaker topics.</li>
                <li><strong>Enhanced Vocabulary:</strong> Improve scholarly paper presentations and academic submissions.</li>
            </ul>
        `;
        syncEditorContent();
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
        container.innerHTML = '';
        activeTags.forEach(t => {
            const span = document.createElement('span');
            span.className = 'tag-chip';
            span.innerHTML = `${t} <span class="remove-tag" onclick="removeTag(this, '${t}')">&times;</span>`;
            container.appendChild(span);
        });
        document.getElementById('tagsHiddenInput').value = activeTags.join(',');
    }

    function toggleSchedule(show) {
        document.getElementById('scheduleBox').style.opacity = show ? '1' : '0.6';
    }

    function submitPostWithStatus(status) {
        document.getElementById('postStatusInput').value = status;
        syncEditorContent();
        document.getElementById('createPostForm').submit();
    }

    document.addEventListener('DOMContentLoaded', function() {
        syncEditorContent();
    });
</script>
@endpush
@endsection
