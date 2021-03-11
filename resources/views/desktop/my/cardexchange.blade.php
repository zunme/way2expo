<style>
    .f-slash:not(:last-child):after {
        content: '\002F';
    }

    .f-slash.slash-hide:after {
        display: none;
    }
</style>
<form name="boothContactForm" action="" class="m-0">
    <p class="text">
        비즈니스 문의란?
    </p>
    <p class="text">
        개인정보 제3자 제공동의
        제공 받는자 : {{$booth->companyBooth->company_name}}
    </p>
    <div class="form-check form-check-inline">
        <label class="form-check-label">
            <input class="form-check-input" type="checkbox" name="agree" value="Y"> 동의합니다.
            <span class="form-check-sign"><em class="check"></em></span>
        </label>
    </div>
    <div class="form-group">
        <label>보낼 명함</label>
        <button type="button" class="btn btn-sm btn-black btn-mycard">정보 수정</button>
        @if( empty($user->card->user_id) && empty($user->business_card_front) && empty($user->business_card_back) )
            <p>
                등록된 명함이 없습니다.
            </p>
        @else
            <h5>텍스트 명함</h5>
            <div class="row">
                <div class="col-6">
                    @if(empty($user->card->user_id))
                        <p>
                            등록된 텍스트 명함이 없습니다.
                        </p>
                    @else
                        <div class="d-flex justify-content-between">
                            <div class="card_name">{{$user->card->card_name}}</div>
                            <div class="d-flex">
                                <div class="card_dept f-slash {{empty($user->card->card_position)?'slash-hide':''}}">{{$user->card->card_dept}}</div>
                                <div class="card_position">{{$user->card->card_position}}</div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <div class="card_company">{{$user->card->card_company}}</div>
                        </div>
                        <div class="d-flex">
                            <div class="card_tel">{{$user->card->card_tel}}</div>
                        </div>
                        <div class="d-flex">
                            <div class="card_email">{{$user->card->card_email}}</div>
                        </div>
                        <div class="d-flex">
                            <div class="card_homepage">{{$user->card->card_homepage}}</div>
                        </div>
                    @endif

                </div>
            </div>
            <h5>이미지 명함</h5>

            <div class="row">
                <div class="col-6">
                    @if(empty($user->business_card_front))
                        <p>
                            등록된 이미지 명함(앞)이 없습니다.
                        </p>
                    @else
                        <img src="/storage/{{$user->business_card_front}}"
                             class="img img-fluid" alt="">

                    @endif

                </div>
                <div class="col-6">
                    @if(empty($user->business_card_back))
                        <p>
                            등록된 이미지 명함(뒷)이 없습니다.
                        </p>
                    @else
                        <img src="/storage/{{$user->business_card_back}}"
                             class="img img-fluid" alt="">

                    @endif

                </div>
            </div>
        @endif
    </div>
    <div class="form-group">
        <label>소개 및 인사말</label>
        <textarea class="form-control" name="message" rows="3"
                  placeholder="비즈니스 문의 이유 및 목적을 자세하게 설명해주시면 응답이 올 확률이 높아집니다.&#13;&#10;(최대 1,000자)"></textarea>
    </div>
    <button type="submit" class="btn btn-sm btn-black btn-ajax">보내기</button>
</form>
