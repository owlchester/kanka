@extends('layouts.app', [
    'title' => __('campaigns/recovery.title') . ' - ' . $campaign->name,
    'breadcrumbs' => [
        __('campaigns.show.tabs.recovery')
    ],
    'mainTitle' => false,
    'sidebar' => 'campaign',
    'centered' => true,
])

@section('content')

    <div class="flex gap-5 flex-col">
        @include('partials.errors')
        <div class="flex gap-2 items-center">
            <h3 class="inline-block grow">
                @if (isset($isPost))
                    {{ __('campaigns/recovery.post-title') }}
                @else
                    {{ __('campaigns/recovery.title') }}
                @endif
            </h3>
            <button class="btn2 btn-sm btn-ghost" data-toggle="dialog"
                    data-target="recovery-help">
                <x-icon class="question" />
                {{ __('crud.actions.help') }}
            </button>
            @if(isset($isPost))
                <a class="btn2 btn-sm" href="{{ route('recovery', [$campaign]) }}">
                    <x-icon class="fa-solid fa-rotate" />
                    {{ __('campaigns/recovery.toggle.entity') }}
                </a>
            @else
                <a class="btn2 btn-sm" href="{{ route('recovery.posts', [$campaign]) }}">
                    <x-icon class="fa-solid fa-rotate" />
                    {{ __('campaigns/recovery.toggle.post') }}
                </a>
            @endif
        </div>
        @if (session()->get('boosted-pitch'))
            <x-cta :campaign="$campaign">
            </x-cta>
        @endif

        @if(Datagrid::hasBulks())
            <x-form :action="[isset($isPost) ? 'recovery.save.posts' : 'recovery.save', $campaign]" :shortcut="false">
                <div id="datagrid-parent" class="table-responsive">
                    @include('layouts.datagrid._table')
                </div>
            </x-form>
        @else
        <div id="datagrid-parent" class="table-responsive">
            @include('layouts.datagrid._table')
        </div>
        @endif
    </div>
@endsection


@section('modals')
    @parent
    <x-dialog id="recovery-help" :title="__('campaigns.show.tabs.recovery')">
        <p>{!! __('campaigns/recovery.helper', ['count' => '<code>' . config('entities.hard_delete') . '</code>']) !!}</p>
    </x-dialog>

@endsection

