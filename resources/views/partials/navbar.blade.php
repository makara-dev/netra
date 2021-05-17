{{-- BEGIN: Main Navigation Bar --}}
<nav class="main-navbar-wrapper navbar navbar-light navbar-menu navbar-expand-lg">
    <div class="mobile-btn-close-navbar">x</div>
    {{-- navbar logo --}}
    <a class="navbar-brand-wrapper" href="{{url('/')}}">
        <img src="{{asset('icon/netra.svg')}}" alt="Netra-logo" width="100%" />
    </a>
    {{-- mobile featured list --}}
    <div class="mobile-featured-list-wrapper">
        <a href="{{url('#')}}" class="mobile-search-img-wrapper">
            <img src="{{asset('icon/search.png')}}" alt="search-image">
        </a>
        <a href="{{url('checkout/cart')}}" class="mobile-cart-img-wrapper">
            <img src="{{asset('icon/shopping-cart.png')}}" alt="cart-image">
        </a>
        {{-- menu button --}}
        <button class="navbar-toggler-wrapper navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsingNavbar" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>
    {{-- navbar menu list --}}
    <div class="navbar-menu-wrapper navbar-collapse collapse" id="collapsingNavbar">
        <div class="purple-line"></div>
        <p class="menu-text">MENU</p>
        {{-- category list --}}
        <ul class="category-list-wrapper nav navbar-nav">
            {{-- category from db --}}
            @foreach ($categories as $category)
                <li>
                    <a class="nav-item nav-link " href="{{url('/products',[$category->category_id])}}">{{Str::ucfirst(Str::plural($category->category_name))}}</a>
                    <img src="{{asset('icon/next-sign.png')}}" alt="next-sign">
                </li>
            @endforeach
            {{-- gitset --}}
            <li>
                <a class="nav-item nav-link" href="{{url('giftset')}}">Gift Set</a>
                <img src="{{asset('icon/next-sign.png')}}" alt="next-sign">
            </li>
            {{-- eyecare --}}
            <li>
                <a class="nav-item nav-link" href="{{url('eyescare')}}">Eyes Care</a>
                <img src="{{asset('icon/next-sign.png')}}" alt="next-sign">
            </li>
        </ul>
        {{-- navbar featured list --}}
        {{-- mobile version --}}
        <ul class="mobile-navbar-featured-list">
            {{-- language --}}
            <li id="mobile-lang-li">
                <a href="#">
                    <img class="nav-icon mx-2 " src="{{asset('icon/kh-lang.png')}}" alt="en-language">
                </a>
                <small>KH</small>
            </li>
            {{-- account featured --}}
            <li id="mobile-account-li">
                <img class="nav-icon mx-2 " src="{{asset('icon/account2.png')}}" alt="account">
                @guest
                    <small>
                        <a class="text-white" href="{{route('login')}}">Login / </a>
                    </small>
                    <small>
                        <a class="text-white" href="{{route('register')}}"> Sign Up</a>
                    </small>
                @else   
                    <small>{{ Auth::user()->name }}</small>
                    {{-- logout btn --}}
                    <a href="{{ route('logout') }}" onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                        <small class="text-danger"> {{ __('Logout') }} </small>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                @endguest
            </li>
        </ul>
        {{-- web version --}}
        <ul class="web-navbar-featured-list nav navbar-nav flex-row">
            {{-- search btn --}}
            <li class="nav-item">
                <a href="#"><img class="nav-icon mx-2 " src="{{asset('icon/search.png')}}" alt="search"></a>
            </li>
            {{-- account avatar --}}
            <li class="nav-item">
                <a href="#"><img class="nav-icon mx-2 " src="{{asset('icon/account.png')}}" alt="account"></a>
            </li>
            {{-- account featured --}}
            @guest
                <li class="nav-item">
                    <a href="{{ route('login') }}" class="nav-link pt-1" style="color:#515151;">{{ __('Login') }}</a>
                </li>
                <li style="margin-left: 5px; margin-right: 5px">|</li>
                <li class="nav-item">
                    <a href="{{ route('register') }}" class="nav-link pt-1" style="color:#515151;">{{ __('Register') }}</a>
                </li>
            @else
                <li class="nav-item">
                    <a href="#" class="nav-link pt-1" style="color:#515151;">{{ Auth::user()->name }}
                    </a>
                </li>
                <li class="nav-item">
                    <span class="vl-s align-bottom"></span>
                </li>
                <li class="nav-item">
                    <a href="{{ route('logout') }}" class="nav-link pt-1" style="color:#515151;" onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>
                </li>
                {{-- logout btn --}}
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            @endguest
            {{-- favorite --}}
            <li class="nav-item ml-2">
                <a href="#"><img class="nav-icon mx-2 " src="{{asset('icon/heart.png')}}" alt="heart"></a>
            </li>
            {{-- cart --}}
            <li class="nav-item">
                <div id="cartDropdown" class="dropdown keep-open">
                    <a href="{{url('checkout/cart')}}">
                        <img class="nav-icon mx-2" src="{{asset('icon/shopping-cart@2x.png')}}" alt="shopping-cart">
                    </a>
                    <div class="dropdown-menu cart-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">        
                        @forelse ($productVariants as $item)
                            <div class="d-flex flex-row border-bottom p-2" data-row-id="{{$item->rowId}}">                  
                                <div class="col-4 p-0 d-flex">
                                    @if (empty($item->thumbnail))
                                    <img class="w-100 align-self-center" src="{{ asset('icon/dashboard/invalid_img.png') }}" alt="">
                                    @else
                                    <img class="w-100 align-self-center" src="{{ asset('storage/'. $item->thumbnail) }}" alt="">
                                    @endif
                                </div>          
                                <div class="col-8 pl-2 pr-0 d-flex">
                                    <div class="align-self-center" >
                                        <span class="font-10">
                                            {{$item->name}}<br>
                                            {{$item->properties}}<br>
                                            Qty : {{$item->qty}}<br>
                                            price : ${{$item->price}}<br>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="p-2">                  
                                <span>No item in cart</span>
                            </div>
                        @endforelse
                        <div class="d-flex justify-content-between p-2">
                            <small class="font-weight-bold">Subtotal</small>
                            <small class="align-self-center ">${{Cart::total()}}</small>
                        </div>
                        <a href="{{url('checkout/cart')}}" class="btn btn-primary btn-sm w-75 mx-auto d-block">checkout</a>
                    </div>
                </div>

            </li>
            {{-- language --}}
            <li class="nav-item lang-wrapper">
                <a href="#">
                    <span class="align-top">
                        <img class="nav-icon ml-2" src="{{asset('icon/En-lang.png')}}" alt="en-language">
                    </span>
                </a>
            </li>
        </ul>
    </div>
</nav>
{{-- END: Main Navigation Bar --}}

{{-- BEGIN: Mobile Advertisement Navbar --}}
<div class="mobile-navbar-advertisement">
    <div class="navbar-delivery-block" href="#">
        <div class="mobile-icon-wrapper">
            <img  class="mobile-bicycle-icon" src="{{ asset('icon/bicycle-mobile.png') }}">
        </div>
        <h5>Free delivery for<br>every purchase over 30$</h5>
    </div>
    <div class="navbar-discount-block" href="#">
        <h5>20% Off first order,</h5>
        <a href="{{ route('register') }}"><span>sign up with us</span></a>
    </div>
</div>
{{-- END: Mobile Advertisement Navbar --}}