@extends('admin.layouts.app')

@php($isCreate = $isCreate ?? false)

@section('title', $isCreate ? 'Add Academic Program' : 'Edit '.$program->title)
@section('eyebrow', 'Homepage Content')
@section('page_title', $isCreate ? 'Add Academic Program' : 'Edit Academic Program')

@section('content')
    <form class="admin-form-shell" method="POST" action="{{ $isCreate ? route('admin.programs.store') : route('admin.programs.update', $program) }}">
        @csrf
        @unless($isCreate)
            @method('PUT')
        @endunless

        <section class="admin-form-card">
            <div class="admin-card-head">
                <div>
                    <span class="admin-kicker">Program Details</span>
                    <h2>{{ $isCreate ? 'New Program Card' : 'Program Content' }}</h2>
                    <p>{{ $isCreate ? 'Add a clean academic area card for the public homepage.' : 'Changes update the public Academic Areas section after saving.' }}</p>
                </div>
            </div>

            <div class="admin-form-grid">
                <label class="span-2">
                    Title
                    <input name="title" value="{{ old('title', $program->title) }}" placeholder="Doctor of Pharmacy" required>
                    @error('title') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label>
                    Slug
                    <input name="slug" value="{{ old('slug', $program->slug) }}" placeholder="doctor-of-pharmacy">
                    @error('slug') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label>
                    Icon Label
                    <input name="icon_label" value="{{ old('icon_label', $program->icon_label) }}" placeholder="Rx" required>
                    @error('icon_label') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label>
                    Accent
                    <select name="accent" required>
                        @foreach(['sky', 'teal', 'indigo', 'cyan', 'rose', 'pink', 'lavender', 'peach'] as $accent)
                            <option value="{{ $accent }}" @selected(old('accent', $program->accent) === $accent)>{{ ucfirst($accent) }}</option>
                        @endforeach
                    </select>
                    @error('accent') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label>
                    Sort Order
                    <input type="number" name="sort_order" value="{{ old('sort_order', $program->sort_order) }}" min="0" max="999" required>
                    @error('sort_order') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label class="span-2">
                    Link URL
                    <input name="link_url" value="{{ old('link_url', $program->link_url) }}" placeholder="/programs/doctor-of-pharmacy or https://...">
                    @error('link_url') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label>
                    Duration
                    <input name="duration" value="{{ old('duration', $program->duration) }}" placeholder="5 years">
                    @error('duration') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label>
                    Eligibility
                    <input name="eligibility" value="{{ old('eligibility', $program->eligibility) }}" placeholder="F.Sc Pre-Medical or equivalent">
                    @error('eligibility') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label class="span-2">
                    Short Description
                    <textarea name="description" rows="5" placeholder="Core pharmaceutical education with clinical and community practice foundations.">{{ old('description', $program->description) }}</textarea>
                    @error('description') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label class="span-2">
                    Detailed Overview
                    <textarea name="overview" rows="6" placeholder="Write the full overview shown on the program detail page.">{{ old('overview', $program->overview) }}</textarea>
                    @error('overview') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label class="span-2">
                    Learning Focus
                    <textarea name="learning_focus" rows="5" placeholder="Mention labs, teaching approach, practical exposure, or major learning areas.">{{ old('learning_focus', $program->learning_focus) }}</textarea>
                    @error('learning_focus') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label class="span-2">
                    Career Scope
                    <textarea name="career_scope" rows="5" placeholder="Mention professional outcomes, career direction, or higher study options.">{{ old('career_scope', $program->career_scope) }}</textarea>
                    @error('career_scope') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label class="admin-check span-2">
                    <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $program->is_active))>
                    <span>Show this program on the website</span>
                </label>
            </div>
        </section>

        <aside class="admin-preview-card program-preview-card campus-event-accent campus-event-accent--{{ old('accent', $program->accent ?: 'sky') }}">
            <span class="admin-kicker">{{ $isCreate ? 'New Program' : 'Current Program' }}</span>
            <span class="program-preview-icon">{{ old('icon_label', $program->icon_label ?: 'Rx') }}</span>
            <h3>{{ old('title', $program->title) ?: 'Doctor of Pharmacy' }}</h3>
            <p>{{ old('description', $program->description) ?: 'Add a concise program description so the homepage card feels polished and useful.' }}</p>
            <div class="admin-form-actions">
                <a href="{{ route('admin.programs.index') }}">Cancel</a>
                <button type="submit">{{ $isCreate ? 'Create Program' : 'Save Changes' }}</button>
            </div>
        </aside>
    </form>
@endsection
