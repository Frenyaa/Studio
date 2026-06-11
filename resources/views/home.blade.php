@extends('layouts.app')

@section('content')
    @include('partials.hero', ['hero' => $hero])

    @include('partials.categories', ['categories' => $productCategories])

    @include('partials.products', ['featuredProducts' => $featuredProducts])

    @include('partials.portfolio', ['featuredProjects' => $featuredProjects])

    @include('partials.spotlight', ['spotlight' => $spotlight])

    @include('partials.cta')

    @include('partials.contact')
@endsection
