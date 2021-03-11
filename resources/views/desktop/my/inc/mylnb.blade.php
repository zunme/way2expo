<ul class="nav nav-pills nav-pills-black flex-column nav-my p-0">
    @if (Auth::user()->company_id > 0)
        <li class="nav-item">
            <a href="/my/meeting/receive" class="nav-link {{ (request()->segment(2) == 'meeting' && request()->segment(3) == 'receive')?'active':'' }}">신청받은 1:1화상회의</a>
        </li>
        <li class="nav-item">
            <a href="/my/exchange/receive" class="nav-link {{ (request()->segment(2) == 'exchange' && request()->segment(3) == 'receive')?'active':'' }}">신청받은 비즈니스문의</a>
        </li>
        <li class="divider"><hr></li>
    @endif
    <li class="nav-item">
        <a href="/my/info" class="nav-link {{ (request()->segment(2) == 'info')?'active':'' }}">내 정보</a>
    </li>
    <li class="nav-item">
        <a href="/my/card" class="nav-link {{ (request()->segment(2) == 'card')?'active':'' }}">내 명함 관리</a>
    </li>
{{--    <li class="nav-item">--}}
{{--        <a href="/my/notifications" class="nav-link {{ (request()->segment(2) == 'notifications')?'active':'' }}">알림 내역</a>--}}
{{--    </li>--}}
    <li class="divider"><hr></li>
    <li class="nav-item">
        <a href="/my/latest?m=expo" class="nav-link {{ (request()->query('m') == 'expo')?'active':'' }}">내가 본 박람회</a>
    </li>
    <li class="nav-item">
        <a href="/my/latest?m=booth" class="nav-link {{ (request()->query('m') == 'booth')?'active':'' }}">내가 본 부스</a>
    </li>
    <li class="nav-item">
        <a href="/my/favorites" class="nav-link {{ (request()->segment(2) == 'favorites')?'active':'' }}">즐겨찾기</a>
    </li>
    <li class="nav-item">
        <a href="/my/dibs" class="nav-link {{ (request()->segment(2) == 'dibs')?'active':'' }}">찜</a>
    </li>
    <li class="divider"><hr></li>
    <li class="nav-item">
        <a href="/my/meeting/send" class="nav-link {{ (request()->segment(2) == 'meeting' && request()->segment(3) == 'send')?'active':'' }}">1:1 화상회의</a>
    </li>
    <li class="nav-item">
        <a href="/my/exchange/send" class="nav-link {{ (request()->segment(2) == 'exchange' && request()->segment(3) == 'send')?'active':'' }}">비즈니스 문의</a>
    </li>
</ul>
