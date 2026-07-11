@extends('admin.layouts.app')

@section('title', 'Hero Slides')
@section('eyebrow', 'Homepage Content')
@section('page_title', 'Hero Slides')

@section('content')
    <section class="admin-table-card">
        <div class="admin-card-head">
            <div>
                <span class="admin-kicker">Hero Slider</span>
                <h2>Homepage Slides</h2>
                <p>Edit the slide image, heading, copy, buttons, order, and visibility.</p>
            </div>
            <a class="admin-create-link" href="{{ route('admin.hero-slides.create') }}">Add New Slide</a>
        </div>

        <div class="hero-admin-list">
            @foreach($slides as $slide)
                <article>
                    <img src="{{ $slide->imageUrl() }}" alt="{{ $slide->image_alt ?: $slide->heading }}">
                    <div>
                        <span class="status-pill {{ $slide->is_active ? 'active' : '' }}">{{ $slide->is_active ? 'Active' : 'Hidden' }}</span>
                        <h3>{{ $slide->heading }}</h3>
                        <p>{{ $slide->body }}</p>
                        <small>{{ $slide->eyebrow }} · Order {{ $slide->sort_order }}</small>
                    </div>
                    <a href="{{ route('admin.hero-slides.edit', $slide) }}">Edit</a>
                </article>
            @endforeach
        </div>
    </section>
@endsection
