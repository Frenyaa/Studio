@extends('layouts.app')

@section('title', ($page->meta_title ?: $page->title) . ' — ' . config('app.name'))
@section('meta_description', $page->meta_description)

@section('content')
    <section class="bg-ink pt-32 pb-12 text-center lg:pt-40">
        <div class="mx-auto max-w-3xl px-6">
            <p class="eyebrow">{{ config('app.name') }}</p>
            <h1 class="mt-4 font-serif text-4xl font-light leading-tight tracking-wide lg:text-5xl">{{ $page->title }}</h1>
            <div class="mx-auto mt-6 h-px w-16 bg-accent/70"></div>
        </div>
    </section>

    <section class="bg-ink pb-24">
        <div class="prose mx-auto max-w-3xl px-6 prose-headings:font-serif prose-headings:font-light prose-headings:text-cream prose-p:text-cream/80 prose-li:text-cream/80 prose-strong:text-cream prose-a:text-accent">
            {!! $page->content !!}
        </div>
    </section>
@endsection
