file : resources/views/mobile/inc/liveviewconfirm.blade.php
<br>
방송안내는 여기에 넣어주세요
<br>
아래 3개는 필수입니다.

<!-- 필수 -->
	<input type="checkbox" name="agree" value="Y" id="liveview_agree_checkbox"
		   data-msg="여기에 경고문구를 넣어주세요"
	>
	<button class="liveview_agree_btn" @click="back">취소</button>
	<button class="liveview_agree_btn" @click="agree">
		버튼내용을 적어주세요
    </button>
<!-- /필수 -->