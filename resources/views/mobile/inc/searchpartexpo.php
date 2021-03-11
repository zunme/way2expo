<li class="search-list-item">
	<div class="search-list-item-media">
		<a href="/expo/{{expo_code}}" class="mediabg">
			<div style="background-image:url(/storage/{{expo_image_url}});">
			</div>
		</a>
	</div>
	<div class="search-list-item-title-wrap">
		<a href="/expo/{{expo_code}}">
			<div class="new-list-item-title-ellipsis2">
				[{{diffday expo_open_date expo_close_date}}] {{expo_name}}
			</div>
			<div class="new-list-item-title-sub">
				{{expo_open_date}}~{{expo_close_date}}
			</div>
		</a>
	</div>

	<div class="search-list-item-right">
		<a href="#" class="globalToggleExpoLink" onclick="toggleexpo(this)" data-id="{{id}}">
			<i class="material-icons isfavorite {{#unless isfavorite}}hide{{/unless}}">star</i>
			<i class="material-icons unfavorite {{#if isfavorite}}hide{{/if}}">star_border</i>
		</a>
	</div>
</li>