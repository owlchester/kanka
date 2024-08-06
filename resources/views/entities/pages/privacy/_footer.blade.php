<button class="btn2 btn-primary" data-target="primary-dialog" data-url="{{ route('entities.permissions', [$campaign, $entity]) }}" data-toggle="dialog">
    <x-icon class="fa-solid fa-wrench" />
    {{ __('entities/permissions.quick.manage') }}
</button>
