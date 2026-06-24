<div
    x-data="{
        state: @js($selected),
        inherited: @js($inherited),
        inheritedAccess: @js($inheritedAccess),
        cycle() {
            const order = ['inherit', 'allow', 'deny'];
            this.state = order[(order.indexOf(this.state) + 1) % 3];
        }
    }"
>
    <input type="hidden" name="{{ $name }}" value="{{ $selected }}" x-bind:value="state" />
    <button
        type="button"
        @click="cycle()"
        @if (!empty($label)) aria-label="{{ $label }}" @endif
        class="w-full flex items-center justify-center gap-1.5 px-3 py-2 rounded-lg text-sm font-medium border transition-all duration-150 cursor-pointer select-none"
        :class="{
            'border-dashed border-neutral-300 text-neutral-400 hover:border-neutral-400 hover:text-neutral-500': state === 'inherit' && !inherited,
            'border-dashed border-neutral-300 text-green-600 hover:bg-green-50': state === 'inherit' && inherited && inheritedAccess,
            'border-dashed border-red-400 text-red-500 hover:bg-red-50': state === 'inherit' && inherited && !inheritedAccess,
            'border-green-500 bg-green-50 text-green-700 hover:bg-green-100': state === 'allow',
            'border-red-400 bg-red-50 text-red-600 hover:bg-red-100': state === 'deny',
        }"
    >
        <i
            class="fa-regular text-xs"
            :class="{
                'fa-minus': state === 'inherit' && !inherited,
                'fa-check': (state === 'inherit' && inherited) || state === 'allow',
                'fa-xmark': state === 'deny',
            }"
            aria-hidden="true"
        ></i>
        <span x-text="state === 'allow' ? @js(__('crud.permissions.actions.bulk_entity.allow')) : state === 'deny' ? @js(__('crud.permissions.actions.bulk_entity.deny')) : @js(__('crud.permissions.actions.bulk_entity.inherit'))"></span>
    </button>
</div>
