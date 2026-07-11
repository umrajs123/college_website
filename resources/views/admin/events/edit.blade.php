@extends('admin.layouts.app')

@php($isCreate = $isCreate ?? false)

@section('title', $isCreate ? 'Add Campus Event' : 'Edit Campus Event')
@section('eyebrow', 'Homepage Content')
@section('page_title', $isCreate ? 'Add Campus Event' : 'Edit Campus Event')

@section('content')
    <form class="admin-form-shell" method="POST" action="{{ $isCreate ? route('admin.events.store') : route('admin.events.update', $event) }}">
        @csrf
        @unless($isCreate)
            @method('PUT')
        @endunless

        <section class="admin-form-card">
            <div class="admin-card-head">
                <div>
                    <span class="admin-kicker">Event Details</span>
                    <h2>{{ $isCreate ? 'New Calendar Entry' : 'Calendar Entry' }}</h2>
                    <p>{{ $isCreate ? 'Add a homepage event with date, time, venue, and category.' : 'Changes update the public homepage event list after saving.' }}</p>
                </div>
            </div>

            <div class="admin-form-grid">
                <label class="span-2">
                    Title
                    <input name="title" value="{{ old('title', $event->title) }}" placeholder="Orientation for New Pharmacy Students" required>
                    @error('title') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label>
                    Date and Time
                    <input type="datetime-local" name="starts_at" value="{{ old('starts_at', optional($event->starts_at)->format('Y-m-d\TH:i')) }}" required>
                    @error('starts_at') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label>
                    Sort Order
                    <input type="number" name="sort_order" value="{{ old('sort_order', $event->sort_order) }}" min="0" max="999" required>
                    @error('sort_order') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label>
                    Venue
                    <input name="venue" value="{{ old('venue', $event->venue) }}" placeholder="Main Auditorium">
                    @error('venue') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label>
                    Category
                    <input name="category" value="{{ old('category', $event->category) }}" placeholder="Orientation" required>
                    @error('category') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label>
                    Accent
                    <select name="accent" required>
                        @foreach(['sky', 'teal', 'indigo', 'cyan', 'rose', 'pink', 'lavender', 'peach'] as $accent)
                            <option value="{{ $accent }}" @selected(old('accent', $event->accent) === $accent)>{{ ucfirst($accent) }}</option>
                        @endforeach
                    </select>
                    @error('accent') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label class="span-2">
                    Description
                    <textarea name="description" rows="5" placeholder="Short event details for the homepage.">{{ old('description', $event->description) }}</textarea>
                    @error('description') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label class="admin-check span-2">
                    <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $event->is_active))>
                    <span>Show this event on the website</span>
                </label>
            </div>
        </section>

        <aside class="admin-preview-card event-preview-card">
            <span class="admin-kicker">{{ $isCreate ? 'New Event' : 'Current Event' }}</span>
            <time>
                <strong>{{ optional($event->starts_at)->format('d') ?: now()->format('d') }}</strong>
                <span>{{ optional($event->starts_at)->format('M') ?: now()->format('M') }}</span>
            </time>
            <h3>{{ $event->title ?: 'New campus event' }}</h3>
            <p>{{ $event->description ?: 'Add the title, event time, venue, category, and display accent.' }}</p>
            <small>{{ $event->venue ?: 'Venue pending' }} · {{ optional($event->starts_at)->format('h:i A') ?: 'Time pending' }}</small>
            <div class="admin-form-actions">
                <a href="{{ route('admin.events.index') }}">Cancel</a>
                <button type="submit">{{ $isCreate ? 'Create Event' : 'Save Changes' }}</button>
            </div>
        </aside>
    </form>
@endsection
