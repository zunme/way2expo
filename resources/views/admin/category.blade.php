@extends('admin.defaultlayout')
@section('css')
    <style>
        label.striked-text {
            text-decoration: line-through;
        }
    </style>
@endsection
@section('main')
    <div class="section-header">
        <h1>카테고리 관리</h1>
    </div>
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <form role="form" id="category" name="categoryForm">
                        <div class="row">
                            <div class="col-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>카테고리 목록</h4>
                                    </div>
                                    <div class="card-body">
                                        <div id="categoryTree">
                                            <ul id="tree1">
                                                @forelse($categories as $category)
                                                    <li>
                                                        <input type="radio" name="parent_id"
                                                               id="parent_{{ $category->id }}"
                                                               value="{{ $category->id }}" {{($category->display_yn == 'N')?'disabled':''}}>
                                                        <label
                                                            class="{{($category->display_yn == 'N')?'striked-text':''}}"
                                                            for="parent_{{ $category->id }}">[{{$category->full_code}}]
                                                            <span>{{ $category->name }}</span></label>
                                                        @if(($category->display_yn == 'Y'))
                                                            <button type="button"
                                                                    class="btn btn-sm btn-link"
                                                                    data-name="{{$category->name}}"
                                                                    data-id="{{$category->id}}"
                                                                    onclick="editCategory(this)">
                                                                <i class="fas fa-edit"></i>
                                                            </button>
                                                            <button type="button"
                                                                    class="btn btn-sm btn-link"
                                                                    onclick="removeCategory({{$category->id}})">
                                                                <i class="fas fa-times text-danger"></i>
                                                            </button>
                                                        @endif
                                                        <button type="button" class="btn branch float-right">펼치기
                                                        </button>
                                                        <ul class="childs d-none">
                                                            @foreach($category->childs as $child)
                                                                <li>
                                                                    <label
                                                                        for=""
                                                                        class="{{($child->display_yn == 'N')?'striked-text':''}}">[{{$child->full_code}}
                                                                        ] <span>{{ $child->name }}</span></label>
                                                                    <button type="button"
                                                                            class="btn btn-sm btn-link"
                                                                            data-name="{{$child->name}}"
                                                                            data-id="{{$child->id}}"
                                                                            onclick="editCategory(this)">
                                                                        <i class="fas fa-edit"></i>
                                                                    </button>
                                                                    <button type="button"
                                                                            class="btn btn-sm btn-link"
                                                                            onclick="removeCategory({{$child->id}})">
                                                                        <i class="fas fa-times text-danger"></i>
                                                                    </button>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </li>
                                                @empty
                                                    <h6>카테고리 정보가 없습니다.</h6>
                                                @endforelse
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="col-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>카테고리 추가</h4>
                                    </div>
                                    <div class="card-body">
                                        <p class="card-text">최상위 추가는 미 선택 후 입력<br>하위 추가는 해당 카테고리 체크 후 추가</p>
                                        <form name="categoryForm">
                                            <input type="hidden" name="id">
                                            <div class="form-group">
                                                <label>카테고리명:</label>
                                                <input type="text" id="name" name="name" class="form-control"
                                                       placeholder="이름을 입력해주세요.">
                                            </div>
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-success">추가</button>
                                                <button type="button" id="clearCheck" class="btn btn-dark">상위선택해제
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </section>
@endsection
@section('script')
    <script>
        let saveForm = $('form[name=categoryForm]');

        function editCategory(obj) {
            swal({
                text: '변경할 이름을 입력하세요.',
                dangerMode: true,
                content: {
                    element: "input",
                    attributes: {
                        value: $(obj).data('name')
                    }
                },
                buttons: {
                    confirm: {
                        text: "수정",
                        visible: true,
                        className: "",
                    },
                    cancel: {
                        text: "취소",
                        value: null,
                        visible: true,
                        className: "",
                        closeModal: true,
                    },
                },
                closeOnClickOutside: false,
            })
                .then(name => {
                    if (!name) throw null;
                    $.post('/admin/category-add', {id: $(obj).data('id'), name: name}).done(function (res) {
                        $(obj).data('name', name);
                        $(obj).prev('label').find('span').text(name);
                        iziToast.success({
                            message: res.msg,
                            position: 'topRight'
                        });
                    })
                })
                .catch(err => {
                    if (err) {
                        swal("Oh noes!", "The AJAX request failed!", "error");
                    } else {
                        swal.stopLoading();
                        swal.close();
                    }
                });
        }

        function removeCategory(id) {
            swal({
                title: '삭제하시겠습니까?',
                text: '삭제 시 해당 코드는 쓸수 없습니다.',
                icon: 'warning',
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        $.post('/admin/category-remove', {id: id}).done(function () {
                            $('#tree1').find('[data-id=' + id + ']').closest('li').remove();
                        });
                    }
                });
        }

        $(function () {
            $('.branch').on('click', function () {
                let btn = $(this);
                let tree = $(this).closest('li');
                let isExpand = tree.find('ul').hasClass('d-none');
                tree.find('ul').toggleClass('d-none', !isExpand);
                btn.text((isExpand) ? '접기' : '펼치기');
            });
            $('#clearCheck').on('click', function () {
                $('#tree1 input[type=radio]').prop('checked', false);
            });
            saveForm.submit(function (e) {
                e.preventDefault();
                if(($('input[name=name]').val() === '')) return;

                var formData = new FormData(this);
                let text = '최상위 카테고리를 추가하시겠습니까?';
                if(formData.get('parent_id') !== null){
                    text = '상위 카테고리가 선택되어있습니다.\n추가하시겠습니까?';
                }
                swal({
                    text: text,
                    dangerMode: true,
                    icon: 'warning',
                    buttons: {
                        confirm: {
                            text: "추가",
                            visible: true,
                            className: "",
                        },
                        cancel: {
                            text: "취소",
                            value: null,
                            visible: true,
                            className: "",
                            closeModal: true,
                        },
                    },
                    closeOnClickOutside: false,
                })
                    .then(name => {
                        if (!name) throw null;

                        $.ajax({
                            type: 'POST',
                            url: "/admin/category-add",
                            dataType: "JSON",
                            data: formData,
                            contentType: false,
                            cache: false,
                            processData: false,
                            success: function (res) {
                                if (res.data.parent_id > 0) {
                                    let appendHtml = `
                                        <li>
                                            <label
                                                for="">[${res.data.full_code}] <span>${res.data.name}</span></label>
                                            <button type="button"
                                                    class="btn btn-sm btn-link"
                                                    data-name="${res.data.name}"
                                                    data-id="${res.data.id}"
                                                    onclick="editCategory(this)">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button"
                                                    class="btn btn-sm btn-link"
                                                    onclick="removeCategory(${res.data.id})">
                                                <i class="fas fa-times text-danger"></i>
                                            </button>
                                        </li>

                            `;
                                    let list = $('#parent_' + res.data.parent_id).parent('li').find('.childs');
                                    list.append(appendHtml);
                                } else {
                                    window.location.reload();
                                }
                                iziToast.success({
                                    message: res.msg,
                                    position: 'topRight'
                                });

                                $('#name').val('');
                            },
                        });
                    })

            });
        });
    </script>
@stop
