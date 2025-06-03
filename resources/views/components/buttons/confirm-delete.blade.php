<div x-data="{ confirm: false }" @click.away="confirm = false" class="btn2 btn-error btn-outline btn-sm">
    <form method="POST" action="{{ $route }}">
        @csrf
        <input type="hidden" name="_method" value="DELETE" />
        <button type="button" @click="confirm ? $el.closest('form').submit() : confirm = true">
            <x-icon class="trash" />
            <span x-text="confirm ? '{{ __('crud.delete_modal.confirm') }}' : '{{ __('crud.remove') }}'"></span>
        </button>
        {!! $slot !!}
    </form>
</div>
