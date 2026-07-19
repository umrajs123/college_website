@extends('admin.layouts.app')

@section('title', 'Site Settings')
@section('eyebrow', 'Global Website')
@section('page_title', 'Site Settings')

@section('content')
    <form class="admin-form-shell settings-form-shell" method="POST" enctype="multipart/form-data" action="{{ route('admin.settings.update') }}">
        @csrf
        @method('PUT')

        <div class="settings-form-stack">
            <section class="admin-form-card">
                <div class="admin-card-head">
                    <div>
                        <span class="admin-kicker">Identity & Contact</span>
                        <h2>Website Identity</h2>
                        <p>Update the logo, college name, admissions link, contact details, and footer social links from one place.</p>
                    </div>
                </div>

                <div class="admin-form-grid">
                    <label>
                        Site Name
                        <input name="site_name" value="{{ old('site_name', $settings->site_name) }}" placeholder="Swat College" required>
                        @error('site_name') <small class="field-error">{{ $message }}</small> @enderror
                    </label>

                    <label>
                        Tagline
                        <input name="site_tagline" value="{{ old('site_tagline', $settings->site_tagline) }}" placeholder="of Pharmaceutical Sciences">
                        @error('site_tagline') <small class="field-error">{{ $message }}</small> @enderror
                    </label>

                    <label class="span-2">
                        Short Footer Description
                        <textarea name="site_description" rows="3" placeholder="Academic pharmacy education in Swat...">{{ old('site_description', $settings->site_description) }}</textarea>
                        @error('site_description') <small class="field-error">{{ $message }}</small> @enderror
                    </label>

                    <label>
                        Logo URL / Path
                        <input name="logo_path" value="{{ old('logo_path', $settings->logo_path) }}" placeholder="images/scps-logo.png">
                        @error('logo_path') <small class="field-error">{{ $message }}</small> @enderror
                    </label>

                    <label>
                        Upload Logo
                        <input type="file" name="logo" accept="image/*">
                        @error('logo') <small class="field-error">{{ $message }}</small> @enderror
                    </label>

                    <label>
                        Favicon URL / Path
                        <input name="favicon_path" value="{{ old('favicon_path', $settings->favicon_path) }}" placeholder="images/scps-logo.png">
                        @error('favicon_path') <small class="field-error">{{ $message }}</small> @enderror
                    </label>

                    <label>
                        Upload Favicon
                        <input type="file" name="favicon" accept="image/*">
                        @error('favicon') <small class="field-error">{{ $message }}</small> @enderror
                    </label>
                </div>
            </section>

            <section class="admin-form-card">
                <div class="admin-card-head">
                    <div>
                        <span class="admin-kicker">Contact Info</span>
                        <h2>Public Contact Details</h2>
                        <p>These values appear in the footer and related contact areas.</p>
                    </div>
                </div>

                <div class="admin-form-grid">
                    <label>
                        Phone
                        <input name="phone" value="{{ old('phone', $settings->phone) }}" placeholder="+92 946 123456">
                        @error('phone') <small class="field-error">{{ $message }}</small> @enderror
                    </label>

                    <label>
                        Email
                        <input type="email" name="email" value="{{ old('email', $settings->email) }}" placeholder="info@scps.edu.pk">
                        @error('email') <small class="field-error">{{ $message }}</small> @enderror
                    </label>

                    <label class="span-2">
                        Address
                        <input name="address" value="{{ old('address', $settings->address) }}" placeholder="College Road, Swat, Khyber Pakhtunkhwa, Pakistan">
                        @error('address') <small class="field-error">{{ $message }}</small> @enderror
                    </label>

                    <label class="span-2">
                        Admissions URL
                        <input name="admissions_url" value="{{ old('admissions_url', $settings->admissions_url) }}" placeholder="https://scps.digitalcampuspro.com/admin/login">
                        @error('admissions_url') <small class="field-error">{{ $message }}</small> @enderror
                    </label>

                    <label>
                        Facebook URL
                        <input name="facebook_url" value="{{ old('facebook_url', $settings->facebook_url) }}" placeholder="https://facebook.com/...">
                        @error('facebook_url') <small class="field-error">{{ $message }}</small> @enderror
                    </label>

                    <label>
                        LinkedIn URL
                        <input name="linkedin_url" value="{{ old('linkedin_url', $settings->linkedin_url) }}" placeholder="https://linkedin.com/...">
                        @error('linkedin_url') <small class="field-error">{{ $message }}</small> @enderror
                    </label>

                    <label>
                        YouTube URL
                        <input name="youtube_url" value="{{ old('youtube_url', $settings->youtube_url) }}" placeholder="https://youtube.com/...">
                        @error('youtube_url') <small class="field-error">{{ $message }}</small> @enderror
                    </label>

                    <label>
                        Privacy URL
                        <input name="privacy_url" value="{{ old('privacy_url', $settings->privacy_url) }}" placeholder="#">
                        @error('privacy_url') <small class="field-error">{{ $message }}</small> @enderror
                    </label>
                </div>
            </section>
        </div>

        <aside class="admin-preview-card settings-preview-card">
            <span class="admin-kicker">Live Preview</span>
            <div class="settings-preview-card__brand">
                <img src="{{ $settings->logoUrl() }}" alt="Site logo preview">
                <div>
                    <strong>{{ old('site_name', $settings->site_name) }}</strong>
                    <small>{{ old('site_tagline', $settings->site_tagline) }}</small>
                </div>
            </div>
            <p>{{ old('site_description', $settings->site_description) ?: 'Add a concise public description for the footer.' }}</p>
            <div class="settings-preview-card__list">
                <span>{{ old('phone', $settings->phone) ?: 'No phone added' }}</span>
                <span>{{ old('email', $settings->email) ?: 'No email added' }}</span>
                <span>{{ old('address', $settings->address) ?: 'No address added' }}</span>
            </div>
            <div class="admin-form-actions">
                <a href="{{ route('admin.dashboard') }}">Cancel</a>
                <button type="submit">Save Site Settings</button>
            </div>
        </aside>
    </form>
@endsection
