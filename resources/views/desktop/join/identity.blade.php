@extends('desktop.layouts.none')
@section('body-class', '')
@section('header','')
@section('body')
<div class="main">
    <div class="section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-8 ml-auto mr-auto">
                    <h5>본인인증</h5>
                    <form name="identityForm" action="{{ route('join.post.identity') }}" method="POST">
                        @csrf
                        <input type="hidden" name="kakao_id" value="{{session('kakao_id')}}">
                        <button type="submit" class="btn btn-sm btn-black">완료</button>
                    </form>
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
