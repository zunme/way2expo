@extends('desktop.layouts.none')
@section('body-class', '')
@section('header','')
@section('body')
<div class="main">
    <div class="section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-8 ml-auto mr-auto">
                    <p>{{$user->name}}</p>
                    <p>{{$user->email}}</p>
                    <a href="/" class="btn btn-sm btn-black">메인</a>
                    <a href="/login" class="btn btn-sm btn-black">로그인</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('page-after')
@stop
@section('page-script')
    <script>
        $(function () {
        });
    </script>
@stop
