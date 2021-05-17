@php
    $color = $product->getColor();
    $showcaseImg = $product->images->first();
@endphp

@extends('layout.app')

@section('title','Product Name')

@section('stylesheet')
@parent
    <link rel="stylesheet" href="{{asset('css/heart.css')}}">
    <link rel="stylesheet" href="{{ asset('css/product-detail.css') }}">

    {{-- font-awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    {{-- slick slider --}}
    <link rel="stylesheet" href="{{asset('css/slick.min.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.min.css">
@endsection

@section('content')
{{-- BEGIN:: Product Detail --}}
<section class="product-detail-container">
    {{-- product infomation --}}
    <div class="product-detail-wrapper">
        <div class="mobile-product-name">
            <p>{{Str::ucfirst($product->product_name)}}</p>
            <small>Product code: #9987788</small>
        </div>
        {{-- product image & attributes --}}
        <div class="left-product-info-wrapper">
            {{-- product image --}}
            <div class="product-info-img">
                <div class="prev-arrow">
                    <img src="{{asset('img/product-carousel/arrow-prev.png')}}" alt="previous arrow">
                </div>
                <div class="child-product-img-wrapper">
                    @foreach ($product->images as $img)
                        <div class="child-img-wrapper">
                            <img src="{{ asset('storage/' . $img->path) }}" alt="product preview image">
                        </div>
                    @endforeach
                </div>
                <div class="next-arrow">
                    <img src="{{asset('img/product-carousel/arrow-next.png')}}" alt="next-arrow">
                </div>
                <div class="preview-product-image-wrapper">
                    @if (empty($showcaseImg))
                        <img src="{{ asset('icon/dashboard/invalid_img.png') }}" alt="Product">
                    @else
                        <img src="{{ asset('storage/' . $showcaseImg->path) }}" alt="Product">
                    @endif
                </div>
            </div>
            {{-- product attributes --}}
            <div class="product-info-wrapper">
                {{-- product name and code --}}
                <div class="web-product-name">
                    <h5>{{Str::ucfirst($product->product_name)}}</h5>
                    @if (!empty($product->productVariants->first()->product_variant_sku))
                        <p>Product code: #{{$product->productVariants->first()->product_variant_sku}}</p>
                    @else
                        <p>Product code: <small style="color: red; font-size: 12px;"># --</small></p>
                    @endif
                </div>
                {{-- product price --}}
                <h5> Price <small id='product-price'>${{$product->productVariants->first()->price}}</small> </h5>
                {{-- product attributes --}}
                <form class="product-attribute-container" action="{{ action('CartController@store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product" value="{{$product->product_id}}">
                    {{-- color --}}
                    @if (!empty($color))
                        <p class="color-text"> COLOR : {{Str::ucfirst($color->attribute_value)}}</p>
                        <input type="hidden" name="color" value="{{$color->attribute_value_id}}">
                    @endif
                    {{-- pv attributes--}}
                    <div class="product-attribute-wrapper">
                        {{-- quantity --}}
                        <div class="quantity-wrapper">
                            <label for="quantity">Quantity:</label>
                            <input class="form-control" type="number" value=1 name="quantity" min="1">
                        </div>
                        {{-- myopia and disposal --}}
                        <input id="prAttr1" type="hidden" name="prAttr1" value="{{$attrIds->prAttr1Id}}">
                        <input id="prAttr2" type="hidden" name="prAttr2" value="{{$attrIds->prAttr2Id}}">
                        @foreach ($attributes as $attribute)
                            @if ($attribute->attribute_name !== 'color')
                                <div class="myopia-wrapper">
                                    <label for="{{$attribute->attribute_name}}">{{$attribute->attribute_name}}</label>
                                    <select id="{{$attribute->attribute_name}}" name="{{$attribute->attribute_name}}" class="custom-select attribute-value-select">
                                        @foreach ($attribute->attributeValues->sortByDesc('attribute_value') as $attributeValue)
                                        @if ($loop->first)
                                            <option value="{{$attributeValue->attribute_value_id}}" selected aria-selected="true"> 
                                        @else
                                            <option value="{{$attributeValue->attribute_value_id}}">
                                        @endif
                                                {{$attributeValue->attribute_value}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif
                        @endforeach
                        {{-- available status --}}
                        <div class="available-status">
                            <small id="productAlert" class="success"></small>
                        </div>
                        {{-- add to cart  --}}
                        <div class="add-to-cart-wrapper">
                            <div id="heart" class="heart-btn"></div>
                            <button id="addToCartBtn" type="submit" class="btn btn-secondary">
                                ADD TO CART
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="border info-border"></div>
        {{-- product description --}}
        <div class="right-product-description-wrapper">
            <h5>Description</h5>
            <p>PRODUCT DETAILS</p>
            <p id="description-block">{{ $product->description}}</p>
        </div>
    </div>

    <div class="hr-line"></div>

    {{-- gift set available --}}
    <div class="gift-set-wrapper">
        <h4>Gift Set Available</h4>
        <div class="gift-set-card-wrapper">
            @foreach($giftsets as $giftset)
                <div class="gift-set-card">
                    <div class="card-img-wrapper">
                        @if ($giftset->thumbnail)
                            <img src="{{asset('storage/'.$giftset->thumbnail)}}" alt="Giftset Thumbnail">
                        @else
                            <img src="{{asset('icon/dashboard/invalid_img.png')}}" alt="Invalide Giftset Thumbnail">
                        @endif
                    </div>
                    <div class="card-description-wrapper">
                        <h5 class="card-title text-center">{{$giftset->giftset_name}}</h5>
                        <h5 class="card-title text-center">{{$giftset->giftset_price}}$</h5>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    {{-- customer review --}}
    <div class="customer-review-wrapper">
        <div class="customer-review-header">
            <h4>All Customer Reviews ( {{$product->reviews->count()}} ) </h4>
            {{-- <div class="rating-icon-wrapper">
                <img src="{{asset('img/icons/star-icon.png')}}" alt="">
                <h5>5</h5>
            </div> --}}
        </div>
        {{-- Review Table--}}
        <div class="review-table">
            {{-- heading --}}
            <div class="review-heading">
                <div class="mobile-th review-th">RATING and REVIEW</div>
                <div class="web-th review-th"> RATING   </div>
                <div class="web-th cmt-th review-th"> REVIEW   </div>
                <div class="web-th review-th"> NICKNAME </div>
                <div class="web-th review-th"> DATE     </div>
            </div>
            {{-- review --}}
            @foreach ($reviews as $review)
                <div class="review-body-wrapper review">
                    <div class="review-td">
                        <div class="rating-icon-wrapper product-rating-wrapper">
                            <img src="{{asset('img/icons/star-icon.png')}}" alt="">
                            <h5>{{$review->rating}}</h5>
                        </div>
                        <div class="mobile-review-td">{{$review->user->name}}</div>
                        <div class="mobile-review-td">{{$review->getReviewDate($review->created_at)}}</div>
                    </div>
                    <div class="review-td review-desc">
                        <p>{{$review->description}}</p>
                    </div>
                    <div class="web-review-td review-td">
                        {{$review->user->name}}
                    </div>
                    <div class="web-review-td review-td">
                        {{$review->getReviewDate($review->created_at)}}
                    </div>
                </div>
            @endforeach
            <div style="margin-top: 1em; display: flex; justify-content: center;">
                {{ $reviews->links() }}
            </div>
        </div>
        {{-- Review Comment --}}
        <div class="review-comment-wrapper">
            <form action="{{url('review/store')}}" method="POST">
                @csrf
                <div class="review-comment-body-wrapper">
                    <div class="review-rating-wrapper">
                        <small class="mr-2 font-weight-bold" style="vertical-align: -webkit-baseline-middle;">Rate us: </small>
                        <input type="hidden" name="product-id" value="{{$product->product_id}}">
                        <input id="rating-score" type="hidden" name="rating-score" value="">
                        @for ($i = 5; $i >= 1; $i--)
                            <input class="star" name="ratingRadio" type="radio" id="st{{$i}}" value="{{$i}}" />
                            <label for="st{{$i}}"></label>
                        @endfor
                    </div>
                    <div class="review-comment">
                        <textarea id="review-comment" value="" name="rating-review" placeholder="Write a review..." rows="7"></textarea>
                    </div>
                </div>
                <div class="review-comment-btn-wrapper">
                    @guest
                        <a href="{{route('login')}}" id="comment-review-btn" class="btn">Login and Rate Us</a>
                    @else
                        <input type="hidden" name="user-id" value="{{Auth::user()->user_id}}">    
                        <div id="cancel-review-btn" class="btn">CANCEL</div>
                        <button id="comment-review-btn" class="submit-btn btn">COMMENT</button>
                    @endguest
                </div>
            </form>
        </div>
    </div>
    {{-- you might also like --}}
    <section class="you-might-also-like-wrapper">
        <h5>YOU MIGHT ALSO LIKE</h5>
        <img class="recommend-prev-btn" src="{{asset('img/product-carousel/arrow-prev.png')}}" alt="previous arrow">
        <div class="recommend-card-carousel">
            @for ($i = 0; $i < 5; $i++)
                <div class="recommend-card-wrapper">
                    <a class="recommend-img-wrapper" href="#">
                        <img src="{{asset('img/gift-set-img/gf4.png')}}">
                    </a>
                    <div class="recommend-description-wrapper">
                        <h5>Item name</h5>
                    </div>
                </div>
            @endfor
        </div>
        <img class="recommend-next-btn" src="{{asset('img/product-carousel/arrow-next.png')}}" alt="previous arrow">
    </section>
</section>
{{-- END:: Product Detail --}}
@endsection

@section('script')
{{-- js for heart --}}
<script src="{{asset('js/heart.js')}}"></script>
<script src="{{ asset('js/check-product-stock.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/@mojs/core"></script>

{{-- js for product and slick slider --}}
<script src="{{asset('js/slick.min.js')}}"></script>
<script src="{{asset('js/product-detail.js')}}"></script>

<script>
    apiUrl   = "{!! url('api/product/stock') !!}"
    apiToken = "{!! csrf_token() !!}"
</script>
@endsection