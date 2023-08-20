<a class="btn2 btn-sm" href="{{ route('entities.attributes.template', [$campaign, $entity]) }}" data-toggle="dialog" data-target="primary-dialog" data-url="{{ route('entities.attributes.template', [$campaign, $entity]) }}">
    <i class="fa-solid fa-copy" aria-hidden="true"></i>
    {{ __('entities/attributes.actions.apply_template') }}
</a>

<a href="{{ route('entities.attributes.edit', [$campaign, 'entity' => $entity]) }}" class="btn2 btn-sm btn-accent">
    <i class="fa-solid fa-list" aria-hidden="true"></i>
    {{ __('entities/attributes.actions.manage') }}
</a>
