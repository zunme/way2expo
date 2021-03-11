// TODO : 모듈화 필요
/* elements */
const channelBtnEl = $('#channelBtn');
const videoInputSelect = $("#videoInputSelect");
const audioInputSelect = $("#audioInputSelect");
const chatLogDiv = $("#chatLogDiv");
const viewersDiv = $("#viewersDiv");
const chatMsg = $("#chatMsg");
const sendMessageBtn = $("#sendMessageBtn");
const resolutionText = $("#resolutionText");
const autoScrollBtn = $("#autoScrollBtn");
const scrollDownIcon = $("#chatLogDownIcon");
const scrollView = $("#live-comment-inner");
const clearChatBtn = $("#clearChatBtn");
const userViewCountText = $("#userViewCount");
const totalViewCountText = $("#totalViewCount");
const likeCountText = $("#likeCount");
const screenShareBtn = $("#screenShareBtn");
const viewerModeBtn = $("#viewerModeBtn");

/* variables */
let cameraList = [];
let micList = [];
let bannedList = [];
let isConnected = false;
let captured = false;
let isReady = false;
let isSaveLog = false;

const waitScrollTime = 5000;
let isScrollDivMouseEnter = false;
let isScrolling = false;
let isMovedScroll = false;
let onAutoScroll = true;
let autoScrollLoop;

let userViewCount = 0;
let totalViewCount = 0;
let likeCount = 0;
let remon;
let myChannelId;
let myLiveId;
let generateThumb = true;
let thumbLoop;
let thumbLoopTime = 60000;

const screenShareOptipon = {
    width: '1920',
    height: '1080',
    frameRate: 30,
    maxBandwidth: 4000,
};

const listener = {
    onComplete() {
        // join message
        var msgItem = document.createElement("p");
        msgItem.className = "chatText join";
        msgItem.innerHTML = `<span class="badge badge-black">${new Date().toLocaleString()}</span>`;
        chatLogDiv.append(msgItem);
        remon.muteLocalAudio(false);
        generateThumb = true;
        if (generateThumb) {
            capture();
            thumbLoop = setInterval(function () {
                capture();
            }, thumbLoopTime);
        }
    },
    onDisconnectChannel() {
        if (isConnected) endCast();
    },
    onClose() {
        if (isConnected) endCast();
    },
    onRoomEvent(msg) {
    },
    onError(error) {
        console.log(`EVENT FIRED: onError:`, error);
        if (error.replace(/[^0-9]/g, "") === "4182") {
            showGuidePop('카메라/오디오 장치를 확인해주세요.');
        }
        if (error.replace(/[^0-9]/g, "") === "2370") {
            Swal2.fire({
                text: 'LIVE 방송이 강제 종료 되었습니다.',
                icon: 'error',
                showConfirmButton: true,
            });
        }
        endCast();
    },
    onStat(result) {
        if (isConnected) {
            // statPanel.innerHTML = "";
            // Object.keys(result).map(value => {
            //     statPanel.innerHTML = statPanel.innerHTML + value + " = " + result[value] + "<br>";
            // })
            resolutionText.textContent = result.remoteFrameWidth + 'x' + result.remoteFrameHeight;
        }

        // console.log(`EVENT FIRED: onStat:`, result);
        // if (isConnected) {
        //     statPanel.innerHTML = "";
        //     Object.keys(result).map(value => {
        //         statPanel.innerHTML = statPanel.innerHTML + value + " = " + result[value] + "<br>";
        //     })
        //     frameRateText.textContent = 'nowLocalFrameRate: ' + result.nowLocalFrameRate;
        // }
    },
    onMessage(msg) {
        addMesssage(false, msg);
    }
};

function autoScroll(isOn) {
    if (isOn) {
        autoScrollMouseEvent(true);
    } else {
        $(".live-comment-inner").unbind();
        autoScrollBtn.unbind('click');
        autoScrollMouseEvent(false);
    }
}

function autoScrollMouseEvent(isOn) {
    if (isOn) {
        $(".live-comment-inner").on('mousewheel', function (e) {
            isScrolling = true;
            onAutoScroll = false;
            isMovedScroll = true;
            if (isScrollDivMouseEnter) return;
            waitAutoScrollTime();
        });
    } else {
        $(".live-comment-inner").unbind();
    }

}

function waitAutoScrollTime() {
    clearTimeout(autoScrollLoop);
    autoScrollLoop = setTimeout(function () {
        isScrolling = false;
        onAutoScroll = true;
        $('.live-comment-inner').scrollTop($('#chatLogDiv')[0].scrollHeight);
        scrollDownIcon.hide();
    }, waitScrollTime);
}

/* Devices */
async function getDevices() {
    Swal2.fire({
        allowOutsideClick: false,
        allowEscapeKey: false,
        allowEnterKey: false,
        stopKeydownPropagation: false,
        html: '장치 정보를 가져오는 중...',
        didOpen: () => {
            Swal2.showLoading()
        },
        didClose() {
            Swal2.hideLoading()
        },
        willClose: () => {
        }
    }).then((result) => {
        /* Read more about handling dismissals below */
        if (result.dismiss === Swal.DismissReason.timer) {
            console.log('I was closed by the timer')
        }
    });
    try {
        var getMedia = await navigator.mediaDevices.getUserMedia({audio: true, video: true})
            .then(function (stream) {
                isReady = true;
                window.localStream = stream;
                Swal2.close();
            })
            .catch(function (err) {
                showGuidePop('카메라/오디오 장치를 확인해주세요.');
            });
        if (isReady) {
            localStream.getTracks().forEach((track) => {
                track.stop();
            });
            var devices = await navigator.mediaDevices.enumerateDevices()
                .then(devices => {
                    const deviceIds = devices.filter(d => {
                        return d.deviceId !== ''
                    });
                    const microphones = deviceIds.filter(d => d.kind === 'audioinput');
                    const cameras = deviceIds.filter(d => d.kind === 'videoinput');
                    if (deviceIds.length < 1) {
                        showGuidePop('카메라/오디오 장치를 확인해주세요.');
                    }
                    for (let i = 0; i < deviceIds.length; i++) {
                        let device = deviceIds[i];
                        if (device.kind === 'videoinput') {
                            cameraList.push({text: device.label, id: device.deviceId})
                        } else if (device.kind === 'audioinput') {
                            micList.push({text: device.label, id: device.deviceId})
                        }
                    }
                    for (let i = 0; i < cameraList.length; i++) {
                        const videoInputOption = document.createElement('option');
                        videoInputOption.value = cameraList[i].id;
                        videoInputOption.text = cameraList[i].text ? cameraList[i].text : ("Device " + cameraList[i].id);
                        videoInputSelect.append(videoInputOption);
                    }
                    for (let i = 0; i < micList.length; i++) {
                        const audioInputOption = document.createElement('option');
                        audioInputOption.value = micList[i].id;
                        audioInputOption.text = micList[i].text ? micList[i].text : ("Device " + micList[i].id);
                        audioInputSelect.append(audioInputOption);
                    }
                    channelBtnEl.prop('disabled', false);
                    $('.selectpicker').selectpicker('refresh');
                    $('#videoInputSelect').on('changed.bs.select', function (e) {
                        config.media.video.deviceId = e.target.value;
                    });
                    $('#audioInputSelect').on('changed.bs.select', function (e) {
                        console.log(e.target.value)
                        config.media.audio.deviceId = e.target.value;
                    });

                });
        }
    } catch (err) {
        showGuidePop('카메라/오디오 장치를 확인해주세요.')
    }
}

function setDisplay(isCasting) {
    if (isCasting) {
        isConnected = true;

        viewerModeBtn.attr('href', '/live/view/' + booth_id + '?caster=1');
        viewerModeBtn.show();

        channelBtnEl.text('LIVE 종료');
        chatMsg.prop('disabled', false);
        sendMessageBtn.prop('disabled', false);
        autoScrollBtn.prop('disabled', false);

        autoScroll(true);

        const ele = document.getElementById('live-comment-inner');
        let pos = {top: 0, left: 0, x: 0, y: 0};

        const mouseDownHandler = function (e) {
            // Change the cursor and prevent user from selecting the text
            ele.style.cursor = 'grabbing';
            pos = {
                // The current scroll
                left: ele.scrollLeft,
                top: ele.scrollTop,
                // Get the current mouse position
                x: e.clientX,
                y: e.clientY,
            };
            clearTimeout(autoScrollLoop);
            isScrolling = true;

            document.addEventListener('mousemove', mouseMoveHandler);
            document.addEventListener('mouseup', mouseUpHandler);
        };
        const mouseMoveHandler = function (e) {
            // How far the mouse has been moved
            const dx = e.clientX - pos.x;
            const dy = e.clientY - pos.y;

            // Scroll the element
            ele.scrollTop = pos.top - dy;
            ele.scrollLeft = pos.left - dx;
            isMovedScroll = true;
        };
        const mouseUpHandler = function () {
            isScrolling = false;

            ele.style.cursor = 'grab';
            document.removeEventListener('mousemove', mouseMoveHandler);
            document.removeEventListener('mouseup', mouseUpHandler);
            if (onAutoScroll) waitAutoScrollTime();
        };

        ele.addEventListener('mousedown', mouseDownHandler);
        clearChatBtn.prop('disabled', false);
        clearChatBtn.on('click', function () {
            chatLogDiv.empty();
        });

        // $('#live-manage-tab li:nth-child(2) a').removeClass('disabled')
        // $('#live-manage-tab li:nth-child(2) a').prop('disabled', false)
        // $('#live-manage-tab li:nth-child(2) a').tab('show');

        $(window).bind('beforeunload', function () {
            if (isConnected) endCast();
            return '';
        });
        scrollDownIcon.on('click', function () {
            $('.live-comment-inner').scrollTop($('#chatLogDiv')[0].scrollHeight);
            scrollDownIcon.hide();
        })
        $(".live-comment-inner").scroll(function () {
            if (chatLogDiv.height() - $(this).scrollTop() <= $(this).height()) {
                scrollDownIcon.hide();
            }
        });
        autoScrollBtn.on('click', function () {
            onAutoScroll = !onAutoScroll;
            autoScrollBtn.toggleClass('btn-warning btn-black');
            if (onAutoScroll) {
                scrollDownIcon.hide();
                clearTimeout(autoScrollLoop);
                $('.live-comment-inner').scrollTop($('#chatLogDiv')[0].scrollHeight);
            }
            autoScrollMouseEvent(onAutoScroll);
        });
        viewersDiv.empty();
        if (bannedList.length > 0) {
            let bannedTypeArr = [];
            bannedTypeArr['C'] = {text: '채팅해제', cmd: 'unblock', icon: 'speaker_notes_off'};
            bannedTypeArr['B'] = {text: '강퇴해제', cmd: 'unban', icon: 'not_interested'};

            for (let i = 0; i < bannedList.length; i++) {
                let bannedIconText;
                let bannedType = bannedList[i].banned_type;

                bannedIconText = bannedTypeArr[bannedType].icon;
                var viewerItem = `
                        <div class="m-0 text-center viewer-dropdown-menu" data-search-term="${bannedList[i].name}">
                            <i class="material-icons text-danger">${bannedIconText}</i>
                            <button type="button" class="btn btn-sm btn-outline btn-block m-0 mb-1 p-0  dropdown-toggle"
                                data-key="${bannedList[i].key}"
                                data-toggle="dropdown"
                                aria-haspopup="true"
                                aria-expanded="false">
                                    ${bannedList[i].name}</button>

                            <div class="dropdown-menu"
                                 aria-labelledby="dropdownMenuButton"
                                 role="menu">
                                    <button type="button" class="dropdown-item ban" onclick="sendCmd(this, '${(bannedType === 'B') ? bannedTypeArr[bannedType].cmd : 'ban'}')">${(bannedType === 'B') ? bannedTypeArr[bannedType].text : '강제퇴장'}</button>
                                    <button type="button" class="dropdown-item block" onclick="sendCmd(this, '${(bannedType === 'C') ? bannedTypeArr[bannedType].cmd : 'block'}')">${(bannedType === 'C') ? bannedTypeArr[bannedType].text : '채팅잠금'}</button>
                            </div>
                        </div>
                    `;
                var child = viewersDiv.append(viewerItem).children("div:last-child");
                userDropDownEvent()

                // if(bannedList[i].banned_type === 'C'){
                //     if (bannedList[i].memo !== 'null' || bannedList[i].memo !== '') {
                //         child.find('.ban').append(`<small>(${bannedList[i].memo})</small>`)
                //     }
                // }
            }
            viewersDiv.prepend(`<p>bannedList</p>`)
            viewersDiv.append('<hr>')
        }

        screenShareBtn.show();
        screenShareBtn.on('click', function () {
            captured = !captured;
            screenShareBtn.toggleClass('btn-info btn-danger');
            screenShareBtn.text((!captured) ? '화면 공유 켜기' : '화면 공유 끄기');
            remon.captureScreen(0, 0, 0, false)
            (captured) ? remon.captureScreen(screenShareOptipon.width, screenShareOptipon.height, screenShareOptipon.frameRate, false) : remon.stopCaptureScreen();
        })
        totalViewCount = 0;
        totalViewCountText.text(totalViewCount);
        userViewCount = 0;
        userViewCountText.text(userViewCount);
        likeCount = 0;
        likeCountText.text(likeCount);
    } else {
        isConnected = false;
        myChannelId = "";
        myLiveId = "";

        // viewersDiv.empty();
        // chatLogDiv.empty();
        channelBtnEl.text('LIVE 시작');

        viewerModeBtn.hide();
        chatMsg.prop('disabled', true);
        sendMessageBtn.prop('disabled', true);
        autoScrollBtn.prop('disabled', true);
        autoScroll(false);

        // clearChatBtn.prop('disabled', true);
        // clearChatBtn.unbind();

        // totalViewCount = 0;
        // totalViewCountText.text(totalViewCount);
        // userViewCount = 0;
        // userViewCountText.text(userViewCount);
        // likeCount = 0;
        // likeCountText.text(likeCount);

        // $('#live-manage-tab li:nth-child(2) a').addClass('disabled')
        // $('#live-manage-tab li:nth-child(2) a').prop('disabled', true)
        // $('#live-manage-tab li:nth-child(1) a').tab('show');

        $(window).unbind('beforeunload');
        scrollDownIcon.unbind();
        $(".live-comment-inner").unbind();
        autoScrollBtn.unbind();
        screenShareBtn.unbind();
        screenShareBtn.hide();
    }
    channelBtnEl.toggleClass('btn-danger btn-warning');
}

function startCast() {
    if (!isReady) {
        Swal2.fire({
            text: `카메라/오디오 장치를 확인해주세요.`,
            icon: 'error',
            allowOutsideClick: false,
            showConfirmButton: true,
            confirmButtonText:
                '가이드 보기',
            cancelButtonText:
                '닫기',
            didOpen: () => {
                Swal2.hideLoading()
            },
        });
    }

    if (isConnected) {
        endCast();
    } else {
        $.ajax({
            type: 'POST',
            url: "/live/create",
            data: {expo_id: expo_id, booth_id: booth_id},
            dataType: "JSON",
            success: function (res) {
                myLiveId = res.data.live.id;
                myChannelId = res.data.live.full_channel_id;
                bannedList = res.data.bannedUsers;
                remon = new Remon({config, listener});
                remon.createCast(myChannelId);
                setDisplay(true);
            },
        });
    }
}

function endCast() {
    if (isConnected) {
        isConnected = false;
        $.post('/live/close', {live_id: myLiveId}).done(function () {
            remon.close();
            setDisplay(false)
        });
        generateThumb = false;
        clearInterval(thumbLoop);
    }
}

function addMesssage(isMine, body) {
    try {
        var data = JSON.parse(body.replace(/&quot;/g, '\"'));
        if (data.command === 'onMessage' || data.command === 'message') {
            var msgContainer = document.createElement("div");
            msgContainer.className = "d-flex justify-content-between";

            var msgItem = document.createElement("div");
            msgItem.className = "chatText"

            data.body = decodeURIComponent(data.body)
            data.body = data.body.replace(/&#x2F;&quot;/g, '"').replace(/&#x2F;&#39;/g, "'")

            if (isSaveLog)
                saveLogs(data);
            if (isMine) {
                msgItem.innerHTML = `<span class="badge badge-black">Me</span> ` + data.body;
            } else {
                var message;
                if (data.sender.type === 'manager') {
                    message = `
                        <span class="badge badge-real-black chatName">${data.sender.name} (담당자)</span>
                        <span>${data.body}</span>
                `;
                } else {
                    message = `
                        <span class="badge badge-real-black chatName dropdown-toggle" data-toggle="dropdown" data-key="${data.sender.key}" aria-haspopup="true">${data.sender.name}</span>
                        <div class="dropdown-menu"
                             aria-labelledby="dropdownMenuButton"
                             role="menu">
                            <button type="button" class="dropdown-item ban" onclick="sendCmd(this, 'ban')">강제퇴장</button>
                            <button type="button" class="dropdown-item block" onclick="sendCmd(this, 'block')">채팅잠금</button>
                        </div>
                        <span>${data.body}</span>
                `;
                }
                msgItem.innerHTML = message;
            }

            msgContainer.appendChild(msgItem);
            msgContainer.innerHTML += `<small>${getChatTextTime()}</small>`;
            chatLogDiv.append(msgContainer);
            if (onAutoScroll) {
                $('.live-comment-inner').scrollTop($('#chatLogDiv')[0].scrollHeight);
            } else {
                if (scrollDownIcon.css('display') === 'block') {
                    scrollDownIcon.fadeOut(100).fadeIn(100);
                } else {
                    scrollDownIcon.fadeIn(100);
                }
            }
            userDropDownEvent();


        }
        if (data.command === 'join') {
            totalViewCount++;
            totalViewCountText.text(totalViewCount);
            if (data.sender.name === 'guest' && data.sender.key === 'guestUser') return;
            userViewCount++;
            userViewCountText.text(userViewCount);

            // join message
            var msgItem = document.createElement("div");
            msgItem.className = "chatText join";
            msgItem.innerHTML = `<span class="badge badge-real-black">${data.sender.name} 님이 입장하였습니다.</span>`;
            chatLogDiv.append(msgItem);

            if (onAutoScroll) {
                $('.live-comment-inner').scrollTop($('#chatLogDiv')[0].scrollHeight);
            } else {
                if (scrollDownIcon.css('display') === 'block') {
                    scrollDownIcon.fadeOut(100).fadeIn(100);
                } else {
                    scrollDownIcon.fadeIn(100);
                }
            }
            addViewer(data);
        }
        if (data.command === 'addlike') {
            likeCountText.text(data.body);
        }
    } catch (e) {
        console.error(e);
    }
}

function addViewer(data) {
    let isExist = false;
    let updateItem;
    let bannedIconText;
    let bannedType = data.sender.banned_type;
    let bannedTypeArr = [];
    bannedTypeArr['C'] = {text: '채팅해제', cmd: 'unblock', icon: 'speaker_notes_off'};
    bannedTypeArr['B'] = {text: '강퇴해제', cmd: 'unban', icon: 'not_interested'};
    bannedIconText = (bannedType == null || bannedType === 'U') ? '' : bannedTypeArr[bannedType].icon;

    // update
    $('#viewersDiv [data-key]').each(function () {
        if ($(this).data('key') === parseInt(data.sender.key)) {
            isExist = true;
            updateItem = $(this);
            return false;
        }
    });

    if (isExist) {
        let dropDownDiv = updateItem.siblings('.dropdown-menu')
        let bannedIcon = updateItem.siblings('.material-icons');
        let blockBtn = dropDownDiv.find('.block')

        if (bannedType === 'C') {
            blockBtn.text(bannedTypeArr[bannedType].text);
            blockBtn.attr('onclick', `sendCmd(this,'${bannedTypeArr[bannedType].cmd}')`);
            bannedIcon.text(bannedIconText);
        }
        return;
    }

    var viewerItem = `
                        <div class="m-0 text-center" data-search-term="${data.sender.name}">
                            <i class="material-icons text-danger">${bannedIconText}</i>
                            <button type="button" class="btn btn-sm btn-outline btn-block m-0 mb-1 p-0  dropdown-toggle"
                                data-key="${data.sender.key}"
                                data-toggle="dropdown"
                                aria-haspopup="true"
                                aria-expanded="false">
                                    ${data.sender.name}</button>

                            <div class="dropdown-menu"
                                 aria-labelledby="dropdownMenuButton"
                                 role="menu">
                                    <button type="button" class="dropdown-item ban" onclick="sendCmd(this, 'ban')">강제퇴장</button>
                                    <button type="button" class="dropdown-item block" onclick="sendCmd(this, 'block')">채팅잠금</button>
                            </div>
                        </div>
                    `;


    var child = viewersDiv.append(viewerItem).children("div:last-child");

    if (bannedType === 'C') {
        var blockBtn = child.find('.block');
        blockBtn.text(bannedTypeArr[bannedType].text);
        blockBtn.attr('onclick', `sendCmd(this,'${bannedTypeArr[bannedType].cmd}')`);
        blockBtn.siblings('material-icons').text(bannedIconText);
    }
    userDropDownEvent();
}

function saveLogs(data) {
    var messageRef = db.collection('RemoteMonster').doc(myChannelId).collection('messages');

    messageRef.add({
        user_id: data.sender.key,
        msg: data.body,
        createdAt: firebase.firestore.Timestamp.now()
    })
        .then(function (docRef) {
        })
        .catch(function (error) {
            console.error("Error adding document: ", error);
        });
}

window.sendMessage = function (msg) {
    if (!isConnected) {
        Swal2.fire({
            text: 'LIVE 방송 중이 아닙니다.',
            icon: 'error',
            showConfirmButton: true,
        });
        return;
    }
    if (chatMsg.val()) {
        msg = chatMsg.val();
        chatMsg.val('');
    } else {
        return;
    }
    payload.command = 'message';
    payload.body = encodeURIComponent(escapeHtml(badWordfilter(msg, true)));
    var body = JSON.stringify(payload);
    remon.sendMessage(body);
    addMesssage(true, body);
}
window.sendCmd = async function (ele, cmd) {
    let dropdownItem = $(ele);

    let btn = $(dropdownItem).parent().siblings('.dropdown-toggle');
    let userKey = $(btn).data('key');
    let userName = $.trim($(btn).text());
    let viewerItem = viewersDiv.find(`[data-key=${userKey}]`);
    let icon = $(viewerItem).siblings('.material-icons');

    let cmdArr = [];
    cmdArr['ban'] = {text: '강제퇴장', cmd: 'unban', enumText: 'B', icon: 'not_interested', setTextClass: 'ban'};
    cmdArr['unban'] = {text: '강제퇴장해제', cmd: 'ban', enumText: 'U', icon: '', setTextClass: 'ban'};
    cmdArr['block'] = {text: '채팅잠금', cmd: 'unblock', enumText: 'C', icon: 'speaker_notes_off', setTextClass: 'block'};
    cmdArr['unblock'] = {text: '채팅해제', cmd: 'block', enumText: 'U', icon: '', setTextClass: 'block'};

    payload.command = cmd;
    payload.target.key = userKey;
    payload.booth_id = booth_id;

    if (cmd === 'ban') {
        const {value: text} = await Swal2.fire({
            input: 'textarea',
            inputLabel: '메모',
            inputPlaceholder: '',
            inputAttributes: {
                'aria-label': 'Type your message here'
            },
            showConfirmButton: true
        })

        if (text) {
            payload.target.memo = text;
        }
    }
    $.ajax({
        type: 'POST',
        url: "/live/commands",
        data: payload,
        dataType: "JSON",
        success: function (res) {
            icon.text(cmdArr[cmd].icon);
            bannedList = bannedList.filter(function (obj) {
                return obj.key !== userKey;
            });
            bannedList.push({
                banned_type: cmdArr[cmd].enumText,
                name: userName,
                key: userKey,
                memo: payload.target.memo
            });
            if (isConnected)
                remon.sendMessage(JSON.stringify(payload));
        }
    });

    // Swal2.fire({
    //     text: `${userName} 님을 ${cmdArr[cmd].text} 하시겠습니까?`,
    //     icon: 'warning',
    //     showConfirmButton: true,
    //     showCancelButton: true,
    // }).then(function (value) {
    //     if (value.isConfirmed) {
    //
    //     }
    // });
}

function userDropDownEvent() {
    $('.viewers,.chatText').unbind('show.bs.dropdown');
    $('.viewers,.chatText').on('show.bs.dropdown', function (e) {
        let button = $(e.relatedTarget);
        let userKey = button.data('key');
        let menu = button.siblings('.dropdown-menu');
        let bannedItem = bannedList.find(x => x.key === userKey);
        // Change Menu
        if (typeof bannedItem !== 'undefined') {
            if (bannedItem.banned_type === 'B') {
                menu.find('.ban').attr('onclick', `sendCmd(this,'unban')`);
                menu.find('.ban').text('강퇴해제');
                menu.find('.block').attr('onclick', `sendCmd(this,'block')`);
                menu.find('.block').text('채팅차단');
                if (bannedItem.memo != null) menu.find('.ban').append(`<small>(${bannedItem.memo})</small>`);
            }
            if (bannedItem.banned_type === 'C') {
                menu.find('.ban').attr('onclick', `sendCmd(this,'ban')`);
                menu.find('.ban').text('강제퇴장');
                menu.find('.block').attr('onclick', `sendCmd(this,'unblock')`);
                menu.find('.block').text('채팅해제');
                menu.find('.ban small').remove();
            }
            if (bannedItem.banned_type === 'U') {
                menu.find('.ban').attr('onclick', `sendCmd(this,'ban')`);
                menu.find('.ban').text('강제퇴장');
                menu.find('.block').attr('onclick', `sendCmd(this,'block')`);
                menu.find('.block').text('채팅차단');
                menu.find('.ban small').remove();
            }
        }
    })
}

function capture() {
    var canvas = document.createElement('canvas');
    var video = document.getElementById('localVideo');
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;

    var context = canvas.getContext('2d');
    context.drawImage(video, 0, 0, video.videoWidth, video.videoHeight);
    var imgsrc = canvas.toDataURL("image/jpg");

    $.ajax({
        type: 'POST',
        url: "/live/thumb",
        data: {channel_id: myChannelId, imgBase64: canvas.toDataURL()},
    });
}

function getChatTextTime() {
    var now = new Date();

    return moment(now).format("a hh:mm");
}

function showGuidePop(msg) {
    Swal2.fire({
        text: msg,
        icon: 'error',
        allowOutsideClick: false,
        showConfirmButton: true,
        showCancelButton: true,
        confirmButtonText:
            '가이드 보기',
        cancelButtonText:
            '이전으로',
        didOpen: () => {
            Swal2.hideLoading()
        },
    }).then(function (value) {
        console.log(value)
        if (value.isConfirmed) {
        }

        if (value.isDismissed) {
            window.history.back(-1);
        }
    });


}

$(function () {

    getDevices();
    /* event */
    $(channelBtnEl).on('click', function () {
        startCast();
    });
    $(window).on('beforeunload', function () {
        // return '';
    });
});
