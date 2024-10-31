@extends('emails.2024.base', [
    'utmSource' => 'welcome',
    'utmCampaign' => 'onboarding'
])

@section('content')

    <div style="display: none"></div>

    <!-- heading -->
    <table class="ml-default" width="100%" bgcolor="" align="center" border="0" cellspacing="0" cellpadding="0">
        <tbody><tr>
            <td style="">
                <table class="container ml-6 ml-default-border" width="640" bgcolor="#ffffff" align="center" border="0" cellspacing="0" cellpadding="0" style="color: #515856; width: 640px; min-width: 640px;">
                    <tbody><tr>
                        <td class="ml-default-border container" height="20" style="line-height: 20px; min-width: 640px;"></td>
                    </tr>
                    <tr>
                        <td class="row" style="padding: 0 50px;">
                            <p style="font-family: 'Inter', sans-serif; color: #515856; font-size: 16px; line-height: 165%; margin-top: 0; margin-bottom: 10px;"></p><h1 style="font-family: 'Inter', sans-serif; color: #000000; font-size: 28px; line-height: 125%; font-weight: bold; font-style: normal; text-decoration: none; ;margin-bottom: 10px; text-align: center;">{!! __('emails/welcome/2024.header', ['name' => $user->name]) !!}</h1>
                            <p style="font-family: 'Inter', sans-serif; color: #515856; font-size: 16px; line-height: 165%; margin-top: 0; margin-bottom: 10px;"></p>
                            <p style="font-family: 'Inter', sans-serif; color: #515856; font-size: 16px; line-height: 165%; margin-top: 0; margin-bottom: 10px;">{!! __('emails/welcome/2024.lead_1', ['name' => $user->name]) !!}</p>
                            <p style="font-family: 'Inter', sans-serif; color: #515856; font-size: 16px; line-height: 165%; margin-top: 0; margin-bottom: 10px;"></p>
                            <p style="font-family: 'Inter', sans-serif; color: #515856; font-size: 16px; line-height: 165%; margin-top: 0; margin-bottom: 10px;">{!! __('emails/welcome/2024.lead_2', ['name' => $user->name]) !!}</p>
                            <p style="font-family: 'Inter', sans-serif; color: #515856; font-size: 16px; line-height: 165%; margin-top: 0; margin-bottom: 0;"></p>
                        </td>
                    </tr>
                    <tr>
                        <td height="20" style="line-height: 20px;"></td>
                    </tr>
                    </tbody></table>
            </td>
        </tr>
        </tbody>
    </table>

    <!-- useful links -->
    <table class="ml-default" width="100%" bgcolor="" align="center" border="0" cellspacing="0" cellpadding="0">
        <tbody><tr>
            <td style="">
                <table class="container ml-11 ml-default-border" width="640" bgcolor="#404790" align="center" border="0" cellspacing="0" cellpadding="0" style="color: #ffffff; width: 640px; min-width: 640px;">
                    <tbody><tr>
                        <td class="ml-default-border container" height="20" style="line-height: 20px; min-width: 640px;"></td>
                    </tr>
                    <tr>
                        <td class="row" style="padding: 0 50px;">
                            <p style="font-family: 'Inter', sans-serif; color: #ffffff; font-size: 16px; line-height: 165%; margin-top: 0; margin-bottom: 10px;"></p>
                            <h2 style="font-family: 'Inter', sans-serif; color: #ffffff; font-size: 28px; line-height: 125%; font-weight: bold; font-style: normal; text-decoration: none; ;margin-bottom: 10px; text-align: center;"><strong>{{ __('emails/welcome/2024.what_now') }}</strong></h2>
                            <p style="font-family: 'Inter', sans-serif; color: #ffffff; font-size: 16px; line-height: 165%; margin-top: 0; margin-bottom: 10px;"></p>
                            <p dir="ltr" style="font-family: 'Inter', sans-serif; color: #ffffff; font-size: 16px; line-height: 165%; margin-top: 0; margin-bottom: 10px;">
                                {!! __('emails/welcome/2024.what_1', [
    'start' => '<a href="' . route('start', ['utm_source' => 'welcome', 'utm_medium' => 'email']) . '" style="color: #2CB191; font-weight: normal; font-style: normal; text-decoration: underline;"><strong>' . __('emails/welcome/2024.what_new') . '</strong></a>'
    ]) !!}
                            <p dir="ltr" style="font-family: 'Inter', sans-serif; color: #ffffff; font-size: 16px; line-height: 165%; margin-top: 0; margin-bottom: 10px;">{{ __('emails/welcome/2024.what_2') }}</p>
                            <ul style="font-family: 'Inter', sans-serif; color: #ffffff; font-size: 16px; line-height: 165%; margin-top: 0; margin-bottom: 10px;">
                                <li dir="ltr">
                                    <p dir="ltr" style="font-family: 'Inter', sans-serif; color: #ffffff; font-size: 16px; line-height: 165%; margin-top: 0; margin-bottom: 0;">{!! __('emails/welcome/2024.what_3', ['kb' => '<a href="https://kanka.io/kb?utm_source=welcome&utm_medium=email" style="color: #2CB191; font-weight: normal; font-style: normal; text-decoration: underline;"><strong>' . __('footer.kb') . '</strong></a>']) !!}</p>
                                </li>
                                <li dir="ltr">
                                    <p dir="ltr" style="font-family: 'Inter', sans-serif; color: #ffffff; font-size: 16px; line-height: 165%; margin-top: 0; margin-bottom: 0;">{!! __('emails/welcome/2024.what_4', [
    'doc' => '<a href="https://docs.kanka.io/?utm_source=welcome&utm_medium=email" style="color: #2CB191; font-weight: normal; font-style: normal; text-decoration: underline;"><strong>' . __('footer.documentation') . '</strong></a>'
    ]) !!}</p>
                                </li>
                                <li dir="ltr">
                                    <p dir="ltr" style="font-family: 'Inter', sans-serif; color: #ffffff; font-size: 16px; line-height: 165%; margin-top: 0; margin-bottom: 0;">{!! __('emails/welcome/2024.what_5', [
    'campaigns' => '<a href="https://kanka.io/campaigns?utm_source=welcome&utm_medium=email" style="color: #2CB191; font-weight: normal; font-style: normal; text-decoration: underline;"><strong>' . __('footer.public-campaigns') . '</strong></a>'
    ]) !!}</p>
                                </li>
                            </ul>
                            <p style="font-family: 'Inter', sans-serif; color: #ffffff; font-size: 16px; line-height: 165%; margin-top: 0; margin-bottom: 0;"></p>
                        </td>
                    </tr>
                    <tr>
                        <td height="20" style="line-height: 20px;"></td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>

    <!-- ending -->
    <table class="ml-default" width="100%" bgcolor="" align="center" border="0" cellspacing="0" cellpadding="0">
        <tbody><tr>
            <td style="">
                <table class="container ml-16 ml-default-border" width="640" bgcolor="#ffffff" align="center" border="0" cellspacing="0" cellpadding="0" style="color: #515856; width: 640px; min-width: 640px;">
                    <tbody><tr>
                        <td class="ml-default-border container" height="20" style="line-height: 20px; min-width: 640px;"></td>
                    </tr>
                    <tr>
                        <td class="row" style="padding: 0 50px;">
                            <p style="font-family: 'Inter', sans-serif; color: #515856; font-size: 16px; line-height: 165%; margin-top: 0; margin-bottom: 10px;"></p>
                            <p dir="ltr" style="font-family: 'Inter', sans-serif; color: #515856; font-size: 16px; line-height: 165%; margin-top: 0; margin-bottom: 10px;">
                                {{ __('emails/welcome/2024.closing') }}</p>
                            <p dir="ltr" style="font-family: 'Inter', sans-serif; color: #515856; font-size: 16px; line-height: 165%; margin-top: 0; margin-bottom: 10px;"><br></p>
                            <p dir="ltr" style="font-family: 'Inter', sans-serif; color: #515856; font-size: 16px; line-height: 165%; margin-top: 0; margin-bottom: 10px;"><em>Jay &amp; Jon</em></p>
                            <p dir="ltr" style="font-family: 'Inter', sans-serif; color: #515856; font-size: 16px; line-height: 165%; margin-top: 0; margin-bottom: 10px;"><br></p>
                            <p dir="ltr" style="font-family: 'Inter', sans-serif; color: #515856; font-size: 16px; line-height: 165%; margin-top: 0; margin-bottom: 10px;">{!! __('emails/welcome/2024.ps', [
    'discord' => '<a href="https://kanka.io/go/discord" style="color: #2CB191; font-weight: normal; font-style: normal; text-decoration: underline;"></strong>Discord<strong></a>',
    'email' => '<a href="mailto:' . config('app.email') . '" style="color: #2CB191; font-weight: normal; font-style: normal; text-decoration: underline;"><strong>' . config('app.email') . '</strong></a>',
    ]) !!}</p>
                            <p style="font-family: 'Inter', sans-serif; color: #515856; font-size: 16px; line-height: 165%; margin-top: 0; margin-bottom: 10px;"><br></p>
                            <p style="font-family: 'Inter', sans-serif; color: #515856; font-size: 16px; line-height: 165%; margin-top: 0; margin-bottom: 0;"></p>
                        </td>
                    </tr>
                    <tr>
                        <td height="20" style="line-height: 20px;"></td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>
@endsection
