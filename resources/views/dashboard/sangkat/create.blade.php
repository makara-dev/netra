@extends('layout.dashboard')


{{-- Page Title --}}
@section('page_title','Create Sangkat')

@section('dashboard_stylesheet')
<style>
    .form-custom-input {
        width: 100%;
        max-width: 400px;
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
    <a href="{{ url('dashboard/sangkats') }}" class="breadcrumb-link">Sangkats</a>
</li>
<li class="breadcrumb-item active" aria-current="page">Create</li>
@endsection

@section('dashboard_content')

<form action="{{ url('dashboard/sangkats') }}" method="POST">
    <section class="container-fluid bg-white p-5 mt-2 shadow-lg">
        <div class="mx-auto col-xl-5 col-lg-6 col-md-9 col-12 my-5">
            <div class="form-custom-input">
                <div class="form-group">
                    <label for="districtSelect">Select a district first</label>
                    <select name="districtSelect" id="districtSelect" class="form-control" autofocus required>
                        <option value="" selected>Sangkats</option>
                        @foreach ($districts as $district)
                        <option value="{{$district->district_id}}">{{$district->district_name}}</option>
                        @endforeach
                    </select>
                    <input type="hidden" name="district" id="district">
                </div>
                <div class="form-group">
                    <label for="name">Enter a sangkat name</label>
                    <div class="input-group mb-3">
                        <input id="sangkatInput" type="text" class="form-control m-0" placeholder="Sangkat Name"
                            disabled>
                        <input id="deliveryFeeInput" type="number" class="form-control col-3" step="0.01" min="0" value="0.00" disabled>
                        <div class="input-group-append">
                            <button id="addSangkatBtn" class="btn btn-outline-gray" type="button" disabled>Add</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>


        @csrf
        <table id="sangkatTable" class="table shadow-lg-2 d-none text-center">
            <thead class="thead-dark">
                <tr>
                    <th>Sangkat Name</th>
                    <th>Delivery Fee</th>
                    <th>Options</th>
                </tr>
            </thead>
            <tbody>
                {{-- sangkat hidden inputs here --}}
            </tbody>
        </table>
        <div class="d-block text-right pr-5">
            <button type="submit" class="btn btn-dark">Submit</button>
        </div>
    </section>
</form>

@endsection

@section('dashboard_script')
<script>
    // bulk add sangkats
    hasAdded = false;
    $('#addSangkatBtn').on('click', function(){

        sangkatName = $('#sangkatInput').val();
        deliveryFee = $('#deliveryFeeInput').val();

        if(!sangkatName){
            alert('Sangkat name empty.')
            return false;
        }
        $('#sangkatInput').val('').focus();

        table = $('#sangkatTable');

        if(!hasAdded){
            $(table).removeClass('d-none');
        }
        
        //Sangkat Names
        nameInput = $('<input>')
            .attr('type', 'hidden')
            .attr('name', 'names[]')
            .val(sangkatName);        
        tdName = $('<td></td>')
            .html(sangkatName)
            .append(nameInput);

      

            


        //delivery Fees
        deliveryFeeInput = $('<input>')
            .attr('type', 'hidden')
            .attr('name', 'deliveryFees[]')
            .val(deliveryFee);
        tdDeliveryFee = $('<td></td>')
            .html('$' + deliveryFee)
            .append(deliveryFeeInput);

        //delete btn
        deleteBtn = $('<button></button>')
            .addClass('btn btn-link')
            .attr('type', 'button')
            .html('<i class="fas fa-trash"></i>')
        tdDelete = $('<td></td>')
            .append(deleteBtn);


        tr = $('<tr></tr>')
            .append(tdName)
            .append(tdDeliveryFee)
            .append(tdDelete);
        
        tbody = $(table)
            .find('tbody')
            .append(tr);

        $(tdDelete).on('click', function(){
            $(this).closest('tr').remove();
        })
    });

    //lock inputs
    $('#districtSelect').on('change', function(){
        val = $(this).val();

        $('#district').val(val);
        
        $(this).attr('disabled',true);
        
        $('#sangkatInput').attr('disabled',false).focus();
        $('#deliveryFeeInput').attr('disabled',false);
        $('#addSangkatBtn').attr('disabled',false);

    })
</script>
@endsection