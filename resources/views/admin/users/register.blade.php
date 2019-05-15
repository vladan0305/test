@extends('admin.layout.noauthenticated')

@section('seo-title')
    <title>Register</title>
@endsection

@section('content')
    <div class="text-center">
        <h1 class="h4 text-gray-900 mb-4">Register</h1>
        @if($errors->has('message'))
            <div class='text text-danger'>
                {{ $errors->first('message') }}
            </div>
        @endif
    </div>
    <form class="user" method="post" action="">
        @csrf
        <div class="form-group row">
            <div class="col-sm-6 mb-3 mb-sm-0">
                <input type="text" name='firstName' value='{{ old("firstName") }}' class="form-control form-control-user" placeholder="First Name">
                @if($errors->has('firstName'))
                    <div class='text text-danger'>
                        {{ $errors->first('firstName') }}
                    </div>
                @endif
            </div>
            <div class="col-sm-6">
                <input type="text" name='lastName' value='{{ old("lastName") }}' class="form-control form-control-user" placeholder="Last Name">
                @if($errors->has('lastName'))
                    <div class='text text-danger'>
                        {{ $errors->first('lastName') }}
                    </div>
                @endif
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-6 mb-3 mb-sm-0">
                <input type="email" name='email' value='{{ old("email") }}' class="form-control form-control-user" placeholder="Email Address">
                @if($errors->has('email'))
                    <div class='text text-danger'>
                        {{ $errors->first('email') }}
                    </div>
                @endif
            </div>
            <div class="col-sm-6">
                <input type="text" name='phone' value='{{ old("phone") }}' class="form-control form-control-user" placeholder="Phone">
                @if($errors->has('phone'))
                    <div class='text text-danger'>
                        {{ $errors->first('phone') }}
                    </div>
                @endif
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-6 mb-3 mb-sm-0">
                <input type="password" class="form-control form-control-user" name="password" placeholder="Password">
            </div>
            <div class="col-sm-6">
                <input type="password" class="form-control form-control-user" name="password_confirmation" placeholder="Repeat Password">
            </div>
        </div>
        <button type="submit" class="btn btn-primary btn-user btn-block">
            Register Account
        </button>
    </form>
    <hr>
@endsection