@extends('layouts.app')

@section('content')

    <div id="app" class="container-fluid p-2">

        <breadcrumbs class="align-self-stretch"></breadcrumbs>

        {{-- <lock></lock> --}}

        <router-view></router-view>
    </div>

@endsection
