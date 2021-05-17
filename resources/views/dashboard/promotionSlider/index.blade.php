@extends('layout.dashboard')

{{-- page title --}}
@section('page_title','Dashboard')

{{-- style sheet --}}
@section('dashboard_stylesheet')
    <link rel="stylesheet" href="{{asset('css/dashboard/promotion-slider.css')}}">
@endsection

{{-- Breadcrumb --}}
@section('breadcrumb')
<li class="breadcrumb-item" aria-current="page">
    <a href="{{ url('/dashboard') }}" class="breadcrumb-link">Dashboard</a>
</li>
<li class="breadcrumb-item" aria-current="page"> 
    <a href="{{url('dashboard/promotionslider')}}" class="breadcrumb-link">Promotion Slider Home Page</a> 
</li>
<li class="breadcrumb-item active" aria-current="page">List</li>
@endsection

@section('dashboard_content')
    <h3 class="mt-3">Home Page Promotion Slide</h3>
    {{-- BEGIN:: Promotion Slide Product Listing --}}
    <div class="promotion-slide-wrapper mt-5">
        {{-- web page --}}
        <div class="web-promotion-slide-wrapper">
            <h3>Web Promotion Slide Image ( 1778x640 )</h3>
            {{-- if doesn't have --}}
            @if (count($webPromotionSliders)==0 || count($webPromotionSliders)<3)
                <form action="{{url('dashboard/promotionslider/add')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-wrapper">
                        <div class="image-block">
                            <label for="web-slider-image" class="cursor-pointer">
                                <img class="web-image" src="{{asset('img/product-carousel/invalid-web-slide.jpg')}}" alt="no-web-slide-image">
                            </label>
                            <input type="file" accept="image/*" name="web-slider-image" id="web-slider-image" class="d-none img-file-web" />                
                        </div>
                        {{-- upload promotion slider --}}
                        <div id="web-upload-btn" class="btn-upload-wrapper">
                            <input type="hidden" name="screen-option" value="desktop">
                            <button class="web-upload-file btn btn-small btn-dark">Set As Web Promotion Slide</button>
                        </div>
                    </div>
                </form>
            @endif
            {{-- if has image --}}
            @foreach ($promotionSliders as $key => $promotionSlider)
                {{-- if path = null --}}
                @if ($promotionSlider->desktop_thumbnail == null) 
                <form action="{{url('dashboard/promotionslider/update',[$promotionSlider->promotion_slider_id])}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-wrapper">
                        <div class="image-block">
                            <label for="{{"web-slider-image-".$key}}" class="cursor-pointer">
                                <img class="update-web-image" src="{{asset('img/product-carousel/invalid-web-slide.jpg')}}" alt="no-web-slide-image">
                            </label>
                            <input type="file" accept="image/*" name="update-web-slider-image" id="{{"web-slider-image-".$key}}" class="d-none update-img-file-web" />                
                        </div>
                        {{-- upload promotion slider --}}
                        <div class="web-update-btn btn-upload-wrapper">
                            <input type="hidden" name="img-tmp-id" value="{{'-'.$key}}">
                            <input type="hidden" name="screen-option" value="desktop">
                            <small class="mb-5 ml-5">Web Version Slide Number {{$key+1}}</small>
                            <button class="mt-3 web-upload-file btn btn-small btn-dark">Upload New Image</button>
                        </div>
                    </div>
                </form>
                {{-- if path != null --}}
                @else
                    <div class="card-wrapper">
                        <div class="image-block">
                            <label>
                                <img id={{"change-".$key}} class="update-web-image" src="{{asset('storage/'.$promotionSlider->desktop_thumbnail)}}" alt="promotion image slider">
                            </label>
                        </div>
                        <div class="option-block">
                            <small>Web Version Slide Number {{$key+1}}</small>
                            <div class="option-btn-wrapper">
                                {{-- change --}}
                                <button id={{"change-".$key}} class="btn-change btn btn-sm btn-dark">change</button>
                                {{-- confirm change --}}
                                <form id="btn-confirm-change" style="display: none;" class="form-change bg-success ml-3" action="{{url('dashboard/promotionslider/update',[$promotionSlider->promotion_slider_id])}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="screen-option" value="desktop">
                                    <input type="file" id={{"input-change-".$key}} name="update-web-slider-image" accept="image/*" class="d-none img-file-web" />                
                                    <button class="btn btn-sm text-white">confirm change</button>
                                </form>
                                {{-- delete --}}
                                <form id="btn-delete" class="form-delete bg-danger ml-3" method="POST" action="{{url('dashboard/promotionslider', [$promotionSlider->promotion_slider_id])}}">
                                    @csrf
                                    @method('delete')
                                    <input type="hidden" name="screen-option" value="desktop">
                                    <button class="btn btn-sm text-white">delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
        {{-- mobile page--}}
        <div class="mobile-promotion-slide-wrapper">
            <h3>Mobile Promotion Slide Image</h3>
            @foreach ($promotionSliders as $key => $promotionSlider)
            {{-- if path = null --}}
            @if ($promotionSlider->mobile_thumbnail == null)
            <form action="{{url('dashboard/promotionslider/update',[$promotionSlider->promotion_slider_id])}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-wrapper">
                    <div class="image-block">
                        <label for={{'mobile-slider-image-'.$key}} class="cursor-pointer">
                            <img class="update-mobile-image" src="{{asset('img/product-carousel/invalid-mobile-slide.jpg')}}" alt="no-mobile-slide-image">
                        </label>
                        <input type="file" name="update-mobile-slider-image" id={{'mobile-slider-image-'.$key}} accept="image/*" class="d-none update-img-file-mobile" />                
                    </div>
                    <div class="mobile-update-btn option-block">
                        <input type="hidden" name="img-tmp-id" value="{{'-'.$key}}">
                        <input type="hidden" name="screen-option" value="mobile">
                        <small class="mb-5 ml-5">Mobile Version Slide Number {{$key+1}}</small>
                        <button class="btn btn-sm btn-dark">Upload New Image</button>
                    </div>
                </div>
            </form>
            {{-- if path != null --}}
            @else    
                <div class="card-wrapper">
                    <div class="image-block">
                        <label>
                            <img id={{"mobile-change-".$key}} class="update-mobile-image" src="{{asset('storage/'.$promotionSlider->mobile_thumbnail)}}" alt="promotino image slider">
                        </label>
                        <input type="file" name="mobile-slider-image" id="mobile-slider-image" accept="image/*" class="d-none img-file-mobile" />                
                    </div>
                    <div class="option-block">
                        <small>Mobile Version Slide Number {{$key+1}}</small>
                        <div class="option-btn-wrapper">
                            {{-- change --}}
                            <button id={{"mobile-change-".$key}} class="btn-change btn btn-sm btn-dark">change</button>
                            {{-- confirm change --}}
                            <form id="btn-confirm-change" style="display: none;" class="form-change bg-success ml-3" action="{{url('dashboard/promotionslider/update',[$promotionSlider->promotion_slider_id])}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="screen-option" value="mobile">
                                <input type="file" id={{"input-mobile-change-".$key}} name="update-mobile-slider-image" accept="image/*" class="d-none img-file-mobile" />                
                                <button class="btn btn-sm text-white">confirm change</button>
                            </form>
                            {{-- delete --}}
                            <form id="btn-delete" class="form-delete bg-danger ml-3" method="POST" action="{{url('dashboard/promotionslider', [$promotionSlider->promotion_slider_id])}}">
                                @csrf
                                @method('delete')
                                <input type="hidden" name="screen-option" value="mobile">
                                <button class="btn btn-sm text-white">delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
            @endforeach
        </div>
    </div>
    {{-- END:: Promotion Slide Product Listing --}}
@endsection

@section('dashboard_script')
    <script src="{{asset('js/custom-image-replicator-form.js')}}"></script>
    <script>
        //confirm delete promotion slider product
        $('.form-delete').click(function(){
            return confirm('Are you sure to delete this image from promotion slider?');
        });

        // onclick set web promotion image slider 
        imageReplicator('.img-file-web','.web-image');
        // onclick re-upload existen web image slider
        imageReplicator('.update-img-file-web','.update-web-image');
        
        // onclick update existen web and mobile [promotion image slider, Anything Panorama Image]
        showConfirmBtnOnClick();

        //onclick re-upload mobile promotion image slider
        imageReplicator('.update-img-file-mobile','.update-mobile-image');

        // check null image path before submit upload
        onUploadCheckNullImage('#web-upload-btn', 'web-slider-image');
        
        // check null image path before submit update [ Promotion Slider ]
        onUpdateCheckNullImage('.web-update-btn', 'web-slider-image');
        onUpdateCheckNullImage('.mobile-update-btn', 'mobile-slider-image');
    </script>
@endsection

