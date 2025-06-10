<x-mail::message layout="welcome">

# **{!! __('emails/welcome/2024.header', ['name' => $user->name]) !!}**

{!! __('emails/welcome/2024.lead_1') !!}

{!! __('emails/welcome/2024.lead_2') !!}


<x-mail::panel>

## **{!! __('emails/welcome/2024.what_now') !!}**

{!! __('emails/welcome/2024.what_1', [
    'start' => __('emails/welcome/2024.what_new'),
]) !!}


{!! __('emails/welcome/2024.what_2') !!}

- {!! __('emails/welcome/2024.what_3', [
    'kb' => '[' . __('footer.kb') . '](' . \App\Facades\Domain::toFront('kb') . ')',
]) !!}
- {!! __('emails/welcome/2024.what_4', [
    'doc' => '[' . __('footer.documentation') . '](https://docs.kanka.io/en/latest/index.html)',
]) !!}
- {!! __('emails/welcome/2024.what_5', [
    'campaigns' => '[' . __('footer.public-campaigns') . '](https://kanka.io/campaigns)',
]) !!}

</x-mail::panel>

{!! __('emails/welcome/2024.closing') !!}

_Jay and Jon_

{!! __('emails/welcome/2024.ps', [
    'email' => '[' . config('app.email') . '](mailto:' . config('app.email') . ')',
    'discord' => '[Discord](https://kanka.io/go/discord)',
]) !!}
</x-mail::message>
