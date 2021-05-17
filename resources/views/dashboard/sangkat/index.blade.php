@extends('layout.dashboard')


{{-- Page Title --}}
@section('page_title','Sangkats')

{{-- Breadcrumb --}}
@section('breadcrumb')
<li class="breadcrumb-item" aria-current="page">
    <a href="{{ url('dashboard') }}" class="breadcrumb-link">Dashboard</a>
</li>
<li class="breadcrumb-item active" aria-current="page">Sangkats</li>
@endsection

@section('dashboard_content')
{{-- Table  --}}
<table class="table shadow-lg bg-white mt-3">
    <thead class="thead-dark thead-btn">
        <tr>
            <th>ID</th>
            <th>Sangkat Name</th>
            <th>Delivery Fee</th>
            <th>District</th>
            <th>Option</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($sangkats as $sangkat)
        <tr>
            <td>{{$sangkat->sangkat_id}}</td>
            <td>{{$sangkat->sangkat_name}}</td>
            <td>${{$sangkat->delivery_fee}}</td>
            <td>{{$sangkat->district->district_name}}</td>
            <td>
                <a class="text-dark mr-1" href="{{ url("dashboard/sangkats/$sangkat->sangkat_id/edit") }}"><i
                        class="fas fa-edit"></i></a>
                <form action="{{ url("dashboard/sangkats/$sangkat->sangkat_id") }}" method="POST"
                    class="d-inline-block">
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
{{ $sangkats->links() }}
<hr class="w-75 mx-auto">
@endsection

@section('dashboard_script')
<script>
    $('.td-options > a, .btn-delete').on('click', function disableCollapse(e){
        e.stopPropagation();
    });
    $('.btn-delete').on('click', function disableCollapse(e){
        return confirm('Are you sure?') 
    });
</script>
@endsection