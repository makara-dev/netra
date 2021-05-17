@extends('layout.app')

@section('title','Eyescare')

@section('stylesheet')
@parent
    <link rel="stylesheet" href="{{ asset('css/eyescare.css') }}">
@endsection

@section('content')
{{-- BEGIN:: Eyescare Wrapper --}}
<div class="eyescare-wrapper">
    {{-- Eyescare Blog --}}
    <div class="eyescare-category-wrapper">
        <div class="eyescare-image-wrapper">
            <a href="{{url('eyescare/blog')}}">
                <img src="{{asset('img/eyescare/blog.png')}}" alt="Blog Image">
            </a>
        </div>
        <div class="eyescare-description-wrapper">
            <h4>Blog</h4>
            <p>Description</p>
        </div>
    </div>
    {{-- Eyescare DIY --}}
    <div class="eyescare-category-wrapper">
        <div class="eyescare-image-wrapper">
            <a href="{{url('eyescare/diy')}}">
                <img src="{{asset('img/eyescare/diy.png')}}" alt="Diy Image">
            </a>
        </div>
        <div class="eyescare-description-wrapper">
            <h4>DIY</h4>
            <p>Description</p>
        </div>
    </div>
    {{-- Eyescare Youtube --}}
    <div class="eyescare-category-wrapper">
        <div class="eyescare-image-wrapper">
            <a href="{{url('eyescare/youtube/')}}">
                <img src="{{asset('img/eyescare/vlog.png')}}" alt="Youtube Image">
            </a>
        </div>
        <div class="eyescare-description-wrapper">
            <h4>Youtube</h4>
            <p>Description</p>
        </div>
    </div>
</div>
{{-- END:: Eyescare Wrapper --}}
@endsection