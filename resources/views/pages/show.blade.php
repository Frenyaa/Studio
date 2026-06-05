@extends('layouts.app')

@section('title', ($page->meta_title ?: $page->title) . ' — ' . config('app.name'))
@section('meta_description', $page->meta_description)

@section('content')
    <section class="bg-cream pt-32 pb-12 text-center lg:pt-40">
        <div class="mx-auto max-w-3xl px-6">
            <p class="eyebrow">{{ config('app.name') }}</p>
            <h1 class="mt-4 font-serif text-4xl font-light leading-tight tracking-wide lg:text-5xl">{{ $page->title }}</h1>
            <div class="mx-auto mt-6 h-px w-16 bg-ink/30"></div>
        </div>
    </section>

    <section class="bg-cream pb-24">
        <div class="prose prose-neutral mx-auto max-w-3xl px-6 prose-headings:font-serif prose-headings:font-light">
            {!! $page->content !!}
        </div>
    </section>
@endsection
