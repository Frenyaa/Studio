@extends('layouts.app')

@section('title', 'Liên hệ — ' . config('app.name'))

@section('content')
    {{-- Chừa khoảng cho thanh menu cố định; form liên hệ đã có tiêu đề riêng --}}
    <div class="bg-ink pt-20 lg:pt-24">
        @include('partials.contact')
    </div>
@endsection
