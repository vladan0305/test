@extends('admin.layout.noauthenticated')

@section('seo-title')
<title>Login</title>
@endsection

@section('content')
<div class="text-center">
    <h1 class="h4 text-gray-900 mb-4">Login</h1>
    @if($errors->has('message'))
    <div class='text text-danger'>
         {{ $errors->first('message') }}
    </div>
    @endif
</div>
<form class="user" method="post" action=''>
    @csrf
    <div class="form-group">
        <input type="text" class="form-control form-control-user" name="email" value="{{ old('email') }}" placeholder="Enter Email Address...">
        @if($errors->has('email'))
        <div class='text text-danger'>
             {{ $errors->first('email') }}
        </div>
        @endif
    </div>
    <div class="form-group">
        <input type="password" class="form-control form-control-user" name="password" placeholder="Password">
        @if($errors->has('password'))
        <div class='text text-danger'>
             {{ $errors->first('password') }}
        </div>
        @endif
    </div>
    
    <button type="submit" class="btn btn-primary btn-user btn-block">
        Login
    </button>
</form>
<hr>
@endsection