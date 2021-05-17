<div class="nav-left-sidebar sidebar-dark">
    <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 100%;">
        <div class="menu-list" style="overflow: hidden; width: auto; height: 90%; overflow-y:scroll;">
            <nav class="navbar navbar-expand-lg navbar-light">
                <a class="d-xl-none d-lg-none text-white" href="javascript:void(0)">Dashboard</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav flex-column">
                        <li class="nav-divider">DASHBOARD</li>
                        {{-- home --}}
                        <li class="nav-item ">
                            <a href="{{ url('dashboard') }}" class="nav-link">
                                <i class="fas fa-home fa-fw text-white mr-3"></i>
                                Home
                            </a>
                        </li>
                        {{-- products --}}
                        <li class="nav-item">
                            <a class="nav-link collapsed" href="javascript:void(0)" data-toggle="collapse" aria-expanded="false"
                                data-target="#products-dropdown" aria-controls="products-dropdown">
                                <i class="fas fa-boxes fa-fw text-white mr-3"></i>
                                Products
                            </a>
                            <div id="products-dropdown" class="submenu collapse" style="">
                                <ul class="nav flex-column pl-3">
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ url('dashboard/products') }}">
                                            Product List
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ url('products/create') }}">
                                            Products Add
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('stock-list') }}">
                                            Stock Control
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('adjustment-list') }}">
                                            Quantity Adjustments
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('adjustment-add') }}">
                                            Add Adjustment
                                        </a>
                                    </li>
                                    {{-- <li class="nav-item">
                                        <a class="nav-link" href="{{ url('dashboard/attributes/create') }}">
                                            Attribute Add
                                        </a>
                                    </li> --}}
                                </ul>
                            </div>
                        </li>

                        {{-- exchage rates --}}
                        <li class="nav-item">
                            <a class="nav-link collapsed" href="javascript:void(0)" data-toggle="collapse" aria-expanded="false"
                                data-target="#exchange-dropdown" aria-controls="exchange-dropdown">
                                <i class="far fa-file fa-fw text-white mr-3"></i>
                                Exchage Rates
                            </a>
                            <div id="exchange-dropdown" class="submenu collapse" style="">
                                <ul class="nav flex-column pl-3">
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('exrate-list') }}">
                                            Exchage Rates List
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('exrate-add') }}">
                                            Exchage Rates Add
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        {{-- quotation --}}
                        <li class="nav-item">
                            <a class="nav-link collapsed" href="javascript:void(0)" data-toggle="collapse" aria-expanded="false"
                                data-target="#quotations-dropdown" aria-controls="quotations-dropdown">
                                <i class="fa fa-hourglass-half text-white" aria-hidden="true"></i>
                                Quotations
                            </a>
                            <div id="quotations-dropdown" class="submenu collapse" style="">
                                <ul class="nav flex-column pl-3">
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('quotation-list') }}">
                                            Quotations List
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('quotation-add') }}">
                                            Quotation Add
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        {{-- sales --}}
                        <li class="nav-item">
                            <a class="nav-link collapsed" href="javascript:void(0)" data-toggle="collapse" aria-expanded="false"
                                data-target="#sales-dropdown" aria-controls="sales-dropdown">
                                <i class="fa fa-list-alt text-white" aria-hidden="true"></i>
                                Sales
                            </a>
                            <div id="sales-dropdown" class="submenu collapse" style="">
                                <ul class="nav flex-column pl-3">
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('sale-list') }}">
                                            Sales List
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('sale-add') }}">
                                            Sale Add
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        {{-- featured products --}}
                        <li class="nav-item">
                            <a class="nav-link collapsed" href="javascript:void(0)" data-toggle="collapse" aria-expanded="false"
                                data-target="#featuredProducts-dropdown" aria-controls="featuredProducts-dropdown">
                                <i class="far fa-image fa-fw text-white mr-3"></i>
                                Image Display Selection
                                {{-- Featured Product<br><br>Recommend Product<br><br>Best Seller Product<br><br>Promotion Slider<br><br>Panorama Anythings --}}
                            </a>
                            <div id="featuredProducts-dropdown" class="submenu collapse" style="">
                                <ul class="nav flex-column pl-3">
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ url('dashboard/featured') }}">
                                            Featured Product Add
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ url('dashboard/recommend') }}">
                                            Recommend Product Add
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ url('dashboard/bestseller') }}">
                                            Best Seller Add
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ url('dashboard/promotionslider') }}">
                                            Promotion Slider Add
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ url('dashboard/panorama') }}">
                                            Panorama Anythings Add
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        {{-- orders --}}
                        <li class="nav-item">
                            <a class="nav-link collapsed" href="javascript:void(0)" data-toggle="collapse" aria-expanded="false"
                                data-target="#orders-dropdown" aria-controls="orders-dropdown">
                                <i class="far fa-clipboard fa-fw text-white mr-3"></i>
                                Orders
                            </a>
                            <div id="orders-dropdown" class="submenu collapse" style="">
                                <ul class="nav flex-column pl-3">
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ url('dashboard/orders') }}">
                                            All orders
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ url('dashboard/orders/create') }}">
                                            Add order
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ url('dashboard/orders?order_status=pending') }}">
                                            Pending
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ url('dashboard/orders?order_status=confirmed') }}">
                                            Confirmed
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ url('dashboard/orders?order_status=completed') }}">
                                            Completed
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ url('dashboard/orders?order_status=cancelled') }}">
                                            Cancelled
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                         {{-- customer group --}}
                         <li class="nav-item">
                            <a class="nav-link collapsed" href="javascript:void(0)" data-toggle="collapse" aria-expanded="false"
                                data-target="#setting-dropdown" aria-controls="setting-dropdown">
                                <i class="fas fa-users fa-fw text-white mr-3"></i>
                                Customer Group
                            </a>
                            <div id="setting-dropdown" class="submenu collapse" style="">
                                <ul class="nav flex-column pl-3">
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('cusgroup-list') }}">
                                            Customer Group List
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('cusgroup-add') }}">
                                            Customer Group Add
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        {{-- staffs --}}
                        <li class="nav-item">
                            <a class="nav-link collapsed" href="javascript:void(0)" data-toggle="collapse" aria-expanded="false"
                                data-target="#users-dropdown" aria-controls="users-dropdown">
                                <i class="fa fa-user text-white" aria-hidden="true"></i>
                                Users
                            </a>
                            <div id="users-dropdown" class="submenu collapse" style="">
                                <ul class="nav flex-column pl-3">
                                    {{-- staffs --}}
                                    <li class="nav-item">
                                        <a class="nav-link" href="javascript:void(0)" data-toggle="collapse" aria-expanded="false" data-target="#staffs-dropdown" aria-controls="staffs-dropdown">
                                            Staff
                                        </a>
                                        <div id="staffs-dropdown" class="submenu collapse" style="">
                                            <ul class="nav flex-column pl-2">
                                                <li>
                                                    <a class="nav-link" href="{{ url('dashboard/staffs') }}">
                                                        Staff List
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="nav-link" href="{{ url('dashboard/staffs/create') }}">
                                                        Staff Add
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                    {{-- customers --}}
                                    <li class="nav-item">
                                        <a class="nav-link" href="javascript:void(0)" data-toggle="collapse" aria-expanded="false" data-target="#customers-dropdown" aria-controls="customers-dropdown">
                                            Customer
                                        </a>
                                        <div id="customers-dropdown" class="submenu collapse" style="">
                                            <ul class="nav flex-column pl-2">
                                                <li>
                                                    <a class="nav-link" href="{{ url('dashboard/customers') }}">
                                                        Customer List
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        {{-- giftSets --}}
                        <li class="nav-item">
                            <a class="nav-link collapsed" href="javascript:void(0)" data-toggle="collapse" aria-expanded="false"
                                data-target="#setCreators-dropdown" aria-controls="setCreators-dropdown">
                                <i class="fas fa-hand-holding fa-fw text-white mr-3"></i>
                                Set Creator
                            </a>
                            <div id="setCreators-dropdown" class="submenu collapse" style="">
                                <ul class="nav flex-column pl-3">
                                    {{-- giftset  --}}
                                    <li class="nav-item">
                                        <a class="nav-link collapsed" href="javascript:void(0)" data-toggle="collapse" aria-expanded="false"
                                            data-target="#giftsets-dropdown" aria-controls="giftsets-dropdown">
                                            <i class="fas fa-cubes fa-fw text-white mr-3"></i>
                                            Giftset
                                        </a>
                                        <div id="giftsets-dropdown" class="submenu collapse" style="">
                                            <ul class="nav flex-column pl-3">
                                                <li class="nav-item">
                                                    <a class="nav-link" href="{{url('dashboard/promosets')}}">
                                                        Giftset List
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" href="{{url('dashboard/promosets/create')}}">
                                                        Giftset Add
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                    {{-- comboset --}}
                                    <li class="nav-item">
                                        <a class="nav-link collapsed" href="javascript:void(0)" data-toggle="collapse" aria-expanded="false"
                                            data-target="#combosets-dropdown" aria-controls="combosets-dropdown">
                                            <i class="fas fa-sitemap fa-fw text-white mr-3"></i>
                                            Comboset
                                        </a>
                                        <div id="combosets-dropdown" class="submenu collapse" style="">
                                            <ul class="nav flex-column pl-3">
                                                <li class="nav-item">
                                                    <a class="nav-link" href="{{url('dashboard/giftsets')}}">
                                                        Comboset List
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" href="{{url('dashboard/giftsets/create')}}">
                                                        Comboset Add
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                            </div>

                            
                        </li>
                        {{-- delivery setting  --}}
                        <li class="nav-item">
                            <a class="nav-link collapsed" href="javascript:void(0)" data-toggle="collapse" aria-expanded="false"
                                data-target="#delivery-dropdown" aria-controls="delivery-dropdown">
                                <i class="fas fa-dolly fa-fw text-white mr-3"></i>
                                Delivery
                            </a>
                            <div id="delivery-dropdown" class="submenu collapse" style="">
                                <ul class="nav flex-column pl-3">
                                    <li class="nav-item">
                                        <a class="nav-link" href="javascript:void(0)"data-toggle="collapse" aria-expanded="false"
                                            data-target="#districts-dropdown" aria-controls="districts-dropdown">
                                            Districts
                                        </a>
                                        <div id="districts-dropdown" class="submenu collapse" style="">
                                            <ul class="nav flex-column pl-2">
                                                <li>
                                                    <a class="nav-link" href="{{ url('dashboard/districts') }}">
                                                        List districts
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="nav-link" href="{{ url('dashboard/districts/create') }}">
                                                        Add new districts
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="javascript:void(0)"data-toggle="collapse" aria-expanded="false"
                                            data-target="#sangkats-dropdown" aria-controls="sangkats-dropdown">
                                            Sangkats
                                        </a>
                                        <div id="sangkats-dropdown" class="submenu collapse" style="">
                                            <ul class="nav flex-column pl-2">
                                                <li>
                                                    <a class="nav-link" href="{{ url('dashboard/sangkats') }}">
                                                        List sangkats
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="nav-link" href="{{ url('dashboard/sangkats/create') }}">
                                                        Add new sangkats
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        {{-- web pages --}}
                        <li class="nav-item">
                            <a class="nav-link collapsed" href="javascript:void(0)" data-toggle="collapse" aria-expanded="false"
                                data-target="#webpages-dropdown" aria-controls="webpages-dropdown">
                                <i class="far fa-file fa-fw text-white mr-3"></i>
                                Webpages
                            </a>
                            <div id="webpages-dropdown" class="submenu collapse" style="">
                                <ul class="nav flex-column pl-3">
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('home') }}">
                                            <span>Home</span>
                                        </a>
                                    </li>
                                    @foreach ($categories as $category)
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ url('/products',['id' => $category->category_id])}}">
                                            <span>{{ $category->category_name}}</span>
                                        </a>
                                    </li>
                                    @endforeach
                                    <li class="nav-item">
                                        <a class="nav-link" href="">
                                            <span>Giftset</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="">
                                            <span>Eye Care</span>
                                        </a>
                                    </li>
                                   
                                </ul>
                            </div>
                        </li>

                    </ul>
                </div>
            </nav>
        </div>
        <div class="slimScrollBar"
            style="background: rgb(0, 0, 0); width: 7px; position: absolute; top: 0px; opacity: 0.4; display: none; border-radius: 7px; z-index: 99; right: 1px; height: 920px;">
        </div>
        <div class="slimScrollRail"
            style="width: 7px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: rgb(51, 51, 51); opacity: 0.2; z-index: 90; right: 1px;">
        </div>
    </div>
</div>