## {{ __('entries/tabs.aliases') }}

@foreach ($entity->aliases as $alias)
- {!! $alias->name !!}
@endforeach
