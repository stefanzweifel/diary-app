@extends('layouts.app')

@section('content')

    <div id="app" class="container">

        <lock></lock>

        <ul class="list-inline">
            <li><router-link :to="{ name: 'home' }">Home</router-link></li>
        </ul>

        <router-view></router-view>
    </div>

@endsection
