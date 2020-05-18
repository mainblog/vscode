<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>用户登录</title>
    <script type="text/javascript" src="./js/jquery.min.js"></script>

    <style>
        html,
        body {
            margin: 0;
            height: 100%;
        }

        body {
            background: #f8d36c
        }

        button {
            height: 36px;
            width: 100%;
            margin: 15px 0;
            float: right;
            border: 0;
            background: #f83904;
            color: #fff;
            border-radius: 4px;
            box-shadow: 0 1px 3px #888;
            cursor: pointer;
            transition: .5s;

        }

        button:hover {
            background: #fff;
            color: #f83904;
        }

        .fl {
            float: left
        }

        .loginform {
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            margin: auto;
            padding: 25px;
            width: 300px;
            height: 200px;
            background: #fff;
            color: #888;
            box-shadow: 0 1px 4px #222;
        }

        .loginform span {
            line-height: 40px;
        }

        #vcode {
            height: 25px;
            width: 40pt;
            font-size: 12pt;
            padding: 0 8px;
            margin: 7.5px 12px;
        }

        #img_vcode {
            margin: 7.5px 0;
            cursor: pointer;
        }

        #vcode_info {
            margin: 33px 0;
            line-height: 40px;
            height: 40px;
            clear: both;
        }

        #form_hint {
            color: #888888;
            clear: both
        }

        .hint_ok {
            color: green !important;
        }

        .hint_err {
            color: red !important;
        }
    </style>
</head>

<body>

    <div class="loginform">
        <div id="vcode_info">
            <span class="fl">验证码：</span>
            <input class="fl" type="text" id="vcode" maxlength="4">
            <img class="fl" id="img_vcode" src="./vcode.php">
        </div>
        <div>
            <button type="button" id="btn_vcode">提交验证</button>
        </div>
        <p id="form_hint">*点击验证码图片可刷新</p>
    </div>

    <script type="text/javascript">
        //刷新验证码
        $("#img_vcode").click(function() {
            $("#img_vcode").attr("src", "./vcode.php?t=" + (new Date()).valueOf());
        });

        //提交验证(ajax方式)
        $("#btn_vcode").click(function() {
            var btn = this;
            $(btn).prop("disabled", true);

            $.post("./api.vcodeverify.php", {
                "vcode": $("#vcode").val()
            }, function(res) {
                $(btn).prop("disabled", false);
                if (res.code == 200) {
                    $("#form_hint").removeClass('hint_err').addClass('hint_ok').html(res.desc);
                } else {
                    $("#form_hint").removeClass('hint_ok').addClass('hint_err').html(res.desc);
                }
            }, "json");
        });
    </script>
</body>

</html>