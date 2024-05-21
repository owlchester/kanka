<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">
</head>
<body>
    <p>
        New idea <a href="https://admin.kanka.io/features/{{ $feature->id }}" > {{ $feature->name }}</a> from {{ $feature->user->name }}
    </p>
    <br/>
    <p>
        {!! $feature->description !!}
    </p>
</body>
</html>
