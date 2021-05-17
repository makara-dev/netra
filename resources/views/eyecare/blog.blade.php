@extends('layout.app')

@section('title','Blog')

@section('stylesheet')
@parent
    <link rel="stylesheet" href="{{ asset('css/eyescare.css') }}">
@endsection

@section('content')
{{-- BEGIN:: Blog Wrapper --}}
<div class="blog-container">
    {{-- filter sidebar --}}
    @include('eyecare.filter-sidebar')
    {{-- blog body --}}
    <div class="blog-wrapper">
        <div class="blog-card-wrapper">
            <div class="blog-image-wrapper">
                <a href="{{url('eyescare/blog/1')}}">
                    <img src="{{asset('img/eyescare/blog1.png')}}" alt="blog image">
                </a>
            </div>
            <div class="blog-description-wrapper">
                <h4>Title</h4>
                <p>Description</p>
                <p class="date-text">Date</p>
            </div>
        </div>
        <div class="blog-card-wrapper">
            <div class="blog-image-wrapper">
                <a href="{{url('eyescare/blog/2')}}">
                    <img src="{{asset('img/eyescare/blog2.png')}}" alt="blog image">
                </a>
            </div>
            <div class="blog-description-wrapper">
                <h4>Title</h4>
                <p>Description</p>
                <p class="date-text">Date</p>
            </div>
        </div>
        <div class="blog-card-wrapper">
            <div class="blog-image-wrapper">
                <a href="{{url('eyescare/blog/3')}}">
                    <img src="{{asset('img/eyescare/blog3.png')}}" alt="blog image">
                </a>
            </div>
            <div class="blog-description-wrapper">
                <h4>Title</h4>
                <p>Description</p>
                <p class="date-text">Date</p>
            </div>
        </div>
    </div>
</div>
{{-- END:: Blog Wrapper --}}
@endsection

@section('script')
    {{-- filter side bar js --}}
    <script src="{{asset('js/eyescare-filter.js')}}"></script>
@endsection