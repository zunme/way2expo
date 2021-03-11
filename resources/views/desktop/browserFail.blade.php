@extends('desktop.layouts.none')
@section('body-class', 'raised')
@section('body')
@section('navbar','')

@section('header-class','header-filter header-s')
@section('header-bg-attachment','fixed')
@section('header-bg-position','0 -180px')
@section('header-title','안내')
<div class="main main-raised raised-s" style="max-width: 680px;">
    <div class="section">
        <div class="container">
            <div class="info">
                <div class="icon icon-primary">
                    <i class="material-icons">chat</i>
                </div>
                <h4 class="info-title">다른 브라우저를 사용해보세요.</h4>
                <p>저희 서비슨ㄴ 아래의 브라우저만 지원하고 있습니다.</p>
                <p>계속해서 이용하시려면 </p>
            </div>
        </div>
    </div>
</div>
@endsection
