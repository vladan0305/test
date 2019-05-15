@extends('admin.layout.main')

@section('seo-title')
<title>{{ __('Edit') }}</title>
@endsection

@section('custom-css')

@endsection

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">{{ __('Edit admission') . " " . $admission->name }}</h1>
<div class='row'>
    <div class="offset-lg-2 col-lg-8">
        <!-- Basic Card Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">{{ __('New admission details') }}</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('admissions.store') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name='name' value='{{ old("name", $admission->name) }}' class="form-control">
                        @if($errors->has('name'))
                            <div class='text text-danger'>
                                {{ $errors->first('name') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea name='description' class="form-control">{{ old('description', $admission->description) }}</textarea>
                        @if($errors->has('description'))
                            <div class='text text-danger'>
                                {{ $errors->first('description') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group text-right">
                        <button type='submit' class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection

@section('custom-js')

@endsection

