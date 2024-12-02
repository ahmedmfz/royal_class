@extends('jobs::layouts.master')

@section('content')
    <h1>Hello World</h1>

    <p>Module: {!! config('jobs.name') !!}</p>
@endsection
