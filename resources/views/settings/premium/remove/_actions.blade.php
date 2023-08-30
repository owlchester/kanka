@if ($boost->inCooldown()) <?php return ?> @endif
<button type="submit" class="btn2 btn-error">
    <span class="">{{ __('settings/premium.remove.confirm') }}</span>
</button>
