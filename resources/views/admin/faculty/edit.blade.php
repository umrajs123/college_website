@extends('admin.layouts.app')

@php($isCreate = $isCreate ?? false)

@section('title', $isCreate ? 'Add Faculty Member' : 'Edit Faculty Member')
@section('eyebrow', 'People & Profiles')
@section('page_title', $isCreate ? 'Add Faculty Member' : 'Edit Faculty Member')

@section('content')
    <form class="admin-form-shell" method="POST" action="{{ $isCreate ? route('admin.faculty.store') : route('admin.faculty.update', $member) }}" enctype="multipart/form-data">
        @csrf
        @unless($isCreate)
            @method('PUT')
        @endunless

        <section class="admin-form-card">
            <div class="admin-card-head">
                <div>
                    <span class="admin-kicker">Faculty Details</span>
                    <h2>{{ $isCreate ? 'New Profile' : 'Profile Content' }}</h2>
                    <p>These details power the faculty listing and individual profile pages.</p>
                </div>
            </div>

            <div class="admin-form-grid">
                <label>
                    Name
                    <input name="name" value="{{ old('name', $member->name) }}" placeholder="Adnan K Umraj" required>
                    @error('name') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label>
                    Slug
                    <input name="slug" value="{{ old('slug', $member->slug) }}" placeholder="adnan-k-umraj">
                    @error('slug') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label>
                    Designation
                    <input name="designation" value="{{ old('designation', $member->designation) }}" required>
                    @error('designation') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label>
                    Department
                    <input name="department" value="{{ old('department', $member->department) }}" required>
                    @error('department') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label class="span-2">
                    Summary
                    <textarea name="summary" rows="3" required>{{ old('summary', $member->summary) }}</textarea>
                    @error('summary') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label class="span-2">
                    Biography
                    <textarea name="bio" rows="6" required>{{ old('bio', $member->bio) }}</textarea>
                    @error('bio') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label>
                    Education
                    <input name="education" value="{{ old('education', $member->education) }}">
                    @error('education') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label>
                    Experience
                    <input name="experience" value="{{ old('experience', $member->experience) }}">
                    @error('experience') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label>
                    Email
                    <input type="email" name="email" value="{{ old('email', $member->email) }}">
                    @error('email') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label>
                    Office
                    <input name="office" value="{{ old('office', $member->office) }}">
                    @error('office') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label class="span-2">
                    Specialties
                    <input name="specialties" value="{{ old('specialties', implode(', ', $member->specialties ?? [])) }}" placeholder="Medication safety, Patient counseling">
                    @error('specialties') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label class="span-2">
                    Courses
                    <input name="courses" value="{{ old('courses', implode(', ', $member->courses ?? [])) }}" placeholder="Clinical Pharmacy, Hospital Pharmacy">
                    @error('courses') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label>
                    Accent
                    <select name="accent" required>
                        @foreach(['sky', 'teal', 'indigo', 'cyan', 'rose', 'pink', 'lavender', 'peach'] as $accent)
                            <option value="{{ $accent }}" @selected(old('accent', $member->accent) === $accent)>{{ ucfirst($accent) }}</option>
                        @endforeach
                    </select>
                    @error('accent') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label>
                    Sort Order
                    <input type="number" name="sort_order" value="{{ old('sort_order', $member->sort_order) }}" min="0" max="999" required>
                    @error('sort_order') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label class="span-2">
                    Image URL or Existing Path
                    <input name="image_path" value="{{ old('image_path', $member->image_path) }}" placeholder="https://images.unsplash.com/...">
                    @error('image_path') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label class="span-2">
                    Upload New Image
                    <input type="file" name="image" accept="image/*">
                    @error('image') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label class="admin-check span-2">
                    <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $member->is_active))>
                    <span>Show this faculty member on the website</span>
                </label>
            </div>
        </section>

        <aside class="admin-preview-card">
            <span class="admin-kicker">{{ $isCreate ? 'New Profile' : 'Current Profile' }}</span>
            @if(! $isCreate || $member->image_path)
                <img src="{{ $member->imageUrl() }}" alt="{{ $member->name }}">
            @else
                <div class="admin-empty-preview">Image preview will appear after saving.</div>
            @endif
            <h3>{{ $member->name ?: 'New faculty member' }}</h3>
            <p>{{ $member->summary ?: 'Add the member summary, bio, courses, specialties, and contact details.' }}</p>
            <div class="admin-form-actions">
                <a href="{{ route('admin.faculty.index') }}">Cancel</a>
                <button type="submit">{{ $isCreate ? 'Create Profile' : 'Save Changes' }}</button>
            </div>
        </aside>
    </form>
@endsection
