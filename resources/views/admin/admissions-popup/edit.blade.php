@extends('admin.layouts.app')

@section('title', 'Admissions Popup')
@section('eyebrow', 'Homepage Promotion')
@section('page_title', 'Admissions Popup')

@section('content')
    <form class="admin-form-shell admissions-popup-admin-form" method="POST" enctype="multipart/form-data" action="{{ route('admin.admissions-popup.update') }}">
        @csrf
        @method('PUT')

        <section class="admin-form-card">
            <div class="admin-card-head">
                <div>
                    <span class="admin-kicker">Public Website Announcement</span>
                    <h2>Admissions Popup Content</h2>
                    <p>Manage the announcement shown when visitors open the website, including the application button and visibility.</p>
                </div>
            </div>

            <div class="admin-form-grid">
                <fieldset class="span-2 admissions-popup-status-fieldset">
                    <legend>Popup Status</legend>
                    <div class="admissions-popup-status-options">
                        <label class="admissions-popup-status-option">
                            <input
                                type="radio"
                                name="admissions_popup_is_active"
                                value="1"
                                @checked(old('admissions_popup_is_active', $settings->admissions_popup_is_active) == 1)
                                required
                            >
                            <span>
                                <strong>Active</strong>
                                <small>Show the admissions popup whenever someone loads the website.</small>
                            </span>
                        </label>
                        <label class="admissions-popup-status-option">
                            <input
                                type="radio"
                                name="admissions_popup_is_active"
                                value="0"
                                @checked(old('admissions_popup_is_active', $settings->admissions_popup_is_active) == 0)
                                required
                            >
                            <span>
                                <strong>Inactive</strong>
                                <small>Keep the admissions popup hidden from website visitors.</small>
                            </span>
                        </label>
                    </div>
                    @error('admissions_popup_is_active') <small class="field-error">{{ $message }}</small> @enderror
                </fieldset>

                <label>
                    Academic Session
                    <input
                        name="admissions_popup_session"
                        value="{{ old('admissions_popup_session', $settings->admissions_popup_session) }}"
                        maxlength="40"
                        placeholder="2026-27"
                        required
                    >
                    <small class="field-hint">Displayed beside the Admissions Open badge.</small>
                    @error('admissions_popup_session') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label>
                    Eyebrow
                    <input name="admissions_popup_eyebrow" value="{{ old('admissions_popup_eyebrow', $settings->admissions_popup_eyebrow) }}" maxlength="100" required>
                    @error('admissions_popup_eyebrow') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label class="span-2">
                    Main Heading
                    <input name="admissions_popup_heading" value="{{ old('admissions_popup_heading', $settings->admissions_popup_heading) }}" maxlength="180" required>
                    @error('admissions_popup_heading') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label class="span-2">
                    Supporting Message
                    <textarea name="admissions_popup_body" rows="4" maxlength="1000" required>{{ old('admissions_popup_body', $settings->admissions_popup_body) }}</textarea>
                    @error('admissions_popup_body') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label>
                    Apply Button Label
                    <input name="admissions_popup_button_label" value="{{ old('admissions_popup_button_label', $settings->admissions_popup_button_label) }}" maxlength="60" required>
                    @error('admissions_popup_button_label') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label>
                    Apply Button URL
                    <input type="url" name="admissions_popup_button_url" value="{{ old('admissions_popup_button_url', $settings->admissions_popup_button_url) }}" placeholder="{{ $settings->admissions_url ?: 'https://example.com/apply' }}">
                    <small class="field-hint">Leave blank to use the Admissions URL from Site Settings.</small>
                    @error('admissions_popup_button_url') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label class="span-2">
                    Image URL / Path
                    <input name="admissions_popup_image_path" value="{{ old('admissions_popup_image_path', $settings->admissions_popup_image_path) }}" placeholder="images/pharmacy-lab.jpg">
                    @error('admissions_popup_image_path') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label class="span-2">
                    Upload Image
                    <input type="file" name="admissions_popup_image" accept="image/*">
                    <small class="field-hint">Optional. The popup uses a built-in pharmacy-themed illustration if no image is provided.</small>
                    @error('admissions_popup_image') <small class="field-error">{{ $message }}</small> @enderror
                </label>
            </div>

            <div class="admin-form-actions admissions-popup-admin-actions">
                <a href="{{ route('admin.dashboard') }}">Cancel</a>
                <button type="submit">Save Popup Settings</button>
            </div>
        </section>

        <aside class="admin-preview-card admissions-popup-admin-preview">
            <span class="admin-kicker">Live Content Preview</span>
            <div class="admissions-popup-admin-preview__visual">
                @if($settings->admissionsPopupImageUrl())
                    <img src="{{ $settings->admissionsPopupImageUrl() }}" alt="">
                @endif
                <img class="admissions-popup-admin-preview__logo" src="{{ $siteSettings->logoUrl() }}" alt="{{ $siteSettings->site_name }} logo">
            </div>
            <span class="admissions-popup-admin-preview__status {{ old('admissions_popup_is_active', $settings->admissions_popup_is_active) ? 'is-active' : 'is-inactive' }}">
                {{ old('admissions_popup_is_active', $settings->admissions_popup_is_active) ? 'Active on website' : 'Currently hidden' }}
            </span>
            <span class="admissions-popup-admin-preview__session">
                {{ old('admissions_popup_eyebrow', $settings->admissions_popup_eyebrow) }} · {{ old('admissions_popup_session', $settings->admissions_popup_session) }}
            </span>
            <h3>{{ old('admissions_popup_heading', $settings->admissions_popup_heading) }}</h3>
            <p>{{ old('admissions_popup_body', $settings->admissions_popup_body) }}</p>
            <small class="admissions-popup-admin-preview__programs-label">Active admission programs</small>
            <div class="admissions-popup-admin-preview__programs">
                @forelse($admissionsPopupPrograms as $program)
                    <span>{{ $program->title }}</span>
                @empty
                    <span>No active programs</span>
                @endforelse
            </div>
            <div class="admissions-popup-admin-preview__button">
                {{ old('admissions_popup_button_label', $settings->admissions_popup_button_label) }}
                <span aria-hidden="true">&rarr;</span>
            </div>
        </aside>
    </form>

    <section class="admin-table-card admissions-program-manager" id="admissions-programs">
        <div class="admin-card-head">
            <div>
                <span class="admin-kicker">Admission Offerings</span>
                <h2>Manage Programs</h2>
                <p>Add, update, publish, or remove programs here. Active programs are listed in the public admissions popup.</p>
            </div>
            <span class="admissions-program-manager__count">{{ $managedPrograms->count() }} {{ \Illuminate\Support\Str::plural('program', $managedPrograms->count()) }}</span>
        </div>

        <form class="admissions-program-create" method="POST" action="{{ route('admin.admissions-popup.programs.store') }}">
            @csrf
            <div class="admissions-program-create__heading">
                <span class="admissions-program-create__icon" aria-hidden="true">+</span>
                <div>
                    <h3>Add a program</h3>
                    <p>Create a new admission offering for the website.</p>
                </div>
            </div>
            <div class="admissions-program-form-grid">
                <label>
                    Program Name
                    <input name="title" value="{{ old('title') }}" maxlength="160" placeholder="Doctor of Pharmacy" required>
                    @error('title') <small class="field-error">{{ $message }}</small> @enderror
                </label>
                <label>
                    URL Slug
                    <input name="slug" value="{{ old('slug') }}" maxlength="190" placeholder="Generated from program name">
                    @error('slug') <small class="field-error">{{ $message }}</small> @enderror
                </label>
                <label>
                    Icon Label
                    <input name="icon_label" value="{{ old('icon_label', 'Rx') }}" maxlength="16" required>
                    @error('icon_label') <small class="field-error">{{ $message }}</small> @enderror
                </label>
                <label>
                    Sort Order
                    <input type="number" name="sort_order" value="{{ old('sort_order', ($managedPrograms->max('sort_order') ?? 0) + 1) }}" min="0" max="999" required>
                    @error('sort_order') <small class="field-error">{{ $message }}</small> @enderror
                </label>
                <label>
                    Accent
                    <select name="accent" required>
                        @foreach(['sky', 'teal', 'indigo', 'cyan', 'rose', 'pink', 'lavender', 'peach'] as $accent)
                            <option value="{{ $accent }}" @selected(old('accent', 'sky') === $accent)>{{ ucfirst($accent) }}</option>
                        @endforeach
                    </select>
                    @error('accent') <small class="field-error">{{ $message }}</small> @enderror
                </label>
                <label class="admissions-program-form-grid__description">
                    Short Description
                    <textarea name="description" rows="2" maxlength="700" placeholder="A short introduction to this program.">{{ old('description') }}</textarea>
                    @error('description') <small class="field-error">{{ $message }}</small> @enderror
                </label>
                <label class="admissions-program-active-toggle">
                    <input type="checkbox" name="is_active" value="1" @checked(old('is_active', true))>
                    <span>Show this program in the admissions popup</span>
                </label>
                <div class="admissions-program-form-actions">
                    <button class="admin-create-link" type="submit">Add Program</button>
                </div>
            </div>
        </form>

        <div class="admissions-program-list">
            @forelse($managedPrograms as $program)
                <article class="admissions-program-item">
                    <div class="admissions-program-item__heading">
                        <span class="admissions-program-item__icon">{{ $program->icon_label ?: 'Rx' }}</span>
                        <div>
                            <h3>{{ $program->title }}</h3>
                            <span class="admissions-popup-admin-preview__status {{ $program->is_active ? 'is-active' : 'is-inactive' }}">
                                {{ $program->is_active ? 'Visible in popup' : 'Hidden from popup' }}
                            </span>
                        </div>
                        <form method="POST" action="{{ route('admin.admissions-popup.programs.destroy', $program) }}" onsubmit="return confirm('Delete this program? This cannot be undone.');">
                            @csrf
                            @method('DELETE')
                            <button class="admissions-program-item__delete" type="submit" aria-label="Delete {{ $program->title }}">Delete</button>
                        </form>
                    </div>

                    <form class="admissions-program-form-grid admissions-program-item__form" method="POST" action="{{ route('admin.admissions-popup.programs.update', $program) }}">
                        @csrf
                        @method('PUT')
                        <label>
                            Program Name
                            <input name="title" value="{{ $program->title }}" maxlength="160" required>
                        </label>
                        <label>
                            URL Slug
                            <input name="slug" value="{{ $program->slug }}" maxlength="190">
                        </label>
                        <label>
                            Icon Label
                            <input name="icon_label" value="{{ $program->icon_label }}" maxlength="16" required>
                        </label>
                        <label>
                            Sort Order
                            <input type="number" name="sort_order" value="{{ $program->sort_order }}" min="0" max="999" required>
                        </label>
                        <label>
                            Accent
                            <select name="accent" required>
                                @foreach(['sky', 'teal', 'indigo', 'cyan', 'rose', 'pink', 'lavender', 'peach'] as $accent)
                                    <option value="{{ $accent }}" @selected($program->accent === $accent)>{{ ucfirst($accent) }}</option>
                                @endforeach
                            </select>
                        </label>
                        <label class="admissions-program-form-grid__description">
                            Short Description
                            <textarea name="description" rows="2" maxlength="700">{{ $program->description }}</textarea>
                        </label>
                        <label class="admissions-program-active-toggle">
                            <input type="checkbox" name="is_active" value="1" @checked($program->is_active)>
                            <span>Show this program in the admissions popup</span>
                        </label>
                        <div class="admissions-program-form-actions">
                            <button type="submit">Save Program</button>
                        </div>
                    </form>
                </article>
            @empty
                <div class="admin-empty-state">
                    <span>No programs yet</span>
                    <h3>Add your first admission program.</h3>
                    <p>Active programs will appear in the admissions popup.</p>
                </div>
            @endforelse
        </div>
    </section>
@endsection
