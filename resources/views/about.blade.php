@extends('layouts.app')

@section('title', 'Về chúng tôi — ' . config('app.name'))

@section('content')
    {{-- Tiêu đề trang (chừa khoảng cho thanh menu cố định) --}}
    <section class="bg-ink pt-32 pb-4 lg:pt-40">
        <div class="mx-auto max-w-7xl px-6 text-center lg:px-10">
            <p class="eyebrow">Về chúng tôi</p>
            <h1 class="mt-4 font-serif text-4xl font-light tracking-wide lg:text-6xl">Câu Chuyện STUDIO</h1>
            <div class="mx-auto mt-6 h-px w-16 bg-accent/70"></div>
        </div>
    </section>

    @include('partials.services', ['services' => $services])

    @include('partials.about', ['stats' => $stats])

    @include('partials.workflow', ['workflowSteps' => $workflowSteps])

    @include('partials.partners', ['partners' => $partners])

    @include('partials.feedback', ['feedbacks' => $feedbacks])

    @include('partials.insights', ['posts' => $posts])
@endsection
