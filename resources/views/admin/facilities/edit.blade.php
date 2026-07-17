@extends('admin.layouts.app')

@php($isCreate = $isCreate ?? false)

@section('title', $isCreate ? 'Add Academic Facility' : 'Edit '.$facility->title)
@section('eyebrow', 'Homepage Content')
@section('page_title', $isCreate ? 'Add Academic Facility' : 'Edit Academic Facility')

@section('content')
    <form class="admin-form-shell" method="POST" enctype="multipart/form-data" action="{{ $isCreate ? route('admin.facilities.store') : route('admin.facilities.update', $facility) }}">
        @csrf
        @unless($isCreate)
            @method('PUT')
        @endunless

        <section class="admin-form-card">
            <div class="admin-card-head">
                <div>
                    <span class="admin-kicker">Facility Details</span>
                    <h2>{{ $isCreate ? 'New Facility Card' : 'Facility Content' }}</h2>
                    <p>{{ $isCreate ? 'Add a beautiful facility card for the homepage carousel.' : 'Changes update the public Learning Experience section after saving.' }}</p>
                </div>
            </div>

            <div class="admin-form-grid">
                <label class="span-2">
                    Title
                    <input name="title" value="{{ old('title', $facility->title) }}" placeholder="Pharmaceutical Chemistry Lab" required>
                    @error('title') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label>
                    Category
                    <input name="category" value="{{ old('category', $facility->category) }}" placeholder="Laboratory">
                    @error('category') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label>
                    Accent
                    <select name="accent" required>
                        @foreach(['sky', 'teal', 'indigo', 'cyan', 'rose', 'pink', 'lavender', 'peach'] as $accent)
                            <option value="{{ $accent }}" @selected(old('accent', $facility->accent) === $accent)>{{ ucfirst($accent) }}</option>
                        @endforeach
                    </select>
                    @error('accent') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label>
                    Sort Order
                    <input type="number" name="sort_order" value="{{ old('sort_order', $facility->sort_order) }}" min="0" max="999" required>
                    @error('sort_order') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label>
                    Upload Image
                    <input type="file" name="image" accept="image/*">
                    @error('image') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label class="span-2">
                    Image URL
                    <input name="image_path" value="{{ old('image_path', $facility->image_path) }}" placeholder="https://images.unsplash.com/...">
                    @error('image_path') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label class="span-2">
                    Image Alt Text
                    <input name="image_alt" value="{{ old('image_alt', $facility->image_alt) }}" placeholder="Chemistry laboratory equipment">
                    @error('image_alt') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label class="span-2">
                    Description
                    <textarea name="description" rows="5" placeholder="Analytical methods, compound behavior, and experimental discipline.">{{ old('description', $facility->description) }}</textarea>
                    @error('description') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label class="admin-check span-2">
                    <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $facility->is_active))>
                    <span>Show this facility on the website</span>
                </label>
            </div>
        </section>

        <aside class="admin-preview-card facility-preview-card campus-event-accent campus-event-accent--{{ old('accent', $facility->accent ?: 'sky') }}">
            <span class="admin-kicker">{{ $isCreate ? 'New Facility' : 'Current Facility' }}</span>
            <img src="{{ $facility->imageUrl() }}" alt="{{ $facility->image_alt ?: $facility->title ?: 'Facility preview' }}">
            <small>{{ old('category', $facility->category) ?: 'Laboratory' }}</small>
            <h3>{{ old('title', $facility->title) ?: 'Pharmaceutical Chemistry Lab' }}</h3>
            <p>{{ old('description', $facility->description) ?: 'Add a concise facility description so the homepage card feels clear and refined.' }}</p>
            <div class="admin-form-actions">
                <a href="{{ route('admin.facilities.index') }}">Cancel</a>
                <button type="submit">{{ $isCreate ? 'Create Facility' : 'Save Changes' }}</button>
            </div>
        </aside>
    </form>
@endsection
