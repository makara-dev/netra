@extends('layout.dashboard')

{{-- page title --}}
@section('page_title', 'Giftset')

{{-- custom style --}}
@section('dashboard_stylesheet')
    <link rel="stylesheet" href="{{asset('css/dashboard/promoset.css')}}">
@endsection

{{-- breadcrumb --}}
@section('breadcrumb')
    <li class="breadcrumb-item" aria-current="page">
        <a href="{{ url('/dashboard') }}" class="breadcrumb-link">Dashboard</a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">Giftsets</li>
    <li class="breadcrumb-item active" aria-current="page">List</li>
@endsection

{{-- main content --}}
@section('dashboard_content')
{{-- BEGIN::Main Promoset --}}
    <h3 class="mt-3">Giftsets Listing (Total: {{$totalPromoset}}x Items)</h3>
    <div class="promoset-container">
        @foreach ($promosets as $promoset)
            <div class="promoset-content-wrapper">
                {{-- thumbnail --}}
                <div class="promoset-thumbnail-wrapper">
                    <div class="thumbnail-wrapper">
                        @if ($promoset->promoset_thumbnail != null)
                            <img src="{{asset('storage/'.$promoset->promoset_thumbnail)}}" alt="giftset thumbnail">
                        @else
                            <img class="invalid-img" src="{{asset('icon/dashboard/invalid_img.png')}}" style="width: 10em;" alt="giftset thumbnail">
                        @endif
                    </div>
                </div>
                {{-- detail and option --}}
                <div class="promoset-detail-wrapper">
                    <div class="detail-wrapper">
                        <p>Giftset Name: {{$promoset->promoset_name}}</p>
                        <p>Created Date: {{$promoset->created_at}}</p>
                    </div>
                    <div class="options-wrapper">
                        <a href="{{url("dashboard/promosets/detail/$promoset->promoset_id")}}" class="btn btn-sm btn-outline-gray">Detail</a>
                        <form action="{{url("dashboard/promosets/$promoset->promoset_id")}}" method="POST">
                            @csrf
                            @method("delete")
                            <button class="btn btn-sm btn-outline-danger btn-delete">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div style="display: flex; justify-content: center;">
        {{ $promosets->links() }}
    </div>
    {{-- add giftset --}}
    <a href="{{url('dashboard/promosets/create')}}" class="container btn btn-outline-dark mt-3 d-flex justify-content-center">
        <img class="my-auto" src="{{asset('icon/dashboard/add.png')}}" width="20px" height="20px" alt="plus icon">
        <p class="ml-2 m-0">Add New Giftsets</p>
    </a>
{{-- END::Main Promoset --}}
@endsection

{{-- script section --}}
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