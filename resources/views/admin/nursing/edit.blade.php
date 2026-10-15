@extends('admin.layouts.app')

@php($isCreate = $isCreate ?? false)

@section('title', $isCreate ? 'Add Nursing Content' : 'Edit Nursing Content')
@section('eyebrow', 'Public Website Content')
@section('page_title', $isCreate ? 'Add Nursing Content' : 'Edit Nursing Content')

@section('content')
    <form class="admin-form-shell" method="POST" enctype="multipart/form-data" action="{{ $isCreate ? route('admin.nursing.store') : route('admin.nursing.update', $section) }}">
        @csrf
        @unless($isCreate)
            @method('PUT')
        @endunless

        <section class="admin-form-card">
            <div class="admin-card-head">
                <div>
                    <span class="admin-kicker">Nursing College</span>
                    <h2>{{ $isCreate ? 'New Page Content' : 'Edit Page Content' }}</h2>
                    <p>Update a section of the public Nursing page. Use separate paragraphs by starting a new line.</p>
                </div>
            </div>

            <div class="admin-form-grid">
                <label>
                    Content Type
                    <select name="section_type" required>
                        @foreach(['hero' => 'Page hero', 'content' => 'College information', 'feature' => 'Feature card', 'cta' => 'Admissions call to action'] as $type => $label)
                            <option value="{{ $type }}" @selected(old('section_type', $section->section_type) === $type)>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('section_type') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label>
                    Eyebrow
                    <input name="eyebrow" value="{{ old('eyebrow', $section->eyebrow) }}" placeholder="School of Nursing">
                    @error('eyebrow') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label class="span-2">
                    Heading
                    <input name="title" value="{{ old('title', $section->title) }}" placeholder="Care begins with a calling." required>
                    @error('title') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label class="span-2">
                    Information
                    <textarea name="body" rows="7" required placeholder="Write the information shown on the Nursing page.">{{ old('body', $section->body) }}</textarea>
                    @error('body') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label>
                    Card Icon / Short Label
                    <input name="icon_label" value="{{ old('icon_label', $section->icon_label) }}" maxlength="24" placeholder="♡">
                    <small class="field-hint">Feature-card icons: heart, stethoscope, shield, people, spark, or pulse. Other values display as a short text label.</small>
                    @error('icon_label') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <div class="span-2 nursing-admin-image">
                    <span class="admin-kicker">Section Image</span>
                    @if($section->image_url || in_array($section->section_type, ['hero', 'content'], true))
                        <img
                            src="{{ $section->imageUrl($section->section_type === 'hero' ? asset('images/nursing-care.jpg') : ($section->section_type === 'content' ? asset('images/nursing-college.jpg') : null)) }}"
                            alt="Current image for {{ $section->title ?: 'this section' }}">
                        <small>{{ $section->image_url ? 'Current image. Upload a photo or paste a URL to replace it.' : 'Default stock photo from Unsplash. Upload a photo or paste a URL to replace it.' }}</small>
                    @else
                        <p>No image is currently set for this section.</p>
                    @endif
                </div>

                <label class="span-2">
                    Upload Image
                    <input type="file" name="image" accept="image/jpeg,image/png,image/webp">
                    <small class="field-hint">Choose a JPG, PNG, or WebP image up to 4 MB. Uploading a new image replaces the current one.</small>
                    @error('image') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label class="span-2">
                    Or use an Image URL
                    <input type="url" name="image_url" value="{{ old('image_url', str_starts_with((string) $section->image_url, 'http') ? $section->image_url : '') }}" placeholder="https://example.com/nursing.jpg">
                    @error('image_url') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                @if($section->image_url)
                    <label class="admin-check span-2">
                        <input type="checkbox" name="remove_image" value="1">
                        <span>Remove the current image and use the default (if available)</span>
                    </label>
                @endif

                <label>
                    Button Label (optional)
                    <input name="button_label" value="{{ old('button_label', $section->button_label) }}" placeholder="Explore Admissions">
                    @error('button_label') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label>
                    Button URL (optional)
                    <input name="button_url" value="{{ old('button_url', $section->button_url) }}" placeholder="https://..., /admissions, or #contact">
                    @error('button_url') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label>
                    Secondary Button Label
                    <input name="secondary_button_label" value="{{ old('secondary_button_label', $section->secondary_button_label) }}" placeholder="Discover Our College">
                    @error('secondary_button_label') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label>
                    Secondary Button URL
                    <input name="secondary_button_url" value="{{ old('secondary_button_url', $section->secondary_button_url) }}" placeholder="https://..., /about, or #nursing-college">
                    @error('secondary_button_url') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label>
                    Display Order
                    <input type="number" name="sort_order" value="{{ old('sort_order', $section->sort_order) }}" min="0" max="999" required>
                    @error('sort_order') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label class="admin-check span-2">
                    <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $section->is_active))>
                    <span>Show this content on the Nursing page</span>
                </label>
            </div>
        </section>

        <aside class="admin-preview-card campus-event-accent campus-event-accent--teal">
            <span class="admin-kicker">{{ $isCreate ? 'New Content' : 'Current Content' }}</span>
            <span class="program-preview-icon">{{ old('icon_label', $section->icon_label ?: 'NC') }}</span>
            <h3>{{ old('title', $section->title) ?: 'Nursing College' }}</h3>
            <p>{{ old('body', $section->body) ?: 'Add useful information for prospective nursing students.' }}</p>
            <div class="admin-form-actions">
                <a href="{{ route('admin.nursing.index') }}">Cancel</a>
                <button type="submit">{{ $isCreate ? 'Create Content' : 'Save Changes' }}</button>
            </div>
        </aside>
    </form>
@endsection
