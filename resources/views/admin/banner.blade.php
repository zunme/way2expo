@extends('admin.defaultlayout')
@section('css')
<style>
.card-header-innerwrap{
  flex-grow: 1;
}
.card .card-header .form-control.normalform {
    height: 31px;
    font-size: 13px;
    border-radius: initial;
    font-size: 14px;
    padding: 10px 15px;
    height: 42px;
}
.dataTables_wrapper > .row:first-child{
  display:none;
}
.banner_image{
  max-width: 150px;
  max-height: 100px;
}
</style>
<link rel="stylesheet" href="/admin_assets/stisla/node_modules/chocolat/dist/css/chocolat.css">

@endsection
@section('main')
<div class="section-header">
  <h4>Banner Management</h4>
  <div class="section-header-breadcrumb">
    <span class="btn btn-icon btn-warning" onClick="createform()"><i class="fas fa-plus"></i></span>
  </div>
</div>

<div class="row">
  <div class="col-12">

    <div class="card">
      <form id="add_search_from">
        <div class="card-header">

            <div class="col-sm-5 ml-auto">
              <select class="form-control select2" name="banner_category_id" id="banner_category_id">
                <option value="">카테고리</option>
                @foreach ( $bannerCategory as $cate )
                <option value="{{$cate->id}}">{{ $cate->category_title }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-sm-4">
              <div class="input-group">
                  <div class="input-group-prepend">
                    <div class="input-group-text">
                      <i class="fas fa-search"></i>
                    </div>
                  </div>
                  <input type="text" name="alt" id="banner_alt" class="form-control normalform">
                </div>
            </div>

        </div>
      </form>
      <div class="card-body">
        <table id="bannertable" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>title</th>
                    <th>link url</th>
                    <th>image</th>
                    <th>TYPE</th>
                    <th></th>
                </tr>
            </thead>

        </table>
      </div>
    </div>

  </div>
</div>

@endsection

@section('script')
<script src="/admin_assets/stisla/assets/js/custjs.js"></script>
@verbatim
<script id="modaltest" type="text/template">
  <div class="modal-content">
    <div class="modal-header">

      <h5 class="modal-title">{{#if (checkempty id) }}배너추가{{else}}{{alt}} 수정{{/if}}</h5>

      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="modal-body">
      <form id="addform">
        {{#unless (checkempty id) }}
        <input type="hidden" name="id" value="{{id}}">
        {{/unless}}
        <select class="form-control mb-10" name="banner_category_id" >
          <option value="">카테고리</option>
          {{#each banner_categories}}
          <option value="{{id}}" {{#if (isEqual id ../banner_category_id) }}selected{{/if}}>{{category_title}}{{#if (isEqual resize 'Y')}} ( resize -&gt; w: {{width}}, h:{{height}} ){{/if}}</option>
          {{/each}}

        </select>
        <div class="row">
          <div class="col-4 ml-auto">
            <label>Target</label>
            <select class="form-control" name="banner_class" >
              <option value="none" {{#if (isEqual 'none' banner_class ) }}selected{{/if}}>없음</option>
              <option value="_blank" {{#if (isEqual '_blank' banner_class ) }}selected{{/if}}>_blank</option>
              <option value="external" {{#if (isEqual 'external' banner_class ) }}selected{{/if}}>모바일외부</option>
            </select>
          </div>
          <div class="col-4">
            <label>사용여부</label>
            <select class="form-control" name="active" >
              <option value="1" {{#if (isEqual 1 active ) }}selected{{/if}}>사용</option>
              <option value="0" {{#if (isEqual 0 active ) }}selected{{/if}}>사용안함</option>
            </select>
          </div>
        </div>
        <div class="form-group mb-10">
          <label>Title</label>
          <input type="text" name="alt" class="form-control" value="{{alt}}">
        </div>
        <div class="form-group mb-10">
          <label>Link Url</label>
          <input type="text" name="url" class="form-control" value="{{url}}">
        </div>
        <div class="form-group mb-10">
          <label>Title</label>
          <input type="file" name="image" class="form-control" onChange="readURL(this, 'previewimage')">
        </div>
        <div style="text-align:center;">
          <img src = '{{#unless (checkempty id) }}/storage/{{image_path}}{{/unless}}' style="max-width:300px;max-height:300px;"  id="previewimage">
        </div>

      </form>
    </div>
    <div class="modal-footer bg-whitesmoke br">
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      <button type="button" class="btn btn-primary" onClick="{{#if (checkempty id) }}createbanner(){{else}}update(){{/if}}">{{#if (checkempty id) }}Create{{else}}Save changes{{/if}}</button>
    </div>
  </div>
</script>
  @endverbatim

<script src="/admin_assets/stisla/node_modules/chocolat/dist/js/jquery.chocolat.min.js"></script>
<script>
var bannertable;
var chocolateapi;
var banner_categories = @json( $bannerCategory);

$(document).ready(function() {
  bannertable = $('#bannertable').DataTable({
    "processing": true,
    "serverSide": true,
    "lengthMenu": [10],
    "order": [[ 4, "desc" ]],
    "ajax": {
      'url' : "/admin/bannerlist",
      'data' : function (data){
        var cate = $("#banner_category_id").val();
        var alt = $("#banner_alt").val();
        data.searchByCategory = cate;
        data.searchByAlt = alt;
      }
    },
    "columnDefs": [
      {"targets": [ 1 ],"searchable": false,"sortable":false},
      {"targets": [ 2 ],"searchable": false,"sortable":false},
      {"targets": [ 4 ],"searchable": false,"sortable":false},
    ],
    "columns" : [
            {"data" : "alt"},
            {"data" : "url"},
            {"data" : "image_path",
              'render' : function( data, type, row, meta) {
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
                return `<a href="${row.url}" target="_blank"><img class="banner_image" src="/storage/${data}"></a>`
              } },
            {"data" : "category_title"},
            {"data" : "id", 'render' : function (data){
              return `
              <span class="btn btn-icon btn-info" onClick='edit(this)'>
                <i class="fas fa-edit"></i>
              </span>
              <span class="btn btn-icon btn-info"  onClick='deletebanner(this)'>
                <i class="fas fa-trash-alt"></i>
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
  });
  $('#banner_category_id').on("change", function() {
    bannertable.draw();
  });
});
function createform() {
  var data = {'banner_categories' : banner_categories}
  pop_tpl('default','modaltest' , data, 'title')
}
function createbanner() {
  $.ajax({
     url:"/admin/banner ",
     method:"POST",
     data:new FormData( document.getElementById('addform') ),
     dataType:'JSON',
     contentType: false,
     cache: false,
     processData: false,
     success:function(res)
     {
       if( res.result =='error'){
         iziToast.success({
           message: res.msg,
           position: 'topRight'
         });
         return;
       } else {
         iziToast.success({
           message: '생성되었습니다.',
           position: 'topRight'
         });
       }
      bannertable.ajax.reload(null, false);
      $('#modal-default').modal('hide');
    },
     error: function ( err ){
       ajaxError(err)
     }
   });
}
function edit (btn ){
  var data =  bannertable.row($(btn).closest('tr')).data();
  data['banner_categories'] = banner_categories;

  pop_tpl('default','modaltest' , data, data.alt)
}
function update() {
  $.ajax({
     url:"/admin/banner/update ",
     method:"POST",
     data:new FormData( document.getElementById('addform') ),
     dataType:'JSON',
     contentType: false,
     cache: false,
     processData: false,
     success:function(res)
     {
       if( res.result =='error'){
         iziToast.success({
           message: res.msg,
           position: 'topRight'
         });
         return;
       } else {
         iziToast.success({
           message: '수정되었습니다.',
           position: 'topRight'
         });
       }
      bannertable.ajax.reload(null, false);
      $('#modal-default').modal('hide');
    },
     error: function ( err ){
       ajaxError(err)
     }
   });
}
function deletebanner(btn){
  var data =  bannertable.row($(btn).closest('tr')).data();

  swal({
      title: '삭제하시겠습니까?',
      text: 'Once deleted, you will not be able to recover this imaginary file!',
      icon: 'warning',
      buttons: true,
      dangerMode: true,
    })
    .then((willDelete) => {
      if (willDelete) {
        $.ajax({
           url:"/admin/banner/del",
           method:"POST",
           data:{id: data.id},
           dataType:'JSON',
           success:function(res)
           {
             if( res.result =='error'){
               iziToast.success({
                 message: res.msg,
                 position: 'topRight'
               });
               return;
             } else {
               iziToast.success({
                 message: '삭제되었습니다.',
                 position: 'topRight'
               });
             }
            bannertable.ajax.reload(null, false);
          },
           error: function ( err ){
             ajaxError(err)
           }
         });
      } else {
      swal('Your imaginary file is safe!');
      }
    });
}
</script>
@endsection
