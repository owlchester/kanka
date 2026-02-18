<x-grid type="1/1">
    @include('partials.errors')

    {{-- SCENARIO A: Campaign is Public --}}
    @if($campaign->isPublic())
        @if($entity->is_private)
            {{-- Entity is Hidden --}}
            <div class="mb-4">
                <div class="text-sm text-warning font-bold mb-1">
                    <i class="fa-solid fa-eye-slash mr-1"></i>
                    {{ __('entities/share.status.hidden') }}
                </div>
                <p class="text-xs text-neutral-content">
                    {{ __('entities/share.helpers.hidden_explanation') }}
                </p>
            </div>

            <x-forms.field
                field="visibility_mode"
                required
                :label="__('entities/share.fields.visibility_mode')"
                :helper="__('entities/share.helpers.visibility_mode')">
                
                <x-forms.select 
                    name="visibility_mode" 
                    radio 
                    :options="[
                        'entity' => __('entities/share.options.make_entity_public'),
                        'global' => __('entities/share.options.make_all_public'),
                    ]" 
                    :selected="old('visibility_mode', 'entity')" 
                />
            </x-forms.field>
        @else
            {{-- Entity and Campaign are both Public --}}
            <div class="mb-6 p-4 bg-success/10 border border-success/20 rounded-lg">
                <div class="text-sm text-success font-bold mb-1">
                    <i class="fa-solid fa-globe mr-1"></i>
                    {{ __('entities/share.status.public') }}
                </div>
                <p class="text-xs text-neutral-content">
                    {{ __('entities/share.helpers.public_explanation') }}
                </p>
            </div>
        @endif

    {{-- SCENARIO B: Campaign is Private --}}
    @else
        <div class="mb-4">
            <div class="text-sm text-neutral-500 font-bold mb-1">
                <i class="fa-solid fa-lock mr-1"></i>
                {{ __('entities/share.status.private') }}
            </div>
            <p class="text-xs text-neutral-content">
                {{ __('entities/share.helpers.private_explanation') }}
            </p>
        </div>

        <x-forms.field
            field="campaign_visibility"
            required
            :label="__('entities/share.fields.campaign_access')"
            :helper="__('entities/share.helpers.campaign_access')">
            
            <x-forms.select 
                name="campaign_visibility" 
                radio 
                :options="[
                    'private' => __('entities/share.options.keep_private'),
                    'public'  => __('entities/share.options.make_campaign_public'),
                ]" 
                :selected="old('campaign_visibility', 'private')" 
            />
        </x-forms.field>
    @endif

    {{-- Secondary: Copy Link (Always available/Read-only) --}}
    <x-forms.field field="link_readonly" :label="__('entities/share.labels.share_link')">
        <div class="join w-full">
            <input 
                id="entity-share-link"
                class="input input-bordered join-item w-full text-sm font-mono" 
                value="{{ $entity->url() }}" 
                readonly 
            />
            <button 
                type="button" 
                class="btn join-item btn-default" 
                onclick="navigator.clipboard.writeText('{{ $entity->url() }}'); toastr.success('{{ __('entities/share.success.copied') }}')"
                data-toggle="tooltip"
                title="{{ __('entities/share.buttons.copy') }}"
            >
                <i class="fa-solid fa-copy"></i>
            </button>
        </div>
    </x-forms.field>
</x-grid>