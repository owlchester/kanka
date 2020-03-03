<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Font Awesome Icons -->
{{--    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.12.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">--}}

    <!-- Styles -->
    <link href="{{ url(mix('/css/export.css')) }}" rel="stylesheet">
    <style>
        @font-face {
            font-family: 'Open Sans';
            font-style: normal;
            font-weight: 400;
            src: url(https://fonts.google.com/specimen/Open+Sans) format('truetype');
        }
        * {
            font-family: Open Sans, DejaVu Sans, sans-serif;
        }
    </style>
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
