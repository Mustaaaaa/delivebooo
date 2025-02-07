@extends('layouts.app')
@section('title', 'Profilo')

@section('content')

<div class="container container-transparent p-4 rounded-3 shadow">
    <h2 class="fs-4 text-white my-4">
        {{ __('Profilo') }}
    </h2>
    <div class="card p-4 mb-4 bg-white shadow rounded-lg">

        @include('profile.partials.update-profile-information-form')

    </div>

    <div class="card p-4 mb-4 bg-white shadow rounded-lg">


        @include('profile.partials.update-password-form')

    </div>

  
</div>

@endsection
