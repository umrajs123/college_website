@extends('admin.layouts.app')

@php
    $isCreate = $isCreate ?? false;
    $highlights = old('highlight_title')
        ? collect(old('highlight_title'))->map(fn ($title, $index) => ['title' => $title, 'text' => old('highlight_text.'.$index)])->values()->all()
        : ($voice->highlights ?: []);
@endphp

@section('title', $isCreate ? 'Add Student Voice' : 'Edit '.$voice->name)
@section('eyebrow', 'Homepage Content')
@section('page_title', $isCreate ? 'Add Student Voice' : 'Edit Student Voice')

@section('content')
    <form class="admin-form-shell" method="POST" enctype="multipart/form-data" action="{{ $isCreate ? route('admin.student-voices.store') : route('admin.student-voices.update', $voice) }}">
        @csrf
        @unless($isCreate)
            @method('PUT')
        @endunless

        <section class="admin-form-card">
            <div class="admin-card-head">
                <div>
                    <span class="admin-kicker">Student Story</span>
                    <h2>{{ $isCreate ? 'New Testimonial Slide' : 'Testimonial Content' }}</h2>
                    <p>{{ $isCreate ? 'Add a polished student voice for the homepage slider.' : 'Changes update the homepage slider after saving.' }}</p>
                </div>
            </div>

            <div class="admin-form-grid">
                <label>
                    Student Name
                    <input name="name" value="{{ old('name', $voice->name) }}" placeholder="Ayesha Karim" required>
                    @error('name') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label>
                    Program / Department
                    <input name="program" value="{{ old('program', $voice->program) }}" placeholder="Final Year Student">
                    @error('program') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label>
                    Accent
                    <select name="accent" required>
                        @foreach(['sky', 'teal', 'indigo', 'cyan', 'rose', 'pink', 'lavender', 'peach'] as $accent)
                            <option value="{{ $accent }}" @selected(old('accent', $voice->accent) === $accent)>{{ ucfirst($accent) }}</option>
                        @endforeach
                    </select>
                    @error('accent') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label>
                    Sort Order
                    <input type="number" name="sort_order" value="{{ old('sort_order', $voice->sort_order) }}" min="0" max="999" required>
                    @error('sort_order') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label class="span-2">
                    Image URL
                    <input name="image_path" value="{{ old('image_path', $voice->image_path) }}" placeholder="https://images.unsplash.com/...">
                    @error('image_path') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label>
                    Upload Image
                    <input type="file" name="image" accept="image/*">
                    @error('image') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label>
                    Image Alt Text
                    <input name="image_alt" value="{{ old('image_alt', $voice->image_alt) }}" placeholder="Student portrait">
                    @error('image_alt') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label class="span-2">
                    Quote
                    <textarea name="quote" rows="5" placeholder="Write the student testimonial here." required>{{ old('quote', $voice->quote) }}</textarea>
                    @error('quote') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <div class="span-2 admin-nested-fields">
                    <span class="admin-kicker">Highlight Boxes</span>
                    @for($index = 0; $index < 3; $index++)
                        @php($highlight = $highlights[$index] ?? ['title' => '', 'text' => ''])
                        <div class="admin-mini-grid">
                            <label>
                                Highlight {{ $index + 1 }} Title
                                <input name="highlight_title[]" value="{{ $highlight['title'] ?? '' }}" placeholder="Practical">
                            </label>
                            <label>
                                Highlight {{ $index + 1 }} Text
                                <input name="highlight_text[]" value="{{ $highlight['text'] ?? '' }}" placeholder="lab exposure">
                            </label>
                        </div>
                    @endfor
                    @error('highlight_title') <small class="field-error">{{ $message }}</small> @enderror
                    @error('highlight_text') <small class="field-error">{{ $message }}</small> @enderror
                </div>

                <label class="admin-check span-2">
                    <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $voice->is_active))>
                    <span>Show this student voice on the website</span>
                </label>
            </div>
        </section>

        <aside class="admin-preview-card student-voice-preview-card campus-event-accent campus-event-accent--{{ old('accent', $voice->accent ?: 'sky') }}">
            <span class="admin-kicker">{{ $isCreate ? 'New Voice' : 'Current Voice' }}</span>
            <img src="{{ $voice->imageUrl() }}" alt="{{ $voice->image_alt ?: $voice->name ?: 'Student portrait' }}">
            <small>{{ old('program', $voice->program) ?: 'Final Year Student' }}</small>
            <h3>{{ old('name', $voice->name) ?: 'Ayesha Karim' }}</h3>
            <p>{{ old('quote', $voice->quote) ?: 'Add a concise student testimonial so the homepage slider feels alive and credible.' }}</p>
            <div class="admin-form-actions">
                <a href="{{ route('admin.student-voices.index') }}">Cancel</a>
                <button type="submit">{{ $isCreate ? 'Create Voice' : 'Save Changes' }}</button>
            </div>
        </aside>
    </form>
@endsection
