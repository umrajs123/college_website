@extends('admin.layouts.app')

@php
    $isCreate = $isCreate ?? false;
    $features = old('feature_text')
        ? collect(old('feature_text'))->map(fn ($text, $index) => ['text' => $text, 'accent' => old('feature_accent.'.$index, 'sky')])->values()->all()
        : ($section->features ?: []);
@endphp

@section('title', $isCreate ? 'Add About Block' : 'Edit About Block')
@section('eyebrow', 'Homepage Content')
@section('page_title', $isCreate ? 'Add About Block' : 'Edit About Block')

@section('content')
    <form class="admin-form-shell" method="POST" enctype="multipart/form-data" action="{{ $isCreate ? route('admin.about.store') : route('admin.about.update', $section) }}">
        @csrf
        @unless($isCreate)
            @method('PUT')
        @endunless

        <section class="admin-form-card">
            <div class="admin-card-head">
                <div>
                    <span class="admin-kicker">About Details</span>
                    <h2>{{ $isCreate ? 'New About Section' : 'About Content' }}</h2>
                    <p>{{ $isCreate ? 'Add the main story block for the homepage.' : 'Changes update the homepage About section after saving.' }}</p>
                </div>
            </div>

            <div class="admin-form-grid">
                <label>
                    Eyebrow
                    <input name="eyebrow" value="{{ old('eyebrow', $section->eyebrow) }}" placeholder="About SCPS" required>
                    @error('eyebrow') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label>
                    Accent
                    <select name="accent" required>
                        @foreach(['sky', 'teal', 'indigo', 'cyan', 'rose', 'pink', 'lavender', 'peach'] as $accent)
                            <option value="{{ $accent }}" @selected(old('accent', $section->accent) === $accent)>{{ ucfirst($accent) }}</option>
                        @endforeach
                    </select>
                    @error('accent') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label class="span-2">
                    Heading
                    <input name="heading" value="{{ old('heading', $section->heading) }}" placeholder="A College Built for Serious Pharmacy Education" required>
                    @error('heading') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label class="span-2">
                    Body Text
                    <textarea name="body" rows="5" placeholder="Write the main About section paragraph.">{{ old('body', $section->body) }}</textarea>
                    @error('body') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label>
                    Badge Value
                    <input name="badge_value" value="{{ old('badge_value', $section->badge_value) }}" placeholder="15+">
                    @error('badge_value') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label>
                    Badge Label
                    <input name="badge_label" value="{{ old('badge_label', $section->badge_label) }}" placeholder="Years of academic focus">
                    @error('badge_label') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label>
                    Button Label
                    <input name="button_label" value="{{ old('button_label', $section->button_label) }}" placeholder="Request Information">
                    @error('button_label') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label>
                    Button URL
                    <input name="button_url" value="{{ old('button_url', $section->button_url) }}" placeholder="#contact">
                    @error('button_url') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label class="span-2">
                    Image URL
                    <input name="image_path" value="{{ old('image_path', $section->image_path) }}" placeholder="https://images.unsplash.com/...">
                    @error('image_path') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label>
                    Upload Image
                    <input type="file" name="image" accept="image/*">
                    @error('image') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label>
                    Image Alt Text
                    <input name="image_alt" value="{{ old('image_alt', $section->image_alt) }}" placeholder="Pharmacy student using microscope">
                    @error('image_alt') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <div class="span-2 admin-nested-fields">
                    <span class="admin-kicker">Feature Bullets</span>
                    @for($index = 0; $index < 3; $index++)
                        @php($feature = $features[$index] ?? ['text' => '', 'accent' => 'sky'])
                        <div class="admin-mini-grid">
                            <label>
                                Feature {{ $index + 1 }} Text
                                <input name="feature_text[]" value="{{ $feature['text'] ?? '' }}" placeholder="Purpose-built teaching laboratories">
                            </label>
                            <label>
                                Feature {{ $index + 1 }} Accent
                                <select name="feature_accent[]">
                                    @foreach(['sky', 'teal', 'indigo', 'cyan', 'rose', 'pink', 'lavender', 'peach'] as $accent)
                                        <option value="{{ $accent }}" @selected(($feature['accent'] ?? 'sky') === $accent)>{{ ucfirst($accent) }}</option>
                                    @endforeach
                                </select>
                            </label>
                        </div>
                    @endfor
                </div>

                <label>
                    Sort Order
                    <input type="number" name="sort_order" value="{{ old('sort_order', $section->sort_order) }}" min="0" max="999" required>
                    @error('sort_order') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label class="admin-check">
                    <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $section->is_active))>
                    <span>Show this About block on the website</span>
                </label>
            </div>
        </section>

        <aside class="admin-preview-card about-preview-card campus-event-accent campus-event-accent--{{ old('accent', $section->accent ?: 'sky') }}">
            <span class="admin-kicker">{{ old('eyebrow', $section->eyebrow ?: 'About SCPS') }}</span>
            <img src="{{ $section->imageUrl() }}" alt="{{ $section->image_alt ?: $section->heading ?: 'About preview' }}">
            <h3>{{ old('heading', $section->heading) ?: 'A College Built for Serious Pharmacy Education' }}</h3>
            <p>{{ old('body', $section->body) ?: 'Add concise About text so the homepage section feels complete and credible.' }}</p>
            <div class="admin-form-actions">
                <a href="{{ route('admin.about.index') }}">Cancel</a>
                <button type="submit">{{ $isCreate ? 'Create About Block' : 'Save Changes' }}</button>
            </div>
        </aside>
    </form>
@endsection
