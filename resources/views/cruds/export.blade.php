<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8"> <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <!-- Ionicons -->
    <link href="http://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet" type="text/css" />

    <style type="text/css">
        .fa {
            display: inline;
            font-style: normal;
            font-variant: normal;
            font-weight: normal;
            font-size: 14px;
            line-height: 1;
            font-family: FontAwesome;
            font-size: inherit;
            text-rendering: auto;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
    </style>
    <!-- Styles -->
    <link href="{{ asset('/css/export.css') }}" rel="stylesheet">
</head>
<body>
@inject('campaign', 'App\Services\CampaignService')
    <?php $cpt = 0; ?>
    @foreach ($entities as $model)
        <?php $cpt++; ?>
        @include($entity . '.show')
        @if ($cpt < count($entities))
        <div class="page-break"></div>
        @endif
    @endforeach

<!-- Scripts -->
{{--<script src="{{ mix('js/app.js') }}"></script>--}}
</body>
</html>