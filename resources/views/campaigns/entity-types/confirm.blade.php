@extends('layouts.app', [
    'title' => __('campaigns/modules.delete.title') . ' - ' . $campaign->name,
    'breadcrumbs' => [
        __('campaigns.show.tabs.modules')
    ],
    'canonical' => true,
    'mainTitle' => false,
    'sidebar' => 'campaign',
    'centered' => true,
])

@section('content')
    <div class="flex gap-5 flex-col">
        @include('ads.top')
        @include('partials.errors')
        <h1>{{ __('campaigns/modules.delete.title') }}</h1>



        <p>
            {!! __('campaigns/modules.delete.helper', ['name' => $entityType->name()]) !!}

            {!! __('crud.delete_modal.permanent') !!}
        </p>


        <x-box>
            <x-form :action="['entity_types.destroy', $campaign, $entityType]" method="DELETE" class="w-full">
                <x-grid type="1/1">
                    <p class="">
                        {!! __('campaigns/modules.delete.confirm', [
                            'campaign' => '<strong>' . $entityType->name . '</strong>',
                            'code' => '<code>delete</code>'
                        ]) !!}
                    </p>

                    <div class="required field flex gap-2 flex-wrap">
                        <input type="text" name="delete" @if (config('app.debug')) value="delete" @endif autofocus maxlength="10" required id="module-delete-form" class="w-full" />
                    </div>


                    <x-buttons.confirm type="danger" full="true">
                        <x-icon class="trash" />
                        {!! __('campaigns/delete.confirm-button', [
                            'name' => $entityType->name()]) !!}
                    </x-buttons.confirm>

                </x-grid>
            </x-form>
        </x-box>
    </div>

@endsection


