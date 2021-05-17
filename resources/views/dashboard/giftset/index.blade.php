@extends('layout.dashboard')

{{-- page Title --}}
@section('page_title','Comboset')

{{-- custom stylesheet --}}
@section('dashboard_stylesheet')
    <link rel="stylesheet" href="{{asset('css/dashboard/giftset.css')}}">
@endsection

{{-- Breadcrumb --}}
@section('breadcrumb')
    <li class="breadcrumb-item" aria-current="page">
        <a href="{{ url('/dashboard') }}" class="breadcrumb-link">Dashboard</a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">Comboset</li>
    <li class="breadcrumb-item active" aria-current="page">List</li>
@endsection

@section('dashboard_content')
{{-- BEGIN:: Giftset --}}
    <h3 class="mt-3">Product Variants Comboset </h3>
    {{-- <h4>Maximum 8 GiftSets</h4> --}}
    {{-- giftset container --}}
    <div class="giftset-container">
        @foreach ($giftsets as $giftset)
            <div class="giftset-content-wrapper">
                {{-- thumbnail and name --}}
                <div class="giftset-thumbnail-wrapper">
                    <div class="thumbnail-wrapper">
                        @if ($giftset->thumbnail == null)
                            <img src="{{asset('icon/dashboard/invalid_img.png')}}" style="width: 10em;" alt="giftset thumbnail">
                        @else
                            <img src="{{asset('storage/'. $giftset->thumbnail)}}" alt="giftset thumbnail">
                        @endif
                    </div>
                    <p class="giftset-name-text">{{$giftset->giftset_name}}</p>
                </div>
                {{-- detail and options --}}
                <div class="giftset-detail-wrapper">
                    <div class="option-wrapper">
                        {{-- <button class="btn btn-sm btn-outline-gray">Detail</button> --}}
                        <a href="{{url("dashboard/giftsets/detail/$giftset->giftset_id")}}" class="btn btn-sm btn-outline-gray">Detail</a>
                        <form action="{{url("dashboard/giftsets/$giftset->giftset_id")}}" method="POST">
                            @csrf
                            @method("delete")
                            <button class="btn btn-sm btn-outline-danger btn-delete">Delete</button>
                        </form>
                    </div>
                    <div class="detail-wrapper">
                        <p>Set Price: {{$giftset->giftset_price}}$</p>
                        <p>Number of Product Variants: {{count($giftset->productVariants)}}x</p>
                        <p>Expire date: {{$giftset->expires_at}}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    {{-- add giftset --}}
    <a href="{{url('dashboard/giftsets/create')}}" class="container btn btn-outline-dark mt-3 d-flex justify-content-center">
        <img class="my-auto" src="{{asset('icon/dashboard/add.png')}}" width="20px" height="20px" alt="plus icon">
        <p class="ml-2 m-0">Add New Comboset</p>
    </a>
{{-- END:: Giftset --}}
@endsection
@section('dashboard_script')
    <script>
        $(document).ready(function(){
            // confirm before delete
            $('.btn-delete').on('click', function(){
                return confirm('Are you sure to delete this giftset?'); 
            })
        })
    </script>    
@endsection