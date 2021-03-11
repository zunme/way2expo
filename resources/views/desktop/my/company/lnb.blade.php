@if(!request()->segment(3))
    <ul class="nav nav-pills nav-pills-black flex-column nav-company p-0">
    <li class="nav-item d-none">
        <a href="/my/company/info" class="nav-link {{ (request()->segment(3) == 'info')?'active':'' }}">기업 정보 관리</a>
    </li>
        <li class="nav-item">
            <a href="/my/booth" class="nav-link {{ (request()->segment(2) == 'booth' && !request()->segment(3))?'active':'' }}">부스 목록</a>
        </li>
    <li class="nav-item d-none">
        <a href="/my/company/meeting" class="nav-link {{ (request()->segment(3) == 'meeting')?'active':'' }}">1:1 화상회의
            관리</a>
    </li>
    <li class="nav-item d-none">
        <a href="/my/company/exchange" class="nav-link {{ (request()->segment(3) == 'exchange')?'active':'' }}">비즈니스 문의
            관리</a>
    </li>
</ul>
@endif

@if(!empty(request()->booth_id) && !empty($booth))
    <ul class="nav nav-pills nav-pills-rose flex-column nav-booth p-0">
        <li class="nav-item">
            @if($booths->count() > 1)
                <label for="boothSelect">부스 선택</label>
                <select id="boothSelect"
                        class="form-control selectpicker"
                        data-style="btn btn-link"
                        onchange="window.location.href='/my/booth/{{request()->segment(3)}}/' + this.value"
                >
                    @foreach($booths as $item)
                        <option
                            value="{{$item->id}}" {{(request()->booth_id == $item->id)?'selected':''}}>{{$item->booth_title}}</option>
                    @endforeach
                </select>
            @else
                <h3>{{$booth->booth_title}}</h3>
            @endif
            <a href="/expo/{{$booth->expobooth->expo_code}}/{{$booth->id}}" target="_blank" class="btn btn-sm btn-outline-black btn-block">부스 바로보기
                <i class="material-icons"
                   style="padding: 0;display: inline-block;font-size: 1rem;vertical-align: sub;">open_in_new</i></a></a>
            <a href="/my/booth" class="btn btn-sm btn-outline-black btn-block">목록보기</a>
        </li>
        <li class="divider">
            <hr>
        </li>
        <li class="nav-item">
            <a href="/my/booth/detail/{{request()->booth_id}}"
               class="nav-link {{ (request()->segment(3) == 'detail')?'active':'' }}">기본 정보</a>
        </li>
        <li class="nav-item">
            <a href="/my/booth/product/{{request()->booth_id}}"
               class="nav-link {{ (request()->segment(3) == 'product')?'active':'' }}">전시상품 관리</a>
        </li>
        <li class="nav-item">
            <a href="/my/booth/live/{{request()->booth_id}}"
               class="nav-link {{ (request()->segment(3) == 'live')?'active':'' }}">LIVE 방송</a>
        </li>
        {{--    <li class="nav-item dropdown position-relative">--}}
        {{--        <a class="nav-link dropdown-toggle {{ (request()->segment(2) == 'meeting')?'active':'' }}" data-toggle="dropdown" href="#0" role="button"--}}
        {{--           aria-haspopup="true" aria-expanded="false">화상 회의 내역</a>--}}
        {{--        <div class="dropdown-menu dropdown-menu-left">--}}
        {{--            <a class="dropdown-item" href="/my/meeting/receive">요청받은 화상회의</a>--}}
        {{--            <a class="dropdown-item" href="/my/meeting/send">신청한 화상회의</a>--}}
        {{--        </div>--}}
        {{--    </li>--}}
    </ul>
@endif
