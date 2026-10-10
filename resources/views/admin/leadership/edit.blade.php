@extends('admin.layouts.app')

@php($isCreate = $isCreate ?? false)

@section('title', $isCreate ? 'Add Leadership Message' : 'Edit '.$message->role.' Message')
@section('eyebrow', 'Homepage Content')
@section('page_title', $isCreate ? 'Add Leadership Message' : 'Edit '.$message->role.' Message')

@section('content')
    <form class="admin-form-shell" method="POST" action="{{ $isCreate ? route('admin.leadership.store') : route('admin.leadership.update', $message) }}" enctype="multipart/form-data">
        @csrf
        @unless($isCreate)
            @method('PUT')
        @endunless

        <section class="admin-form-card">
            <div class="admin-card-head">
                <div>
                    <span class="admin-kicker">Message Details</span>
                    <h2>{{ $isCreate ? 'New Leadership Card' : 'Content and Display' }}</h2>
                    <p>{{ $isCreate ? 'Add a Director, Principal, or leadership message for the homepage section.' : 'These values update the public homepage immediately after saving.' }}</p>
                </div>
            </div>

            <div class="admin-form-grid">
                <label>
                    Role
                    <input name="role" value="{{ old('role', $message->role) }}" required>
                    @error('role') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label>
                    Title
                    <input name="title" value="{{ old('title', $message->title) }}" required>
                    @error('title') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label class="span-2">
                    Subtitle
                    <input name="subtitle" value="{{ old('subtitle', $message->subtitle) }}">
                    @error('subtitle') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label class="span-2">
                    Message
                    <textarea name="message" rows="5" required>{{ old('message', $message->message) }}</textarea>
                    @error('message') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label>
                    Accent
                    <select name="accent" required>
                        <option value="director" @selected(old('accent', $message->accent) === 'director')>Blue Director Style</option>
                        <option value="principal" @selected(old('accent', $message->accent) === 'principal')>Teal Principal Style</option>
                    </select>
                    @error('accent') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label>
                    Sort Order
                    <input type="number" name="sort_order" value="{{ old('sort_order', $message->sort_order) }}" min="0" max="99" required>
                    @error('sort_order') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label class="span-2">
                    Tags
                    <input name="tags" value="{{ old('tags', implode(', ', $message->tags ?? [])) }}" placeholder="Academic vision, Professional ethics">
                    @error('tags') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label class="span-2">
                    External Image URL or Existing Path
                    <input name="image_path" value="{{ old('image_path', $message->image_path) }}">
                    @error('image_path') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label class="span-2">
                    Upload New Profile Picture (up to 4 MB)
                    <input type="file" name="image" accept="image/*">
                    @error('image') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label class="admin-check span-2">
                    <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $message->is_active))>
                    <span>Show this message on the website</span>
                </label>
            </div>
        </section>

        <aside class="admin-preview-card leadership-preview-card">
            <span class="admin-kicker">{{ $isCreate ? 'New Message' : 'Current Message' }}</span>
            @if(! $isCreate || $message->image_path)
                <img src="{{ $message->imageUrl() }}" alt="{{ $message->role ?: 'Leadership' }} portrait">
            @else
                <div class="admin-empty-preview">Image preview will appear after saving.</div>
            @endif
            <h3>{{ $message->title ?: 'Leadership message title' }}</h3>
            <p>{{ $message->message ?: 'Add the message text, role, accent color, tags, and image details.' }}</p>
            <div class="admin-form-actions">
                <a href="{{ route('admin.leadership.index') }}">Cancel</a>
                <button type="submit">{{ $isCreate ? 'Create Message' : 'Save Changes' }}</button>
            </div>
        </aside>
    </form>
@endsection
