@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <div id="app">
                <router-view></router-view>
            </div>
        </div>

    </div>
</div>
@endsection
