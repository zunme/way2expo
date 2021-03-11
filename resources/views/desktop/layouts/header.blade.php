<div class="page-header-wrap">
    <div class="page-header @yield('header-class', 'header-filter header-m')" data-parallax="@yield('header-parallax', 'false')"
         style="background-image: url('@yield('header-bg','/assets/img/page-header/bg-page-header.png')'); transform: translate3d(0px, 0px, 0px);background-attachment: @yield('header-bg-attachment','fixed');background-repeat: no-repeat;background-position:@yield('header-bg-position','bottom');background-size:@yield('header-bg-size','cover')">
        @section('header-content')
        <div class="container">
            <div class="row">
                <div class="col-md-8 ml-auto mr-auto text-center">
                    <h2 class="title">@yield('header-title','Way2EXPO')</h2>
                </div>
            </div>
        </div>
        @show
    </div>
    <div class="separator separator-bottom separator-skew zindex-100">
        <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1"
             xmlns="http://www.w3.org/2000/svg">
            <polygon class="fill-white" points="2560 0 2560 100 0 100"></polygon>
        </svg>
    </div>
</div>
