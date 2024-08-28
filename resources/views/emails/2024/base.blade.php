<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
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
                            border:1px solid #EAECED;
                            border-radius:8px; border-collapse: separate!important; overflow: hidden;
                            ">
                        <tbody>
                        <tr>
                            <td align="center">
                                @include('emails.2024.header')
                                @yield('content')
                                @include('emails.2024.footer')
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
