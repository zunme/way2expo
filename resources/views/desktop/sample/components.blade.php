@extends('desktop.layouts.none')
@section('body')
    <div class="main">
        <div class="container">
            <div class="section">
                <h2 class="title">Components Page</h2>
                <h3 class="title">박람회 - Noto Sans KR</h3>
                <h4 class="title">badges</h4>
                <div class="row">
                    <span class="badge badge-primary">Primary</span>
                    <span class="badge badge-info">Info</span>
                    <span class="badge badge-success">Success</span>
                    <span class="badge badge-danger">Danger</span>
                    <span class="badge badge-warning">Warning</span>
                    <span class="badge badge-default">Default</span>
                    <span class="badge badge-rose">Rose</span>
                    <span class="badge badge-black">Black</span>
                    <span class="badge badge-real-black">Real Black</span>
                </div>
                <h4 class="title">buttons</h4>

                <div class="row">
                    <button type="button" class="btn btn-primary">Primary</button>
                    <button type="button" class="btn btn-info">Info</button>
                    <button type="button" class="btn btn-success">Success</button>
                    <button type="button" class="btn btn-danger">Danger</button>
                    <button type="button" class="btn btn-warning">Warning</button>
                    <button type="button" class="btn btn-default">Default</button>
                    <button type="button" class="btn btn-rose">Rose</button>
                    <button type="button" class="btn btn-black">Black</button>
                    <button type="button" class="btn btn-primary" disabled>Disabled</button>
                </div>
                <div class="row">
                    <button type="button" class="btn btn-sm btn-primary">Primary</button>
                    <button type="button" class="btn btn-sm btn-info">Info</button>
                    <button type="button" class="btn btn-sm btn-success">확인</button>
                    <button type="button" class="btn btn-sm btn-danger">Danger</button>
                    <button type="button" class="btn btn-sm btn-warning">Warning</button>
                    <button type="button" class="btn btn-sm btn-default">Default</button>
                    <button type="button" class="btn btn-sm btn-rose">Rose</button>
                    <button type="button" class="btn btn-sm btn-black">Black</button>
                    <button type="button" class="btn btn-sm btn-primary" disabled>Disabled</button>
                </div>
                <h4 class="title">buttons - outline</h4>

                <div class="row">
                    <button type="button" class="btn btn-sm btn-outline-primary">확인</button>
                    <button type="button" class="btn btn-sm btn-outline-info">취소</button>
                    <button type="button" class="btn btn-sm btn-outline-success">회원가입</button>
                    <button type="button" class="btn btn-sm btn-outline-danger">회원탈퇴</button>
                    <button type="button" class="btn btn-sm btn-outline-warning">신청하기</button>
                    <button type="button" class="btn btn-sm btn-outline">Default</button>
                    <button type="button" class="btn btn-sm btn-outline-rose">Rose</button>
                    <button type="button" class="btn btn-sm btn-outline-black">Black</button>
                </div>
                <h4 class="title">tab</h4>

                <div class="row">
                    <ul class="nav nav-pills nav-pills-black" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#link1" role="tablist" aria-expanded="true">
                                탭1번
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#link2" role="tablist" aria-expanded="false">
                                탭2번
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#link3" role="tablist" aria-expanded="false">
                                탭3번
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content tab-space">
                        <div class="tab-pane active" id="link1" aria-expanded="true">
                            Collaboratively administrate empowered markets via plug-and-play networks. Dynamically procrastinate B2C users after installed base benefits.
                            <br><br>
                            Dramatically visualize customer directed convergence without revolutionary ROI.
                        </div>
                        <div class="tab-pane" id="link2" aria-expanded="false">
                            Efficiently unleash cross-media information without cross-media value. Quickly maximize timely deliverables for real-time schemas.
                            <br><br>Dramatically maintain clicks-and-mortar solutions without functional solutions.
                        </div>
                        <div class="tab-pane" id="link3" aria-expanded="false">
                            Completely synergize resource taxing relationships via premier niche markets. Professionally cultivate one-to-one customer service with robust ideas.
                            <br><br>Dynamically innovate resource-leveling customer service for state of the art customer service.
                        </div>
                    </div>
                </div>
                <div class="row">
                    <ul class="nav nav-pills nav-pills-black nav-pills-icons" role="tablist">
                        <!--
                            color-classes: "nav-pills-primary", "nav-pills-info", "nav-pills-success", "nav-pills-warning","nav-pills-danger"
                        -->
                        <li class="nav-item">
                            <a class="nav-link" href="#dashboard-1" role="tab" data-toggle="tab">
                                <i class="material-icons">dashboard</i>
                                Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="#schedule-1" role="tab" data-toggle="tab">
                                <i class="material-icons">schedule</i>
                                Schedule
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#tasks-1" role="tab" data-toggle="tab">
                                <i class="material-icons">list</i>
                                Tasks
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content tab-space">
                        <div class="tab-pane active" id="dashboard-1">
                            Collaboratively administrate empowered markets via plug-and-play networks. Dynamically procrastinate B2C users after installed base benefits.
                            <br><br>
                            Dramatically visualize customer directed convergence without revolutionary ROI.
                        </div>
                        <div class="tab-pane" id="schedule-1">
                            Efficiently unleash cross-media information without cross-media value. Quickly maximize timely deliverables for real-time schemas.
                            <br><br>Dramatically maintain clicks-and-mortar solutions without functional solutions.
                        </div>
                        <div class="tab-pane" id="tasks-1">
                            Completely synergize resource taxing relationships via premier niche markets. Professionally cultivate one-to-one customer service with robust ideas.
                            <br><br>Dynamically innovate resource-leveling customer service for state of the art customer service.
                        </div>
                    </div>
                </div>
                <h4 class="title">form</h4>

                <form>
                    <div class="row">
                        <div class="col-6 m-auto">
                            <div class="form-group">
                                <label for="exampleInputEmail1">아이디</label>
                                <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                                <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">비밀번호</label>
                                <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                            </div>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" value="">
                                    Option one is this
                                    <span class="form-check-sign">
              <span class="check"></span>
          </span>
                                </label>
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Example select</label>
                                <select class="form-control selectpicker" data-style="btn btn-link" id="exampleFormControlSelect1">
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                    <option>5</option>
                                </select>
                            </div>
                            <div class="form-group label-floating has-success">
                                <label class="control-label">Success input</label>
                                <input type="text" value="Success" class="form-control" />
                                <span class="form-control-feedback">
    <i class="material-icons">done</i>
    </span>
                            </div>
                            <div class="input-group">
                                <div class="input-group-prepend">
      <span class="input-group-text">
          <i class="material-icons">group</i>
      </span>
                                </div>
                                <input type="text" class="form-control" placeholder="With Material Icons">
                            </div>
                        </div>
                        <div class="col-6 m-auto">

                            <div class="form-check form-check-radio">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="option1" >
                                    Radio is off
                                    <span class="circle">
            <span class="check"></span>
        </span>
                                </label>
                            </div>
                            <div class="form-check form-check-radio">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="option2" checked>
                                    Radio is on
                                    <span class="circle">
            <span class="check"></span>
        </span>
                                </label>
                            </div>

                            <div class="form-check form-check-radio disabled">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio" name="exampleRadios1" id="exampleRadios3" value="option1" disabled>
                                    Disabled radio is off
                                    <span class="circle">
            <span class="check"></span>
        </span>
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1"> 자동로그인
                                    <span class="form-check-sign">
        <span class="check"></span>
    </span>
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox2" value="option2"> 2
                                    <span class="form-check-sign">
        <span class="check"></span>
    </span>
                                </label>
                            </div>
                            <div class="form-check form-check-inline disabled">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox3" value="option3" disabled> 3
                                    <span class="form-check-sign">
        <span class="check"></span>
    </span>
                                </label>
                            </div>
                            <div class="form-group form-file-upload form-file-simple">
                                <input type="text" class="form-control inputFileVisible" placeholder="Simple chooser...">
                                <input type="file" class="inputFileHidden">
                            </div>

                            <div class="form-group form-file-upload form-file-multiple">
                                <input type="file" multiple="" class="inputFileHidden">
                                <div class="input-group">
                                    <input type="text" class="form-control inputFileVisible" placeholder="Single File">
                                    <span class="input-group-btn">
            <button type="button" class="btn btn-fab btn-round btn-primary">
                <i class="material-icons">attach_file</i>
            </button>
        </span>
                                </div>
                            </div>

                            <div class="form-group form-file-upload form-file-multiple">
                                <input type="file" multiple="" class="inputFileHidden">
                                <div class="input-group">
                                    <input type="text" class="form-control inputFileVisible" placeholder="Multiple Files" multiple>
                                    <span class="input-group-btn">
            <button type="button" class="btn btn-fab btn-info">
                <i class="material-icons">layers</i>
            </button>
        </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">Example textarea</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="col text-center">
                            <button type="submit" class="btn btn-sm btn-black">Submit</button>

                        </div>
                    </div>
                </form>
                <h4 class="title">EXPO cards</h4>
                <div class="row justify-content-center">
                    <div class="col-3">
                        <a href="">
                            <div class="card" style="min-width:250px;max-width:250px;">
                                <img class="card-img-top" src="/assets/img/samples/poster/poster_0.jpg" style="width:250px;height:362px;">
                                <div class="card-badge text-center">
                                    <span class="badge badge-black">#다섯글자자</span>
                                    <span class="badge badge-black">#다섯글자자</span>
                                    <span class="badge badge-black">#다섯글자자</span>
                                </div>
                                <div class="card-body p-2">
                                    <h4 class="card-title">한국국제기계박람회</h4>
                                    <p class="card-text">세줄까지만<br>세줄까지만<br>세줄까지만</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-3">
                        <div class="card" style="min-width:250px;max-width:250px;">
                            <img class="card-img-top" src="/assets/img/samples/poster/poster_1.jpg" style="width:250px;height:362px;">
                            <div class="card-badge text-center">
                                <span class="badge badge-black">#다섯글자자</span>
                                <span class="badge badge-black">#다섯글자자</span>
                                <span class="badge badge-black">#다섯글자자</span>
                            </div>
                            <div class="card-body p-2">
                                <h4 class="card-title">한국국제기계박람회</h4>
                                <p class="card-text">세줄까지만<br>세줄까지만<br>세줄까지만</p>
                            </div>
                        </div>
                    </div>
                </div>
                <h4 class="title">Booth cards</h4>
                <div class="row justify-content-center">
                    <div class="col-3">
                        <a href="">
                            <div class="card" style="min-width:250px;max-width:250px;">
                                <img class="card-img-top" src="/assets/img/samples/poster/poster_0.jpg" style="width:250px;height:362px;">
                                <div class="card-badge text-center">
                                    <span class="badge badge-black">#다섯글자자</span>
                                    <span class="badge badge-black">#다섯글자자</span>
                                    <span class="badge badge-black">#다섯글자자</span>
                                </div>
                                <div class="card-body p-2">
                                    <h4 class="card-title">한국국제기계박람회</h4>
                                    <p class="card-text">세줄까지만<br>세줄까지만<br>세줄까지만</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-3">
                        <div class="card" style="min-width:250px;max-width:250px;">
                            <img class="card-img-top" src="/assets/img/samples/poster/poster_1.jpg" style="width:250px;height:362px;">
                            <div class="card-badge text-center">
                                <span class="badge badge-black">#다섯글자자</span>
                                <span class="badge badge-black">#다섯글자자</span>
                                <span class="badge badge-black">#다섯글자자</span>
                            </div>
                            <div class="card-body p-2">
                                <h4 class="card-title">한국국제기계박람회</h4>
                                <p class="card-text">세줄까지만<br>세줄까지만<br>세줄까지만</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('page-script')
<!--	Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select -->
<script src="/assets/js/plugins/bootstrap-selectpicker.js" type="text/javascript"></script>
@endsection
