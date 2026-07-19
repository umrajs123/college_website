@extends('admin.layouts.app')

@php
    $cards = old('card_title')
        ? collect(old('card_title'))->map(fn ($title, $index) => [
            'title' => $title,
            'text' => old('card_text.'.$index),
            'accent' => old('card_accent.'.$index, 'sky'),
        ])->values()->all()
        : ($section->cards ?: []);

    $highlights = old('highlight_label')
        ? collect(old('highlight_label'))->map(fn ($label, $index) => [
            'label' => $label,
            'value' => old('highlight_value.'.$index),
            'accent' => old('highlight_accent.'.$index, 'sky'),
        ])->values()->all()
        : ($section->highlights ?: []);
@endphp

@section('title', 'Campus Life')
@section('eyebrow', 'Homepage Content')
@section('page_title', 'Campus Life')

@section('content')
    <form class="admin-form-shell" method="POST" enctype="multipart/form-data" action="{{ route('admin.campus-life.update') }}">
        @csrf
        @method('PUT')

        <section class="admin-form-card">
            <div class="admin-card-head">
                <div>
                    <span class="admin-kicker">Student Experience</span>
                    <h2>Campus Life Content</h2>
                    <p>Update the homepage Campus Life section shown from the About dropdown.</p>
                </div>
            </div>

            <div class="admin-form-grid">
                <label>
                    Eyebrow
                    <input name="eyebrow" value="{{ old('eyebrow', $section->eyebrow) }}" placeholder="Campus Life" required>
                    @error('eyebrow') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label>
                    Active
                    <select name="is_active">
                        <option value="1" @selected(old('is_active', $section->is_active) == 1)>Show on website</option>
                        <option value="0" @selected(old('is_active', $section->is_active) == 0)>Hide section</option>
                    </select>
                </label>

                <label class="span-2">
                    Heading
                    <input name="heading" value="{{ old('heading', $section->heading) }}" placeholder="A focused campus culture built around learning..." required>
                    @error('heading') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label class="span-2">
                    Body Text
                    <textarea name="body" rows="4" placeholder="Write the main Campus Life introduction.">{{ old('body', $section->body) }}</textarea>
                    @error('body') <small class="field-error">{{ $message }}</small> @enderror
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
                    <input name="image_alt" value="{{ old('image_alt', $section->image_alt) }}" placeholder="Students on campus">
                    @error('image_alt') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label>
                    Image Badge
                    <input name="image_badge" value="{{ old('image_badge', $section->image_badge) }}" placeholder="Student Community">
                    @error('image_badge') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label>
                    Image Heading
                    <input name="image_heading" value="{{ old('image_heading', $section->image_heading) }}" placeholder="Study groups and everyday support...">
                    @error('image_heading') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <div class="span-2 admin-nested-fields">
                    <span class="admin-kicker">Experience Cards</span>
                    @for($index = 0; $index < 3; $index++)
                        @php($card = $cards[$index] ?? ['title' => '', 'text' => '', 'accent' => 'sky'])
                        <div class="admin-mini-grid">
                            <label>
                                Card {{ $index + 1 }} Title
                                <input name="card_title[]" value="{{ $card['title'] ?? '' }}" placeholder="Learning Beyond Class">
                            </label>
                            <label>
                                Accent
                                <select name="card_accent[]">
                                    @foreach(['sky', 'teal', 'indigo', 'cyan', 'rose', 'pink', 'lavender', 'peach'] as $accent)
                                        <option value="{{ $accent }}" @selected(($card['accent'] ?? 'sky') === $accent)>{{ ucfirst($accent) }}</option>
                                    @endforeach
                                </select>
                            </label>
                            <label class="span-2">
                                Card {{ $index + 1 }} Text
                                <input name="card_text[]" value="{{ $card['text'] ?? '' }}" placeholder="Workshops, guest talks, and guided lab sessions...">
                            </label>
                        </div>
                    @endfor
                </div>

                <div class="span-2 admin-nested-fields">
                    <span class="admin-kicker">Highlight Blocks</span>
                    @for($index = 0; $index < 3; $index++)
                        @php($highlight = $highlights[$index] ?? ['label' => '', 'value' => '', 'accent' => 'sky'])
                        <div class="admin-mini-grid">
                            <label>
                                Label
                                <input name="highlight_label[]" value="{{ $highlight['label'] ?? '' }}" placeholder="Daily Rhythm">
                            </label>
                            <label>
                                Value
                                <input name="highlight_value[]" value="{{ $highlight['value'] ?? '' }}" placeholder="Structured">
                            </label>
                            <label class="span-2">
                                Accent
                                <select name="highlight_accent[]">
                                    @foreach(['sky', 'teal', 'indigo', 'cyan', 'rose', 'pink', 'lavender', 'peach'] as $accent)
                                        <option value="{{ $accent }}" @selected(($highlight['accent'] ?? 'sky') === $accent)>{{ ucfirst($accent) }}</option>
                                    @endforeach
                                </select>
                            </label>
                        </div>
                    @endfor
                </div>
            </div>
        </section>

        <aside class="admin-preview-card about-preview-card">
            <span class="admin-kicker">{{ old('eyebrow', $section->eyebrow ?: 'Campus Life') }}</span>
            <img src="{{ $section->imageUrl() }}" alt="{{ $section->image_alt ?: 'Campus Life preview' }}">
            <h3>{{ old('heading', $section->heading) ?: 'Campus Life section heading' }}</h3>
            <p>{{ old('body', $section->body) ?: 'Add a concise description of campus life.' }}</p>
            <div class="admin-form-actions">
                <a href="{{ route('admin.dashboard') }}">Cancel</a>
                <button type="submit">Save Campus Life</button>
            </div>
        </aside>
    </form>
@endsection
