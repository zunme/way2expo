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

<div class="row">
  <div class="col-12">

    <div class="card">
      <form id="add_search_from">
        <div class="card-header" style="justify-content: space-between">
          <h4>사용자 관리</h4>
          <div class="header_flex_wrap">
            <div class="section-header-breadcrumb" style="margin-left: 30px;">
              <span class="btn btn-icon btn-warning" style="border-radius: 10px;" onClick="createform()"><i class="fas fa-plus"></i></span>
            </div>
          </div>
        </div>
      </form>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-striped" id="usertable">
            <thead>
              <tr>
                <th>#</th>
                <th class="text-center">Email</th>
                <th class="text-center">이름</th>
                <th class="text-center">전화번호</th>
                <th class="text-center">상태</th>
                <th class="text-center">명함(앞)</th>
                <th class="text-center">명함(뒤)</th>
                <th class="text-center">명함</th>
                <th class="text-center">수신(S)</th>
                <th class="text-center">수신(E)</th>
                <th class="text-center">가입시간</th>
                <th class="text-center">ETC</th>
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

@verbatim
<script id="formmodal" type="text/template">
  <div class="modal-content">
    <div class="modal-header">

      <h5 class="modal-title">{{#if (checkempty id) }}사용자 추가{{else}}[수정]{{email}}({{name}}){{/if}}</h5>

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
          <label class="col-form-label text-md-right col-1">Email</label>
          <div class="col-11">
            <input type="text" class="form-control" {{#if (checkempty email) }} name="email" {{/if}} value="{{email}}" {{#unless (checkempty email) }}disabled{{/unless}}>
          </div>
        </div>
        {{#if (checkempty id) }}
        <div class="form-group row mb-4">
          <label class="col-form-label text-md-right col-1">비밀번호</label>
          <div class="col-5">
            <input type="password" class="form-control" name="password">
          </div>
          <label class="col-form-label text-md-right col-1">확인</label>
          <div class="col-5">
            <input type="password" class="form-control" name="password_confirmation">
          </div>
        </div>
        {{/if}}

        <div class="form-group row mb-4">
          <label class="col-form-label text-md-right col-1">
            이름
          </label>
          <div class="col-3">
            <input type="text" class="form-control"  name="name" value="{{name}}" >
          </div>
          <label class="col-form-label text-md-right col-1">
            전화
          </label>
          <div class="col-3">
            <input type="text" class="form-control" name="tel" value="{{tel}}" >
          </div>
          <label class="col-form-label text-md-right col-1">
            상태
          </label>
          <div class="col-3">
            <select name="user_status"class="form-control form-control">
                <option value="Y" {{#if (isEqual user_status 'Y') }}selected{{/if}}>정상회원</option>
              </select>
          </div>
        </div>
        <div class="form-group row mb-4">
          <label class="col-form-label text-md-right col-2">
            SMS 수신 동의
          </label>
          <div class="col-3">
            <select name="agree_sms"class="form-control form-control">
                <option value="Y" {{#if (isEqual agree_sms 'Y') }}selected{{/if}}>동의</option>
                <option value="N" {{#if (isEqual agree_sms 'N') }}selected{{/if}}>비동의</option>
              </select>
          </div>

          <label class="col-form-label text-md-right col-2">
            EMAIL 수신 동의
          </label>
          <div class="col-3">
            <select name="agree_email"class="form-control form-control">
                <option value="Y" {{#if (isEqual agree_email 'Y') }}selected{{/if}}>동의</option>
                <option value="N" {{#if (isEqual agree_email 'N') }}selected{{/if}}>비동의</option>
              </select>
          </div>
        </div>
        <div class="form-group row mb-4">
          <label class="col-form-label text-md-right col-2">명함 앞면</label>
          <div class="col-5">
            <input type="file" name="card_front" class="form-control" onChange="readURL(this, 'previewimage')">
          </div>
          <div class="col-5">
            <img src = '{{#unless (checkempty business_card_front) }}/storage/{{business_card_front}}{{/unless}}' style="max-width:100px;max-height:100px;"  id="previewimage">
          </div>
        </div>
        <div class="form-group row mb-4">
          <label class="col-form-label text-md-right col-2">명함 뒷면</label>
          <div class="col-5">
            <input type="file" name="card_back" class="form-control" onChange="readURL(this, 'previewimage2')">
          </div>
          <div class="col-5">
            <img src = '{{#unless (checkempty business_card_back) }}/storage/{{business_card_back}}{{/unless}}' style="max-width:100px;max-height:100px;"  id="previewimage2">
          </div>
        </div>
      </form>
    </div>
    <div class="modal-footer bg-whitesmoke br">
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      <button type="button" class="btn btn-primary" onClick="{{#if (checkempty id) }}default_form_prc({url:'/admin/user',form:'addform',reload:usertable}){{else}}default_form_prc({url:'/admin/user',form:'addform',reload:usertable,'msg' : '수정되었습니다.'}){{/if}}">{{#if (checkempty id) }}Create{{else}}Save changes{{/if}}</button>
    </div>
  </div>
</script>
@endverbatim

<script>
var usertable;
function createform() {
  pop_tpl('lg','formmodal' , null, 'title')
}
function edit (btn ){
  var data =  usertable.row($(btn).closest('tr')).data();

  pop_tpl('lg','formmodal' , data)
}
$(document).ready(function() {
  usertable = $('#usertable').DataTable({
    "processing": true,
    "serverSide": true,
    "lengthMenu": [10, 5],
    "order": [[ 0, "desc" ]],
    "ajax": {
      'url' : "/admin/userlist",
      'data' : function (data){
      }
    },
    "columnDefs": [
      {"targets": [ 0 ],"visible": false,"searchable": false},

      {"targets": [ 4 ],"searchable": false,"sortable":false},
      {"targets": [ 5 ],"searchable": false,"sortable":false},
      {"targets": [ 6 ],"searchable": false,"sortable":false},//명함뒤
      {"targets": [ 7 ],"searchable": false,"sortable":false},
      {"targets": [ 8 ],"searchable": false,"sortable":false},
      {"targets": [ 9 ],"searchable": false,"sortable":false},
      {"targets": [10],"searchable": false,"sortable":false},
      {"targets": [ 11 ],"searchable": false,"sortable":false},
    ],
    "columns" : [
      {"data" : "id"},
      {"data" : "email"
        ,"render" : function( data, type, row, meta) {
          return `<a target="_blank" href="/admin/userlogin?email=${data}"><i class="fas fa-sign-in-alt"></i></a> ${data}`
        }
      },
      {"data" : "name"},
      {"data" : "tel"},
      {"data" : "user_status"},
      {"data" : "business_card_front", 'render' : function( data, type, row, meta) {
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
        }},
      {"data" : "business_card_back", 'render' : function( data, type, row, meta) {
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
        }},
      {"data" : "card", 'render' : function( data, type, row, meta) {
        if( data == null ) return '';
        else return '<i class="far fa-address-card"></i>';
      }},
      {"data" : "agree_sms"},
      {"data" : "agree_email"},
      {"data" : "created_at"},
      {"data" : "id", 'render' : function (data, type, row, meta){
        return `
        <span class="btn btn-icon btn-info" onClick='edit(this)'>
          <i class="fas fa-edit" style='    font-size: 24px;'></i>
        </span>
        `

      }},
    ],
    "initComplete": function(settings, json) {

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
          console.log ( "choco")
          chocolateapi = $(".gallery").Chocolat({
            className: 'gallery',
            imageSelector: '.gallery-item',
          }).data('chocolat');
        }else { console.log ( "pass choco")}
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
