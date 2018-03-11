@extends('layouts.app')

@section('content')

    <div id="app" class="h-screen overflow-hidden">

        {{-- <breadcrumbs class="align-self-stretch"></breadcrumbs> --}}

        <router-view></router-view>
    </div>

@endsection
