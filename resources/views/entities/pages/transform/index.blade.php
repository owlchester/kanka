@extends('layouts.app', [
    'title' => __('entities/transform.title', ['name' => $entity->name]),
    'breadcrumbs' => [
        Breadcrumb::campaign($campaign)->entity($entity)->list(),
        Breadcrumb::show(),
        __('entities/actions.convert'),
    ],
    'centered' => true,
    'entity' => null,
])

@section('content')
    @include('partials.errors')

    <x-form :action="['entities.transform-process', $campaign, $entity->id]">
        <x-box>
            <x-grid type="1/1">
                <x-helper>
                    <p>{{ __('entities/transform.panel.description') }}</p>
                    <x-slot name="docs">guides/transform.html</x-slot>
                    <x-slot name="doc">{{ __('entities/transform.documentation') }}</x-slot>
                </x-helper>

                <x-forms.field field="current" :label="__('entities/transform.fields.current')">
                    <p class="font-bold">{{ $entity->entityType->name() }}</p>
                </x-forms.field>


                <x-forms.field field="target" :label="__('entities/transform.fields.target')">
                    <x-forms.select name="target" :options="$entities" class="w-full" required />
                </x-forms.field>

                @if (!empty($confirm))
                    <x-forms.field field="confirm" required :label=" __('entities/transform.confirm.label')">
                        <x-checkbox :text="__('entities/transform.confirm.checkbox', ['entity' => $entity->name])">
                            <input type="checkbox" name="confirm" value="1" required/>
                            <x-slot name="extra">
                                <ul>
                                    @foreach ($confirm as $label => $number)
                                        <li>{{ __($label) }}: {{ number_format($number)  }}</li>
                                    @endforeach
                                </ul>
                            </x-slot>
                        </x-checkbox>
                    </x-forms.field>
                @else
                    <input type="hidden" name="confirm" value="1" />
                @endif
            </x-grid>

            <x-dialog.footer class="!px-0">
                <button class="btn2 btn-primary">
                    <x-icon class="fa-regular fa-arrows-rotate" />
                    {{ __('entities/actions.convert') }}
                </button>
            </x-dialog.footer>
        </x-box>
    </x-form>
@endsection
