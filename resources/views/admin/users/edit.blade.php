@extends('admin.layout.main')

@section('seo-title')
<title>{{ __('Edit') . ' ' . $user->firstName . ' ' . $user->lastName }}</title>
@endsection

@section('custom-css')

@endsection

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">{{ __('Edit') . ' ' . $user->firstName . ' ' . $user->lastName }}</h1>
<div class='row'>
    <div class="offset-lg-2 col-lg-8">
        <!-- Basic Card Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">{{ __('Admin user details') }}</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('users.update', ['user' => $user->id]) }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label>First Name</label>
                        <input type="text" name='firstName' value='{{ old("firstName", $user->firstName) }}' class="form-control">
                        @if($errors->has('firstName'))
                            <div class='text text-danger'>
                                {{ $errors->first('firstName') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Last Name</label>
                        <input type="text" name='lastName' value='{{ old("lastName", $user->lastName) }}' class="form-control">
                        @if($errors->has('lastName'))
                            <div class='text text-danger'>
                                {{ $errors->first('lastName') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Phone</label>
                        <input type="text" name='phone' value='{{ old("phone", $user->phone) }}' class="form-control">
                        @if($errors->has('phone'))
                            <div class='text text-danger'>
                                {{ $errors->first('phone') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Email address</label>
                        <input disabled type="text" name='email' value='{{ old("email", $user->email) }}' class="form-control" placeholder="name@example.com">
                        @if($errors->has('email'))
                        <div class='text text-danger'>
                            {{ $errors->first('email') }}
                        </div>
                        @endif
                    </div>
                    <div class="form-group {{ (auth()->user()->role == \App\User::STAFF || $user->role == \App\User::ADMINISTRATOR) ? 'd-none' : '' }}">
                        <label>Role</label>
                        <select class="form-control" name="role">
                            <option value=''>-- Choose role --</option>
                            <option value='{{ \App\User::ADMINISTRATOR }}' {{ (old('role', $user->role) == \App\User::ADMINISTRATOR) ? 'selected':'' }}>{{ ucfirst(\App\User::ADMINISTRATOR) }}</option>
                            <option value='{{ \App\User::STAFF }}' {{ (old('role', $user->role) == \App\User::STAFF) ? 'selected':'' }}>{{ ucfirst(\App\User::STAFF) }}</option>
                        </select>
                        @if($errors->has('role'))
                        <div class='text text-danger'>
                            {{ $errors->first('role') }}
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

