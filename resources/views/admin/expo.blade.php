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
.file-size-info{
  display:none;
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

<div class="row">
  <div class="col-12">

    <div class="card">
      <form id="add_search_from">
        <div class="card-header" style="justify-content: space-between">
          <h4>박람회 관리</h4>
          <div class="header_flex_wrap">
            <div class="prc-color-info btn btn-outline-secondary" onClick="change_status('Progress_status','progress')">
              <i class="fas fa-circle recruit_ing"></i> 진행중
            </div>
            <div class="prc-color-info btn btn-outline-secondary"  onClick="change_status('Progress_status','upcomming')">
              <i class="fas fa-circle recruit_before"></i> 예정
            </div>
            <div class="prc-color-info btn btn-outline-secondary"  onClick="change_status('Progress_status','recruiting')">
              <i class="fas fa-circle recruit_end"></i> 종료
            </div>
            <div class="section-header-breadcrumb" style="margin-left: 30px;">
              <span class="btn btn-icon btn-warning" style="border-radius: 10px;" onClick="createform()"><i class="fas fa-plus"></i></span>
            </div>
          </div>
        </div>
      </form>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-striped" id="expotable">
            <thead>
              <tr>
                <th>#</th>
                <th class="text-center">CODE</th>
                <th>타이틀</th>
                <th>이미지</th>
                <th>open</th>
                <th>close</th>
                <th>모집기간</th>
                <th>사용</th>
				<th>부스노출</th>
                <th>etc</th>
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

      <h5 class="modal-title">{{#if (checkempty id) }}박람회 추가{{else}}[수정]{{expo_name}}{{/if}}</h5>

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
          <label class="col-form-label text-md-right col-2">CODE</label>
          <div class="col-6">
            <input type="text" name="expo_code" class="form-control" value="{{expo_code}}" placeholder="박람회 고유 코드값">
          </div>

          <label class="col-form-label text-md-right col-2">숨기기</label>
          <div class="col-2">
          <select name="expo_use_yn"class="form-control form-control-sm">
              <option value="N" {{#if (isEqual expo_use_yn 'N') }}selected{{/if}}>숨기기</option>
              <option value="Y" {{#if (isEqual expo_use_yn 'Y') }}selected{{/if}}>보이기</option>
            </select>
          </div>

        </div>
        <div class="form-group row mb-4">
          <label class="col-form-label text-md-right col-2">타이틀</label>
          <div class="col-6">
            <input type="text" name="expo_name"  value="{{expo_name}}" class="form-control" placeholder="박람회 제목 타이틀">
          </div>

		  <label class="col-form-label text-md-right col-2">부스노출</label>
          <div class="col-2">
          	<select name="open"class="form-control form-control-sm">
              <option value="N" {{#if (isEqual open 'N') }}selected{{/if}}>비노출</option>
              <option value="Y" {{#if (isEqual open 'Y') }}selected{{/if}}>노출</option>
            </select>
          </div>

        </div>
        <div class="form-group row mb-4">
          <label class="col-form-label text-md-right col-2">개최기간</label>
          <div class="col-5">
            <input type="text" name="expo_open_date"  value="{{expo_open_date}}" class="form-control datepicker-pop" placeholder="시작일">
          </div>
          <div class="col-5">
            <input type="text" name="expo_close_date"  value="{{expo_close_date}}" class="form-control datepicker-pop" placeholder="종료일">
          </div>
        </div>
        <div class="form-group row mb-4">
          <label class="col-form-label text-md-right col-2">모집기간</label>
          <div class="col-5">
            <input type="text" name="expo_recruit_start_date" value="{{expo_recruit_start_date}}" class="form-control datepicker-pop" placeholder="시작일">
          </div>
          <div class="col-5">
            <input type="text" name="expo_recruit_end_date" value="{{expo_recruit_end_date}}" class="form-control datepicker-pop" placeholder="종료일">
          </div>
        </div>
        <div class="form-group row mb-4">
          <label class="col-form-label text-md-right col-2">이미지</label>
          <div class="col-5">
            <input type="file" name="select_img" class="form-control" onChange="readURL(this, 'previewimage')">
          </div>
          <div class="col-5">
            <img src = '{{#unless (checkempty expo_image_url) }}/storage/{{expo_image_url}}{{/unless}}' style="max-width:100px;max-height:100px;"  id="previewimage">
          </div>
        </div>
        <div class="form-group row mb-4">
          <label class="col-form-label text-md-right col-2">설명</label>
          <div class="col-10">
            <textarea name="expo_description">{{expo_description}}</textarea>
          </div>
        </div>

        <div class="form-group row mb-4">
          <label class="col-form-label text-md-right col-2">설명</label>
          <div class="col-10">
            <input type="file" id="input-test-id" name="attachment[]" accept="image/*" multiple/>
          </div>
        </div>

        <div class="splitline mb-15"></div>
        <div class="form-group row mb-4">
          <label class="col-form-label text-md-right col-2">안내서</label>
          <div class="col-5">
            <input type="file" name="select_attach" class="form-control">
          </div>
          <div class="col-5">
            {{#unless (checkempty expo_attachment_file_url) }}<a href="/storage/{{expo_attachment_file_url}}">{{expo_attachment_file_url}}</a>{{/unless}}
          </div>
        </div>
        <div class="form-group row mb-4">
          <label class="col-form-label text-md-right col-2">홈페이지url</label>
          <div class="col-10">
            <input type="text" name="expo_url" value="{{expo_url}}" class="form-control" placeholder="">
          </div>
        </div>
        <div class="form-group row mb-4">
          <label class="col-form-label text-md-right col-2">박람회장소</label>
          <div class="col-10">
            <input type="text" name="expo_location" value="{{expo_location}}" class="form-control" placeholder="">
          </div>
        </div>
        <div class="form-group row mb-4">
          <label class="col-form-label text-md-right col-2">박람회주소</label>
          <div class="col-10">
            <input type="text" name="expo_info_addr" value="{{expo_info_addr}}" class="form-control" placeholder="">
          </div>
        </div>
        <div class="form-group row mb-4">
          <label class="col-form-label text-md-right col-2">전화번호</label>
          <div class="col-10">
            <input type="text" name="expo_info_phone" value="{{expo_info_phone}}" class="form-control" placeholder="">
          </div>
        </div>
        <div class="form-group row mb-4">
          <label class="col-form-label text-md-right col-2"><i class="fas fa-arrows-alt"></i><i class="fas fa-download"></i> 이메일</label>
          <div class="col-10">
            <input type="text" name="expo_info_email" value="{{expo_info_email}}" class="form-control" placeholder="">
          </div>
        </div>
          <div class="form-group row mb-4">
              <label class="col-form-label text-md-right col-2">개인정보 수집 및 이용약관</label>
              <div class="col-10">
                  <textarea type="text" name="privacy_terms_text" class="form-control" placeholder="HTML" style="height:400px;">{{#if (checknotempty privacy_terms_text)}}{{encodeMyString privacy_terms_text}}{{/if}}</textarea>
              </div>
          </div>
          <div class="form-group row mb-4">
              <label class="col-form-label text-md-right col-2">참가 규정</label>
              <div class="col-10">
                  <textarea type="text" name="entry_terms_text" class="form-control" placeholder="HTML" style="height:400px;">{{#if (checknotempty entry_terms_text)}}{{encodeMyString entry_terms_text}}{{/if}}</textarea>
              </div>
          </div>
          <div class="form-group row mb-4">
              <label class="col-form-label text-md-right col-2">제3자 정보 제공동의</label>
              <div class="col-10">
                  <textarea type="text" name="provided_terms_text" class="form-control" placeholder="HTML" style="height:400px;">{{#if (checknotempty provided_terms_text)}}{{encodeMyString provided_terms_text}}{{/if}}</textarea>
              </div>
          </div>

      </form>
    </div>
    <div class="modal-footer bg-whitesmoke br">
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      <button type="button" class="btn btn-primary" onClick="{{#if (checkempty id) }}default_form_prc({url:'/admin/expo',form:'addform',reload:expotable}){{else}}default_form_prc({url:'/admin/expo',form:'addform',reload:expotable,'msg' : '수정되었습니다.'}){{/if}}">{{#if (checkempty id) }}Create{{else}}Save changes{{/if}}</button>
    </div>
  </div>
</script>
@endverbatim


<script src="/admin_assets/stisla/node_modules/chocolat/dist/js/jquery.chocolat.min.js"></script>
<script>
var expotable;

function createform() {
  pop_tpl('lg','formmodal' , null, 'title')
	attachfiles({})
}

function edit (btn ){
  var data =  expotable.row($(btn).closest('tr')).data();

  pop_tpl('lg','formmodal' , data)
  attachfiles( data );
}

$(document).ready(function() {
  expotable = $('#expotable').DataTable({
    "processing": true,
    "serverSide": true,
    "lengthMenu": [10, 5],
    "order": [[ 0, "desc" ]],
    "ajax": {
      'url' : "/admin/expolist",
      'data' : function (data){
        data.progressStatus = $("#Progress_status").val();
        data.use_status = $("#use_status").val();
      }
    },
    "columnDefs": [
      {"targets": [ 0 ],"visible": false,"searchable": false},
      {"targets": [ 3 ],"searchable": false,"sortable":false},
      {"targets": [ 6 ],"searchable": false,"sortable":false},
      {"targets": [ 7 ],"searchable": false,"sortable":false},
      {"targets": [ 8 ],"searchable": false,"sortable":false},
	  {"targets": [ 9 ],"searchable": false,"sortable":false},
    ],
    "columns" : [
            {"data" : "id"},
            {"data" : "expo_code"},
            {"data" : "expo_name"},
            {"data" : "expo_image_url", 'render' : function( data, type, row, meta) {
              return `
              <div class="gallery">
                <div class="gallery-item"
                    data-image="/storage/${data}"
                    data-title="Image 1"
                    href="/storage/${data}"
                    title="Image 1"
                    style="background-image: url(/storage/${data});">
                </div>
              </div>
              `;
              }
            },
            {"data" : "expo_open_date",'render' : function( data, type, row, meta) {
              let today = meta.settings.json.today
              let classstr = (today< data) ?"before":(today > row.expo_close_date ) ? "end" : "ing";
              return `<span class="recruit_${classstr}">${data}</span>`
            }},
            {"data" : "expo_close_date",'render' : function( data, type, row, meta) {
              let today = meta.settings.json.today
              let classstr = (today< row.expo_open_date) ?"before":(today > row.expo_close_date ) ? "end" : "ing";
              return `<span class="recruit_${classstr}">${data}</span>`
            }},
            {"data" : "expo_recruit_start_date", 'render' : function( data, type, row, meta) {
              let today = meta.settings.json.today
              let classstr = (today< data) ?"before":(today > row.expo_recruit_end_date ) ? "end" : "ing";
              return `<span class="recruit_${classstr}">${data}~${row.expo_recruit_end_date}</span>`
            }},
            {"data" : "expo_use_yn"},
		    {"data" : "open"},
            {"data" : "id", 'render' : function (data, type, row, meta){
              return `
              <span class="btn btn-icon btn-info" onClick='edit(this)'>
                <i class="fas fa-edit"></i>
              </span>
              <span class="btn btn-icon btn-danger"  onClick="default_form_delete({ 'url' :'/admin/expo/del', 'id' : '${data}', 'reload' : expotable, title : '${row.expo_name}'})">
                <i class="fas fa-trash-alt"></i>
              </span>
              `

            }},
    ],
    "initComplete": function(settings, json) {
        var textBox = $('#expotable_filter label input');
        textBox.unbind();
        textBox.bind('keyup input', function(e) {
            if(e.keyCode == 8 && !textBox.val() || e.keyCode == 46 && !textBox.val()) {
                // do nothing ¯\_(ツ)_/¯
            } else if(e.keyCode == 13 || !textBox.val()) {
                expotable.search(this.value).draw();
            }
        });
        $("#expotable_wrapper > div:nth-child(1) > div:nth-child(1)").removeClass('col-md-6').addClass('col-md-2');
        $("#expotable_wrapper > div:nth-child(1) > div:nth-child(2)").removeClass('col-md-6').addClass('col-md-10');
        let addsearch=`
        <label style="margin-right:10px;">사용:
          <select name="use_status"
              class="form-control form-control-sm form-control-sm-important inline-select"
              onChange="expotable.draw()" id="use_status">
            <option value="">사용여부</option>
            <option value="Y">Y</option>
            <option value="N">N</option>
          </select>
        </label>
        <label style="margin-right:10px;">진행:
          <select name="Progress_status"
              class="form-control form-control-sm form-control-sm-important inline-select"
              onChange="expotable.draw()" id="Progress_status">
            <option value="all">전체</option>
            <option value="progress">진행중</option>
            <option value="upcomming">예정</option>
            <option value="ended">종료</option>
            <option value="recruiting">모집중</option>
          </select>
        </label>
        `
        $("#expotable_filter").prepend(addsearch)
    },
    "drawCallback": function( settings ) {
      $(".gallery .gallery-item").each(function() {
          var me = $(this);

          me.attr('href', me.data('image'));
          me.attr('title', me.data('title'));
          if(me.parent().hasClass('gallery-fw')) {
            me.css({
              height: me.parent().data('item-height'),
            });
            me.find('div').css({
              lineHeight: me.parent().data('item-height') + 'px'
            });
          }
          me.css({
            backgroundImage: 'url("'+ me.data('image') +'")'
          });
        });
        if(jQuery().Chocolat) {
          chocolateapi = $(".gallery").Chocolat({
            className: 'gallery',
            imageSelector: '.gallery-item',
          }).data('chocolat');
        }
    },
    "preDrawCallback": function( settings ) {
        if( typeof chocolateapi != 'undefined' ){
          chocolateapi.api().destroy();
        };
    },
  })
});
</script>
@endsection
