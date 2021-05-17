@extends('layout.app')

@section('title','Customer Services')

@section('content')
<!-- BEING:: Customer Services Block -->
<div class="container-fluid my-5">
    <div class="row container mx-2">
        {{-- left navbar description section --}}
        <div class="col-12 col-md-4">
            <div class="btn-group-vertical">
                <h5 class="mx-3 pb-2">Customer Services</h5>
                <a id="how-to-buy-link" class="btn text-left mx-1 my-2" data-target="#how-to-buy-info">How
                    to buy</a>
                <a id="delivery-and-shipping-info-link" class="btn text-left mx-1 my-2"
                    data-target="#delivery-and-shipping-info">Delivery & Shipping Information</a>
                <a id="faq-link" class="btn text-left mx-1 my-2" data-target="#faq-info">FAQ</a>
                <a id="online-exchange-and-return-policy-link" class="btn text-left mx-1 my-2"
                    data-target="#online-exchange-and-return-policy-info">Online Exchange & Return Policy</a>
                <a id="size-guide-link" class="btn text-left mx-1 my-2" data-target="#size-guide-info">
                    Size Guide</a>
            </div>
        </div>
        {{-- right info section --}}
        <div class="col-12 col-md-7 info-section">
            <!-- BEGIN :: How to buy section -->
            <div id="how-to-buy-info" class="collapse">
                <h5 class="mx-4">How to Buy</h5>
                <p class="mx-4 pt-3">Shop Our Website : www.Netra.com</p>
                <p class="mx-4"><img class="mr-2" src="{{asset('icon/telegram.png')}}"> Telegram ID </p>
                <p class="mx-4"><img class="mr-2" src="{{asset('icon/facebook2.png')}}" style="width: 31px;"> Facebook:
                    Netra </p>
                <p class="mx-4"><img class="mr-2" src="{{asset('icon/instagram.png')}}"> Instagram DM @ Netra </p>
                <p class="mx-4">Hotline: (+885)12 XXX XXX</p>
                <p class="mx-4 pt-4">Cancelling order</p>
                <p class="mx-4 pt-2">To cancel your order, please call at Hotline: (+885)12 XXX XXX (Mon - Fri, 9:00 -
                    17:30)
                    OR send us
                    an email at (pending) Netra@gmail.com​ and inform us your order number (SXS
                    9900xxxxx).</p>
                <p class="mx-4">Please note, once your order has been processed, it can not be cancelled.</p>
            </div>
            <!-- END :: How to buy section -->

            <!-- BEGIN :: Delivery & Shipping Information section -->
            <div id="delivery-and-shipping-info" class="collapse">
                <h5 class="mx-4 mt-5 pt-3">Delivery & Shipping Information</h5>
                <p class="mx-4 mt-4">-Delivery in all 26 cities and provinces in Cambodia only</p>
                <p class="mx-4">-Free delivery for purchases over $30</p>
                <p class="mx-4">-Purchase under $30 will be charged between $1-3 depending on your location</p>
            </div>
            <!-- END :: Delivery & Shipping Information section -->

            <!-- BEGIN:: FAQ section -->
            <div id="faq-info" class="collapse">
                <h5 class="mx-4 mt-2">FAQ</h5>
                <p class="mx-4 mt-3">Our Top FAQ</p>
                <!-- top question toggle down 1 -->
                <div class="col mx-2">
                    <a id="question-link1"   data-toggle="collapse" data-target="#question1" aria-controls="#question1"
                        class="text-decoration-none text-dark">
                        + When will my order arrive ?
                        <img class="p-1" src="{{asset('icon/arrow-down.svg')}}">
                    </a>
                    <div class="collapse question-collapse" id="question1">
                        <div class="card card-body">
                            Delivery will takes between 1-3 days depending on your area and the current
                            availiability of our products that you have ordered.
                        </div>
                    </div>
                </div>
                <!-- top question toggle down 2 -->
                <div class="col mx-2 mt-3">
                    <a id="question-link2"  data-toggle="collapse" data-target="#question2" aria-controls="#question2"
                        class="text-decoration-none text-dark ">
                        +Question 2
                        <img class="p-1" src="{{asset('icon/arrow-down.svg')}}">
                    </a>
                    <div class="collapse question-collapse" id="question2">
                        <div class="card card-body">
                            Question number 2
                        </div>
                    </div>
                </div>
                <!-- top question toggle down 3 -->
                <div class="col mx-2 mt-3">
                    <a id="question-link3"  data-toggle="collapse" data-target="#question3" aria-controls="#question3"
                        class="text-decoration-none text-dark">
                        +Question 3
                        <img class="p-1" src="{{asset('icon/arrow-down.svg')}}">
                    </a>
                    <div class="collapse question-collapse" id="question3">
                        <div class="card card-body">
                            Question number 3
                        </div>
                    </div>
                </div>
                <form>
                    <input type="text" class="mx-4 mt-5 faq-form form-control form-rounded" name="" id="ask-question"
                        placeholder="ask us a question....">
                </form>
            </div>
            <!-- END:: FAQ section -->

            <!-- BEGIN:: Online Exchange & Return Policy section-->
            <div id="online-exchange-and-return-policy-info" class="collapse">
                <h5 class="mx-4">Online Exchange & Return Policy</h5>
                <p class="mx-4 mt-4">-Free exchange for items within 7 days of receiving the parcel, we require the
                    following
                    conditions</p>
                <p class="mx-4">1. Items must be unworn (no stains, fragrances or any form of disarray that warrants
                    the item
                    unsuitable for resale.</p>
                <p class="mx-4">2. Items must be in the original condition with all tags and labels attached</p>
                <p class="mx-4">- Return is only eligible for incorrect item or faulty item. Please note we do not
                    return if the
                    size does not fit your measurement, however we can offer an exchange.</p>
                <p class="mx-4">- Jewelry and undergarments, swimwear are no eligible for returns due to hygiene
                    reasons. Shoes
                    are only eligible for returns if the sole is clean, not soiled and completely new condition.</p>
                <p class="mx-4">- Sale items can only exchange only size or colour of the same item</p>
                <p class="mx-4">- Sugar x Spice reserves the final right to accept or reject a return item. Sale and
                    promotional
                    items bought are not eligible for any form of exchange, return or refund.</p>
                <p class="mx-4">- For online returns, kindly return items to our office either by personal drop off
                    or mail to
                    our office: address & phone number. Do allow us up to 7 days to process your exchange upon
                    receiving your
                    return parcel.</p>
            </div>
            <!-- END:: Online Exchange & Return Policy section-->

            <!-- BEGIN:: Size Guide section -->
            <div id="size-guide-info" class="collapse">
                <h5>Size Guide</h5>
                <p class="mt-4">Women's Casual/Shirt/Bottom Size Chart</p>
                <!-- start table APPAREL -->
                <table class="table table-bordered text-center w-75 table-font-size">
                    <thead>
                        <tr>
                            <th class="p">Size (1cm=0.4inch)</th>
                            <th>XS</th>
                            <th>S</th>
                            <th>M</th>
                            <th>L</th>
                            <th>XL</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Height (cm)</td>
                            <td>150-156</td>
                            <td>153-159</td>
                            <td>156-162</td>
                            <td>159-165</td>
                            <td>165-168</td>
                        </tr>
                        <tr>
                            <td>Bust (cm)</td>
                            <td>74-80</td>
                            <td>77-83</td>
                            <td>80-86</td>
                            <td>83-89</td>
                            <td>89-95</td>
                        </tr>
                        <tr>
                            <td>Waist (cm)</td>
                            <td>56-62</td>
                            <td>59-65</td>
                            <td>62-68</td>
                            <td>66-72</td>
                            <td>72-78</td>
                        </tr>
                        <tr>
                            <td>Hip (cm)</td>
                            <td>81-87</td>
                            <td>84-90</td>
                            <td>87-93</td>
                            <td>91-97</td>
                            <td>97-103</td>
                        </tr>
                    </tbody>
                </table>
                <!-- end of table APPAREL -->

                <!-- start table women's bottom -->
                <p class="mt-4">Women's Bottoms</p>
                <table class="table table-bordered text-center w-75 table-font-size">
                    <thead>
                        <tr>
                            <th>Size (1cm = 0.4inch)</th>
                            <th>23"</th>
                            <th>24"</th>
                            <th>25"</th>
                            <th>26"</th>
                            <th>27"</th>
                            <th>28"</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Waist (cm)</td>
                            <td>74</td>
                            <td>77</td>
                            <td>79</td>
                            <td>82</td>
                            <td>84</td>
                            <td>87</td>
                        </tr>
                        <tr>
                            <td>Hip (cm)</td>
                            <td>87</td>
                            <td>90</td>
                            <td>92</td>
                            <td>95</td>
                            <td>97</td>
                            <td>100</td>
                        </tr>
                    </tbody>
                </table>
                <!-- end table women's bottom -->

                <!-- start table SHOES -->
                <p class="mt-4">Shoes</p>
                <table class="table table-bordered text-center w-75 table-font-size">
                    <thead>
                        <tr>
                            <th>SIZE</th>
                            <th>Measurement</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>35</td>
                            <td>228 - 233mm</td>
                        </tr>
                        <tr>
                            <td>36</td>
                            <td>234 - 239mm</td>
                        </tr>
                        <tr>
                            <td>37</td>
                            <td>240 - 245mm</td>
                        </tr>
                        <tr>
                            <td>38</td>
                            <td>246 - 251mm</td>
                        </tr>
                        <tr>
                            <td>39</td>
                            <td>252 - 258mm</td>
                        </tr>
                        <tr>
                            <td>40</td>
                            <td>263 - 268mm</td>
                        </tr>
                    </tbody>
                </table>
                <!-- end of table SHOES -->
            </div>
            <!-- END:: Size Guide section -->
        </div>
    </div>
</div>
<!-- END:: Customer Services Block -->
@endsection

@section('script')
<script src="{{ asset('js/custom-collapse.js') }}"></script>
<script>
    let infoSectionArr = {
        'how-to-buy-link': 'how-to-buy-info',
        'delivery-and-shipping-info-link': 'delivery-and-shipping-info',
        'faq-link': 'faq-info',
        'online-exchange-and-return-policy-link': 'online-exchange-and-return-policy-info',
        'size-guide-link': 'size-guide-info',
    };

    (function initCollapseSection(infoSectionArray) {
        let id = {!! json_encode($id)!!}
        showDefault(id);
        showSectionOnClick(infoSectionArray);
        hideSectionOnClick(infoSectionArray);
    })(infoSectionArr);
    
</script>
@endsection