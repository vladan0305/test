@extends('admin.layout.main')

@section('seo-title')
<title>{{ __('Welcome') }}</title>
@endsection

@section('custom-css')

@endsection

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">{{ __('Welcome') . ' ' . auth()->user()->firstName . ' ' . auth()->user()->lastName }}</h1>

@endsection

@section('custom-js')

@endsection

