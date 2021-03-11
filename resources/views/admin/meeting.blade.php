@extends('admin.defaultlayout')

@section('css')
<link rel="stylesheet" href="/admin_assets/stisla/node_modules/chocolat/dist/css/chocolat.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.1.2/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />
<style>
textarea{
    max-width: 500px;
    width: 100%;
}
i.material-icons{
    color: #7c8efc;
    background-color: #e1ebff;
    font-size: 50px;
    border-radius: 50%;
    z-index: 1;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.03);
    float: left;
    position: relative;
}
</style>
@endsection

@section('main')

<div class="row">
  <div class="col-12">

    <div class="card">
      <form id="add_search_from">
        <div class="card-header" style="justify-content: space-between">
          <h4>1:1 신청 리스트</h4>
        </div>
      </form>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-striped" id="datatable">
            <thead>
              <tr>
                <th>#</th>
                <th class="text-center">date</th>
                <th class="text-center">time</th>
                <th class="text-center">신청인</th>
                <th class="text-center">회사</th>
                <th class="text-center">상태</th>
                <th class="text-center">내용</th>
                <th class="text-center">expo</th>
                <th class="text-center">booth</th>
                <th class="text-center">신청시간</th>
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

@verbatim
<script id="template_row" type="text/template">
<div class="profile-widget" style="margin-top:10px;margin-bottom:10px;">
    <div class="profile-widget-header">
        <i class="material-icons">person</i>
        <div class="profile-widget-items">
            <div class="profile-widget-item">
                <div class="profile-widget-item-label">이름</div>
                <div class="profile-widget-item-value">{{applicant.name}}</div>
            </div>
            <div class="profile-widget-item">
                <div class="profile-widget-item-label">Email</div>
                <div class="profile-widget-item-value">{{applicant.email}}</div>
            </div>
            <div class="profile-widget-item">
                <div class="profile-widget-item-label">전화번호</div>
                <div class="profile-widget-item-value">{{applicant.tel}}</div>
            </div>
        </div>
    </div>
        <div class="profile-widget-header">
        <i class="material-icons">corporate_fare</i>
        <div class="profile-widget-items">
            <div class="profile-widget-item">
                <div class="profile-widget-item-label">회사이름</div>
                <div class="profile-widget-item-value">{{receptionist.company_name}}</div>
            </div>
            <div class="profile-widget-item">
                <div class="profile-widget-item-label">Email</div>
                <div class="profile-widget-item-value">{{receptionist.company_email}}</div>
            </div>
            <div class="profile-widget-item">
                <div class="profile-widget-item-label">전화번호</div>
                <div class="profile-widget-item-value">{{receptionist.company_tel1}}</div>
            </div>
        </div>
    </div>
</div>
</script>
@endverbatim

<script>
    var datatable;
    moment.locale("ko");
    $(document).ready(function() {
    datatable = $('#datatable').DataTable({
        "processing": true,
        "serverSide": true,
        "lengthMenu": [10, 5],
        "order": [[ 0, "desc" ]],
        "ajax": {
            'url' : "/admin/meetinglist",
            'data' : function (data){
                data.meeting_status = $("#meeting_status").val();
            }
        },
        "columnDefs": [
            {"targets": [ 0 ],"visible": false,"searchable": false,"className":'details-control'},
            {"targets": [ 1 ],"searchable": true,"sortable":true,"className":'details-control'},
            {"targets": [ 2 ],"searchable": true,"sortable":false,"className":'details-control'},
            {"targets": [ 3 ],"searchable": true,"sortable":true,"className":'details-control'},
            {"targets": [ 4 ],"searchable": true,"sortable":true,"className":'details-control'},
            {"targets": [ 5 ],"searchable": true,"sortable":true,"className":'details-control'},
            {"targets": [ 6 ],"searchable": false,"sortable":false,"className":'details-control'},
            {"targets": [ 7 ],"searchable": false,"sortable":false,"className":'details-control'},
            {"targets": [ 8 ],"searchable": false,"sortable":false,"className":'details-control'},
            {"targets": [ 9 ],"searchable": true,"sortable":true,"className":'details-control'},
        ],
        "columns" : [
            {"data" : "id"},
            {"data" : "meeting_date"},
            {"data" : "meeting_time"},
            {"data" : "applicant",
             "render": function( data, type, row, meta) {
                if( data != null && typeof data.name != 'undefined' ) return data.name;
                else return '-'
             }},
            {"data" : "receptionist",
             "render": function( data, type, row, meta) {
                if( data != null && typeof data.company_name != 'undefined' ) return data.company_name;
                else return '-'
             }},
            {"data" : "meeting_status",
             "render": function( data, type, row, meta) {
                 switch ( data ){
                     case 'R' :
                         return '대기';
                         break;
                    case 'A' : 
                        return '승인';
                        break;
                    case 'D'  :
                        return '거절';
                        break;
                    default :
                        return '-';
                 }
             }},
            {"data" : "meeting_msg",
                "render": function( data, type, row, meta) {
                    return `<textarea class="meeting_msg" rows="2" readonly>${data}</textarea>`
             }},
            {"data" : "expo_name"},
            {"data" : "booth_title"},
            {"data" : "created_at",
             "render": function( data, type, row, meta) {
                 var date = moment( data );
                 return date.local().format('LLL')
             }},
        ],
        "initComplete": function(settings, json) {
            var textBox = $('#datatable_filter label input');
            let addsearch = `
            <label style="margin-right:10px;">진행:
                <select name="meeting_status"
                    class="form-control form-control-sm form-control-sm-important inline-select"
                    onChange="datatable.draw()" id="meeting_status">
                    <option value="">전체</option>
                    <option value="R" selected>대기</option>
                    <option value="A">승인</option>
                    <option value="D">거절</option>
                </select>
            </label>
            `;
            textBox.unbind();
            textBox.bind('keyup input', function(e) {
                if(e.keyCode == 8 && !textBox.val() || e.keyCode == 46 && !textBox.val()) {
                    // do nothing ¯\_(ツ)_/¯
                } else if(e.keyCode == 13 || !textBox.val()) {
                    datatable.search(this.value).draw();
                }
            });
            $("#datatable_filter").prepend(addsearch)
        },
        "drawCallback": function( settings ) {
        },
        "preDrawCallback": function( settings ) {

        },
    })
    $('#datatable tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = datatable.row( tr );

        if ( row.child.isShown() ) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
            // Open this row
            row.child( format(row.data()) ).show();
            tr.addClass('shown');
        }
    } );
});
function format( data ) {
    var template = Handlebars.compile( $( "#template_row" ).html() );
    return template(data)
}
</script>



@endsection
