<!doctype html>
<html lang="en-US">

<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
    <title>{{env("APP_NAME")}}</title>
    <meta name="description" content="Add Client">
    <link
        href="{{config('email_template.font_link')}}"
        rel="stylesheet">
    <style type="text/css">
    a:hover {
        color: #455056;
    }
    a {
        color: {{config('email_template.primary_color')}};
        text-decoration: none !important;
    }
    </style>
    <style type="text/css">
    @media screen and (max-device-width: 600px),
    screen and (max-width: 600px) {
        .wrapto100pc {
            width: 100% !important;
            height: auto !important;
        }

        .nomob {
            display: none !important;
            width: 0px !important;
            height: 0px !important;
        }
    }
    </style>

    <style type="text/css">
    @supports (-webkit-overflow-scrolling:touch) and (color:#ffff) {
        div>u~div .gmailbutton {
            width: 100% !important;
        }
    }
    </style>
</head>

<body marginheight="0" topmargin="0" marginwidth="0" style="margin: 0px; background-color: #f2f3f8;" leftmargin="0">
    <!-- 100% body table -->
    <table cellspacing="0" border="0" cellpadding="0" width="100%" bgcolor="#f2f3f8"
        style="font-family: 'Nunito Sans', sans-serif;">
        <tr>
            <td>
                <table style="background-color: #f2f3f8; max-width:650px; margin:0 auto;" width="100%" border="0"
                    align="center" cellpadding="0" cellspacing="0">
                    <tr>
                        <td style="height:20px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="text-align:center;">
                            <a href="{{config('email_template.website_link')}}" title="logo" target="_blank">
                                <img width="150" src="{{config('email_template.logo')}}"
                                    title="logo" alt="logo">
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td style="height:20px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td>
                            <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0"
                                style="max-width:670px; background:#fff; border-radius:3px; text-align:center;-webkit-box-shadow:0 6px 18px 0 rgba(0,0,0,.06);-moz-box-shadow:0 6px 18px 0 rgba(0,0,0,.06);box-shadow:0 6px 18px 0 rgba(0,0,0,.06);">
                                <tr>
                                    <td style="height:40px;">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td style="padding:0 35px;">

                                        <h1
                                            style="color:{{config('email_template.secondary_color')}}; font-weight:500; margin:0px 0px 30px 0px ;font-size:22px;font-family:'Rubik',sans-serif;">
                                            Reset Password Request
                                        </h1>
                                        <p
                                            style="color:#455056;line-height:20px; margin:0; font-weight: 500; text-align:center">
                                            <strong
                                                style="display: block; font-size: 14px; margin: 0 0 10px; color:rgba(0,0,0,.64); font-weight:normal;"></strong>We received a reset password request for your account. To reset your password, click the button below.
                                            
                                        </p>

                                        <!-- Button -->
                                        <table bgcolor="{{config('email_template.primary_color')}}" border="0" cellpadding="0" cellspacing="0"
                                            class="wrapto100pc" style="margin: 20px auto; border-radius: 4px;">
                                            <tr>
                                                <td bgcolor="{{config('email_template.primary_color')}}" class="nomob"
                                                    style="border-top-left-radius: 8px; border-bottom-left-radius: 8px;"
                                                    width="8"></td>
                                                <td align="center" bgcolor="{{config('email_template.primary_color')}}" class="wrapto100pc gmailbutton"
                                                    style="font-size: 16px; line-height:20px; font-family:'Rubik',sans-serif; color: #ffffff; text-decoration: none; vertical-align: middle; height:44px; border-radius: 8px;">
                                                    <a href="{{ $url }}"
                                                        style="font-size: 16px; line-height:20px; font-family: inherit, arial, sans-serif; color: #ffffff; text-decoration: none; text-transform: uppercase; vertical-align: middle; letter-spacing: 1px; padding: 10px 30px; border: 1px solid {{config('email_template.primary_color')}}; border-radius: 8px; display: block;"
                                                        target="_blank">

                                                        <!--[if mso]>&nbsp;&nbsp;&nbsp;<![endif]--><span>Reset Password</span>
                                                        <!--[if mso]>&nbsp;&nbsp;&nbsp;<![endif]-->

                                                    </a>
                                                </td>
                                                <td bgcolor="{{config('email_template.primary_color')}}" class="nomob"
                                                    style="border-top-right-radius: 8px; border-bottom-right-radius: 8px;"
                                                    width="8"> </td>
                                            </tr>
                                        </table>
                                        <!-- /Button -->

                                        <p
                                            style="color:#455056;line-height:20px;font-size: 12px;margin:0; font-weight: 500; text-align:center">
                                            <strong
                                                style="display: block; margin: 0 0 4px; color:rgba(0,0,0,.64); font-weight:normal;"></strong>This password reset link will expire in 60 minutes. If you did not make this request, no further action is required. You are having triuble clicking the "Reset Password" button? <a href="{{ $url }}"><b>CLICK HERE</b></a>
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="height:40px;">&nbsp;</td>
                                </tr>
                            </table>

                        </td>
                    </tr>
                    <tr>
                        <td style="height:20px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="text-align:center;">
                            <p
                                style="font-size:14px; color:{{config('email_template.primary_color')}}; line-height:18px; margin:0 0 0;">
                            </p>
<!--                             <u style="text-decoration: none;list-style: none;display: inline-flex; font-size:13px;">
                                <a href="{{config('email_template.linkedin')}}">
                                    <li style="padding: 6px;">Linkedin</li>
                                </a>
                                <a href="{{config('email_template.twitter')}}">
                                    <li style="padding: 6px;">Twitter</li>
                                </a>
                                <a href="{{config('email_template.instagram')}}">
                                    <li style="padding: 6px;">Instagram</li>
                                </a>
                                <a href="{{config('email_template.rumble')}}">
                                    <li style="padding: 6px;">Rumble</li>
                                </a>
                                <a href="{{config('email_template.trustpilot')}}">
                                    <li style="padding: 6px;">Trustpilot</li>
                                </a>

                            </u>
                            <p>
                                <span
                                    style="display:inline-block; vertical-align:middle; margin:0px 0 10px; border-bottom:1px solid rgba(0,0,0,.20); width:100px;"></span>
                            </p> -->
                            <p
                                style="font-size:14px; color:rgba(69, 80, 86, 0.7411764705882353); line-height:18px; margin:0 0 0;">
                                &copy; <strong>{{config('email_template.website_name')}}</strong> </p>

                            <p
                                style="padding:16px; color: rgba(69, 80, 86, 0.74);line-height:16px;font-size: 11px;margin:0; font-weight: 500; text-align:center">
                                {{ config('email_template.footer_text') }}
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td style="height:80px;">&nbsp;</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <!--/100% body table-->
</body>

</html>
