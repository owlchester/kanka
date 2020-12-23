<?php /** @var \App\User $user */?>
        <!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">
</head>
<body>
    <p>Hi {{ $user->name }},</p>

    <p>Thank you for becoming an Elemental!</p>

    <p>I just wanted to write a few short words to let you know that we deeply appreciate your support and involvement, and that we’re here if you need anything. You can contact us at this email address, or you can also link your Kanka account to <a href="{{ config('discord.url') }}" target="_blank">Discord</a> in your account settings, and that will give you access to the exclusive Elemental channel there.</p>

    <p>A large part of being an Elemental means that you get more say in how we shape Community Votes. If you have any priorities that you would like to see added, feel free to share them with us, and we will see how we can fit them into the votes, or if they overlap with requests made by other Elementals.</p>

    <p>Good to have you among us, don’t hesitate to get in touch if you need anything,</p>

    <p>Jay & Jon</p>
</body>
</html>
