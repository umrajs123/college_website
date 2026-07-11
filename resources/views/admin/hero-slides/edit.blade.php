@extends('admin.layouts.app')

@php($isCreate = $isCreate ?? false)

@section('title', $isCreate ? 'Add Hero Slide' : 'Edit Hero Slide')
@section('eyebrow', 'Homepage Content')
@section('page_title', $isCreate ? 'Add Hero Slide' : 'Edit Hero Slide')

@section('content')
    <form class="admin-form-shell" method="POST" action="{{ $isCreate ? route('admin.hero-slides.store') : route('admin.hero-slides.update', $slide) }}" enctype="multipart/form-data">
        @csrf
        @unless($isCreate)
            @method('PUT')
        @endunless

        <section class="admin-form-card">
            <div class="admin-card-head">
                <div>
                    <span class="admin-kicker">Slide Details</span>
                    <h2>{{ $isCreate ? 'New Hero Content' : 'Hero Content' }}</h2>
                    <p>{{ $isCreate ? 'Fill the fields below to add a new frontend hero slide.' : 'Changes update the public homepage slider after saving.' }}</p>
                </div>
            </div>

            <div class="admin-form-grid">
                <label>
                    Eyebrow
                    <input name="eyebrow" value="{{ old('eyebrow', $slide->eyebrow) }}" required>
                    @error('eyebrow') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label>
                    Sort Order
                    <input type="number" name="sort_order" value="{{ old('sort_order', $slide->sort_order) }}" min="0" max="99" required>
                    @error('sort_order') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label class="span-2">
                    Heading
                    <input name="heading" value="{{ old('heading', $slide->heading) }}" required>
                    @error('heading') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label class="span-2">
                    Body
                    <textarea name="body" rows="4" required>{{ old('body', $slide->body) }}</textarea>
                    @error('body') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label>
                    Primary Button Label
                    <input name="primary_label" value="{{ old('primary_label', $slide->primary_label) }}">
                    @error('primary_label') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label>
                    Primary Button URL
                    <input name="primary_url" value="{{ old('primary_url', $slide->primary_url) }}" placeholder="#programs">
                    @error('primary_url') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label>
                    Secondary Button Label
                    <input name="secondary_label" value="{{ old('secondary_label', $slide->secondary_label) }}">
                    @error('secondary_label') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label>
                    Secondary Button URL
                    <input name="secondary_url" value="{{ old('secondary_url', $slide->secondary_url) }}" placeholder="#contact">
                    @error('secondary_url') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label class="span-2">
                    Image URL or Existing Path
                    <input name="image_path" value="{{ old('image_path', $slide->image_path) }}" @required($isCreate) placeholder="https://images.unsplash.com/...">
                    @error('image_path') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label>
                    Image Alt Text
                    <input name="image_alt" value="{{ old('image_alt', $slide->image_alt) }}">
                    @error('image_alt') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label>
                    Upload New Image
                    <input type="file" name="image" accept="image/*">
                    @error('image') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label class="admin-check span-2">
                    <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $slide->is_active))>
                    <span>Show this slide on the website</span>
                </label>
            </div>
        </section>

        <aside class="admin-preview-card hero-preview-card">
            <span class="admin-kicker">{{ $isCreate ? 'New Slide' : 'Current Slide' }}</span>
            @if(! $isCreate || $slide->image_path)
                <img src="{{ $slide->imageUrl() }}" alt="{{ $slide->image_alt ?: $slide->heading }}">
            @else
                <div class="admin-empty-preview">Image preview will appear after saving.</div>
            @endif
            <h3>{{ $slide->heading ?: 'New homepage slide' }}</h3>
            <p>{{ $slide->body ?: 'Add the slide message, background image, and optional buttons.' }}</p>
            <div class="admin-form-actions">
                <a href="{{ route('admin.hero-slides.index') }}">Cancel</a>
                <button type="submit">{{ $isCreate ? 'Create Slide' : 'Save Changes' }}</button>
            </div>
        </aside>
    </form>
@endsection
