<form method="post" action="">
    <x-dialog.header :dismissible="false">
        {{ __('confirm/editing.title') }}
    </x-dialog.header>
    <x-dialog.article>
        <x-grid type="1/1">
            <p class="m-0 max-w-sm">
                {{ __('confirm/editing.description') }}
            </p>
            <p class="m-0">
                {{ __('confirm/editing.members') }}
            </p>
            <ul>
                @foreach ($editingUsers as $user)
                    <li class="user-id-{{ $user->id }}">
                        {!! __('confirm/editing.user', [
                            'user' => '<strong>' . $user->name . '</strong>',
                            'since' => \Carbon\Carbon::createFromTimeString($user->pivot->created_at)->diffForHumans()
                        ]); !!}
                    </li>
                @endforeach
            </ul>
        </x-grid>
    </x-dialog.article>
    <footer class="bg-base-200 flex flex-wrap gap-3 justify-between items-start p-3 md:rounded-b">
        <menu class="flex flex-wrap gap-3 ps-0 ms-0">
            <a class="btn2" id="entity-edit-warning-back" href="{{ $show }}">
                {{ __('confirm/editing.back') }}
            </a>
        </menu>
        <menu class="flex flex-wrap gap-3 ps-0">
            <button type="button" class="btn2 btn-error btn-outline" id="entity-edit-warning-ignore" data-url="{{ $url }}">
                {{ __('confirm/editing.ignore') }}
            </button>
        </menu>
    </footer>
</form>
