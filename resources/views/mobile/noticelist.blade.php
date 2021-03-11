<template>
  <div class="panel panel-left panel-cover">
    <div class="view">
      <div class="page">

        <div class="page-content">
          <div class="block">
            @guest
             <div class="display-flex justify-content-center align-content-center" >
               <div class="flex-msg-box">
                 로그인 후 사용해주세요
               </div>
             </div>
            @endguest

            @auth
            <div class="list media-list chevron-center">
                <ul>
                  @forelse( $notilist as $noti)
                  <li>
                    @if( $noti->noti_read =='N')
                    <span class="badge color-orange noti-list-new-icon-badge">N</span>
                    @endif
                    <a href="{{$routercfg[ $noti->data['target'] ]}}" class="item-link item-content panel-close">
                      <div class="item-inner">
                        <div class="item-title-row">
                          <div class="item-title" style="position:relative">{{$noti->data['title']}}</div>
                          <div class="item-after">{{$noti->created_at->diffForHumans() }}</div>
                        </div>
                        <div class="item-text">{{$noti->data['content']}}</div>
                      </div>
                    </a>
                  </li>
                  @empty
                    <li>
                      <div class="display-flex justify-content-center">
                        <p><i class="material-icons">warning</i></p>
                        <p>알림 내역이 없습니다.</p>
                      </div>
                    <li>
                  @endforelse
                </ul>
              </div>
            @endauth
          </div> <!-- /block -->
        </div> <!-- /page-conten -->


      </div> <!-- /page -->
    </div> <!-- /view -->
  </div>
</template>

<script>

</script>
