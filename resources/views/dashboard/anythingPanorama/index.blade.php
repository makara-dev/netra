@extends('layout.dashboard')

{{-- page title --}}
@section('page_title','Dashboard')

{{-- style sheet --}}
@section('dashboard_stylesheet')
    <link rel="stylesheet" href="{{asset('css/dashboard/anything-panorama.css')}}">
@endsection

{{-- Breadcrumb --}}
@section('breadcrumb')
<li class="breadcrumb-item" aria-current="page">
    <a href="{{ url('/dashboard') }}" class="breadcrumb-link">Dashboard</a>
</li>
<li class="breadcrumb-item" aria-current="page"> 
    <a href="{{url('dashboard/panorama')}}" class="breadcrumb-link">Anything Panorama</a> 
</li>
<li class="breadcrumb-item active" aria-current="page">List</li>
@endsection

@section('dashboard_content')
    <h3 class="mt-3">[ Home Page ] Image for Anything Panorama You Want To Put</h3>
    {{-- BEGIN:: Anything Panorama Listing --}}
    <div class="anything-panorama-wrapper">
        {{-- web panorama --}}
        <div class="web-panorama-wrapper">
            {{-- upload if doesn't has image --}}
            @if ($anythingPanorama == null)
                <form action="{{url('dashboard/panorama/add')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-wrapper">
                        <div class="web-image-block">
                            <label for="web-panorama-image" class="cursor-pointer">
                                <img class="web-image" src="{{asset('img/product-carousel/invalid-web-slide.jpg')}}" alt="no panorama image">
                            </label>
                            <input type="file" accept="image/*" name="web-panorama-image" id="web-panorama-image" class="d-none img-file-web" />                
                        </div>
                        <div id="web-upload-btn" class="web-update-btn btn-upload-wrapper">
                            <p>Web Version</p>
                            <input type="hidden" name="screen-option" value="desktop">
                            <button class="web-upload-file btn btn-small btn-dark">Set As Web Anything Panorama</button>
                        </div>
                    </div>
                </form>
            {{-- update and delete if has image --}}
            @else 
                {{-- if path == null --}}
                @if ($anythingPanorama->desktop_thumbnail == null)
                    <form action="{{url('dashboard/panorama/update', [$anythingPanorama->anything_panorama_id])}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-wrapper">
                            <div class="web-image-block">
                                <label for="web-panorama-image" class="cursor-pointer">
                                    <img class="web-image" src="{{asset('img/product-carousel/invalid-web-slide.jpg')}}" alt="no panorama image">
                                </label>
                                <input type="file" accept="image/*" name="web-panorama-image" id="web-panorama-image" class="d-none img-file-web" />                
                            </div>
                            <div class="web-update-btn btn-upload-wrapper">
                                <p>Web Version</p>
                                <input type="hidden" name="img-tmp-id">
                                <input type="hidden" name="screen-option" value="desktop">
                                <button class="web-upload-file btn btn-small btn-dark">Upload New Web Image</button>
                            </div>
                        </div>
                    </form>
                {{-- if path != null --}}
                @else 
                    <div class="card-wrapper">
                        <div class="web-image-block">
                            <label>
                                <img id="change-1" class="web-image" src="{{asset('storage/'.$anythingPanorama->first()->desktop_thumbnail)}}" alt="no panorama image">
                            </label>
                        </div>
                        <div class="option-btn-wrapper">
                            <p class="w-100">Web Version</p>
                            {{-- change --}}
                            <button id="change-1" class="btn-change btn btn-sm btn-dark">change</button>
                            {{-- confirm change --}}
                            <form id="btn-confirm-change" style="display: none;" class="form-change bg-success ml-3" action="{{url('dashboard/panorama/update',[$anythingPanorama->anything_panorama_id])}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="screen-option" value="desktop">
                                <input type="file" id="input-change-1" name="web-panorama-image" accept="image/*" class="d-none img-file-web" />                
                                <button class="btn btn-sm text-white">confirm change</button>
                            </form>
                            {{-- delete --}}
                            <form id="btn-delete" class="form-delete bg-danger ml-3" method="POST" action="{{url('dashboard/panorama', [$anythingPanorama->anything_panorama_id])}}">
                                @csrf
                                @method('delete')
                                <input type="hidden" name="screen-option" value="desktop">
                                <button class="btn btn-sm text-white">delete</button>
                            </form>
                        </div>
                    </div>
                @endif
            @endif
        </div>
        {{-- mobile panorama --}}
        <div class="mobile-panorama-wrapper">
            @if ($anythingPanorama != null)
                {{-- if path == null --}}
                @if ($anythingPanorama->mobile_thumbnail == null)
                    <form action="{{url('dashboard/panorama/update', [$anythingPanorama->anything_panorama_id])}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-wrapper">
                            <div class="mobile-image-block">
                                <label for="mobile-panorama-image-1" class="cursor-pointer">
                                    <img class="update-mobile-image mobile-image" src="{{asset('img/product-carousel/invalid-mobile-slide.jpg')}}" alt="no mobile panorama image">
                                </label>
                                <input type="file" name="mobile-panorama-image" id="mobile-panorama-image-1" accept="image/*" class="d-none update-img-file-mobile" />                
                            </div>
                            <div id="mobile-upload-btn" class="mobile-update-btn btn-upload-wrapper">
                                <p>Mobile Version</p>
                                <input type="hidden" name="img-tmp-id" value="-1">
                                <input type="hidden" name="screen-option" value="mobile">
                                <button class="mobile-upload-file btn btn-small btn-dark">Set As mobile Anything Panorama</button>
                            </div>
                        </div>
                    </form>
                {{-- if path != null --}}
                @else
                    <div class="card-wrapper">
                        <div class="mobile-image-block">
                            <label>
                                <img id="mobile-change-1" class="mobile-image" src="{{asset('storage/'.$anythingPanorama->mobile_thumbnail)}}" alt="no mobile panorama image">
                            </label>
                            <input type="file" accept="image/*" name="mobile-panorama-image" id="mobile-panorama-image" class="d-none img-file-mobile" />                
                        </div>
                        <div class="option-btn-wrapper">
                            <p class="w-100">Mobile Version</p>
                            {{-- change --}}
                            <button id="mobile-change-1" class="btn-change btn btn-sm btn-dark">change</button>
                            {{-- confirm change --}}
                            <form id="btn-confirm-change" style="display: none;" class="form-change bg-success ml-3" action="{{url('dashboard/panorama/update',[$anythingPanorama->anything_panorama_id])}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="screen-option" value="mobile">
                                <input type="file" id="input-mobile-change-1" name="mobile-panorama-image" accept="image/*" class="d-none img-file-mobile" />                
                                <button class="btn btn-sm text-white">confirm change</button>
                            </form>
                            {{-- delete --}}
                            <form id="btn-delete" class="form-delete bg-danger ml-3" method="POST" action="{{url('dashboard/panorama', [$anythingPanorama->anything_panorama_id])}}">
                                @csrf
                                @method('delete')
                                <input type="hidden" name="screen-option" value="mobile">
                                <button class="btn btn-sm text-white">delete</button>
                            </form>
                        </div>
                    </div>
                @endif
            @endif
        </div>
    </div>
    {{-- END:: Anything Panorama Listing --}}
@endsection

@section('dashboard_script')
    <script src="{{asset('js/custom-image-replicator-form.js')}}"></script>
    <script>
        //confirm delete anything panorama
        $('.form-delete').click(function(){
            return confirm('Are you sure to delete this image from Panorama image?');
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
        onUploadCheckNullImage('#web-upload-btn', 'web-panorama-image');
        
        // check null image path before submit update [ Anything Panorama ]
        onUpdateCheckNullImage('.web-update-btn', 'web-panorama-image');
        onUpdateCheckNullImage('.mobile-update-btn', 'mobile-panorama-image');
    </script>
@endsection

