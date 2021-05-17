@extends('layout.app')

@section('title','Giftset')
    
@section('stylesheet')
    @parent
    <link rel="stylesheet" href="{{asset('css/giftset.css')}}">
@endsection

{{-- BEGIN:: Giftset --}}
@section('content')

@endsection
{{-- END:: Giftset --}}

@section('script')
    <script>
        $(document).ready(function(){

        });
    </script>
@endsection
