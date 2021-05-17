@extends('layout.app')

@section('title','DIY')

@section('stylesheet')
@parent
    <link rel="stylesheet" href="{{ asset('css/eyescare.css') }}">
@endsection

@section('content')
{{-- BEGIN:: DIY Wrapper --}}
<div class="diy-container">
    {{-- filter sidebar --}}
    @include('eyecare.filter-sidebar')
    {{-- diy body --}}
    <div class="diy-wrapper">
        <div class="diy-card-wrapper">
            <div class="diy-image-wrapper">
                <a href="{{url('eyescare/diy/1')}}">
                    <img src="{{asset('img/eyescare/diy1.png')}}" alt="diy image">
                </a>
            </div>
            <div class="diy-description-wrapper">
                <h4>Item Name</h4>
                <p>Description</p>
                <p class="date-text">Date</p>
            </div>
        </div>
        <div class="diy-card-wrapper">
            <div class="diy-image-wrapper">
                <a href="{{url('eyescare/diy/2')}}">
                    <img src="{{asset('img/eyescare/diy2.png')}}" alt="diy image">
                </a>
            </div>
            <div class="diy-description-wrapper">
                <h4>Item Name</h4>
                <p>Description</p>
                <p class="date-text">Date</p>
            </div>
        </div>
        <div class="diy-card-wrapper">
            <div class="diy-image-wrapper">
                <a href="{{url('eyescare/diy/3')}}">
                    <img src="{{asset('img/eyescare/diy3.png')}}" alt="diy image">
                </a>
            </div>
            <div class="diy-description-wrapper">
                <h4>Item Name</h4>
                <p>Description</p>
                <p class="date-text">Date</p>
            </div>
        </div>
    </div>
</div>
{{-- END:: DIY Wrapper --}}
@endsection

@section('script')
    {{-- filter side bar js --}}
    <script src="{{asset('js/eyescare-filter.js')}}"></script>
@endsection