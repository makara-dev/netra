@extends('layout.app')

@section('title','Netra')

@section('stylesheet')
    @parent
    <link rel="stylesheet" href="{{asset('css/home.css')}}">
    <link rel="stylesheet" href="{{asset('css/slick.min.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.min.css">
    {{-- flickity --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flickity/2.2.1/flickity.min.css">
@endsection

@section('content')
{{-- BEGIN :: Home Page --}}
    <!-- products slide show -->
    {{-- mobile version --}}
    <div class="mobile-promotion-slider carousel slide" data-ride="carousel">
        <div class="carousel-inner carousel-image-container">
            @foreach ($promotionSliders as $key => $promotionSlider)
                <div class="mobile-carousel-img-wrapper carousel-item carousel-image-wrapper @if($loop->first) active @endif">
                    <img class="mobile-slide-img" src="{{asset('storage/'.$promotionSlider->mobile_thumbnail)}}" alt={{"product slide number ".($key+1)}}>
                </div>
            @endforeach
        </div>
    </div>
    {{-- web version --}}
    <div id="carouselProductIndicators" class="web-product-slider carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            @for ($i=0; $i < count($promotionSliders); $i++)
                <li data-target="#carouselProductIndicators" data-slide-to="{{$i}}" @if($i == 0) class="active" @endif></li>
            @endfor
        </ol>
        <div class="carousel-inner carousel-image-container">
            @foreach ($promotionSliders as $key => $promotionSlider)
                <div class="carousel-item carousel-image-wrapper @if($loop->first) active @endif">
                    <img src="{{asset('storage/'.$promotionSlider->desktop_thumbnail)}}" alt={{"product slide number ".($key+1)}}>
                </div>
            @endforeach
        </div>
        <a class="carousel-control-prev" href="#carouselProductIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselProductIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
    <!-- featured brands list -->
    <div class="border-line"></div>
    <div class="featured-product-wrapper">
        <p class="featured-brand-heading">FEATURED PRODUCTS</p>
        <ul>
            <li> <a href="#">FEATURED</a> </li>
            <li> <a href="#">LATEST</a> </li>
            <li> <a href="#">SPECIAL</a> </li>
        </ul>
        <div class="featured-brand-body">
            <div class="featured-product-card-container">
                @foreach ($featuredProducts as $featuredProduct) 
                <div class="featured-product-card-wrapper">
                    <a class="featured-image-wrapper" href="{{url("/products/{$featuredProduct->productVariant->product->product_id}/details/{$featuredProduct->attribute_1}/{$featuredProduct->attribute_2}")}}">
                        @if ($featuredProduct->thumbnail == null)
                            <img class="featured-image" src="{{asset('icon/dashboard/invalid_img.png')}}" alt="product thumbnail">
                        @else
                            <img class="featured-image" src="{{asset('storage/'.$featuredProduct->thumbnail)}}" alt="product thumbnail">
                        @endif
                    </a>
                    <div class="featured-description">
                        <h6>{{ ucwords( $featuredProduct->productVariant->product_variant_sku ) }}</h6>
                        <p style="color: gray; font-weight: normal;">$ {{$featuredProduct->productVariant->price}}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- anything you want to put panorama bar -->
    <div class="anything-panorama-wrapper">
        {{-- mobile version --}}
        <div id="mobile-panorama" class="anything-panorama-image-wrapper">
            @if (!$anythingPanorama->isEmpty() || count($anythingPanorama) != 0)
                @if($anythingPanorama->first()->mobile_thumbnail != null)
                    <img src="{{asset('storage/'.$anythingPanorama->first()->mobile_thumbnail)}}" alt="mobile version of panorama">
                @else
                    <span>Anything you want to put</span>
                @endif
            @else
                <span>Anything you want to put</span>
            @endif
        </div>
        {{-- desktop version --}}
        <div id="desktop-panorama" class="anything-panorama-image-wrapper">
            @if (!$anythingPanorama->isEmpty() || count($anythingPanorama) != 0)
                @if($anythingPanorama->first()->desktop_thumbnail != null)
                    <img src="{{asset('storage/'.$anythingPanorama->first()->desktop_thumbnail)}}" alt="desktop version of panorama">
                @else
                    <span>Anything you want to put</span>
                @endif
            @else
                <span>Anything you want to put</span>
            @endif
        </div>
    </div>
    <!-- recommended products   -->
    <section class="recommend-product-wrapper">
        <div class="recommend-heading-text-wrapper">
            <span>WE RECOMMEND</span>
        </div>
        <div id="recommend-flickity-wrapper" class="recommend-product-body-wrapper custom-carousel">
            @foreach ($recommendProducts as $recommendProduct) 
            <div class="recommend-product-card-wrapper">
                <a class="recommend-image-wrapper" href="{{url("/products/{$recommendProduct->productVariant->product->product_id}/details/{$recommendProduct->attribute_1}/{$recommendProduct->attribute_2}")}}">
                    @if ($recommendProduct->thumbnail == null)
                        <img class="featured-image" src="{{asset('icon/dashboard/invalid_img.png')}}" alt="product thumbnail">
                    @else
                        <img class="recommend-image" src="{{asset('storage/'.$recommendProduct->thumbnail)}}" alt="Card image cap">
                    @endif
                </a>
            </div>
            @endforeach
        </div>
    </section>
    <!-- best seller products   -->
    <section class="best-seller-product-wrapper">
        <div class="best-seller-product-heading-text-wrapper">
            <span>BEST SELLER</span>
        </div>
        <div id="best-seller-flickity-wrapper" class="best-seller-product-body-wrapper custom-carousel">
            @foreach ($bestSellerProducts as $bestSellerProduct) 
            <div class="best-seller-product-card-wrapper">
                <a class="best-seller-image-wrapper" href="{{url("/products/{$bestSellerProduct->productVariant->product->product_id}/details/{$bestSellerProduct->attribute_1}/{$bestSellerProduct->attribute_2}")}}">
                    @if ($bestSellerProduct->thumbnail == null)
                        <img class="featured-image" src="{{asset('icon/dashboard/invalid_img.png')}}" alt="product thumbnail">
                    @else
                        <img class="best-seller-image" src="{{asset('storage/'.$bestSellerProduct->thumbnail)}}" alt="best seller product image">
                    @endif
                </a>
                <div class="best-seller-description">
                    <h6>{{ ucwords( $bestSellerProduct->productVariant->product_variant_sku ) }}</h6>
                    <p style="color: gray;">$ {{$bestSellerProduct->productVariant->price}}</p>
                </div>
            </div>
            @endforeach
        </div>
    </section>
    <!-- instagram posts -->
    <section class="instagram-post-wrapper">
        <div class="instagram-post-heading-text-wrapper">
            <span>#NETRALENS <br> </span>
            <small>Featured posts from our customers</small>
        </div>
        <div class="instagram-post-body-wrapper">
            {{-- feedback 1 --}}
            <div class="instagram-post-card-wrapper">
                <a class="instagram-image-wrapper" href="#">
                    <img class="instagram-image" src="{{asset('img/instagram-photos/instagram-1.png')}}" alt="instagram image">
                </a>
                <div class="instagram-description">
                    <h6># kosamak_s</h6>
                    <p style="color: gray;">INSTAGRAM</p>
                </div>
            </div>
            {{-- feedback 2 --}}
            <div class="instagram-post-card-wrapper">
                <a class="instagram-image-wrapper" href="#">
                    <img class="instagram-image" src="{{asset('img/instagram-photos/instagram-2.png')}}" alt="instagram image">
                </a>
                <div class="instagram-description">
                    <h6># fortunevivath</h6>
                    <p style="color: gray;">INSTAGRAM</p>
                </div>
            </div>
            {{-- feedback 3 --}}
            <div class="instagram-post-card-wrapper">
                <a class="instagram-image-wrapper" href="#">
                    <img class="instagram-image" src="{{asset('img/instagram-photos/instagram-3.png')}}" alt="instagram image">
                </a>
                <div class="instagram-description">
                    <h6># may_nid</h6>
                    <p style="color: gray;">INSTAGRAM</p>
                </div>
            </div>
            {{-- feedback 4 --}}
            <div class="instagram-post-card-wrapper">
                <a class="instagram-image-wrapper" href="#">
                    <img class="instagram-image" src="{{asset('img/instagram-photos/instagram-4.png')}}" alt="instagram image">
                </a>
                <div class="instagram-description">
                    <h6># _shulee_</h6>
                    <p style="color: gray;">INSTAGRAM</p>
                </div>
            </div>
            {{-- feedback 5 --}}
            <div class="instagram-post-card-wrapper">
                <a class="instagram-image-wrapper" href="#">
                    <img class="instagram-image" src="{{asset('img/instagram-photos/instagram-5.png')}}" alt="instagram image">
                </a>
                <div class="instagram-description">
                    <h6># sim_lymouy</h6>
                    <p style="color: gray;">INSTAGRAM</p>
                </div>
            </div>
            {{-- feedback 6 --}}
            <div class="instagram-post-card-wrapper">
                <a class="instagram-image-wrapper" href="#">
                    <img class="instagram-image" src="{{asset('img/instagram-photos/instagram-6.png')}}" alt="instagram image">
                </a>
                <div class="instagram-description">
                    <h6># jamie.keo</h6>
                    <p style="color: gray;">INSTAGRAM</p>
                </div>
            </div>
        </div>
    </section>
{{-- END :: Home Page --}}
@endsection

@section('script')
    <script src="{{asset('js/home.js')}}"></script>
    <script src="{{asset('js/slick.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flickity/2.2.1/flickity.pkgd.min.js"></script>
    
    <script>
        $(document).ready(function(){
            sliderInit();

            changeMobileCarouselWrapperHeight();
            
            isFlickityActivate();  

            if($(window).width() < 991){
                changeMobilePanoramaWrapperHeight();
            }
        });
    </script>
@endsection
