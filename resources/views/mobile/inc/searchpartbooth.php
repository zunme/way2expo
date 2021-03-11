<li class="search-list-item">
	<div class="search-list-item-media">
		<a href="/expo/{{expo_code}}/{{id}}" class="mediabg">
			<div style="background-image:url(/storage/{{booth_mobile_image_url}});">
			</div>
		</a>
	</div>
	<div class="search-list-item-title-wrap">
		<a href="/expo/{{expo_code}}/{{id}}">
			<div class="new-list-item-title-ellipsis2">
				{{booth_title}}
			</div>
			<ul class="search-list-item-tag_wrap">
				{{#tags}}
				<li>{{name}}</li>
				{{/tags}}
			</ul>
		</a>
	</div>

	<div class="search-list-item-right">
		<a href="#" class="globalToggleBoothLink" onclick="togglebooth(this)" data-id="{{id}}">
			
			<i class="material-icons isfavorite {{#unless isfavorite}}hide{{/unless}}">star</i>
			<i class="material-icons unfavorite {{#if isfavorite}}hide{{/if}}">star_border</i>

		</a>
	</div>
</li>