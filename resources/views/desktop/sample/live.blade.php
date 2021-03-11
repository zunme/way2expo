<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="/assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="/assets/img/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>
        {{ env('APP_NAME') }}
    </title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name=”robots” content=”index”>
    <meta property="og:site_name" content="@yield('meta_site_name', env('APP_NAME') )" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="Url.ToString()">

    <meta property="og:title" content="@yield('meta_title', 'Way2EXPO 온라인 박람회')">
    <meta property="og:image" content="@yield('meta_image', env("DEFAULT_HOST_URL", "https://www.way2expo.com").Config::get('setting.default_image') )">
    <meta property="og:description" content="@yield('meta_description','Way2EXPO 온라인 박람회')">
    <meta name="description" content="@yield('meta_name_description','Way2EXPO 온라인 박람회')">
    <meta name="keywords" content="way2expo,온라인박람회,박람회, @yield('meta_keywords','')">
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
    <!-- CSS Files -->
    <link href="/assets/css/material-kit.css?v=2.2.0" rel="stylesheet" />
    @stack('css-plugins')
    <link rel="stylesheet" href="{{ mix('/assets/css/style.css') }}">

    <!--     Fonts and icons     -->

    <style>
        html.body{
            width: 100%;
            height: 100%;
        }
        .live-page{
            width:100%;
            height:100%;
            position: relative;
            background-color: #fff;
            word-wrap: break-word;
            word-break: keep-all;
            -webkit-text-size-adjust: none;
            -webkit-tap-highlight-color: transparent;
        }
        #root{
            height: 100vh;
            display: block;
        }
        .live-layout{
            overflow: auto;
            text-align: center;
            position: relative;
            height: 100%;
            background-color: #000;
        }
        .live-inner{
            position: relative;
            transform: translateY(0px);
            min-width: 360px;
            min-height: 640px;
            width: calc(100vh * 0.5625);
            height: 100%;
            display: inline-block;
            text-align: left;
            vertical-align: top;
            font-size: 0;
        }
        .live-comment{
            right: 75px;
            bottom: 78px;
            left: 15px;
            z-index: 50;

            overflow-y: hidden;
            position: absolute;
            max-height: 200px;
            -webkit-transition: bottom 0.5s cubic-bezier(0, 1, 0, 1) 0.1s;
            transition: bottom 0.5s cubic-bezier(0, 1, 0, 1) 0.1s;
            font-size: 14px;
            color: #fff;
            will-change: bottom;
        }
        .live-comment-inner{
            overflow: hidden;
            position: relative;
            z-index: 1;
        }
        .live-comment-inner .comment{
            text-align:left;
        }
        .live-player{
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
        }
        .live-player:after{
            position: absolute;
            top: 0;
            right: -1px;
            left: 0;
            z-index: 10;
            height: 120px;
            background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0, rgba(0,0,0,0.5)), to(rgba(0,0,0,0)));
            background-image: linear-gradient(to bottom, rgba(0,0,0,0.5) 0, rgba(0,0,0,0) 100%);
            content: '';
        }
        .live-header-wrap{
            position: absolute;
            top: 0;
            right: 0;
            left: 0;
            z-index: 40;
            padding: 13px 15px 0;
        }
        .live-header-title{
            min-height: 38px;
            margin-top: 13px;
            position: relative;
            padding-left: 46px;
            color: #fff;
        }
        .live-header-title h3{
            overflow: hidden;
            text-overflow: ellipsis;
            display: block;
            white-space: nowrap;
            word-wrap: normal;
            margin-top: -1px;
            font-size: 18px;
            line-height: 1.3;
            letter-spacing: -0.3px;
            font-weight: 600;
        }
        .live-header-tool{
            position: absolute;
            top: 5px;
            right: 5px;
            z-index: 60;
            white-space: nowrap;
        }
        .live-header-tool .btn{
            padding: 10px;
            vertical-align: top;
        }
        .live-header-tool .btn i{
            font-size:2rem;
        }
        .live-like{
            position: absolute;
            right: 0;
            bottom: 0;
            z-index: 40;
            width: 62px;
            height: 70px;
            padding: 15px 15px 15px 7px;
            outline: none;
            -webkit-tap-highlight-color: transparent;
        }
        .live-like .btn i{
            font-size:2rem;
        }
        .live-like .btn{
            padding: 10px;
            vertical-align: top;
        }
        particle {
            border-radius: 50%;
            left: 0;
            pointer-events: none;
            position: fixed;
            top: 0;
            opacity: 0;
        }
    </style>

</head>

<body>
<div id="root">
    <div class="live-layout">
        <div class="live-inner">
            <div class="live-header-wrap">
                <div class="live-header-title">
                    <h2 class="title text-white">부스 라이브 화면</h2>
                </div>
            </div>
            <div class="live-header-tool">
                <button class="btn btn-link"><i class="material-icons">star_border</i></button>
                <button class="btn btn-link" onclick="window.history.back(-1);"><i class="material-icons">close</i></button>
            </div>
            <div class="live-player">
                <video id="remoteVideo" autoplay muted class="webplayer-internal-video" playsinline="" disablepictureinpicture="true" controlslist="nodownload" x-webkit-airplay="" webkit-playsinline="" src="" width="100%" height="100%"></video>
            </div>
            <div class="live-comment">
                <div class="live-comment-inner">
                    <div id="chatLogDiv" class="comment" style="transform: translateY(0px); transition-duration: 0.5s;">
                    </div>
                </div>
            </div>
            <div class="live-like">
                <button id="like-btn" class="btn btn-link"><i class="material-icons">favorite_border</i></button>

            </div>
        </div>
    </div>
    <h2 class="title">RemoteMonster Test</h2>
    <blockquote class="blockquote">
        <p class="mb-0"><a href="https://way2expo.com/live/live.php" target="_blank">방송하기 Link</a></p>
    </blockquote>

    <div class="form-inline">
        <input type="text" class="form-control" id="channel" placeholder="채널아이디">
        <button id="mystart" class="btn btn-sm">시청</button>
        <button id="mystop" class="btn btn-sm" disabled>중지</button>
        <input type="hidden" class="form-control" id="nameInput" value="시청자" placeholder="이름"><input type="text" class="form-control" id="chatMsg" placeholder="메시지 내용...">
        <button class="btn btn-sm" onclick="sendMessage()">메시지 보내기</button>
    </div>

</div>

<script src="/assets/js/core/jquery.min.js" type="text/javascript"></script>
<script src="https://webrtc.github.io/adapter/adapter-latest.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@remotemonster/sdk/remon.min.js"></script>
<script>
    let remon;

    const config = {
        credential: {
            serviceId: '1d41f14c-53ad-42bc-baf0-eea8f533b592',
            key: '468c5a1d0a385f811050956575587dcf7733c612e947dbe3455f7f7b8f01e3df'
        },
        view: {
            remote: '#remoteVideo'
        },
        media: {
            recvonly: false,
            audio: false,
            video: {
                width: '640',
                height: '480',
                codec: 'vp8',
                maxBandwidth: 1800,
                frameRate: {max: 25, min: 25}
            },
        }
    };

    const listener = {
        onCreate(chid) { console.log(`EVENT FIRED: onCreate: ${chid}`); },
        onJoin(chid) { console.log(`EVENT FIRED: onJoin: ${chid}`); $('#mystart').prop( "disabled", true ); $('#mystop').prop( "disabled", false ); },
        onClose() {
            console.log('EVENT FIRED: onClose');
            $('#mystart').prop( "disabled", false );
            $('#mystop').prop( "disabled", true );
            remon.close();
            remon = new Remon({ config, listener });
        },
        onError(error) { console.log(`EVENT FIRED: onError: ${error}`); },
        onStat(result) { console.log(`EVENT FIRED: onStat: ${result}`); },
        onMessage(msg) {
            addMesssage(false, msg);
        }
    };
    const sendMessageBtn = document.getElementById("sendMessageBtn");
    const chatLogDiv = document.getElementById("chatLogDiv");
    const chatMsg = document.getElementById("chatMsg");
    const nameInput = document.getElementById("nameInput");
    let isConnected = false;
    let isCaster = false;
    const cameraSwitchBtn = document.getElementById("cameraSwitchBtn");
    const videoInputSelect = document.getElementById("videoInputSelect");
    const audioInputSelect = document.getElementById("audioInputSelect");
    const videoCodecSelect = document.getElementById("videoCodecSelect");
    const resolutionSelect = document.getElementById("resolutionSelect");
    const videoFPSInput = document.getElementById("videoFPSInput");

    let cameraList = [];
    let micList = [];

    async function getDevices () {
        var devices = await navigator.mediaDevices.enumerateDevices();
        for (let i = 0; i < devices.length; i++) {
            let device = devices[i];
            console.log(JSON.stringify(device));
            if (device.kind === 'videoinput') {
                cameraList.push({ text: device.label, id: device.deviceId })
            } else if (device.kind === 'audioinput') {
                micList.push({ text: device.label, id: device.deviceId })
            }
            // else if (device.kind === 'audiooutput') {
            //     speakerList.push({ text: device.label, id: device.deviceId })
            // }
        }
        for (let i=0; i< cameraList.length; i++){
            const videoInputOption = document.createElement('option');
            videoInputOption.value= cameraList[i].id;
            // videoInputOption.text = cameraList[i].text;
            videoInputOption.text = cameraList[i].text ? cameraList[i].text : ("Device " + cameraList[i].id);
            videoInputSelect.appendChild(videoInputOption);
        }
        for (let i=0; i< micList.length; i++){
            const audioInputOption = document.createElement('option');
            audioInputOption.value= micList[i].id;
            // audioInputOption.text = micList[i].text;
            audioInputOption.text = micList[i].text ? micList[i].text : ("Device " + micList[i].id);
            audioInputSelect.appendChild(audioInputOption);
        }
    }
    function changeVideoInputDevice() {
        config.media.video.deviceId = videoInputSelect.options[videoInputSelect.selectedIndex].value;
    }
    function changeVideoCodec() {
        config.media.video.codec = videoCodecSelect.options[videoCodecSelect.selectedIndex].value;
    }
    function changeAudioInputDevice() {
        config.media.audio.deviceId = audioInputSelect.options[audioInputSelect.selectedIndex].value;
        console.log(JSON.stringify(config));
        // remon.setAudioDevice(audioInputSelect.options[audioInputSelect.selectedIndex].value);
    }
    function changeVideoFPS() {
        config.media.video.frameRate = parseInt(videoFPSInput.value, 10);
    }
    function changeResolution() {
        resolution = resolutionSelect.options[resolutionSelect.selectedIndex].text.split('-');
        config.media.video.width= resolution[0];
        config.media.video.height = resolution[1]
    }
    // getDevices();

    function sendMessage(msg) {
        if (nameInput.value) {
            name = nameInput.value;
        }

        if (chatMsg.value){
            msg = chatMsg.value;
            chatMsg.value="";
        }else{
            if (!msg) {}msg = "Test Message";
        }
        remon.sendMessage(name + '-' + msg);
        addMesssage(true, msg);
    }
    function addMesssage(isMine, msg) {
        var msgItem = document.createElement("p");
        msgItem.style.textShadow = "0 0 7px #ffffff";
        msgItem.style.lineHeight = 0.9;
        // if (!isMine) msgItem.style.color = "Blue";

        msgItem.innerHTML = isMine ? "나 : " + msg : msg.split('-')[0] + " : " + msg.split('-')[1];
        chatLogDiv.appendChild(msgItem);
        var myscroll = $('.live-comment');
        myscroll.scrollTop(myscroll.get(0).scrollHeight);
        console.log(myscroll.get(0).scrollHeight)
    }

    remon = new Remon({ config, listener });

    $('#mystop').click(function(){
        remon.close();
    });

    $('#mystart').click(function(){
        var $roomID = document.getElementById('channel');
        remon.joinCast($roomID.value);
    });
    $('#switch').click(function () {
        remon.switchCamera();
    });
    $(function(){
        $('#chatMsg').keydown(function(key){
            if (key.keyCode == 13) {
                sendMessage();
            }
        });
    })
    if (document.body.animate) {
        document.querySelector('#like-btn').addEventListener('click', pop);
    }''

    function pop (e) {
        // Quick check if user clicked the button using a keyboard
        if (e.clientX === 0 && e.clientY === 0) {
            const bbox = document.querySelector('#like-btn').getBoundingClientRect();
            const x = bbox.left + bbox.width / 2;
            const y = bbox.top + bbox.height / 2;
            for (let i = 0; i < 30; i++) {
                // We call the function createParticle 30 times
                // We pass the coordinates of the button for x & y values
                createParticle(x, y);
            }
        } else {
            for (let i = 0; i < 30; i++) {
                // We call the function createParticle 30 times
                // As we need the coordinates of the mouse, we pass them as arguments
                createParticle(e.clientX, e.clientY);
            }
        }
    }

    function createParticle (x, y) {
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
</script>
</body>

</html>
