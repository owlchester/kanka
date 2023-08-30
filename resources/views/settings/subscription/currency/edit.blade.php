{!! Form::model(auth()->user(), ['method' => 'PATCH', 'route' => ['billing.payment-method.save']]) !!}
@include('partials.forms.form', [
    'title' => __('settings.subscription.currency.title'),
    'content' => 'settings.subscription.currency.' . $content,
    'submit' => __('settings.subscription.actions.update_currency'),
    'dialog' => true,
])
<input type="hidden" name="from" value="{{ 'settings.subscription' }}" />
{!! Form::close() !!}
