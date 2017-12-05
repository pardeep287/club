<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Download App</title>
    <link href="{{ asset('/frontend/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/frontend/css/style.css') }}" rel="stylesheet">
    <script src="//cdnjs.cloudflare.com/ajax/libs/clipboard.js/1.7.1/clipboard.min.js"></script>

    <style>
        .btn-primary {
            background: #FF3E01;
            border:0;
            padding: 20px 40px;
            font-weight: bold;
            margin-top: 40px;
            position: relative;
            z-index: 2;
        }

        .btn-primary:hover, .btn-primary:active, .btn-primary:focus {
            background: #e23400;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <div class="text-center" style="padding: 50px 20px;">
                    <img src="{{ asset("frontend/images/logo.png") }}" alt="">

                    <br>
                    <br>
                    <br>
                    <br>

                    <p>You are referred by {{ $username }}</p>

                    <div>
                        <input type="text" style="opacity: 0; position:absolute; left: 0;" id="refCode" value="{{ $refCode }}">
                        <button class="btn btn-primary btn-block" data-clipboard-target="#refCode" data-clipboard-action="copy">INSTALL APP</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        var clipboard = new Clipboard('.btn');

        clipboard.on("success", function(e) {
            window.location = "market://details?id=net.digiguru.clubjb";
        })
    </script>
</body>
</html>

