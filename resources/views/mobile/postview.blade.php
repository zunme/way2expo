<template>
  <div class="page page-booth" data-name="boothpage">
    <div class="navbar navbar-new">
      <div class="navbar-bg"></div>
      <div class="navbar-inner sliding">
        <div class="left">
          <a href="#" class="link back">
            <i class="icon icon-back"></i>
            <span class="if-not-md">Back</span>
          </a>
        </div>
        <div class="title">공지사항</div>
        <div class="right">
          <a href="/m/notilist" class="link icon-only">
            <i class="icon material-icons md-only">notifications
              <span class="badge color-red noti-cnt">0</span>
            </i>
          </a>
          <!--a href="#" class="link icon-only panel-open menu-icon"  style="margin-left:12px;" data-panel="left"-->
			<a href="/m/menu" class="link icon-only menu-icon">
            <i class="icon material-icons">menu</i>
          </a>
        </div>
      </div>
    </div>
    <div class="page-content">
		<div class="post_wrap">
			<div class="post_head">
				{{ $post->title }}
			</div>
			<div class="post_head2">
				{{ $post->created_at->format('Y-m-d H:i:s') }}
			</div>
			<div class="post_content">
				{!! $post->body !!}
			</div>
			
		</div>
		<div class="posts_file_wrap">
			<div class="posts_file_title">
				첨부파일
			</div>
			<div class="posts_file_inner">
				@foreach ($post->attachFiles as $attach)
				<div class="posts_file_dn_wrap">
					<div class="posts_file_dn_inner">
						<a href="/mobile/posts/filedown?id={{$attach->id}}"
						   class="external">
							{{$attach->org_name}}
						</a>
					</div>
				</div>
				@endforeach
			</div>
		</div>
    </div><!-- / page-content -->


  </div><!-- / page -->
</template>
<script>
  return {
    data: function () {
      return {
      }
    },
    methods: {

    },
  }
</script>
