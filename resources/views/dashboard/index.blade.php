@extends('layout.dashboard')

@section('page_title','Dashboard')

{{-- Breadcrumb --}}
@section('breadcrumb')
<li class="breadcrumb-item" aria-current="page">
    <a class="breadcrumb-link active">Dashboard</a>
</li>
@endsection

@section('dashboard_content')
<hr>
<div class="ecommerce-widget">
    <div class="row">
        <!-- ============================================================== -->
        <!-- sales  -->
        <!-- ============================================================== -->
        <div class="col-xl-3 col-md-6 col-12 mb-4">
            <div class="card border-top-primary shadow-sm h-100">
                <div class="card-body">
                    <div class="row align-items-center justify-content-between  px-3">
                        <div class="widget-circle rounded-circle bg-purple">
                            <p class="widget-text" style="">S</p>
                        </div>
                        <div class="metric-value">
                            <h1 class="font-weight-bold text-center">$1245</h1>
                            <span class="text-muted mr-2">Sale</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- end sales  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- new customer  -->
        <!-- ============================================================== -->
        <div class="col-xl-3 col-md-6 col-12 mb-4 h-100">
            <div class="card border-top-primary shadow-sm">
                <div class="card-body">
                    <div class="row align-items-center justify-content-between  px-3">
                        <div class="widget-circle rounded-circle bg-purple">
                            <p class="widget-text" style="">N.C</p>
                        </div>
                        <div class="metric-value">
                            <h1 class="font-weight-bold text-center">3</h1>
                            <span class="text-muted mr-2">New Customer</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- end new customer  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- visitor  -->
        <!-- ============================================================== -->
        <div class="col-xl-3 col-md-6 col-12 mb-4">
            <div class="card border-top-primary shadow-sm h-100">
                <div class="card-body">
                    <div class="row align-items-center justify-content-between  px-3">
                        <div class="widget-circle rounded-circle bg-purple">
                            <p class="widget-text" style="">V</p>
                        </div>
                        <div class="metric-value">
                            <h1 class="font-weight-bold">245</h1>
                            <span class="text-muted mr-2">Visitor</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- end visitor  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- total orders  -->
        <!-- ============================================================== -->
        <div class="col-xl-3 col-md-6 col-12 mb-4">
            <div class="card border-top-primary shadow-sm h-100">
                <div class="card-body">
                    <div class="row align-items-center justify-content-between  px-3">
                        <div class="widget-circle rounded-circle bg-purple">
                            <p class="widget-text" style="">T.O</p>
                        </div>
                        <div class="metric-value">
                            <h1 class="font-weight-bold">1</h1>
                            <span class="text-muted mr-2">Total Order</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- end total orders  -->
        <!-- ============================================================== -->
    </div>
    <div class="row">
        <!-- ============================================================== -->
        <!-- product category  -->
        <!-- ============================================================== -->
        <div class="col-xl-8 col-lg-12 col-md-12 col-sm-12 col-12 mb-4">
            <div class="card shadow-sm">
                <h5 class="card-header"> Product Category</h5>
                <div class="card-body py-5">
                    <div class="row">
                        <div class="ct-chart-category ct-golden-section col-md-8 col-12" style="height: 330px;"></div>
                        <div class="col-md-4 col-12">
                            <div class="row mt-5">
                                <p class="legend-item mb-md-5 mb-0 col-4 col-md-12">
                                    <span class="fa-xs text-primary mr-1 legend-tile"><i
                                            class="fa fa-fw fa-square-full "></i></span><span
                                        class="legend-text">Man</span>
                                </p>
                                <p class="legend-item mb-md-5 mb-0 col-4 col-md-12">
                                    <span class="fa-xs text-secondary mr-1 legend-tile"><i
                                            class="fa fa-fw fa-square-full"></i></span>
                                    <span class="legend-text">Woman</span>
                                </p>
                                <p class="legend-item mb-md-5 mb-0 col-4 col-md-12">
                                    <span class="fa-xs text-info mr-1 legend-tile"><i
                                            class="fa fa-fw fa-square-full"></i></span>
                                    <span class="legend-text ">Accessories</span>
                                </p>
                                <p class="legend-item mb-md-5 mb-0 col-4 col-md-12">
                                    <span class="fa-xs text-info mr-1 legend-tile"><i
                                            class="fa fa-fw fa-square-full"></i></span>
                                    <span class="legend-text ">Accessories</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- end product category  -->
        <!-- ============================================================== -->

        <!-- ============================================================== -->
        <!-- lowest product in stock  -->
        <!-- ============================================================== -->
        <div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 col-12 mb-4">
            <div class="card shadow-sm h-100">
                <h5 class="card-header">Lowest products in stock</h5>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table no-wrap p-table">
                            <thead class="bg-light">
                                <tr class="border-0">
                                    <th class="border-0">product sku</th>
                                    <th class="border-0">cost</th>
                                    <th class="border-0">price</th>
                                    <th class="border-0">quantity</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($lowestProducts as $lowestProduct)
                                <tr>
                                    <td>{{$lowestProduct->product_variant_sku}}</td>
                                    <td>{{$lowestProduct->cost}}</td>
                                    <td>{{$lowestProduct->price}}</td>
                                    <td>{{$lowestProduct->quantity}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- end top perfomimg  -->
            <!-- ============================================================== -->
        </div>
    </div>
    <div class="row">
        <!-- ============================================================== -->
        <!-- recent orders  -->
        <!-- ============================================================== -->
        <div class="col-12 mb-4">
            <div class="card shadow-sm h-100">
                <h5 class="card-header">Recent Orders</h5>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="bg-light">
                                <tr class="border-0">
                                    <th class="border-0">#</th>
                                    <th class="border-0">Image</th>
                                    <th class="border-0">Product Name</th>
                                    <th class="border-0">Product Id</th>
                                    <th class="border-0">Quantity</th>
                                    <th class="border-0">Price</th>
                                    <th class="border-0">Order Time</th>
                                    <th class="border-0">Customer</th>
                                    <th class="border-0">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>
                                        <div class="m-r-10"><img src="" alt="user" class="rounded" width="45"></div>
                                    </td>
                                    <td>Product #1 </td>
                                    <td>id000001 </td>
                                    <td>20</td>
                                    <td>$80.00</td>
                                    <td>27-08-2018 01:22:12</td>
                                    <td>Patricia J. King </td>
                                    <td><span class="badge-dot badge-primary mr-1"></span>InTransit
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>
                                        <div class="m-r-10"><img src="" alt="user" class="rounded" width="45"></div>
                                    </td>
                                    <td>Product #2 </td>
                                    <td>id000002 </td>
                                    <td>12</td>
                                    <td>$180.00</td>
                                    <td>25-08-2018 21:12:56</td>
                                    <td>Rachel J. Wicker </td>
                                    <td><span class="badge-dot badge-success mr-1"></span>Delivered
                                    </td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>
                                        <div class="m-r-10"><img src="" alt="user" class="rounded" width="45"></div>
                                    </td>
                                    <td>Product #3 </td>
                                    <td>id000003 </td>
                                    <td>23</td>
                                    <td>$820.00</td>
                                    <td>24-08-2018 14:12:77</td>
                                    <td>Michael K. Ledford </td>
                                    <td><span class="badge-dot badge-success mr-1"></span>Delivered
                                    </td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>
                                        <div class="m-r-10"><img src="" alt="user" class="rounded" width="45"></div>
                                    </td>
                                    <td>Product #4 </td>
                                    <td>id000004 </td>
                                    <td>34</td>
                                    <td>$340.00</td>
                                    <td>23-08-2018 09:12:35</td>
                                    <td>Michael K. Ledford </td>
                                    <td><span class="badge-dot badge-success mr-1"></span>Delivered
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- end recent orders  -->
        <!-- ============================================================== -->
    </div>
</div>
@endsection

{{-- Javascript --}}
@section('dashboard_script')
<!-- Libs JS -->
<script src="{{asset('js/libs/chartist/dist/chartist.min.js')}}"></script>
<script src="{{asset('js/libs/chartist-plugin-threshold/dist/chartist-plugin-threshold.min.js')}}">
</script>
<script src="{{asset('js/libs/chart.js/dist/Chart.bundle.min.js')}}"></script>
@endsection