@extends('mobile.defaultlayout')
@section('css')

@endsection

@section('body')
<div class="page page-home">


    <div class="navbar navbar-large navbar-transparent">
        <div class="navbar-bg"></div>
        <div class="navbar-inner">
            <div class="left">
                <a href="/" class="link external">
                    <img class="navbar-logo-img" src="/image/logo/logo-way2expo.svg" />
                </a>
            </div>
            <div class="title"></div>
            <div class="right">
              <a href="/m/notilist" class="link icon-only">
                <i class="icon material-icons md-only">notifications
                  <span class="badge color-red noti-cnt">{{empty($notiCount)?'0': $notiCount}}</span>
                </i>
              </a>
				
				<a class="link icon-only searchbar-enable" data-searchbar=".searchbar-components">

					<i class="icon material-icons">search</i>
				</a>
				
                <a href="#" class="link icon-only panel-open" data-panel="left">
                  <i class="icon material-icons">menu</i>
                </a>
            </div>
			
			<form class="searchbar searchbar-expandable searchbar-components searchbar-init">
				<div class="searchbar-inner">
					<div class="searchbar-input-wrap">
						<input type="search" id="globalsearchstr" onKeyUp="globalsearchkey(this)" placeholder="검색어를 입력해주세요">
						<i class="searchbar-icon"></i>
						<span class="" style="
  	transition-duration: .1s;
	position: absolute;
	top: 50%;
	border: none;
	padding: 0;
	margin: 0;
	outline: 0;
	z-index: 1;
	cursor: pointer;
	background: 0 0;
	opacity: 1;
	pointer-events: auto;
	visibility: visible;
	width: 48px;
	height: 48px;
	right: 0;
	margin-top: -16px;
											  ">
							<a href="#" onClick="globalsearch('globalsearchstr')">
								<i class="icon material-icons" style="color:black">search</i>
							</a>
						</span>
						<!--span class="input-clear-button"></span-->
					</div>
					
					<span class="searchbar-disable-button if-not-aurora">Cancel</span>
				</div>
			</form>
			
			
        </div>
    </div> <!-- navbar -->

    <div class="page-content page-none-padding-top" style="background-image: url(/image/bg-logo-poster.png);background-position: 50%;
    background-size: cover;opacity:.5">
	</div>
</div>

@endsection

@section('script')

@endsection