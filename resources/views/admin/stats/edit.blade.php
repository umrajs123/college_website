@extends('admin.layouts.app')

@php($isCreate = $isCreate ?? false)

@section('title', $isCreate ? 'Add Statistic' : 'Edit '.$stat->label)
@section('eyebrow', 'Homepage Content')
@section('page_title', $isCreate ? 'Add Statistic' : 'Edit Statistic')

@section('content')
    <form class="admin-form-shell" method="POST" action="{{ $isCreate ? route('admin.stats.store') : route('admin.stats.update', $stat) }}">
        @csrf
        @unless($isCreate)
            @method('PUT')
        @endunless

        <section class="admin-form-card">
            <div class="admin-card-head">
                <div>
                    <span class="admin-kicker">Counter Details</span>
                    <h2>{{ $isCreate ? 'New Animated Counter' : 'Counter Content' }}</h2>
                    <p>{{ $isCreate ? 'Add a polished number card for the homepage stats section.' : 'Changes update the homepage animated counter after saving.' }}</p>
                </div>
            </div>

            <div class="admin-form-grid">
                <label class="span-2">
                    Label
                    <input name="label" value="{{ old('label', $stat->label) }}" placeholder="Students Trained" required>
                    @error('label') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label>
                    Value
                    <input type="number" name="value" value="{{ old('value', $stat->value) }}" min="0" max="9999999" required>
                    @error('value') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label>
                    Icon Label
                    <input name="icon_label" value="{{ old('icon_label', $stat->icon_label) }}" placeholder="SCPS">
                    @error('icon_label') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label>
                    Prefix
                    <input name="prefix" value="{{ old('prefix', $stat->prefix) }}" placeholder="">
                    @error('prefix') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label>
                    Suffix
                    <input name="suffix" value="{{ old('suffix', $stat->suffix) }}" placeholder="+">
                    @error('suffix') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label>
                    Accent
                    <select name="accent" required>
                        @foreach(['sky', 'teal', 'indigo', 'cyan', 'rose', 'pink', 'lavender', 'peach'] as $accent)
                            <option value="{{ $accent }}" @selected(old('accent', $stat->accent) === $accent)>{{ ucfirst($accent) }}</option>
                        @endforeach
                    </select>
                    @error('accent') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label>
                    Sort Order
                    <input type="number" name="sort_order" value="{{ old('sort_order', $stat->sort_order) }}" min="0" max="999" required>
                    @error('sort_order') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label class="span-2">
                    Short Note
                    <textarea name="description" rows="4" placeholder="Optional internal or public note for this statistic.">{{ old('description', $stat->description) }}</textarea>
                    @error('description') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label class="admin-check span-2">
                    <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $stat->is_active))>
                    <span>Show this counter on the website</span>
                </label>
            </div>
        </section>

        <aside class="admin-preview-card stats-preview-card campus-event-accent campus-event-accent--{{ old('accent', $stat->accent ?: 'sky') }}">
            <span class="admin-kicker">{{ $isCreate ? 'New Counter' : 'Current Counter' }}</span>
            <span class="stats-preview-icon">{{ old('icon_label', $stat->icon_label ?: '#') }}</span>
            <h3>{{ old('prefix', $stat->prefix) }}{{ number_format((int) old('value', $stat->value ?: 0)) }}{{ old('suffix', $stat->suffix) }}</h3>
            <p>{{ old('label', $stat->label) ?: 'Students Trained' }}</p>
            <div class="admin-form-actions">
                <a href="{{ route('admin.stats.index') }}">Cancel</a>
                <button type="submit">{{ $isCreate ? 'Create Statistic' : 'Save Changes' }}</button>
            </div>
        </aside>
    </form>
@endsection
