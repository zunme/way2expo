const live = function ($$) {
    /* elements */
    const chatLogDiv = $$("#chatLogDiv");
    const chatMsg = $$("#chatMsg");
    const sendMessageBtn = $$("#sendMessageBtn");
    const autoScrollBtn = $$("#autoScrollBtn");
    const scrollDownIcon = $$("#chatLogDownIcon");
    const scrollView = $$("#live-comment-inner");
    const clearChatBtn = $$("#clearChatBtn");
    const muteBtn = $$("#muteBtn");
    const playBtn = $$("#playBtn");
    const videoPlayer = $$("#remoteVideo");
    const loading = $$("#loading");
    const totalViewCountText = $$("#totalViewCount");
    const likeCountText = $$("#likeCount");
    const likeBtn = $$("#like-btn");

    let isMuted = true;
    let isChatBlock = false;
    let isConnected = false;
    let isBanned = false;
    let isReConnect = false;
    let reConnectCount = 0;

    let onAutoScroll = true;
    const waitScrollTime = 5000;
    let isScrollDivMouseEnter = false;
    let isScrolling = false;
    let isMovedScroll = false;
    let autoScrollLoop;

    let waitingLoop;
    let remon;
    const listener = {
        onComplete() {
            if (!isReConnect) {
                setTimeout(function () {
                    loading.hide();
                }, 700)
                if (payload.sender.type !== 'manager') {
                    payload.command = 'join';
                    var body = JSON.stringify(payload);
                    remon.sendMessage(body);
                    likeCountText.text(likeCount);
                }
                likeCountText.text(likeCount);
                muteBtn.popover('show');
                setDisplay(true);
            }
        },
        onDisconnectChannel() {
            endView();
        },
        onClose() {
            if (!isReConnect) {
                endView();
                Swal2.fire({
                    text: 'LIVE 방송이 종료되었습니다.',
                    icon: 'error',
                    showConfirmButton: true,
                }).then(function () {
                    // window.close();
                });
            }
        },
        onRoomEvent(msg) {
            console.log('onRoomEvent', msg);
        },
        onError(error) {
            if (error.replace(/[^0-9]/g, "") === "2370") {
                endView();
                Swal2.fire({
                    text: 'LIVE 방송이 강제 종료 되었습니다.',
                    icon: 'error',
                    showConfirmButton: true,
                }).then(function () {
                    window.close();
                });
            }
            if (error.replace(/[^0-9]/g, "") === "2031") {
                endView();
                Swal2.fire({
                    text: 'LIVE 방송 중이 아닙니다.',
                    icon: 'error',
                    showConfirmButton: true,
                }).then(function () {
                    window.close();
                });
            }

        },
        onJoin(chid) {
        },
        onStat(result) {
            if (isConnected) {
            }
        },
        onMessage(msg) {
            addMessage(false, msg);
        }
    };

    function endView() {
        isConnected = false;
        clearInterval(waitingLoop);
        if (remon)
            remon.close();
        remon = null;

        autoScrollMouseEvent(false);
        autoScrollBtn.unbind();
        clearChatBtn.unbind();
        scrollDownIcon.unbind();
        scrollView.unbind();
        chatMsg.unbind();
        sendMessageBtn.unbind();
        muteBtn.unbind();
        setDisplay(false);


        function setDisplay(isOn) {
            if (isOn) {
                playBtn.hide();
                loading.fadeIn(300);
                videoPlayer.css('background', '')
                $$(window).bind('beforeunload', function () {
                    // return true;
                });
                videoPlayer.prop('muted', isMuted);
                totalViewCountText.text(totalViewCount);
            } else {
                loading.hide();
                if (!isBanned) playBtn.fadeIn(300);
                chatMsg.prop('disabled', true);
                sendMessageBtn.prop('disabled', true);
                likeBtn.prop('disabled', true);
                chatLogDiv.empty();
            }
        }

    }

    function reconnect() {
        isReConnect = true;
        Swal2.fire({
            text: '네트워크 환경이 원활하지 않아 다시 접속해 주세요.',
            icon: 'info',
            showConfirmButton: true,
        }).then(function () {
            endView();
            window.location.replace(boothUrl);
            window.close();
            return false;
        });
    }

    async function startView() {
        if (isConnected) {
            endView();
        } else {
            remon = new Remon({config, listener});
            remon.joinCast(myChannelId);

        }
    }

    function autoScrollMouseEvent(isOn) {

        if (isOn) {
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

            $$(".live-comment-inner").on('mousewheel', function (e) {
                isScrolling = true;
                onAutoScroll = false;
                isMovedScroll = true;
                if (isScrollDivMouseEnter) return;
                waitAutoScrollTime();
            });
        } else {
            $$(".live-comment-inner").unbind();
        }
    }


    function waitAutoScrollTime() {
        clearTimeout(autoScrollLoop);
        autoScrollLoop = setTimeout(function () {
            isScrolling = false;
            onAutoScroll = true;
            $$('.live-comment-inner').scrollTop($('#chatLogDiv')[0].scrollHeight);
            scrollDownIcon.hide();
        }, waitScrollTime);

    }

    function banned(data) {
        if (data.target.key === parseInt(payload.sender.key)) {
            isBanned = true;
            Swal2.fire({
                text: '차단되었습니다.',
                icon: 'error',
                timer: 3000,
                // timerProgressBar: true,
                didOpen: function (toast) {
                    toast.addEventListener('mouseenter', Swal2.stopTimer)
                    toast.addEventListener('mouseleave', Swal2.resumeTimer)
                }
            }).then(function () {
                window.close();
            });
            endView();
        }
    }

    function blocked(data) {
        if (data.target.key === parseInt(payload.sender.key)) {
            isChatBlock = true;
            $(chatMsg).prop({'disabled': true, 'placeholder': '채팅이 차단되었습니다.'});
            $(sendMessageBtn).prop('disabled', true);
            chatMsg.unbind();
            sendMessageBtn.unbind();
        }
    }

    async function unblock(data) {
        if (data.target.key === parseInt(payload.sender.key)) {
            isChatBlock = false;
            $(chatMsg).prop({'disabled': false, 'placeholder': '메시지 내용...'});
            $(sendMessageBtn).prop('disabled', false);
            chatMsg.keyup(function (e) {
                if (e.keyCode === 13) {
                    sendMessage();
                }
            })
            sendMessageBtn.on('click', function (e) {
                sendMessage();
            });
        }
    }

    function addMessage(isMine, body) {
        try {
            var data = JSON.parse(body.replace(/&quot;/g, '\"'));
            // Add a second document with a generated ID.
            if (data.command === 'onMessage' || data.command === 'message') {
                var msgItem = document.createElement("div");
                msgItem.className = "chatText";

                data.body = decodeURIComponent(data.body)
                data.body = data.body.replace(/&#x2F;&quot;/g, '"').replace(/&#x2F;&#39;/g, "'")
                if (isMine) {
                    msgItem.innerHTML = "나 : " + data.body;
                } else {
                    var message;
                    if (data.sender.type === 'manager') {
                        message = `<span class="text-rose">담당자 : ${data.body}</span>`;
                    } else {
                        message = `${data.sender.name} : ${data.body}`;
                    }
                    msgItem.innerHTML = message;
                }

                chatLogDiv.append(msgItem);
                if (onAutoScroll)
                    $('.live-comment-inner').scrollTop($('#chatLogDiv')[0].scrollHeight);
                if (!onAutoScroll && chatLogDiv.height() >= scrollView.height()) {
                    if (scrollDownIcon.css('display') === 'block') {
                        scrollDownIcon.fadeOut(100).fadeIn(100);
                    } else {
                        scrollDownIcon.fadeIn(100);
                    }
                }

            }
            if (data.command === 'ban') {
                banned(data);
            }
            if (data.command === 'block') {
                blocked(data);
            }
            if (data.command === 'unblock') {
                unblock(data);
            }
            if (data.command === 'addlike') {
                // likeCountText.text(data.body);
            }
            if (data.command === 'join') {
                totalViewCount++;
                totalViewCountText.text(totalViewCount);
                if(data.sender.type !== 'member') return;
                var msgItem = document.createElement("div");
                msgItem.className = "chatText join";
                msgItem.innerHTML = `<span class="badge badge-real-black">${data.sender.name} 님이 입장하였습니다.</span>`;
                chatLogDiv.append(msgItem);
            }
        } catch (e) {
        }
    }

    function sendMessage(msg) {
        if (!isConnected) {
            Swal2.fire({
                text: 'LIVE 방송 중이 아닙니다.',
                icon: 'error',
                showConfirmButton: true,
            });
            return;
        }
        if (isChatBlock) {
            return;
        }
        if (chatMsg.val()) {
            msg = chatMsg.val();
            chatMsg.val('');
        } else {
            return;
        }
        payload.command = 'message';
        payload.body = encodeURIComponent(escapeHtml(badWordfilter(msg,true)));
        var body = JSON.stringify(payload);
        remon.sendMessage(body);
        addMessage(true, body);
    }
    $('#like-btn').on('click', function () {
        pop();
    })

    function pop(e) {
        if (payload.sender.type === 'guest') {
            Swal2.fire({
                text: '로그인 후 이용하세요.',
                icon: 'error',
                showConfirmButton: true,
                timer: 3000,
                // timerProgressBar: true,
                didOpen: function (toast) {
                    toast.addEventListener('mouseenter', Swal2.stopTimer)
                    toast.addEventListener('mouseleave', Swal2.resumeTimer)
                }
            });
            return;
        }
        payload.command = 'addlike';
        payload.live_id = myLiveId;
        $$.ajax({
            type: 'POST',
            url: "/live/commands",
            data: payload,
            dataType: "JSON",
            success: function (res) {
                likeCount = res.data.likeCount;
                payload.body = likeCount;
                remon.sendMessage(JSON.stringify(payload));
                likeCountText.text(likeCount);
            }
        });

    }

    function createParticle(x, y) {
        const particle = document.createElement('particle');
        document.body.appendChild(particle);

        // Calculate a random size from 5px to 25px
        const size = Math.floor(Math.random() * 20 + 5);
        particle.style.width = `${size}px`;
        particle.style.height = `${size}px`;
        // Generate a random color in a blue/purple palette
        particle.style.background = `hsl(${Math.random() * 90 + 180}, 70%, 60%)`;

        // Generate a random x & y destination within a distance of 75px from the mouse
        const destinationX = x + (Math.random() - 0.5) * 2 * 75;
        const destinationY = y + (Math.random() - 0.5) * 2 * 75;

        // Store the animation in a variable as we will need it later
        const animation = particle.animate([
            {
                // Set the origin position of the particle
                // We offset the particle with half its size to center it around the mouse
                transform: `translate(-50%, -50%) translate(${x}px, ${y}px)`,
                opacity: 1
            },
            {
                // We define the final coordinates as the second keyframe
                transform: `translate(${destinationX}px, ${destinationY}px)`,
                opacity: 0
            }
        ], {
            // Set a random duration from 500 to 1500ms
            duration: Math.random() * 1000 + 500,
            easing: 'cubic-bezier(0, .9, .57, 1)',
            // Delay every particle with a random value of 200ms
            delay: Math.random() * 200
        });

        // When the animation is complete, remove the element from the DOM
        animation.onfinish = () => {
            particle.remove();
        };
    }

    function showAgree(){
        pop_tpl('lg', 'template-live-agree', null);
        let form = $$('form[name=agreeForm]');
        form.submit(function (e) {
            e.preventDefault();
            form.closest('.modal').modal('hide');
            playBtn.click();
        });
    }

    return {
        init:function(){
            showAgree();
            autoScrollMouseEvent(true)
            playBtn.on('click', function () {
                $$(this).hide();
                startView();
            });
            if (payload.sender.banned_type === 'B') {
                endView();
                Swal2.fire({
                    text: '차단되었습니다.',
                    icon: 'error',
                    showConfirmButton: true,
                    timer: 3000,
                    // timerProgressBar: true,
                    didOpen: function (toast) {
                        toast.addEventListener('mouseenter', Swal2.stopTimer)
                        toast.addEventListener('mouseleave', Swal2.resumeTimer)
                    }

                }).then(function () {
                    window.close();
                });
            } else {
                // startView();
            }
            if (payload.sender.banned_type === 'C') {
                isChatBlock = true;
                $$(chatMsg).prop({'disabled': true, 'placeholder': '채팅이 차단되었습니다.'});
                $$(sendMessageBtn).prop('disabled', true);
            }
        }
    }
}(jQuery);

$(function () {
    live.init();
});
