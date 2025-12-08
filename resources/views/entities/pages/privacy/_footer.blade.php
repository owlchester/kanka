<button class="btn2 btn-outline" data-url="{{ route('entities.permissions', [$campaign, $entity]) }}" data-toggle="dialog">
    <x-icon class="fa-regular fa-wrench" />
    {{ __('entities/permissions.quick.manage') }}
</button>
