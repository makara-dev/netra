@extends('layout.dashboard')

@php
    $idSort = app('request')->input('product_id-sort');
    $nameSort = app('request')->input('product_name-sort');
    $categorySort = app('request')->input('category_name-sort');
    $createdAtSort = app('request')->input('created_at-sort');
    $updatedAtSort = app('request')->input('updated_at-sort');
@endphp

{{-- Page Title --}}
@section('page_title','Products List')

{{-- Breadcrumb --}}
@section('breadcrumb')
<li class="breadcrumb-item" aria-current="page">
    <a href="{{ url('/dashboard') }}" class="breadcrumb-link">Dashboard</a>
</li>
<li class="breadcrumb-item active" aria-current="page">Products</li>
@endsection

@section('dashboard_content')
{{-- Table  --}}
<div style="overflow-x:scroll;">
    <table class="table shadow-lg bg-white mt-3">
        <thead class="thead-dark thead-btn">
            <tr>
                <form id="product_id-sort-form">
                    @csrf
                    <th onclick="$('#product_id-sort-form').submit()">
                        ID
                        @if ($idSort === "desc")
                        <i class="fas fa-caret-up ml-2"></i>
                        <input type="hidden" name="product_id-sort" value="asc">
                        @else
                        <i class="fas fa-caret-down ml-2"></i>
                        <input type="hidden" name="product_id-sort" value="desc">
                        @endif
                </form>

                <form id="product_name-sort-form">
                    @csrf
                    <th onclick="$('#product_name-sort-form').submit()">
                        Name
                        @if ($nameSort === "desc")
                        <i class="fas fa-caret-up ml-2"></i>
                        <input type="hidden" name="product_name-sort" value="asc">
                        @else
                        <i class="fas fa-caret-down ml-2"></i>
                        <input type="hidden" name="product_name-sort" value="desc">
                        @endif
                </form>
                <form id="category_name-sort-form">
                    @csrf
                    <th onclick="$('#category_name-sort-form').submit()">
                        Category
                        @if ($categorySort === "desc")
                        <i class="fas fa-caret-up ml-2"></i>
                        <input type="hidden" name="category_name-sort" value="asc">
                        @else
                        <i class="fas fa-caret-down ml-2"></i>
                        <input type="hidden" name="category_name-sort" value="desc">
                        @endif
                </form>
                <form id="created_at-sort-form">
                    @csrf
                    <th onclick="$('#created_at-sort-form').submit()">
                        Date Created
                        @if ($createdAtSort === "desc")
                        <i class="fas fa-caret-up ml-2"></i>
                        <input type="hidden" name="created_at-sort" value="asc">
                        @else
                        <i class="fas fa-caret-down ml-2"></i>
                        <input type="hidden" name="created_at-sort" value="desc">
                        @endif
                </form>
                <form id="updated_at-sort-form">
                    @csrf
                    <th onclick="$('#updated_at-sort-form').submit()">
                        Date Updated
                        @if ($updatedAtSort === "desc")
                        <i class="fas fa-caret-up ml-2"></i>
                        <input type="hidden" name="updated_at-sort" value="asc">
                        @else
                        <i class="fas fa-caret-down ml-2"></i>
                        <input type="hidden" name="updated_at-sort" value="desc">
                        @endif
                    </th>
                    <th>Option</th>
                </form>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
            <tr class="cursor-pointer" data-toggle="collapse" data-target="#product{{$product->product_id}}Collapse">
                <td>{{$product->product_id}}</td>
                <td>{{$product->product_name}}</td>
                <td>{{$product->Category->category_name}}</td>
                <td>{{$product->created_at}}</td>
                <td>{{$product->updated_at}}</td>
                <td class="td-options">
                    <a class="text-dark mr-1" href="{{ url("products/$product->product_id/edit") }}"><i
                            class="fas fa-edit"></i></a>
                    <a class="text-dark mr-1" href="{{ url('products/create') }}"><i class="fas fa-plus"></i></a>
                    <form action="{{ url("products/$product->product_id") }}" method="POST"
                        class="d-inline-block">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-link btn-delete text-dark p-0"><i
                                class="fas fa-trash"></i></button>
                    </form>
                </td>
    
            </tr>
            <tr>
                <td colspan="6" class="p-0 border-0">
                    <div class="collapse" id="product{{$product->product_id}}Collapse">
                        <table class="table shadow-lg bg-white w-75 mx-auto">
                            <thead>
                                <tr>
                                    <th>Product Variant SKU</th>
                                    <th class="text-center">Quantity</th>
                                    <th>Date Created</th>
                                    <th>Option</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($product->productVariants as $item)
                                <tr>
                                    <td>{{$item->product_variant_sku}}</td>
                                    <td class="text-center">{{$item->quantity}}</td>
                                    <td>{{$item->created_at}}</td>
                                    <td>
                                        <a class="text-dark mr-1" href="{{ url("products/$product->product_id/edit") }}"><i
                                                class="fas fa-edit"></i></a>
                                        <a class="text-dark mr-1" href="{{ url("products/$product->product_id/edit") }}"><i
                                                class="fas fa-plus"></i></a>
                                        <form action="{{ url("dashboard/productvariants/$item->product_variant_id") }}"
                                            method="POST" class="d-inline-block">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-link btn-delete text-dark p-0"><i
                                                    class="fas fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{-- <div class="collapse" id="product{{$product->product_id}}Collapse">
    
                    </div> --}}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $products->links() }}
    <hr class="w-75 mx-auto">
</div>
@endsection

@section('dashboard_script')
<script>
    //confirm delete 
    $('.btn-delete').on('click',function(){
        return confirm('Are you sure?') 
    });

    $('.td-options').on('click',function(e){
        e.stopPropagation();
    })
</script>
@endsection