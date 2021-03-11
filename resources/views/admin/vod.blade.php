@extends('admin.defaultlayout')

@section('css')
<link rel="stylesheet" href="/admin_assets/stisla/node_modules/chocolat/dist/css/chocolat.css">
<style>
textarea{width:100%;min-height: 80px;}
:root{
  --recruit_before_color : #3abaf4;
  --recruit_end_color : #84a5c1;
  --recruit_ing_color : #47c363;
}
.header_flex_wrap{
    align-self: center;
    padding: 15px 25px;
    display: flex;
    align-items: center;
}
.recruit_before{
  color : var(--recruit_before_color);
}
.recruit_end{
  color : var(--recruit_end_color);
}
.recruit_ing{
  color : var(--recruit_ing_color);
}
.prc-color-info{margin-left:10px;margin-right:10px;}
</style>
@endsection

@section('main')
<style>
	.moveable{display: flex;
    margin: 2px 0;
    border: 1px solid gray;
    padding: 3px 5px;
	font-size:18px;
	height:80px;
	}
	.moveable > div{
		display:flex;

	}
	.moveable > div:not(:first-child){
		margin-left:10px;
		margin-right:10px;		
	}
	.moveable img {
		max-height:80px;
		max-width:100px;
	}
	.draghandle{
		font-size: 18px;
		padding: 0 10px;
		align-items: center;}
	.vod-title{
	flex-grow: 1;
    display: flex;
    align-self: center;
	}
</style>
<div class="row">
  <div class="col-12">

    <div class="card">
      <form id="add_search_from">
        <div class="card-header" style="justify-content: space-between">
          <h4>VOD 관리</h4>
          <div class="header_flex_wrap">
            <div class="section-header-breadcrumb" style="margin-left: 30px;">
              <span class="btn btn-icon btn-warning" style="border-radius: 10px;" onClick="createform()"><i class="fas fa-plus"></i></span>
            </div>
          </div>
        </div>
      </form>
      <div class="card-body sortable">
        <!-- 각 카드 리스트 박스 -->
		  @foreach( $vods as $vod)
		<div class="moveable" id="item_{{$vod->id}}">
			<div class="draghandle">
				<i class="fas fa-arrows-alt"></i>
			</div>
			<div>
				<a href="{{$vod->mov_url}}" target="_blank">
					<img src="{{$vod->img_url}}" />
				</a>
			</div>
			<div class="vod-title">
				{{$vod->title}}
			</div>
			<div>
				<label class="custom-switch mt-2">
                        <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input" @if( $vod->use_yn =='Y') checked @endif disabled>
                        <span class="custom-switch-indicator"></span>
                        <span class="custom-switch-description">
							@if( $vod->use_yn =='Y')
								사용중
							@else
								사용안함
							@endif
						</span>
                      </label>
			</div>
			<div>
				<div>
				<span class="btn btn-icon btn-warning" style="border-radius: 10px;    margin-top: 22px;" onclick="edit({{$vod->id}})"><i class="fas fa-edit"></i></span>	
				</div>
				
			</div>
		  </div>
		  @endforeach

      </div>
		
		<div class="card-footer" style="text-align:right;">
			<div>
				* mov url 은 직접 입력만 가능합니다.(mp4로 올려주세요)
			</div>
			<div>
				* 순서는 드래그시 즉각적으로 변경 (저장) 됩니다.
			</div>
		</div-->
    </div>

  </div>
</div>
@endsection


@section('script')
@verbatim
<script id="formmodal" type="text/template">
  <div class="modal-content">
    <div class="modal-header">

      <h5 class="modal-title">{{#if (checkempty id) }}VOD 추가{{else}}[수정]{{title}}{{/if}}</h5>

      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="modal-body">
      <form id="addform">
	  	{{#unless (checkempty id) }}
			<input type="hidden" name="id" value="{{id}}">
		{{/unless}}
		
		<div class="form-group row mb-4">
          <label class="col-form-label text-md-right col-2">title</label>
          <div class="col-10">
            <input type="text" class="form-control" name="title" value="{{title}}">
          </div>
        </div>
		
		<div class="form-group row mb-4">
          <label class="col-form-label text-md-right col-2">url</label>
          <div class="col-10">
            <input type="text" class="form-control" name="url" value="{{url}}">
          </div>
        </div>
		
		<div class="form-group row mb-4">
          <label class="col-form-label text-md-right col-2">img url</label>
          <div class="col-10">
            <input type="text" class="form-control" name="img_url" value="{{img_url}}">
          </div>
        </div>
		
		<div class="form-group row mb-4">
          <label class="col-form-label text-md-right col-2">이미지</label>
          <div class="col-7">
            <input type="file" name="bgimg" class="form-control" onchange="readURL(this, 'previewimage')">
          </div>
          <div class="col-3">
            <img src="" style="max-width:100px;max-height:100px;" id="previewimage">
          </div>
        </div>
		
		<div class="form-group row mb-4">
          <label class="col-form-label text-md-right col-2">mov_url</label>
          <div class="col-10">
            <input type="text" class="form-control" name="mov_url" value="{{mov_url}}">
          </div>
        </div>
		
		<div class="form-group row mb-4">
          <label class="custom-switch mt-2" style="    margin-left: auto;
    margin-right: 20px;">
			<input type="checkbox" name="use_yn" value="Y" class="custom-switch-input" 
			{{#if (isNotEqual use_yn 'N') }}checked{{/if}} >
			<span class="custom-switch-indicator"></span>
			<span class="custom-switch-description">사용여부</span>
		  </label>
        </div>
		
	  </form>
	  
    </div>
	<div class="modal-footer bg-whitesmoke br">
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      <button type="button" class="btn btn-primary" onclick="default_form_prc({url:'/admin/vod',form:'addform',reload:'self'})">SEND</button>
    </div>
  </div>
</script>
@endverbataim


<script src="/admin_assets/stisla/assets/js/custjs.js?ver=0001"></script>
<script src="/admin_assets/stisla/node_modules/chocolat/dist/js/jquery.chocolat.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

@verbatim
<script id="formmodal" type="text/template">
</script>
@endverbatim

<script>
	
	function createform() {
	  pop_tpl('lg','formmodal' , null, 'title')
	}
	function edit(id){
        $.ajax({
           url: '/admin/vod/info',
           method:"get",
           data:{id:id},
           dataType:'JSON',
           success:function(res)
           {
			   pop_tpl('lg','formmodal' , res.data)
          },
           error: function ( err ){
             console.log (err)
           }
         });
	}
	function sort() {
		var data = $('.sortable').sortable("toArray");
        $.ajax({
           url: '/admin/vod/sort',
           method:"POST",
           data:$( ".sortable" ).sortable( "serialize", { key: "sort[]" } ),
           dataType:'JSON',
           success:function(res)
           {
				iziToast.success({
                 message: '변경되었습니다.',
                 position: 'topRight'
               });
          },
           error: function ( err ){
             console.log (err)
           }
         });
		
	}
$(function() {
$(".sortable").sortable({
// 드래그 앤 드롭 단위 css 선택자
connectWith: ".sortable",
// 움직이는 css 선택자
handle: ".draghandle",
// 움직이지 못하는 css 선택자
cancel: ".no-move",
// 이동하려는 location에 추가 되는 클래스
placeholder: "card-placeholder",
	update: function( event, ui ) {
		sort()
	}
});
});
</script>
@endsection
