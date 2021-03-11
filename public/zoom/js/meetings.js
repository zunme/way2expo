(function () {
    var testTool = window.testTool;
    // get meeting args from url
    var meetingConfig = {
        apiKey: args.apiKey,
        meetingNumber: args.mn,
        userName: args.name ,
        passWord: args.pwd,
        leaveUrl: "/expo",
        role: parseInt(args.role, 10),
        userEmail: (function () {
            try {
                return testTool.b64DecodeUnicode(args.email);
            } catch (e) {
                return args.email;
            }
        })(),
        lang: "ko-KO",
        signature: args.signature || "",
        china: false,
    };
    if (testTool.isMobileDevice()) {
        //vConsole = new VConsole();
    }
    //console.log(JSON.stringify(ZoomMtg.checkSystemRequirements()));
    ZoomMtg.setZoomJSLib("https://source.zoom.us/1.8.1/lib", "/av"); // CDN version defaul
    ZoomMtg.preLoadWasm();
    ZoomMtg.prepareJssdk();
    function beginJoin(signature) {
        ZoomMtg.init({
            leaveUrl: meetingConfig.leaveUrl,
            webEndpoint: meetingConfig.webEndpoint,
            success: function () {
                console.log(meetingConfig);
                console.log("signature", signature);
                $.i18n.reload(meetingConfig.lang);
                ZoomMtg.join({
                    meetingNumber: meetingConfig.meetingNumber,
                    userName: meetingConfig.userName,
                    signature: signature,
                    apiKey: meetingConfig.apiKey,
                    userEmail: meetingConfig.userEmail,
                    passWord: meetingConfig.passWord,
                    success: function (res) {
                        console.log("join meeting success");
                        console.log("get attendeelist");
                        ZoomMtg.getAttendeeslist({});
                        ZoomMtg.getCurrentUser({
                            success: function (res) {
                                console.log("success getCurrentUser", res.result.currentUser);
                            },
                        });
                    },
                    error: function (res) {
                        console.log(res);
                    },
                });
            },
            error: function (res) {
                console.log(res);
            },
        });

        ZoomMtg.inMeetingServiceListener('onUserJoin', function (data) {
            console.log('inMeetingServiceListener onUserJoin', data);
        });

        ZoomMtg.inMeetingServiceListener('onUserLeave', function (data) {
            console.log('inMeetingServiceListener onUserLeave', data);
        });

        ZoomMtg.inMeetingServiceListener('onUserIsInWaitingRoom', function (data) {
            console.log('inMeetingServiceListener onUserIsInWaitingRoom', data);
        });

        ZoomMtg.inMeetingServiceListener('onMeetingStatus', function (data) {
            console.log('inMeetingServiceListener onMeetingStatus', data);
        });
    }

    beginJoin(meetingConfig.signature);
})();
