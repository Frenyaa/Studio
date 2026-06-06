@extends('layouts.app')

@section('title', 'Blog — ' . config('app.name'))

@section('content')
    <section class="bg-ink pt-32 pb-20 lg:pt-40">
        <div class="mx-auto max-w-7xl px-6 lg:px-10">
            <div class="mb-12 text-center">
                <p class="eyebrow">Blog</p>
                <h1 class="mt-4 font-serif text-4xl font-light tracking-wide lg:text-6xl">Góc Tư Vấn & Cảm Hứng</h1>
            </div>

            {{-- Lọc theo chủ đề --}}
            <div class="mb-14 flex flex-wrap items-center justify-center gap-x-8 gap-y-3 text-xs font-medium uppercase tracking-luxe">
                <a href="{{ route('blog.index') }}"
                   class="border-b-2 pb-1 transition-colors {{ ! request('category') ? 'border-accent text-cream' : 'border-transparent text-cream/60 hover:text-cream' }}">
                    Tất cả
                </a>
                @foreach ($categories as $slug => $label)
                    <a href="{{ route('blog.index', ['category' => $slug]) }}"
                       class="border-b-2 pb-1 transition-colors {{ request('category') === $slug ? 'border-accent text-cream' : 'border-transparent text-cream/60 hover:text-cream' }}">
                        {{ $label }}
                    </a>
                @endforeach
            </div>

            @if ($posts->isEmpty())
                <p class="text-center text-cream/70">Chưa có bài viết nào.</p>
            @else
                <div class="grid grid-cols-1 gap-x-8 gap-y-12 md:grid-cols-3">
                    @foreach ($posts as $post)
                        <a href="{{ route('blog.show', $post) }}" class="group block">
                            <div class="relative overflow-hidden bg-ink">
                                <div class="aspect-[4/3] w-full overflow-hidden">
                                    @if ($post->cover_image)
                                        <img src="{{ asset('storage/' . $post->cover_image) }}" alt="{{ $post->title }}" loading="lazy"
                                             class="h-full w-full object-cover transition-transform duration-[1400ms] ease-luxe group-hover:scale-105">
                                    @endif
                                </div>
                            </div>
                            @if ($post->category)
                                <p class="mt-5 text-[11px] uppercase tracking-luxe text-cream/70">{{ $post->category_label }}</p>
                            @endif
                            <h2 class="mt-2 font-serif text-2xl font-light leading-snug text-cream">{{ $post->title }}</h2>
                            @if ($post->excerpt)
                                <p class="mt-3 text-sm leading-relaxed text-cream/70 line-clamp-2">{{ $post->excerpt }}</p>
                            @endif
                        </a>
                    @endforeach
                </div>

                <div class="mt-16">
                    {{ $posts->links() }}
                </div>
            @endif
        </div>
    </section>
@endsection
