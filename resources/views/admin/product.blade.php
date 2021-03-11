@extends('admin.defaultlayout')

@section('css')
<link rel="stylesheet" href="/admin_assets/stisla/node_modules/chocolat/dist/css/chocolat.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.1.2/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />

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
.glyphicon {
  font-family: "Font Awesome 5 Free";
  font-style: normal;
}
.glyphicon.glyphicon-trash:before {
    content: "\f2ed";
}
.glyphicon.glyphicon-zoom-in:before {
    content: "\f002";
}
.glyphicon.glyphicon-download:before {
    content: "\f019";
}
.drag-handle-init.file-drag-handle.text-info{
  font-weight: 600;
  line-height: 12px;
  padding: .3rem .8rem;
  padding: .10rem .4rem;
  font-size: 12px;
}
.glyphicon {
      color: #6c757d;
}
.glyphicon.glyphicon-move:before {
    content: "\f0b2";
}
.file-caption-main,.fileinput-remove {display:none;}
	
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
	.max-expo-title-with{
		max-width:150px;
	}
	#prdtable_filter{display:none}
</style>
@endsection

@section('main')

<div class="row">
  <div class="col-12">

    <div class="card">
      <form id="add_search_from">
        <div class="card-header" style="justify-content: space-between">
          <h4>상품 관리</h4>
          <div class="header_flex_wrap">
            <div class="section-header-breadcrumb" style="margin-left: 30px;">
				
              <!--span class="btn btn-icon btn-warning" style="border-radius: 10px;" onClick="createform()"><i class="fas fa-plus"></i></span-->
				
            </div>
          </div>
        </div>
      </form>
      <div class="card-body">
		<div style="    display: flex;
    justify-content: space-between;">
			<div>
				<button type="button" class="btn btn-primary" onClick="changeBlock('Y')">선택 공개</button>
				<button type="button" class="btn btn-primary" onClick="changeBlock('N')">선택 비공개</button>	
			</div>
			
			<form id="add_search_from">
				<select name="expo" onchange="dt.draw()">
					<option vlaue="">선택</option>
					@foreach ($expos as $expo)
					<option value="{{$expo->id}}">
						{{$expo->expo_name}}
					</option>
					@endforeach
				</select>
			</form>
		</div>
        <div class="table-responsive">
          <table class="table table-striped" id="prdtable">
            <thead>
              <tr>
				  <td></td>
				<td>엑스포명</td>
				<td>부스명</td>
				  <td>이미지</td>
				  <td>상품명</td>
				  <td>가격공개</td>
				  <td>세일전</td>
				  <td>세일후</td>
				  <td>퍼센트</td>
				  <td>관리자공개</td>
				  <td>상품공개</td>
				  <td>생성일자</td>
				  <td>관리</td>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>

  </div>
</div>
@endsection


@section('script')
<script src="/admin_assets/stisla/assets/js/custjs.js"></script>
<script src="/admin_assets/stisla/node_modules/chocolat/dist/js/jquery.chocolat.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.1.2/js/plugins/piexif.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.1.2/js/plugins/sortable.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>

<!--script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" type="text/javascript"></script-->

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.1.2/js/fileinput.min.js"></script>
<!-- optionally if you need a theme like font awesome theme you can include it as mentioned below -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.1.2/themes/fa/theme.js"></script>

@verbatim
<script id="formmodal" type="text/template">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title">{{#if (checkempty id) }}상품 추가{{else}}[수정]{{email}} {{prd_title}} {{/if}}</h5>

      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      
    </div>
	<div class="modal-body">
		  <form id="addform">
			{{#unless (checkempty id) }}
			<input type="hidden" name="id" value="{{id}}">
			{{/unless}}
			
			<div class="form-group row mb-1">
			  <label class="col-form-label text-md-right col-2">상품명</label>
			  <div class="col-10">
				<input type="text" class="form-control" name="prd_title" 
				{{#unless (checkempty id) }}
				value="{{prd_title}}"
				{{/unless}}
				>
			  </div>
			</div>
			
			<div class="form-group row mb-1">
			  <label class="col-form-label text-md-right col-2">상품URL</label>
			  <div class="col-10">
				<input type="text" class="form-control" name="prd_url" 
				{{#unless (checkempty id) }}
				value="{{prd_url}}"
				{{/unless}}
				>
			  </div>
			</div>
			
			
			<div class="form-group row mb-1">
			  <label class="col-form-label text-md-right col-2">사용</label>
			  <div class="col-3">
				
					<select name="prd_use_yn" class="form-control">
						<option value="">사용여부</option>
						<option value="Y" {{#if (isEqual prd_use_yn 'Y') }}selected{{/if}}>사용</option>
						<option value="N" {{#if (isEqual prd_use_yn 'N') }}selected{{/if}}>사용안함</option>
					  </select>
				
			  </div>
			  
			  <label class="col-form-label text-md-right col-2">노출여부</label>
			  <div class="col-3">
				
					<select name="prd_display_yn" class="form-control">
						<option value="">노출여부</option>
						<option value="Y" {{#if (isEqual prd_display_yn 'Y') }}selected{{/if}}>노출</option>
						<option value="N" {{#if (isEqual prd_display_yn 'N') }}selected{{/if}}>숨김</option>
					  </select>
				
			  </div>
			  
			</div>
			
			<div class="form-group row mb-1">
				<label class="col-form-label text-md-right col-2">가격노출</label>
				
				  <div class="col-3">
					<select name="prd_viewprice" class="form-control">
						<option value="">가격노출</option>
						<option value="Y" {{#if (isEqual prd_viewprice 'Y') }}selected{{/if}}>노출</option>
						<option value="N" {{#if (isEqual prd_viewprice 'N') }}selected{{/if}}>가격협의</option>
					  </select>
			  	  </div>
			  
			</div>
			<div class="form-group row mb-1">
			  <label class="col-form-label text-md-right col-2">정상가</label>
			  <div class="col-2">
				<input type="text" class="form-control" name="prd_org_price" id="prd_org_price" onKeyup="disRate()"
				{{#unless (checkempty id) }}
				value="{{prd_org_price}}"
				{{/unless}}
				>
			  </div>
			  <label class="col-form-label text-md-right col-2">세일가</label>
			  <div class="col-2">
				<input type="text" class="form-control" name="prd_price" id="prd_price" onKeyup="disRate()"
				{{#unless (checkempty id) }}
				value="{{prd_price}}"
				{{/unless}}
				>
			  </div>
			  <label class="col-form-label text-md-right col-2">할인</label>
			  <div class="col-2">
				<input type="text" class="form-control" id="prd_price_percent" name="prd_price_percent" 
				{{#unless (checkempty id) }}
				value="{{prd_price_percent}}"
				{{/unless}}
				 readonly >
			  </div>
			</div>
			
			
			<div class="form-group">
				<label class="col-form-label text-md-left col-12">
				상품 이미지
				</label>
				{{#unless (checkempty id) }}
				<div class="row">
					<div class="col-3">
						{{#if (checkempty prd_img1) }}
						<img src="https://via.placeholder.com/90X70?text=None" style="width:100%" >
						{{else}}
						<img src="/storage/{{prd_img1}}" style="width:100%">
						{{/if}}
					</div>
					<div class="col-3">
						{{#if (checkempty prd_img2) }}
						<img src="https://via.placeholder.com/90X70?text=None" style="width:100%" >
						{{else}}
						<img src="/storage/{{prd_img2}}" style="width:100%">
						{{/if}}
					</div>
					<div class="col-3">
						{{#if (checkempty prd_img3) }}
						<img src="https://via.placeholder.com/90X70?text=None" style="width:100%" >
						{{else}}
						<img src="/storage/{{prd_img3}}" style="width:100%">
						{{/if}}
					</div>
					<div class="col-3">
						{{#if (checkempty prd_img4) }}
						<img src="https://via.placeholder.com/90X70?text=None" style="width:100%" >
						{{else}}
						<img src="/storage/{{prd_img4}}" style="width:100%">
						{{/if}}
					</div>
				</div>
				{{/unless}}
			</div>
			<div class="form-group row">
				<label class="col-form-label text-md-right col-2">설명</label>
			  <div class="col-10">
				<input type="file" id="input-test-id" name="attachment[]" accept="image/*" multiple/>
			  </div>
			</div>
			<div class="" id="sortform">
			
			</div>
		  </form>
	</div>
	
	
	<div class="modal-footer bg-whitesmoke br">
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      <button type="button" class="btn btn-primary" onClick="{{#if (checkempty id) }}default_form_prc({url:'/admin/product/save',form:'addform',reload:dt}){{else}}default_form_prc({url:'/admin/product/update',form:'addform',reload:dt,'msg' : '수정되었습니다.'}){{/if}}">{{#if (checkempty id) }}Create{{else}}Save changes{{/if}}</button>
    </div>
  </div>
</script>
@endverbatim

<script>
var dt;
var sortdata = null;
	
 moment.locale("ko");
	
function createform() {
  pop_tpl('lg','formmodal' , null, 'title')
}
function edit (btn ){
   var data =  dt.row($(btn).closest('tr')).data();
  $.ajax({
     url:"/admin/product/info",
     method:"get",
     data:{id :data.id },
     dataType:'JSON',
     success:function(res)
     {
       pop_tpl('lg','formmodal' , res.product )
	   attachimgss( res)
    },
     error: function ( err ){
       ajaxErrorST(err)
     }
   });
}
function disRate() {
    var dis_price = $("#prd_price").val().trim(); //할인가
    var price = $("#prd_org_price").val().trim(); //정상가
    if (dis_price == "" || price == "" || price == "0" ) {
        result = 0;
    }else if(dis_price == "0"){
		result = 100
	} else {
        result = Math.round( 100 - (dis_price / price * 100) );
		if( result==100 && dis_price > 0 ) result = 99;
    }
    $("#prd_price_percent").val(result);
}
function attachimgss(data){
  let previewimages = []
  let urls =[];
  if( typeof data.imgs != 'undefined'){
    for ( idx in data.imgs ){
      let img = {
          caption : 'sort : ' + data.imgs[idx].sort,
          downloadUrl : '/storage/' + data.imgs[idx].url,
          size: '',
          width: "120px",
          key: data.imgs[idx].id
      };
      urls.push( '/storage/' + data.imgs[idx].url );
      previewimages.push( img )
    }
  }
    $("#input-test-id").fileinput({
        initialPreview: urls,
        initialPreviewAsData: true,
        initialPreviewConfig: previewimages,
		initialPreviewShowDelete : false,
		showUpload: false,
		showBrowse:false,
		fileActionSettings: {
			dragIcon:'<span></span>',
			removeIcon: `<span></span>`,
		},
		
        overwriteInitial: false,
        maxFileSize: 1024000,
        initialCaption: "Detail",
        
    });
    $('#input-test-id').on('filezoomhidden', function(event, params) {
        $("body").addClass("modal-open");
    });
    $('#input-test-id').on('filedeleted', function(event, id, index) {
        expotable.ajax.reload(null, false);
    });
    $('#input-test-id').on('filesorted', function(event, params) {
        let data = [];
		console.log ( params.stack )
		$("#sortform").empty();
        for( idx in params.stack ){
			$("#sortform").append(`<input type="hidden" name="sort[]" value="${params.stack[idx].key}">`)
          data.push( params.stack[idx].key )
        }
    });
}
	
$(document).ready(function() {
  dt = $('#prdtable').DataTable({
    "processing": true,
    "serverSide": true,
    "lengthMenu": [10, 50 ,100],
    "order": [[ 0, "desc" ]],
    "ajax": {
      'url' : "/admin/product/list",
      'data' : function (data){
		  data.expo_id = $("select[name=expo]").val()
      }
    },
    "columnDefs": [
		{"targets": [ 0 ],"visible": true,"searchable": false},
		{"targets": [ 1 ],"searchable": false,"sortable":false},
		{"targets": [ 2 ],"searchable": false,"sortable":false},
		{"targets": [ 3 ],"searchable": false,"sortable":false},
		{"targets": [ 4 ],"searchable": false,"sortable":false},
		{"targets": [ 5 ],"searchable": false,"sortable":false},
		{"targets": [ 6 ],"searchable": false,"sortable":false},
		{"targets": [ 7 ],"searchable": false,"sortable":false},

		{"targets": [ 8 ],"searchable": false,"sortable":false},
		{"targets": [ 9 ],"searchable": false,"sortable":false},
		{"targets": [10],"searchable": false,"sortable":false},
		{"targets": [ 11 ],"searchable": false,"sortable":false},
		{"targets": [ 11 ],"searchable": false,"sortable":false},
		{"targets": [ 12 ],"searchable": false,"sortable":false},
    ],
    "columns" : [
        {"data" : "id", 'render' : 
		 	function( data) {
				return `<input type="checkbox" name="chk[]" value="${data}">`
			}	
		},
		{"data" : "expo_name", 'render' : 
		 	function( data, type, row, meta) {
				return `<div class="max-expo-title-with">${data}</div>`
			}	
		},
		{"data" : "booth_title", 'render' : 
		 	function( data, type, row, meta) {
				return `<div class="max-booth-title-with">${data}</div>`
			}	
		},
		{"data" : "prd_img1", 'render' : 
		 	function( data, type, row, meta) {
				return `
					<div class="gallery">
					  <div class="gallery-item"
						  data-image="/storage/thumb/${data}"
						  data-title="Image 1"
						  href="/storage/${data}"
						  title="Image 1"
						  style="background-image: url(/storage/${data});">
					  </div>
					</div>
				`;
			}
		},
		{"data" : "prd_title"},
		{"data" : "prd_viewprice"},
		{"data" : "prd_org_price", 'render' : 
		 	function( data, type, row, meta) {
				if (data ==null ) return ''
		 		return new Intl.NumberFormat('en-IN').format(data)
			}
		},
		{"data" : "prd_price", 'render' : 
		 	function( data, type, row, meta) {
				if (data ==null ) return ''
		 		return new Intl.NumberFormat('en-IN').format(data)
			}
		},
		{"data" : "prd_price_percent", 'render' : 
		 	function( data, type, row, meta) {
				if (data ==null ) return ''
		 		return `${data}%`
			}},
		{"data" : "prd_use_yn"},
		{"data" : "prd_display_yn"},
		{"data" : "created_at",
             "render": function( data, type, row, meta) {
                 var date = moment( data );
                 return date.local().format('LLL')
             }
		},
		{"data" : "id",
             "render": function( data, type, row, meta) {
                 return `<button onClick="edit(this)">수정</button>`
             }
		 
		},
	]
  }); //datatable end
	
	
});
function changeBlock(changetype){
		var url = '/admin/product/changeblock';
		let len = $("input[type=checkbox]:checked").length;
		if ( len < 1 ){
			alert ( "선택된 상품이 없습니다.")
			return ;
		}
		if (confirm( '선택된 상품들에 대해 관리자 공개를 바꾸시겠습니까?')){
	    $.ajax({
           url:url,
           method:"POST",
           data: dt.$('input').serialize() + '&change_type=' +changetype ,
           dataType:'JSON',
           cache: false,
           success:function(res)
           {
			dt.ajax.reload(null, false);
           },
           error: function ( err ){
             ajaxError(err);
           }
         });
		}
}
</script>
@endsection
