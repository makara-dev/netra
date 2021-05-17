@extends('layout.dashboard')


{{-- Page Title --}}
@section('page_title','Create District')

@section('dashboard_stylesheet')
<style>
    .form-custom-input {
        width: 100%;
        max-width: 330px;
        padding: 15px;
        margin: 0 auto;
    }

    .form-custom-input .checkbox {
        font-weight: 400;
    }

    .form-custom-input .form-control {
        position: relative;
        box-sizing: border-box;
        height: auto;
        padding: 10px;
        font-size: 16px;
    }

    .form-custom-input .form-control:focus {
        z-index: 2;
    }

    .form-custom-input input[type="text"] {
        margin-bottom: -1px;
        border-bottom-right-radius: 0;
        border-bottom-left-radius: 0;
    }
</style>
@endsection

{{-- Breadcrumb --}}
@section('breadcrumb')
<li class="breadcrumb-item" aria-current="page">
    <a href="{{ url('dashboard') }}" class="breadcrumb-link">Dashboard</a>
</li>
<li class="breadcrumb-item" aria-current="page">
    <a href="{{ url('dashboard/districts') }}" class="breadcrumb-link">Districts</a>
</li>
<li class="breadcrumb-item active" aria-current="page">Create</li>
@endsection

@section('dashboard_content')

<section class="container-fluid bg-white p-5 mt-2 shadow-lg">
    <div class="mx-auto col-xl-5 col-lg-6 col-md-9 col-12 my-5">
        <div class="form-custom-input">
            <label for="name">Enter a district name</label>
            <div class="input-group mb-3">
                <input id="districtInput" type="text" class="form-control" placeholder="Distict Name" autofocus>
                <div class="input-group-append">
                    <button id="addDistrictBtn" class="btn btn-outline-gray" type="button">Add</button>
                </div>
            </div>
        </div>

    </div>
    <form action="{{ url('dashboard/districts') }}" method="POST">
        @csrf
        <table id="districtTable" class="table shadow-lg-2 d-none text-center">
            <thead class="thead-dark">
                <tr>
                    <th>District Name</th>
                    <th>Options</th>
                </tr>
            </thead>
            <tbody>
                {{-- District hidden inputs --}}
            </tbody>
        </table>
        <div class="d-block text-right pr-5">
            <button type="submit" class="btn btn-dark">Submit</button>
        </div>
    </form>
</section>

@endsection

@section('dashboard_script')
<script>
    hasAdded = false;
    $('#addDistrictBtn').on('click', function(){

        districtName = $('#districtInput').val();
        
        if(!districtName){
            alert('District name empty.')
            return false;
        }
        $('#districtInput').val('');
    
        table = $('#districtTable');

        if(!hasAdded){
            $(table).removeClass('d-none');
        }
        
        input = $('<input>').attr('type', 'hidden').attr('name', 'names[]').val(districtName);
        tdInput = $('<td></td>').html(districtName).append(input);

        deleteBtn = $('<button></button>').addClass('btn btn-link').attr('type', 'button').html('<i class="fas fa-trash"></i>')
        tdDelete = $('<td></td>').append(deleteBtn);

        tr = $('<tr></tr>').append(tdInput).append(tdDelete);
        tbody = $(table).find('tbody').append(tr);

        $(tdDelete).on('click', function(){
            $(this).closest('tr').remove();
        })
    });
</script>
@endsection