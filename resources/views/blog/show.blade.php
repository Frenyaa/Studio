@extends('layouts.app')

@section('title', ($post->meta_title ?: $post->title) . ' — ' . config('app.name'))
@section('meta_description', $post->meta_description ?: $post->excerpt)

@section('content')
    <article>
        {{-- Tiêu đề + ảnh bìa --}}
        <header class="bg-ink pt-32 pb-12 text-center lg:pt-40">
            <div class="mx-auto max-w-3xl px-6">
                @if ($post->category)
                    <p class="eyebrow">{{ $post->category_label }}</p>
                @endif
                <h1 class="mt-4 font-serif text-4xl font-light leading-tight tracking-wide lg:text-5xl">{{ $post->title }}</h1>
                @if ($post->published_at)
                    <p class="mt-5 text-xs uppercase tracking-luxe text-cream/70">{{ $post->published_at->format('d/m/Y') }}</p>
                @endif
            </div>
        </header>

        @if ($post->cover_image)
            <div class="mx-auto max-w-5xl px-6 lg:px-10">
                <img src="{{ asset('storage/' . $post->cover_image) }}" alt="{{ $post->title }}" class="aspect-[16/9] w-full rounded-sm object-cover">
            </div>
        @endif

        {{-- Nội dung --}}
        <div class="bg-ink py-16">
            <div class="prose prose-invert mx-auto max-w-3xl px-6 prose-headings:font-serif prose-headings:font-light prose-img:rounded-sm">
                {!! $post->content !!}
            </div>
        </div>

        {{-- Bài viết liên quan --}}
        @if ($related->isNotEmpty())
            <section class="border-t border-line bg-ink-soft py-20">
                <div class="mx-auto max-w-7xl px-6 lg:px-10">
                    <h2 class="mb-12 text-center font-serif text-3xl font-light">Bài viết khác</h2>
                    <div class="grid grid-cols-1 gap-x-8 gap-y-10 md:grid-cols-3">
                        @foreach ($related as $item)
                            <a href="{{ route('blog.show', $item) }}" class="group block">
                                <div class="aspect-[4/3] overflow-hidden bg-ink">
                                    @if ($item->cover_image)
                                        <img src="{{ asset('storage/' . $item->cover_image) }}" alt="{{ $item->title }}" loading="lazy"
                                             class="h-full w-full object-cover transition-transform duration-1000 ease-luxe group-hover:scale-105">
                                    @endif
                                </div>
                                <h3 class="mt-4 font-serif text-xl font-light text-cream">{{ $item->title }}</h3>
                            </a>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif
    </article>
@endsection
