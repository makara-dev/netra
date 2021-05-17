@extends('layout.app')

@section('title','Cart')

@section('stylesheet')
    @parent
    <link rel="stylesheet" href="{{asset('css/cart.css')}}">   
@endsection

@section('content')
{{-- BEGIN:: Cart  --}}
    {{-- cart breadcrumb --}}
    <div id="desktop-cart-navbar" class="d-none">
        @include('checkout.partials.breadcrumb-nav')
    </div>
    {{-- cart wrapper --}}
    <div class="container">
        <div class="row h-100 p-lg-4">
            {{-- ======= Cart wrapper ======= --}}
            <div class="cart-wrapper col-xl-8 col-lg-7 col-12 py-lg-0 pl-lg-0 custom-border">
                {{-- mobile --}}
                {{-- cart breadcrumb navbar ***** mobile ***** --}}
                <div id="mobile-cart-navbar">
                    @include('checkout.partials.breadcrumb-nav')
                </div>

                <h3 class="font-weight-bold font-18 mb-3">My Cart</h3>
                {{-- item list --}}
                @forelse ($productVariants as $key => $item)
                    <div id="cartItemRow" class="row border-top py-3 mx-1">
                        {{-- cart image block --}}
                        <div class="col-5 cart-img-wrapper">
                            @if ($item->thumbnail)
                                <img src="{{ asset('storage/'. $item->thumbnail) }}" alt="Product">
                            @else
                                <img src="{{ asset('icon/dashboard/invalid_img.png') }}" alt="Product">
                            @endif
                        </div>
                        {{-- item attributes block --}}
                        <div class="col-7">
                            {{-- delete form --}}
                            <form action="{{url("cart/delete/{$item->rowId}")}}" method="POST">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-sm float-right font-weight-bold">x</button>
                            </form>
                            {{-- update form --}}
                            <form id="form{{$key}}" action="{{url("cart/update")}}" method="POST" class="form-update">
                                @csrf
                                <input type="hidden" name="rowId" value="{{ $item->rowId }}">
                                <input type="hidden" name="id" value="{{$item->product_variant_id}}">
                            </form>
                            {{-- name and price --}}
                            <p class="font-12 text-gray">price : ${{$item->price}}</p>
                            <p class="font-12">{{Str::ucfirst($item->product->product_name)}}</p>
                            {{-- attributes --}}
                            <p class="font-12">{{$item->properties}}</p>
                            {{-- quantity --}}
                            <label class="font-12">Quantity :</label>
                            <div class="dropdown dropdown-quantity border border-gray rounded-sm">
                                <a class="btn btn-sm btn-light dropdown-toggle font-12" href="" id="dropdownMenuQty{{$key}}"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{$item->quantity}}
                                </a>
                                <div class="dropdown-menu dropdown-menu-center font-12" style="width: 100px !important;" aria-labelledby="dropdownMenuQty{{$key}}">
                                    @for($i = 1; $i <= 10; $i++) 
                                        @if ($i < 10) 
                                            <button 
                                                name="quantity"
                                                type="submit"
                                                value="{{$i}}"
                                                class="dropdown-item quantity-btn"
                                                form="form{{$key}}">
                                                {{$i}}
                                            </button>
                                        @else
                                            <button
                                                value="10"
                                                type="button"
                                                class="dropdown-item dropdown_10">
                                                10+
                                            </button>
                                        @endif
                                    @endfor
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="d-block m-auto">
                        You currently don't have any item in the cart.
                    </p>
                @endforelse
            </div>
            {{-- ======= Checkout detail wrapper ======= --}}
            <div class="checkout-area-wrapper col-xl-4 col-lg-5 col-12 border-top py-lg-0 pr-lg-0 pt-3">
                <div class="checkout-area-cart rounded pt-3 px-4">
                    <h3 class="font-weight-bold font-18">Total</h3>
                    {{-- item list --}}
                    <div class="pt-3 mt-3 border-top border-bottom">
                        @foreach ($productVariants as $key => $item)
                        <div class="d-block my-3">
                            <p class="font-12">Item #{{$key+1}}</p>
                            <p class="font-12">{{Str::ucfirst($item->name)}}</p>
                            <p class="font-10 ml-2">
                                <small>{{$item->properties}}</small><br>
                                quantity : <strong class="font-12">{{$item->quantity}}</strong>
                                <span class="float-right">
                                    price : <strong class="font-12">${{$item->price}}</strong>
                                </span>
                            </p>
                        </div>
                        @endforeach
                    </div>
                    {{-- subtotal --}}
                    @if(!$productVariants->isEmpty())
                        <div class="pr-2 pb-2 mt-3 border-bottom">
                            <h4 class="font-weight-bold font-15">Subtotal
                                <span class="float-right">
                                    <strong>${{Cart::subtotal()}}</strong>
                                </span>
                            </h4>
                            <div class="font-12 ml-2">
                                <p class="mb-1 d-none">
                                    VAT : 
                                    <span class="float-right">21%</span>
                                </p>
                                <p  class="mb-1">
                                    discount :
                                    <span class="float-right">1%</span>
                                </p>
                            </div>
                        </div>
                    @endif
                    {{-- total price --}}
                    <p class="my-2 font-weight-bold">
                        Total Price :
                        <strong class="float-right">
                            ${{Cart::total()}}
                        </strong>
                    </p>
                    {{-- process checkout --}}
                    <div class="mt-4">
                        @auth
                            <a href="{{url('checkout/contact')}}" class="btn btn-primary  w-100 mx-auto d-block">Product To Checkout</a>
                        @else
                            <a href="{{url('checkout/contact')}}" class="btn btn-primary  w-100 mx-auto d-block" style="background-color: #691C56;">Checkout as Guest</a>
                        @endauth
                    </div>
                </div>
                <div class="d-flex flex-row align-items-center" style="width: 100%">
                    <hr style="flex: 0 0 32%; border-top: 2px solid rgb(177, 174, 174);">
                    <small class="text-center" style="flex: 0 0 30%">New to Netra?</small>
                    <hr style="flex: 0 0 32%; border-top: 2px solid rgb(177, 174, 174);">
                </div>
                @guest
                    <div class="text-center mb-5 px-4">
                        <a class="checkout-btn btn btn-primary w-100 d-flex flex-column" href="{{ route('register') }}" style="background-color: #691C56">
                            <small class="font-12 my-auto text-white">Sign Up?</small>
                        </a>
                    </div>
                @endguest
            </div>
        </div>
    </div>
{{-- END:: Cart  --}}
@endsection

@section('script')
<script src="{{ asset('js/checkout.js') }}"></script>
@endsection