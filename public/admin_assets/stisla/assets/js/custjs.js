Handlebars.registerHelper('encodeMyString',function(inputData){
    return new Handlebars.SafeString(inputData);
});
Handlebars.registerHelper('isEqual', function (expectedValue, value) {
  return value === expectedValue;
});
Handlebars.registerHelper('isNotEqual', function (expectedValue, value) {
  return value !== expectedValue;
});
Handlebars.registerHelper('checkempty', function(value) {
    if ( typeof value == 'undefined') return true;
    if (value === null) return true;
    else if (value === '') return true;
    else return false;
});
Handlebars.registerHelper('gt', function(a, b) {
  return (a > b);
});
Handlebars.registerHelper('gte', function(a, b) {
  return (a >= b);
});
Handlebars.registerHelper('lt', function(a, b) {
  return (a < b);
});
Handlebars.registerHelper('lte', function(a, b) {
  return (a <= b);
});
Handlebars.registerHelper('ne', function(a, b) {
  return (a !== b);
});
function readURL(input, imgid) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#'+imgid).attr('src', e.target.result);
            $('#'+imgid).show();
            $("#card-noneimg").hide();

        }
        reader.readAsDataURL(input.files[0]);
    }else {
      $('#'+imgid).hide();
      $("#card-noneimg").show();
    }
}

function ajaxErrorST(jqXHR ){
  $('.loading_wrap').hide();

  if(jqXHR.status != 422 && jqXHR.status != 500 ) {
      alert('잠시후에 이용해주세요');
      console.log ( jqXHR  )
      return;
  }

  var msg ;
  var exception ;
  if (jqXHR.responseJSON ) {
    msg = jqXHR.responseJSON.errors;
    exception = jqXHR.responseJSON.exception;
  }

    if(msg) {
      for(key in msg) {
      if(msg.hasOwnProperty(key)) {
        if(key.indexOf('.') < 0 ) {
          $('input[name='+key+']').focus();
        }

        if ( $.isNumeric( key )) {
          iziToast.error({
            message: msg,
            position: 'topRight'
          });
        } else {
          iziToast.error({
            message: msg[key][0],
            position: 'topRight'
          });
        }
        break;
      }
    }
    } else {
      iziToast.error({
        message: '시스템 오류입니다',
        position: 'topRight'
      });
    }
}
function pop_tpl( size, id , data, title ){
  if ( typeof id =='undefined') return false;
  var availsize = ['sm', 'lg', 'xl']
  if ( !availsize.includes(size) ) size='default';

  var template = Handlebars.compile( $( "#"+id ).html() );
  $("#modal-"+size+"-area" ).html ( template(data) );
  $( "#modal-"+size ).modal('handleUpdate')
  if(jQuery().daterangepicker) {
    if($(".datepicker-pop").length) {
      $('.datepicker-pop').daterangepicker({
        locale: {format: 'YYYY-MM-DD'},
        singleDatePicker: true,
      });
    }
  }
  $( "#modal-"+size ).modal('show')
}

function change_status(target, selectval ){
    $("#"+target).val(selectval).trigger('change');
}
function default_form_prc(info) {
  var msg = ( typeof info.msg =='undefined') ? '정상적으로 처리되었습니다.' : info.msg;
  $.ajax({
     url:info.url,
     method:"POST",
     data:new FormData( document.getElementById(info.form) ),
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
           message: msg,
           position: 'topRight'
         });
       }
       if( typeof info.reload !='undefined')   {
		   if ( info.reload=="self"){
			   location.reload();
		   }else info.reload.ajax.reload(null, false);
	   }
      $('.modal.show').modal('hide');
    },
     error: function ( err ){
       ajaxErrorST(err)
     }
   });
}
function default_form_delete( info ){
  let title='';
  if (typeof info.title != 'undefined') title = `[${info.title}] 을(를) 삭제합니다.`;
  swal({
      title: '삭제하시겠습니까?',
      text : title,
      icon: 'warning',
      buttons: true,
      dangerMode: true,
    })
    .then((willDelete) => {
      if (willDelete) {
        $.ajax({
           url: info.url,
           method:"POST",
           data:{delete_id: info.id },
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
             if( typeof info.reload !='undefined')   info.reload.ajax.reload(null, false);
          },
           error: function ( err ){
             ajaxErrorST(err)
           }
         });
      } else {
      swal('취소되었습니다.');
      }
    });

}
function attachfiles(data){
  let previewimages = []
  let urls =[];
  if( typeof data.expo_attach != 'undefined'){
    for ( idx in data.expo_attach ){
      let img = {
          caption : 'sort : ' + data.expo_attach[idx].sort,
          downloadUrl : '/storage/' + data.expo_attach[idx].url,
          size: data.expo_attach[idx].attach_size,
          width: "120px",
          key: data.expo_attach[idx].id
      };
      urls.push( '/storage/' + data.expo_attach[idx].url );
      previewimages.push( img )
    }
  }
    $("#input-test-id").fileinput({
        initialPreview: urls,
        initialPreviewAsData: true,
        initialPreviewConfig: previewimages,
        deleteUrl: "/admin/expo/delattach",
        showUpload: false,
        overwriteInitial: false,
        maxFileSize: 1024000,
        initialCaption: "Detail",
        removeIcon: `<i class="material-icons">delete</i>`,
    });
    $('#input-test-id').on('filezoomhidden', function(event, params) {
        $("body").addClass("modal-open");
    });
    $('#input-test-id').on('filedeleted', function(event, id, index) {
        expotable.ajax.reload(null, false);
    });
    $('#input-test-id').on('filesorted', function(event, params) {
        let data = {};
        for( idx in params.stack ){
          data['keys["'+ params.stack[idx].key+'"]'] = parseInt(idx)+1;
        }
        data['key'] = params.stack[params.newIndex].key;
        data['old'] = params.oldIndex + 1;
        data['new'] = params.newIndex + 1;
        $.ajax({
           url: '/admin/expo/attachsort',
           method:"POST",
           data:data,
           dataType:'JSON',
           success:function(res)
           {
              expotable.ajax.reload(null, false);
              iziToast.success({
                message: res.message,
                position: 'topRight'
              });
           },
           error: function ( err ){
             ajaxErrorST(err)
           }
         });


    });
}
