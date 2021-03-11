<template>
  <div class="page">
    <div class="navbar">
      <div class="navbar-bg"></div>
      <div class="navbar-inner sliding">
        <div class="left">
          <a href="#" class="link back">
            <i class="icon icon-back"></i>
            <span class="if-not-md">Back</span>
          </a>
        </div>
        <div class="title">상품관리</div>
      </div>
    </div>

    <div class="page-content">
		<form id="prd-make-form">
			@if( !empty($product->id))
			<input type="hidden" name="prd_id" value="{{$product->id}}">
			@endif
			<input type="hidden" name="booth_id" value="{{$booth->id}}">
			<div class="list no-hairlines-md">
			  <ul>

				<li class="item-content item-input item-input-outline item-input-with-value">
				  <div class="item-inner">
					<div class="item-title item-label">상품명</div>
					<div class="item-input-wrap">
					  <input type="text" name="prd_title" placeholder="상품명" class="input-with-value" value="{{$product->prd_title}}">
					  <span class="input-clear-button"></span>
					</div>
				  </div>
				</li>
				<li class="item-content item-input item-input-outline item-input-with-value">
				  <div class="item-inner">
					<div class="item-title item-label">상품 URL</div>
					<div class="item-input-wrap">
					  <input type="text" name="prd_url" placeholder="상품 URL" class="input-with-value" value="{{$product->prd_url}}">
					  <span class="input-clear-button"></span>
					</div>
				  </div>
				</li>


					<li class="item-content item-input item-input-outline">
					  <div class="item-inner">
						<div class="item-title item-label">상품 노출</div>
						<div class="item-input-wrap">
	<div class="item-input-wrap input-dropdown-wrap">
						  <select name="prd_display_yn" placeholder="Please choose..." class="input-with-value">
							<option value="Y" @if ($product->prd_display_yn =='Y')  selected @endif>상품 노출</option>
							<option value="N" @if ($product->prd_display_yn =='N')  selected @endif>상품 숨김</option>
						  </select>
						</div>
						</div>
					  </div>
					   <div class="item-inner">
						<div class="item-title item-label">가격 노출</div>
						<div class="item-input-wrap">
	<div class="item-input-wrap input-dropdown-wrap">
						  <select name="prd_viewprice" placeholder="Please choose..." class="input-with-value">
							<option value="Y" @if ($product->prd_viewprice =='Y')  selected @endif >가격 노출</option>
							<option value="N" @if ($product->prd_viewprice =='N')  selected @endif >상품 협의</option>
						  </select>
						</div>
						</div>
					  </div>
					</li>

				<li class="item-content item-input item-input-outline item-input-with-value">
				  <div class="item-inner">
					<div class="item-title item-label">세일전 가격</div>
					<div class="item-input-wrap">
					  <input type="number" name="prd_org_price" placeholder="세일전 가격" class="input-with-value" value="{{$product->prd_org_price}}">
					  <span class="input-clear-button"></span>
					</div>
				  </div>
				</li>
				<li class="item-content item-input item-input-outline item-input-with-value">
				  <div class="item-inner">
					<div class="item-title item-label">판매 가격</div>

					<div class="item-input-wrap">
					  <input type="number" name="prd_price" placeholder="판매 가격" class="input-with-value"  value="{{$product->prd_price}}">
					  <span class="input-clear-button"></span>
					</div>
				  </div>

				</li>



					<li class="item-content item-input item-input-outline">
					  <div class="item-inner">
						<div class="item-title item-label">상품 이미지 1</div>
						<div class="item-input-wrap">
						  <input type="file" name="selectimg_1" placeholder="image" data-maxheight='140px' data-maxwidth='100%' data-type="prdimage1" onChange="fnImgPreview(this)">
						  <span class="input-clear-button"></span>
						</div>
					  </div>
					  <div class="item-inner">
						<div class="item-title item-label">상품 이미지 2</div>
						<div class="item-input-wrap">
						  <input type="file" name="selectimg_2" placeholder="image" data-maxheight='140px' data-maxwidth='100%' data-type="prdimage2" onChange="fnImgPreview(this)">
						  <span class="input-clear-button"></span>
						</div>
					  </div>
					</li>
					<li class="item-content item-input item-input-outline">
					  <div class="item-inner">
						<div class="item-input-wrap text-align-center img-previewarea" data-type="prdimage1">
						  @if ( empty($product->prd_img1))
						  이미지가 없습니다
						  @else
						  <img src="/storage/{{$product->prd_img1}}" style="max-width:100%;max-height:140px;">
						  @endif
						</div>
					  </div>
					  <div class="item-inner">
						<div class="item-input-wrap text-align-center img-previewarea" data-type="prdimage2">
						  @if ( empty($product->prd_img2))
						  이미지가 없습니다
						  @else
							<img src="/storage/{{$product->prd_img2}}" style="max-width:100%;max-height:140px;">
						  @endif
						</div>
					  </div>
					</li>
					<li class="item-content item-input item-input-outline">
					  <div class="item-inner">
						<div class="item-title item-label">상품 이미지 3</div>
						<div class="item-input-wrap">
						  <input type="file" name="selectimg_3" placeholder="image" data-maxheight='140px' data-maxwidth='100%' data-type="prdimage3" onChange="fnImgPreview(this)">
						  <span class="input-clear-button"></span>
						</div>
					  </div>
					  <div class="item-inner">
						<div class="item-title item-label">상품 이미지 4</div>
						<div class="item-input-wrap">
						  <input type="file" name="selectimg_4" placeholder="image" data-maxheight='140px' data-maxwidth='100%' data-type="prdimage4" onChange="fnImgPreview(this)">
						  <span class="input-clear-button"></span>
						</div>
					  </div>
					</li>
<li class="item-content item-input item-input-outline">
					  <div class="item-inner">
						<div class="item-input-wrap text-align-center img-previewarea" data-type="prdimage3">
						  @if ( empty($product->prd_img3))
						  이미지가 없습니다
						  @else
						  <img src="/storage/{{$product->prd_img3}}" style="max-width:100%;max-height:140px;">
						  @endif
						</div>
					  </div>
					  <div class="item-inner">
						<div class="item-input-wrap text-align-center img-previewarea" data-type="prdimage4">
						  @if ( empty($product->prd_img4))
						  이미지가 없습니다
						  @else
							<img src="/storage/{{$product->prd_img4}}" style="max-width:100%;max-height:140px;">
						  @endif
						</div>
					  </div>
					</li>
			  </ul>
			</div>
			
			
			
			
			
<!-- list item-->	
<div class="product_form_imgs_wrap">
	
	<div class="list media-list sortable sortable-opposite" id="product_form_imgs">
		<div class="prdform_item-lbel">
			상품상세이미지
		</div>
		<ul>
			@forelse  ( $productImage as $img)
				<li data-id="{{$img->id}}">
					<div class="item-content">
						<div class="item-media">
							<img src="/storage/{{$img->url}}" width="80">
						</div>
						<div class="item-inner">
							<div class="item-title-row">
								<div class="item-title">Yellow Submarine</div>
							</div>
							<div class="prd-detail-imgs-ctrl">
								<i class="material-icons" data-img="https://cdn.framework7.io/placeholder/people-160x160-1.jpg" @click="zoom">search</i>
								<i class="material-icons" data-id="{{$img->id}}" @click="deleteDetailImg">delete</i>
							</div>
						</div>
					</div>

					<div class="sortable-handler"></div>

				</li>
			@empty
			<li class="prdform_none_detail">상품상세이미지를 올려주세요</li>
			@endforelse
			
		</ul>
	</div>	
</div><!-- /list item-->
	
<div class="prdform-attach_wrap">
	<div class="prdform-attach_inner">
		<input type="file" name="attach[]" multiple accept="image/*" @change="loadimg">
	</div>
</div><!-- / prdform-attach_wra -->
			
			
		</form>
		<div class="prdform_savearea">
			  <div class="item-inner align-items-flex-end mt-20">
				<a href="#" class="button button-fill" style="min-width:150px;" @click="saveconfirm">
				저장
				</a>
			  </div>
		</div>
		
    </div><!-- / page-content -->

  </div>
	<style>
		.prd-detail-imgs-ctrl{
			position: absolute;
			bottom: 0;
			right: 0;
		}
	</style>
</template>
<script>
  return {
    data: function () {
      return {
		  sortChange : false,
		  sortData : null,
		  compiledAddItem : null,
@verbatim		  
		  additemTemplate : `
			<li class="prdform-add-items no-sorting">
				<div class="item-content">
					<div class="item-media">
						<img src="{{src}}" style="max-width:140px;max-height:90px;">
					</div>
					<div class="item-inner">
						<div class="item-title-row">
							<div class="item-title">{{title}}</div>
						</div>
						<div class="prd-detail-imgs-ctrl">
							
						</div>
					</div>
				</div>

				<div class="sortable-handler"></div>

			</li>
			`,
@endverbatim		  
      }
    },
    methods: {
		zoom: function(e){
			var photo = $$(e.target).data("img")
			app.photoBrowser.create({
				photos : [ photo ] ,
				theme: 'dark',
        		type: 'popup',
				on : {
					closed : function(){
						this.destroy()
					}
				}
			}).open();
		},
		deleteDetailImg : function (e){
			var id = $$(e.target).data("id")
			$$(e.target).closest('li').remove();
		},
		loadimg : function (e) {
			var self = this;
			$$("li.prdform-add-items").remove();
			if ( e.target.files ) [].forEach.call(e.target.files, self.readAndPreview);
		},
		readAndPreview : function(file) {	
			var self = this;
			var reader = new FileReader();
			reader.addEventListener("load", function() {
			  var data={title : file.name, src :   this.result };
			  self.addItem(data)
			});
			reader.readAsDataURL(file);
		},
		addItem : function (data){
			var self = this;
			if(self.compiledAddItem == null ) self.compiledAddItem = Template7.compile(self.additemTemplate);
		 	$$("#product_form_imgs ul").append( self.compiledAddItem(data))
		},
		saveconfirm : function() {
			var self = this;
			var text = "저장하시겠습니까?";
			if ( $$("select[name=prd_viewprice] option:selected").val() =='Y'){
				var price = $$("input[name=prd_price]").val().trim();
				if( price =='' || price < 1 ) {
					$$("input[name=prd_price]").val('0');
					text = "판매가격이 0원 입니다.<br>저장하시겠습니까?"
				}				
			}
			
			app.dialog.confirm( 
				text ,
			   'way2Expo', 
				function(){
					self.save();
				},
				function() {
					
				}
			);
		},
		save : function() {
			var self = this;
			var data = new FormData( document.getElementById('prd-make-form' ));
			var srotdata = new Blob([JSON.stringify(self.sortData)], {
				  type: 'application/json'
				})
			data.append( 'sort', JSON.stringify(self.sortData) )
			
			axios.post('/mobileapi/productmanage', data, {
			  headers: {
				'Content-Type': 'multipart/form-data'
			  }
			})
			.then((response) => {
			  // 응답 처리
				myprdreload();
				history.back();
			})
			.catch((error) => {
				console.log ( "error")
				temptest =  error.response
				if( error.response ) ajaxError( error.response)
                else toastmessage('잠시후에 이용해주세요')
			})
		},
    },
    on: {
      pageBeforeRemove: function () {
        var self = this;
        // Destroy popup when page removed
        if (self.notificationFull) self.notificationFull.destroy();
        if (self.popup) self.popup.destroy();
        if (self.popupSwipe) self.popupSwipe.destroy();
        if (self.popupSwipeHandler) self.popupSwipeHandler.destroy();
        if (self.popupPush) self.popupPush.destroy();
      },
      pageInit: function () {
        var self = this;
        var today = new Date();
        var app = self.$app;
		app.sortable.enable("#product_form_imgs")
		app.on('sortableSort', function (listEl, indexes) {
			var id = $(listEl).data('id')
			var sort = []
			var data = { key: id, old : indexes.from+ 1, new : indexes.to + 1}
			$("#product_form_imgs li").each( function (index) {
				data['keys["'+ $$(this).data('id') +'"]'] = index + 1
				sort.push({key: $$(this).data('id') , sort : index + 1 })
			});
		    self.sortData = sort;
			self.sortChange = true;
			console.log ( sort)
		});
		 
      },
    }
  }
</script>
