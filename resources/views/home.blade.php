@extends('layouts.app')

@section('content')
    @include('partials.hero', ['hero' => $hero])

    @include('partials.categories', ['categories' => $productCategories])

    @include('partials.products', ['featuredProducts' => $featuredProducts])

    @include('partials.portfolio', ['featuredProjects' => $featuredProjects])

    @include('partials.spotlight', ['spotlight' => $spotlight])

    @include('partials.services', ['services' => $services])

    @include('partials.about', ['stats' => $stats])

    @include('partials.workflow', ['workflowSteps' => $workflowSteps])

    @include('partials.partners', ['partners' => $partners])

    @include('partials.feedback', ['feedbacks' => $feedbacks])

    @include('partials.insights', ['posts' => $posts])

    @include('partials.cta')

    @include('partials.contact')
@endsection
