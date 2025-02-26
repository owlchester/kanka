@can('update', $entity)
<a href="{{ route('entities.attributes.edit', [$campaign, 'entity' => $entity]) }}" class="btn2 btn-sm">
    <i class="fa-solid fa-list" aria-hidden="true"></i>
    {{ __('entities/attributes.actions.manage') }}
</a>
@endif
