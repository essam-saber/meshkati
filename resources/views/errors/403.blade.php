{{-- Extends layout --}}
@extends('layout.default')

{{-- Content --}}
@section('content')
    <div class="card card-custom overflow-hidden">
        <h1 class="text-danger text-center p-20">Sorry you don't have permission to view this content !</h1>
    </div>

@endsection

@section('styles')
    <style>
        .footer{
            position: absolute;
            bottom: 0;
            width: 82.5%;
            height: 3.5rem;
        }
    </style>
@endsection
{{-- Scripts Section --}}

