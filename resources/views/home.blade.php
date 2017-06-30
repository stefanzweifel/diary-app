@extends('layouts.app')

@section('content')

    <div id="app" class="container">

        <breadcrumbs></breadcrumbs>

        <lock></lock>

        <router-view></router-view>
    </div>

@endsection
