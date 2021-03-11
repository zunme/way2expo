file : resources/views/mobile/inc/livetransconfirm.blade.php
<div>
	라이브방송은way2expo의회원및기업회원과함께소통을할수있는새로운
만남의장입니다.
</div>.
<div>
	다음과같은준비와규칙을준수하여방송을해주시길바랍니다
</div>
<div>
	방송규정
</div>
<div>
	<ul>
		<li>
			<div>
				기본규정
			</div>
			<div>
				방송시작버튼클릭시바로방송이송출됩니다.<br>
				박람회중오전10시부터오후5시사이까지원하시는시각에방송이가
				능합니다.<br>
				방송중비속어및욕설등을자제해주시기바랍니다.<br>
				방송중부적절한언행및영상송출시사전알림없이강제로방송이 종료될수있습니다.<br>
			</div>
		</li>
		<li>
			<div>
				방송책임
			</div>
			<div>
				클린한방송을위해방송송출자는선정적, 폭력적표현및언어는자제
를해주시기바랍니다.<br>
소통중발생한모든사항등은방송당사자및시청자간의책임이있으며, way2expo와관련이없음을확인합니다.<br>

			</div>
		</li>		
	</ul>
</div>
<!-- 필수 -->
<div>
	<input type="checkbox" name="agree" value="Y" id="livetran_agree_checkbox"> 동의합니다.
</div>
<div>
	<button class="livetrans_agree_btn" @click="back">취소</button>
	<button class="livetrans_agree_btn" @click="agree">방송시작</button>		
</div>

<!-- /필수 -->