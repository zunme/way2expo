@extends('admin.defaultlayout')

@section('css')
<style>
	textarea{width:100%}
</style>

@endsection

@section('main')
<div class="row">
  <div class="col-12">

    <div class="card">
      <form id="add_search_from">
        <div class="card-header" style="justify-content: space-between">
          <h4>config</h4>

        </div>
      </form>

		<div class="card-body sortable">
        <!-- 각 카드 리스트 박스 -->
<div class="table-responsive">
	<table class="table table-striped table-md" id="dt">
		<thead>
			<tr>
				<th>code</th>
				<th>title</th>
				<th>type</th>
				<th>val</th>
				<th>use</th>
				<th>action</th>
			</tr>			
		</thead>
		<tbody>

				@foreach ( $data as $row )
				<tr>

						<input type="hidden" name="id" value="{{$row->id}}">
					<td>{{$row->code}}</td>
					<td>{{$row->title}}</td>
					<td>{{$row->config_type}}</td>
					<td><textarea name="val">{!! $row->val !!}</textarea></td>
					<td>
						<select name="use_yn">
							<option value="Y" @if ($row->use_yn =='Y') selected @endif		>Y</option>
							<option value="N" @if ($row->use_yn =='N') selected @endif >N</option>
						</select>
					</td>
					<td>
						<a href="#" class="btn btn-secondary" onClick="edit(this)">save</a>
					</td>

				</tr>
				@endforeach

		</tbody>
	</table>
</div>			

		<!-- / 각 카드 리스트 박스 -->
       </div>
		

    </div>

  </div>
</div>
@endsection


@section('script')
@verbatim
<script id="formmodal" type="text/template">

</script>
@endverbataim


<script src="/admin_assets/stisla/assets/js/custjs.js?ver=0001"></script>
<script src="/admin_assets/stisla/node_modules/chocolat/dist/js/jquery.chocolat.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>




<script>
var dt = $("#dt").DataTable({ 
	paging: false,
	  "columns": [
		{ "width": "200px" },
		{ "width": "200px" },
		{ "width": "50px" },
		null,
		{ "width": "50px" },
		{ "width": "50px" },
	  ]
});
function edit ( bt ){
	var tr = $(bt).closest('tr');
    var row = dt.row( tr );
	//var data =  row.$('input, select, textarea').serialize()
	var data =$(tr).find('input,textarea,select').serialize()
       $.ajax({
           url: "/admin/config",
           method:"POST",
           data:data,
           dataType:'JSON',
           success:function(res)
           {
               iziToast.success({
                 message: '저장하였습니다.',
                 position: 'topRight'
               });
               return;
          },
           error: function ( err ){
             ajaxErrorST(err)
           }
         });
	
}
</script>
@endsection
