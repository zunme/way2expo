<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" 
    content="width=device-width, initial-scale=1, minimum-scale=1, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">    
    <title>{{$company->company_name}}</title>
    <link type="text/css" rel="stylesheet" href="https://source.zoom.us/1.8.1/css/bootstrap.css" />
    <link type="text/css" rel="stylesheet" href="https://source.zoom.us/1.8.1/css/react-select.css" />
    <meta name="format-detection" content="telephone=no">
    <meta http-equiv="origin-trial" content="">
</head>

<body>
    <script src="https://source.zoom.us/1.8.1/lib/vendor/react.min.js"></script>
    <script src="https://source.zoom.us/1.8.1/lib/vendor/react-dom.min.js"></script>
    <script src="https://source.zoom.us/1.8.1/lib/vendor/redux.min.js"></script>
    <script src="https://source.zoom.us/1.8.1/lib/vendor/redux-thunk.min.js"></script>
    <script src="https://source.zoom.us/1.8.1/lib/vendor/jquery.min.js"></script>
    <script src="https://source.zoom.us/1.8.1/lib/vendor/lodash.min.js"></script>
    <script src="https://source.zoom.us/zoom-meeting-1.8.1.min.js"></script>
    <script>
        var args = @json($arg, JSON_PRETTY_PRINT);
        
    </script>
    <script src="/zoom/js/tool.js"></script>
    <!--script src="/zoom/js/vconsole.min.js"></script-->
    <script src="/zoom/js/meetings.js"></script>

    <script>
        const simd = async () => WebAssembly.validate(new Uint8Array([0, 97, 115, 109, 1, 0, 0, 0, 1, 4, 1, 96, 0, 0, 3, 2, 1, 0, 10, 9, 1, 7, 0, 65, 0, 253, 15, 26, 11]))
        simd().then((res) => {
          console.log("simd check", res);
        });
    </script>
</body>

</html>