@verbatim
{{#each data}}
<li>
	<div class="item-content prdlistslayout2 prdliststyle2">
		<div class="item-media">
			<a href="/m/product/{{id}}">
				<div class="prdimg" style="background-image: url(/storage/{{prd_img1}});">
				</div>
			</a>
		</div>
		<div class="item-inner ">
			<div class="item-title-row">
				<a href="/m/product/{{id}}" class="new-list-item-title-ellipsis2">{{prd_title}}
				</a>
			</div>
			<div class="prd-item-company-name" style="display:none">Beatles</div>
			<a href="/m/product/{{id}}" class="prd-item-price-wrap display-flex justify-content-space-between">
				<div class="prd-item-price-down">

				</div>
				<div class="prd-item-price-inner">
					{{#js_if " this.prd_viewprice == 'Y' " }}
						<div class="prd-item-before_price">
							<span class="prd-item-before_price_tag2">{{numberformat prd_org_price}} 원</span>
							<span class="pricedntag">{{prd_price_percent}}%</span>
						</div>
						<div class="prd-item-after_price">
							{{numberformat prd_price}} 원
						</div>
					{{/js_if}}
					{{#js_if " this.prd_viewprice == 'N' " }}
						<div class="prd-item-after_price prd-item-none-price">
							가격 협의
						</div>
					{{/js_if}}

				</div>
			</a>
		</div>
		<div class="prd-item-fav prd-item-fav-outer display-flex">
			<a class="globalTogglePrdLink" onclick="toggleprd(this)" data-id="{{id}}">
					<i class="material-icons isfavorite
	{{#js_if " this.isfavorite != true "}} hide {{/js_if}}
					">favorite</i>
					<i class="material-icons unfavorite 
	{{#js_if " this.isfavorite != false "}} hide {{/js_if}}">favorite_border</i>
			</a>
		</div>
	</div>
</li>
{{/each}}
@endverbatim