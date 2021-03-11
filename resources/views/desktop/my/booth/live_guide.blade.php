<div class="row">
    <div class="col-12 ml-auto mr-auto">
        <form name="agreeForm" method="post">
            @csrf
            <div class="card mt-0 mb-3">
                <div class="card-body">
                    <h4 class="card-title">Live 방송안내</h4>
                    <h6 class="card-subtitle mb-2 text-muted">라이브방송은 Way2EXPO 의 회원 및 기업회원과 함께 소통을 할 수있는 새로운 만남의장입니다.<br>다음과
                        같은 준비와 규칙을 준수하여 방송을 해주시길 바랍니다.</h6>
{{--                    <div class="card m-0 mt-2 mb-2 {{($has_live)?'bg-danger':'bg-info'}}">--}}
{{--                        <div class="card-body p-0 pt-2 pb-2 pl-3">--}}
{{--                            <span class="text">현재 방송 상태 : {{($has_live)?'진행 불가':'진행 가능'}}</span>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                    <p class="card-text mt-4">1. 방송장비 체크<br>방송에 필요한 노트북, 휴대폰 등의 기능을 점검해 주시길 바랍니다.</p>
                    <p class="card-text">2. 방송규정</p>
                    <textarea class="form-control" rows="8" readonly>• 기본규정
방송시작 버튼 클릭 시 바로 방송이 송출됩니다.
박람회 중 오전 10시 부터 오후 5시 사이까지 원하시는 시각에 방송이 가능합니다.
방송 중 비속어 및 욕설 등을 자제해 주시기 바랍니다.
방송 중 부적절한 언행 및 영상 송출 시 사전 알림없이 강제로 방송이 종료 될 수 있습니다.

• 방송책임
소통 중 발생한 모든사항 등은 방송 당사자 및 시청자 간의 책임이 있으며, Way2EXPO 와 관련이 없음을 확인합니다.</textarea>
                    <div class="form-group form-check text-right">
                        <label class="form-check-label text-dark">
                            <input class="form-check-input" type="checkbox" name="agree"
                                   id="inlineCheckbox1">동의합니다.
                            <span class="form-check-sign"><span class="check"></span></span>
                        </label>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-black float-right">방송 시작</button>
        </form>
    </div>

</div>
