var W2EPC = W2EPC || {};
W2EPC.modules = {};
let isAjaxError = false;
window.history.scrollRestoration = 'auto';
toastr.options = {
    closeButton: true,
    progressBar: true,
    positionClass: "toast-top-center",
    showMethod: 'slideDown',
};
toastr.subscribe(function (args) {
    if (args.state === 'visible') {
        var toasts = $("#toast-container > *:not([hidden])");
        if (toasts && toasts.length > 3)
            toasts[0].hidden = true;
    }
});

Swal2 = Swal.mixin({
    toast: false,
    customClass: {
        confirmButton: 'btn btn-sm btn-success',
        cancelButton: 'btn btn-sm btn-black'
    },
    confirmButtonText: '확인',
    cancelButtonText: '취소',
    buttonsStyling: false,
    position: 'center',
    showConfirmButton: false,
    // timer: 3000,
    // timerProgressBar: true,
    didOpen: function (toast) {
        // toast.addEventListener('mouseenter', Swal2.stopTimer)
        // toast.addEventListener('mouseleave', Swal2.resumeTimer)
    }
})
window.confirmPopup = function (msg, icon, callback, addOptions) {
    var options = {
        toast: false,
        html: msg,
        position: 'center',
        showConfirmButton: true,
        // showClass: {
        //     popup: 'swal2-noanimation',
        //     backdrop: 'swal2-noanimation'
        // },
        // hideClass: {
        //     popup: '',
        //     backdrop: ''
        // },
        // timer: 3000,
        icon: icon,
        // timerProgressBar: true,
        didOpen: function (toast) {
            // toast.addEventListener('mouseenter', Swal2.stopTimer)
            // toast.addEventListener('mouseleave', Swal2.resumeTimer)
        }
    }
    if (typeof addOptions !== 'undefined') {
        options = _.merge(options, addOptions)
    }
    var swal = Swal2.fire(options);

    if (typeof callback !== 'undefined') {
        swal.then(function (value) {
            callback(value);
        });
    }
}

window.notificationPopup = function (e) {
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": "toast-top-right notification",
        "preventDuplicates": false,
        "onclick": function () {
            let arr = e.data.target.split('.');
            let menu = arr[0];
            let method = arr[1];
            if (menu === 'meeting') {
                if (method === 'receive') location.href = '/my/meeting/receive';
                else location.href = '/my/meeting/send';
            }
            $.post('/my/notiupdate');
        },
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "0",
        "extendedTimeOut": "0",
        "showEasing": "swing",
        "hideEasing": "linear",
        "hideMethod": "fadeOut",
    };
    toastr.info(e.data.title, e.data.content);
}
window.toastPopup = function (msg, title) {
    // var options = {
    //     toast: true,
    //     title: msg,
    //     position: 'top',
    //     showCloseButton: true,
    //     icon: icon,
    //     customClass: {container:'swal2-custom-container'},
    // }

    // Swal2.fire(options).then(function (value) {
    // });
    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "3000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };
    toastr.info(msg, title);
}

window.refreshToken = function () {
    $.ajax({
        url: '/refresh',
        method: 'post',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (xhr) {
            $('meta[name="csrf-token"]').attr('content', xhr);
            $('input[name=_token]').val(xhr)
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        }
    })
}

window.pop_tpl = function (size, id, data) {
    if (typeof id == 'undefined') return false;
    var availsize = ['sm', 'lg', 'xl']
    if (!availsize.includes(size)) size = 'default';
    var template = Handlebars.compile($("#" + id).html());
    $("#modal-" + size + "-area").html(template(data));

    $("#modal-" + size).modal('handleUpdate')
    $("#modal-" + size).modal('show')
}

function readCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) === ' ') c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length, c.length);
    }
    return null;
}

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        'X-XSRF-TOKEN': decodeURIComponent(readCookie('XSRF-TOKEN'))
    },
    error: function (x, e) {
        let msg;
        let result;
        let exception;
        isAjaxError = true;
        if (x.responseJSON) {
            msg = x.responseJSON.errors;
            result = x.responseJSON.result;
            exception = x.responseJSON.exception;
        }
        if (x.status === 401) {
            msg = '로그인 후 이용해주세요.';
            Swal2.fire({
                icon: 'error',
                position: 'center',
                text: msg,
                showConfirmButton: true,
                showCancelButton: true,
                confirmButtonText: "로그인",
                customClass: {
                    confirmButton: 'btn btn-sm btn-black',
                    cancelButton: 'btn btn-sm',
                },
            }).then(function (value) {
                if (value.isConfirmed) {
                    window.location.href = '/login';
                }
            });
            return;
        }
        // code x.status
        if (x.status !== 422 && x.status !== 500) {
            alert('잠시후에 이용해주세요');
            console.log(x)
            return;
        }

        if (msg) {
            for (let key in msg) {
                if (msg.hasOwnProperty(key)) {
                    if (key.indexOf('.') < 0) {
                        let node = $('[name=' + key + ']');
                        if (node.length > 0 && typeof node.prop('nodeName') !== 'undefined') {
                            let nodeName = node.prop('nodeName');
                            if(nodeName === 'SELECT'){
                                $('select[name=' + key + ']')[0].focus();
                            }else if(nodeName === 'TEXTAREA'){
                                $('textarea[name=' + key + ']')[0].focus();
                            }
                        }
                    }

                    if ($.isNumeric(key)) {
                        toastr.error(msg);
                    } else {
                        confirmPopup(msg[key][0], 'error');
                    }
                    break;
                }
            }
        } else if (result === 'error') {
            confirmPopup(x.responseJSON.msg, 'error');
        } else {
            Swal2.fire({
                toast: true,
                width: 500,
                position: 'center',
                background: '#f44336',
                title: "<span class='text-white'>시스템 오류입니다</span>",
                showCloseButton: true,
                timer: 3000,
                timerProgressBar: false,
                didOpen: function (toast) {
                    toast.addEventListener('mouseenter', Swal2.stopTimer)
                    toast.addEventListener('mouseleave', Swal2.resumeTimer)
                }

            });
        }
    }
});

Handlebars.registerHelper('isEqual', function (expectedValue, value) {
    return value === expectedValue;
});
Handlebars.registerHelper('isNotEqual', function (expectedValue, value) {
    return value !== expectedValue;
});
Handlebars.registerHelper('checkempty', function (value) {
    if (typeof value == 'undefined') return true;
    if (value === null) return true;
    else if (value === '') return true;
    else return false;
});
Handlebars.registerHelper('checknotempty', function (value) {
    if (typeof value == 'undefined') return false;
    if (value === null) return false;
    else if (value === '') return false;
    else return true;
});
Handlebars.registerHelper('count', function (array) {
    return array.length;
});
Handlebars.registerHelper('gt', function (a, b) {
    return (a > b);
});
Handlebars.registerHelper('gte', function (a, b) {
    return (a >= b);
});
Handlebars.registerHelper('lt', function (a, b) {
    return (a < b);
});
Handlebars.registerHelper('lte', function (a, b) {
    return (a <= b);
});
Handlebars.registerHelper('ne', function (a, b) {
    return (a !== b);
});
Handlebars.registerHelper('addtime', function (time) {
    return parseInt(time) + 1;
});
Handlebars.registerHelper('notificationLink', function (target) {
    let arr = target.split('.');
    let mode = arr[0];
    let type = arr[1];
    if (mode === 'meeting') {
        if (type === 'receive') return '/my/meeting/receive';
        if (type === 'send') return '/my/meeting/send';
        if (type === 'accept' || type === 'deny') return '/my/meeting/send';
    }
    if (mode === 'card') {
        if (type === 'receive') return '/my/exchange/receive';
        if (type === 'send') return '/my/exchange/send';
    }
});
Handlebars.registerHelper('meetingstatus', function (status) {
    if (status == 'R') return '<span class="text-info">승인대기</span>'
    if (status == 'E') return '<span class="">종료</span>'
    if (status == 'D') return '<span class="text-warning">반려</span>'
    if (status == 'A') return '<span class="">종료</span>'
    if (status == 'C') return '<span class="text-danger">취소</span>'
});

Handlebars.registerHelper('nl2br', function (val) {
    var nl2br = (val).replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + '<br>' + '$2');
    return new Handlebars.SafeString(nl2br);
});
Handlebars.registerHelper('json', function (context) {
    return JSON.stringify(context);
});
Handlebars.registerHelper('dateformat', function (val, format) {
    return moment(val).format(format);
});
Handlebars.registerHelper('numberformat', function (val) {
    return new Intl.NumberFormat().format(val);
});


$(function () {
    // setInterval(function () {
    //     axios({
    //         method: 'post',
    //         url: '/refresh',
    //     }).then(function (res) {
    //         $('meta[name="csrf-token"]').attr('content', res.data)
    //         $.ajaxSetup({
    //             headers: {
    //                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //             }
    //         });
    //
    //     });
    //
    // }, 1000 * 60 * 1);
    $(document).on('show.bs.modal', '.modal', function () {
        var zIndex = 1040 + (10 * $('.modal:visible').length);
        $(this).css('z-index', zIndex);
        setTimeout(function () {
            $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
            $(".fixed-top").css("padding-right", "0");
        }, 0);
    });

    $(document).on('hidden.bs.modal', '.modal', function () {
        if ($('.modal:visible').length > 0) {
            $(document.body).addClass('modal-open');
            $('body').css('padding-right', '17px');
            $(".fixed-top").css("padding-right", "17px");
        }
    });

    $(document).ajaxStart(function () {
        $('.btn-ajax').prop('disabled', true);
    })
    $(document).ajaxStop(function () {
        $('.btn-ajax').prop('disabled', false);
    })

    if (navigator.userAgent.match(/iPhone|iPad|iPod/i) != null) {
    }
});
