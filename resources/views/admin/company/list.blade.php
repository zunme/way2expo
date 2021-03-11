@extends('admin.defaultlayout')
@section('css')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="/admin_assets/stisla/node_modules/chocolat/dist/css/chocolat.css">

    <style>
        .dt-highlight-row {
            background-color: #e3eaef !important;
        }

        .dataTables_filter label {
            font-weight: 600 !important;
            color: #34395e !important;
            font-size: 12px !important;
            a letter-spacing: .5px !important;
        }

        .dataTables_info {
            font-weight: 600 !important;
            color: #34395e !important;
        }
        .table td .buttons button,.table td .buttons a{
            vertical-align:top;
            line-height: 1rem;
        }
    </style>
@endsection
@section('main')
    <div class="section-header">
        <h1>기업관리</h1>
    </div>
    <div class="section-body">
        <div class="modal" id="modal-xl" role="dialog" aria-hidden="true" data-backdrop="static"
             data-keyboard="false">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>목록</h4>
                        <div class="card-header-action">
                            <button class="btn btn-primary" onClick="edit(this)">
                                등록하기
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-md" id="company_table">
                                <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>회사명</th>
                                    <th>마스터</th>
                                    <th>사업자번호</th>
                                    <th>주소</th>
                                    <th>전화번호</th>
                                    <th>이메일</th>
                                    <th>인증유무</th>
                                    <th>노출유무</th>
                                    <th>등록자</th>
                                    <th>등록일시</th>
                                    <th>관리</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <!-- iOS에서는 position:fixed 버그가 있음, 적용하는 사이트에 맞게 position:absolute 등을 이용하여 top,left값 조정 필요 -->
    <div id="daumPost"
         style="display:none;position:fixed;overflow:hidden;z-index:2000;-webkit-overflow-scrolling:touch;">
        <img src="//t1.daumcdn.net/postcode/resource/images/close.png" id="btnCloseLayer"
             style="cursor:pointer;position:absolute;right:-3px;top:-3px;z-index:1" onclick="closeDaumPostcode()"
             alt="닫기 버튼">
    </div>

    <script type="text/javascript"
            src="//dapi.kakao.com/v2/maps/sdk.js?appkey=e1e0c8cd1b6f4167551210b0d77056c6"></script>
    <script src="https://t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
    <script>
        var search_usertable;

        $(function () {
            companyTable = $('#company_table').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": {
                    'url': "/admin/company-list",
                    'data': function (data) {
                        data.display_status = $('#display_status').val();
                        data.company_level_status = $('#company_level_status').val();
                    }

                },
                "dom": "<'row justify-content-between'<'col-4'l><'col text-right'>><'row justify-content-between'<'col-4'i><'col'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-5'P><'col-sm-12 col-md-7'p>>",
                "order": [[10, 'desc']],
                "language": {
                    "info": "_TOTAL_ 건",
                    "infoFiltered": "/ 전체 _MAX_ 건",
                    "infoEmpty": "검색된 결과가 없습니다.",
                    "emptyTable": "검색된 결과가 없습니다.",
                    "zeroRecords": "검색된 결과가 없습니다.",
                    "lengthMenu": "표시 _MENU_ 개",
                    "search": "검색:",
                    "paginate": {
                        "first": "처음",
                        "last": "끝",
                        "next": "다음",
                        "previous": "이전"
                    },
                },
                "drawCallback": function (settings) {
                    $(".gallery .gallery-item").each(function () {
                        var me = $(this);

                        me.attr('href', me.data('image'));
                        me.attr('title', me.data('title'));
                        if (me.parent().hasClass('gallery-fw')) {
                            me.css({
                                height: me.parent().data('item-height'),
                            });
                            me.find('div').css({
                                lineHeight: me.parent().data('item-height') + 'px'
                            });
                        }
                        me.css({
                            backgroundImage: 'url("' + me.data('image') + '")'
                        });
                    });
                    if (jQuery().Chocolat) {
                        chocolateapi = $(".gallery").Chocolat({
                            className: 'gallery',
                            imageSelector: '.gallery-item',
                        }).data('chocolat');
                    }

                },
                "preDrawCallback": function (settings) {
                    if (typeof chocolateapi != 'undefined') {
                        chocolateapi.api().destroy();
                    }
                },
                "initComplete": function (settings, json) {
                    var textBox = $('#company_table_filter label input');
                    textBox.unbind();
                    textBox.bind('keyup input', function (e) {
                        if (e.keyCode === 8 && !textBox.val() || e.keyCode === 46 && !textBox.val()) {
                            // do nothing ¯\_(ツ)_/¯
                        } else if (e.keyCode === 13 || !textBox.val()) {
                            companyTable.search(this.value).draw();
                        }
                    });
                    $("#company_table_wrapper > div:nth-child(1) > div:nth-child(1)").removeClass('col-md-6').addClass('col-md-2');
                    $("#company_table_wrapper > div:nth-child(1) > div:nth-child(2)").removeClass('col-md-6').addClass('col-md-10');
                    let addSearch = `
                            <div class="form-group m-0">
                            <label class="col-form-label mr-2">인증유무</label>
                            <select name="company_level_status"
                                    class="form-control form-control-sm form-control-sm-important inline-select mr-2"
                                    onChange="companyTable.draw()" id="company_level_status"
                                    style="width:80px">
                                <option value="">전체</option>
                                <option value="100">인증</option>
                                <option value="90">미인증</option>
                            </select>
                            <label class="col-form-label mr-2">노출상태</label>
                            <select name="display_status"
                                    class="form-control form-control-sm form-control-sm-important inline-select mr-2"
                                    onChange="companyTable.draw()" id="display_status"
                                    style="width:80px">
                                <option value="">전체</option>
                                <option value="Y">Y</option>
                                <option value="N">N</option>
                            </select>
                            </div>
                    `;
                    // $("#booth_table_filter").append(addSearch);
                    $("#company_table_length").parent().next().append(addSearch);

                },
                "columnDefs": [
                    {"targets": [0], "searchable": true, "sortable": true, "visible": false},//No
                    {"targets": [1], "searchable": true, "sortable": false},//회사명
                    {"targets": [2], "searchable": false, "sortable": false},//담당자
                    {"targets": [3], "searchable": false, "sortable": false, "visible": false},//사업자번호
                    {"targets": [4], "searchable": true, "sortable": false},//주소
                    {"targets": [5], "searchable": true, "sortable": false},//전화번호
                    {"targets": [6], "searchable": true, "sortable": false},//이메일
                    {"targets": [7], "searchable": false, "sortable": false},//인증유무
                    {"targets": [8], "searchable": false, "sortable": false},//노출
                    {"targets": [9], "searchable": false, "sortable": false, "visible": false},//등록자
                    {"targets": [10], "searchable": false, "sortable": true},//등록일시
                    {"targets": [11], "searchable": false, "sortable": false},//관리
                ],
                createdRow: function (row, data, dataIndex) {
                    // Set the data-status attribute, and add a class
                },
                "columns": [
                    {
                        data: "DT_RowIndex",
                    },
                    {data: "company_name"},
                    {
                        data: "name",
                        render: function (data) {
                            return (data == null || typeof data == 'undefined') ? '-' : data;
                        },
                    },
                    {
                        data: "biz_no",
                        render: function (data) {
                            return (data !== '') ? ' - ' : '';
                        },
                    },
                    {
                        data: "company_address1",
                        render: function (data) {
                            return data;
                        }
                    },
                    {data: "company_tel1"},
                    {
                        data: "company_email",
                        render: function (data) {
                            return data;
                        }
                    },
                    {
                        data: "company_level",
                        render: function (data) {
                            return (data >= 100) ? 'Y' : 'N';
                        },
                    },
                    {
                        data: "company_display_status",
                        render: function (data) {
                            return data;
                        },
                    },

                    {data: "company_name"},
                    {
                        data: "created_at",
                        render: function (data, type, row) {
                            if (data == null || typeof data == 'undefined') return ''
                            else return data;
                        }
                    },
                    {
                        data: "id",
                        render: function (data, type, row) {
                            return `
                                <div class="buttons">
                                <button type="button" class="btn btn-sm btn-primary" onClick="edit(this)">수정</button>
                                <button type="button" class="btn btn-sm btn-warning" onClick="change_pserson(this)">담당자변경</button>
                                <!--<button type="button" class="btn btn-sm btn-icon btn-danger" onClick="deleteBooth(this)">삭제</button>-->
                                </div>
                            `;

                        }
                    },

                ],
            });
            $("#company_table tbody").on('click', 'tr', function (event) {
                $("#company_table tbody tr").removeClass('dt-highlight-row');
                $(this).addClass('dt-highlight-row');
            });

        });

        function edit(btn) {
            selected_row = $(btn).closest('tr');
            var row_data = companyTable.row(selected_row).data();
            company_data = row_data;

            pop_tpl('lg', 'editpop', row_data);
        }

        function change_pserson(btn) {
            if (search_usertable != null) {
                search_usertable.destroy();
            }
            selected_row = $(btn).closest('tr');
            var row_data = companyTable.row(selected_row).data();
            company_data = row_data;

            pop_tpl('lg', 'person_pop', row_data);
        }

        /* updatePhotoPreview */
        function updatePhotoPreview(obj) {
            var reader = new FileReader();
            var target = $(obj).data('target');

            reader.onload = (e) => {
                var img = $("#" + target + " img");
                img.attr('src', e.target.result);
                img.show();
            };
            reader.readAsDataURL(obj.files[0]);
        }

        function change_person_prc(btn) {
            var userdata = search_usertable.row($(btn).closest('tr')).data();
            $.ajax({
                url: "/admin/company-addpserson ",
                method: "POST",
                data: {company_id: company_data.id, user_id: userdata.id},
                dataType: 'JSON',
                success: function (res) {
                    if (res.result == 'OK') {
                        companyTable.ajax.reload(null, false);
                        search_usertable.ajax.reload(null, false);
                        iziToast.success({
                            message: res.msg,
                            position: 'topRight'
                        });


                        let td = `
         <tr data-id='${res.data.id}' data-name='${res.data.name}'>
             <td>${res.data.name}</td>
             <td>${res.data.email}</td>
             <td>${res.data.tel}</td>
             <td class="center"><i class="fas fa-trash-alt" onClick='pserson_delete(this)'></i></td>
         </tr>
         `
                        $("#pserson-onedata-tr").remove();
                        $("#person_tbody").append(td)

                    } else {
                        iziToast.warning({
                            message: res.msg,
                            position: 'topRight'
                        });

                    }
                },
                error: function (err) {
                    ajaxError(err)
                }
            });
        }


        function change_master_prc(btn) {
            var userdata = search_usertable.row($(btn).closest('tr')).data();

            swal({
                title: '',
                text: "마스터 아이디를 변경하시겠습니까?",
                icon: 'warning',
                dangerMode: true,
                buttons: {
                    confirm: "변경",
                    cancel: {
                        text: "취소",
                        value: null,
                        visible: true,
                        className: "",
                        closeModal: true,
                    },
                },

            }).then((value) => {
                if (value) {
                    $.ajax({
                        url: "/admin/company-changemaster ",
                        method: "POST",
                        data: {company_id: company_data.id, user_id: userdata.id},
                        dataType: 'JSON',
                        success: function (res) {
                            if (res.result == 'OK') {
                                companyTable.ajax.reload(null, false);
                                search_usertable.ajax.reload(null, false);
                                iziToast.success({
                                    message: res.msg,
                                    position: 'topRight'
                                });
                                $("#master-pserson").val('(' + res.data.name + ')' + res.data.email)
                            } else {
                                iziToast.warning({
                                    message: res.msg,
                                    position: 'topRight'
                                });
                            }
                        },
                        error: function (err) {
                            ajaxError(err)
                        }
                    });
                }
            })

        }
        function file_delete(obj){

            swal({
                title: '',
                text: "첨부파일을 삭제 하시겠습니까?",
                icon: 'warning',
                dangerMode: true,
                buttons: {
                    confirm: "삭제",
                    cancel: {
                        text: "취소",
                        value: null,
                        visible: true,
                        className: "",
                        closeModal: true,
                    },
                },

            }).then((value) => {
                if (value) {
                    $.ajax({
                        url: "/admin/company-delfile ",
                        method: "POST",
                        data: {company_id: company_data.id},
                        dataType: 'JSON',
                        success: function (res) {
                            if (res.result == 'OK') {
                                $('#fileInp_target').remove();
                                companyTable.ajax.reload(null, false);
                                iziToast.success({
                                    message: res.msg,
                                    position: 'topRight'
                                });

                            }
                        },
                        error: function (err) {
                            ajaxError(err)
                        }
                    });
                }
            });
        }
        function pserson_delete(btn) {
            var id = $(btn).closest('tr').data('id');
            var name = $(btn).closest('tr').data('name');

            swal({
                title: 'Are you sure?',
                text: "담당자[" + name + "]를 삭제 하시겠습니까?",
                icon: 'warning',
                dangerMode: true,
                buttons: {
                    confirm: "삭제",
                    cancel: {
                        text: "취소",
                        value: null,
                        visible: true,
                        className: "",
                        closeModal: true,
                    },
                },
            }).then((value) => {
                if (value) {

                    $.ajax({
                        url: "/admin/company-delpserson ",
                        method: "POST",
                        data: {company_id: company_data.id, user_id: id},
                        dataType: 'JSON',
                        success: function (res) {
                            if (res.result == 'OK') {
                                companyTable.ajax.reload(null, false);
                                search_usertable.ajax.reload(null, false);
                                iziToast.success({
                                    message: res.msg,
                                    position: 'topRight'
                                });
                                $(btn).closest('tr').remove();

                                if (res.data < 1) {
                                    var td = '<tr id="pserson-onedata-tr"><td colspan="6" style="text-align: center;padding: 30px;" >담당자가 없습니다</td></tr>'
                                    $("#person_tbody").append(td)
                                }

                            } else {
                                iziToast.warning({
                                    message: res.msg,
                                    position: 'topRight'
                                });
                            }
                        },
                        error: function (err) {
                            ajaxError(err)
                        }
                    });

                }
            })
        }

        // 우편번호 찾기 화면을 넣을 element
        var element_layer = document.getElementById('daumPost');

        function closeDaumPostcode() {
            // iframe을 넣은 element를 안보이게 한다.
            element_layer.style.display = 'none';
        }

        function execDaumPostcode() {
            new daum.Postcode({
                oncomplete: function (data) {
                    // 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.

                    // 각 주소의 노출 규칙에 따라 주소를 조합한다.
                    // 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
                    var addr = ''; // 주소 변수
                    var extraAddr = ''; // 참고항목 변수

                    //사용자가 선택한 주소 타입에 따라 해당 주소 값을 가져온다.
                    if (data.userSelectedType === 'R') { // 사용자가 도로명 주소를 선택했을 경우
                        addr = data.roadAddress;
                    } else { // 사용자가 지번 주소를 선택했을 경우(J)
                        addr = data.jibunAddress;
                    }

                    // 사용자가 선택한 주소가 도로명 타입일때 참고항목을 조합한다.
                    if (data.userSelectedType === 'R') {
                        // 법정동명이 있을 경우 추가한다. (법정리는 제외)
                        // 법정동의 경우 마지막 문자가 "동/로/가"로 끝난다.
                        if (data.bname !== '' && /[동|로|가]$/g.test(data.bname)) {
                            extraAddr += data.bname;
                        }
                        // 건물명이 있고, 공동주택일 경우 추가한다.
                        if (data.buildingName !== '' && data.apartment === 'Y') {
                            extraAddr += (extraAddr !== '' ? ', ' + data.buildingName : data.buildingName);
                        }
                        // 표시할 참고항목이 있을 경우, 괄호까지 추가한 최종 문자열을 만든다.
                        if (extraAddr !== '') {
                            extraAddr = ' (' + extraAddr + ')';
                        }
                        // 조합된 참고항목을 해당 필드에 넣는다.
                        document.getElementById("address1").value = extraAddr;

                    } else {
                        document.getElementById("address1").value = '';
                    }

                    // 우편번호와 주소 정보를 해당 필드에 넣는다.
                    // document.getElementById('sample2_postcode').value = data.zonecode;
                    document.getElementById("address1").value = addr + extraAddr;
                    // 커서를 상세주소 필드로 이동한다.
                    document.getElementById("address1").focus();

                    // iframe을 넣은 element를 안보이게 한다.
                    // (autoClose:false 기능을 이용한다면, 아래 코드를 제거해야 화면에서 사라지지 않는다.)
                    element_layer.style.display = 'none';
                },
                width: '100%',
                height: '100%',
                maxSuggestItems: 5
            }).embed(element_layer);

            // iframe을 넣은 element를 보이게 한다.
            element_layer.style.display = 'block';

            // iframe을 넣은 element의 위치를 화면의 가운데로 이동시킨다.
            initLayerPosition();
        }

        // 브라우저의 크기 변경에 따라 레이어를 가운데로 이동시키고자 하실때에는
        // resize이벤트나, orientationchange이벤트를 이용하여 값이 변경될때마다 아래 함수를 실행 시켜 주시거나,
        // 직접 element_layer의 top,left값을 수정해 주시면 됩니다.
        function initLayerPosition() {
            var width = 400; //우편번호서비스가 들어갈 element의 width
            var height = 480; //우편번호서비스가 들어갈 element의 height
            var borderWidth = 1; //샘플에서 사용하는 border의 두께

            // 위에서 선언한 값들을 실제 element에 넣는다.
            element_layer.style.width = width + 'px';
            element_layer.style.height = height + 'px';
            element_layer.style.border = borderWidth + 'px solid';
            // 실행되는 순간의 화면 너비와 높이 값을 가져와서 중앙에 뜰 수 있도록 위치를 계산한다.
            element_layer.style.left = (((window.innerWidth || document.documentElement.clientWidth) - width) / 2 - borderWidth) + 'px';
            element_layer.style.top = (((window.innerHeight || document.documentElement.clientHeight) - height) / 2 - borderWidth) + 'px';
        }

    </script>
    @include('admin.company.template')
@stop
