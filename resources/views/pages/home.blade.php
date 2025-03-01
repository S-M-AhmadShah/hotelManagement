@extends('layouts.app')

@section('header')
    @include('layouts.header')
    <!-- Carousel -->
    @include('sections.carousel')
@endsection

@section('content')
    <!-- Service -->
    @include('sections.service')
    <!-- Room -->
    @include('sections.room-container-brief')

    @include('sections.reviews')
    <!-- Team -->
    @include('sections.team')
    <!-- Newsletter -->
    @include('sections.newsletter')

@endsection

@section('footer')
    @include('layouts.footer')
@endsection
