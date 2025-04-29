@props([
    'layout' => 'user',
])

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="{{ app()->getLocale() }}" dir="ltr"  xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>{{ config('app.name') }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="color-scheme" content="light">
    <meta name="supported-color-schemes" content="light">
    <meta name="format-detection" content="telephone=no, date=no, address=no, email=no, url=no">
    <meta name="x-apple-disable-message-reformatting">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <style>
        @media screen {
            body {
                font-family: 'Inter', sans-serif;
            }
        }
        html, body, .document { margin: 0 !important; padding: 0 !important; width: 100% !important; height: 100% !important; }
        body { -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; text-rendering: optimizeLegibility;}
        img { border: 0; outline: none; text-decoration: none;  -ms-interpolation-mode: bicubic; }
        table { border-collapse: collapse; }
        table, td { mso-table-lspace: 0pt; mso-table-rspace: 0pt; }
        body, table, td, a { -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; }
        p {padding-left: 50px; padding-right: 50px;}
        ul {padding-left: 65px; padding-right: 65px;}
        h1, h2, h3, h4, h5, p { margin:0;}
        @media all and (max-width:639px) {
            .wrapper{ width:100%!important; }
            .container{ width:100%!important; min-width:100%!important; padding: 0 !important; }
            .row{padding-left: 20px!important; padding-right: 20px!important;}
            p { padding-left: 20px!important; padding-right: 20px!important; }
            ul { padding-left: 35px!important; padding-right: 35px!important; }
        }
    </style>
</head>
<body style="margin: 0 !important; padding: 0 !important; background-color: #F4F7FA">
    <div class="document" role="article" aria-roledescription="email" aria-label="" lang="{{ app()->getLocale() }}" dir="ltr" style="background-color:#F4F7FA; line-height: 100%; font-size:medium; font-size:max(16px, 1rem);">

        <table width="100%" align="center" cellspacing="0" cellpadding="0" border="0">
            <tbody>
                <tr>
                    <td class="" background="" bgcolor="#F4F7FA" align="center" valign="top" style="padding: 0 8px;">
                        <table width="640" class="wrapper" align="center" border="0" cellpadding="0" cellspacing="0" style="
                            max-width: 640px;
                            border-radius:8px; border-collapse: separate!important; overflow: hidden;
                        ">
                            <tbody>
                                <tr>
                                    <td align="center" bgcolor="#ffffff">

                                        @include('emails.2024.header')

                                        {{ Illuminate\Mail\Markdown::parse($slot) }}

                                        {{ $subcopy ?? '' }}
                                        @includeWhen($layout != 'admin', 'emails.2024.footer', ['layout' => $layout])
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>
