<?php /**
 * @var \App\Models\CampaignUser[] $users
 * @var \App\Models\CampaignRole[] $roles
 * @var \App\Models\Campaign $campaign
 */

?>
<div class="flex gap-2 items-center mb-5">
    <h3 class="m-0 inline-block grow">
        {{ __('campaigns.show.tabs.members') }} <span class="text-sm">({{ $users->total() }} / @if ($limit = $campaign->memberLimit()){{ $limit }}@else<i class="fa-solid fa-infinity" aria-hidden="true"></i>@endif)</span>
    </h3>
    <a href="https://docs.kanka.io/en/latest/features/campaigns/members.html" class="btn2 btn-sm btn-ghost" target="_blank">
        <x-icon class="question"></x-icon>
        {{ __('crud.actions.help') }}
    </a>
</div>

@if (!$campaign->canHaveMoreMembers())
    <x-cta :campaign="$campaign" image="0" minimal="1">
        <p>{{ __('campaigns/limits.members') }}</p>
    </x-cta>
@endif

<x-box :padding="false">
    <div class="table-responsive">
        <table id="campaign-members" class="table table-hover table-striped mb-0">
            <thead>
                <tr>
                    <th></th>
                    <th>{{ __('campaigns.members.fields.name') }}</th>
                    <th>{{ __('campaigns.members.fields.roles') }}</th>
                    <th class="hidden-xs hidden-md">{{ __('campaigns.members.fields.joined') }}</th>
                    <th class="hidden-xs hidden-md">{{ __('campaigns.members.fields.last_login') }}</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            @foreach ($users as $relation)
                <tr class="">
                    <td class="w-14">
                        <div class="entity-image pull-left" style="background-image: url({{ $relation->user->getAvatarUrl() }})" title="{{ $relation->user->name }}">
                        </div>
                    </td>
                    <td class=" max-w-30 !align-middle">
                        <a class="block break-all truncate" href="{{ route('users.profile', [$relation->user]) }}" target="_blank">
                            {{ $relation->user->name }}
                        </a>
                        @if ($relation->user->isBanned())
                            <i class="fa-solid fa-ban" aria-hidden="true" data-toggle="tooltip" data-title = "{{ __('campaigns.members.fields.banned') }}"></i>
                        @endif
                    </td>
                    <td class="!align-middle">
                        {!! $relation->user->rolesList($campaign) !!}
                        @can('update', $relation)
                            <i role="button" tabindex="0" class="fa-solid fa-plus-circle cursor-pointer" title="{{ __('campaigns.members.manage_roles') }}" data-toggle="dialog" data-target="member-roles-{{ $relation->id  }}"></i>

                            <x-dialog id="member-roles-{{ $relation->id }}" :title="__('campaigns.members.manage_roles') . ' - ' . $relation->user->name">
                                <div class="w-full flex flex-col gap-2">
                                @foreach($roles as $role)
                                    {!! Form::open(['method' => 'post', 'route' => ['campaign_users.update-roles', [$campaign, $relation, $role]], 'class' => 'w-full']) !!}
                                        <button class='btn2 btn-block btn-feedback @if($relation->user->hasCampaignRole($role->id)) btn-error btn-outline @endif'>
                                            @if($relation->user->hasCampaignRole($role->id))
                                                <x-icon class="trash" />
                                                {{ $role->name }}
                                            @else
                                                <x-icon class="plus" />
                                                {{ $role->name }}
                                            @endif
                                        </button>
                                    {!! Form::close() !!}
                                @endforeach
                                </div>

                            </x-dialog>
                        @endcan
                    </td>
                    <td class="!align-middle hidden-xs hidden-md">
                        @if (!empty($relation->created_at))
                            <span data-title="{{ $relation->created_at }} UTC" data-toggle="tooltip">{{ $relation->created_at->diffForHumans() }}</span>
                        @endif
                    </td>
                    <td class="!align-middle hidden-xs hidden-md">
                        @if ($relation->user->has_last_login_sharing && !empty($relation->user->last_login_at))
                            <span data-title="{{ $relation->user->last_login_at }} UTC" data-toggle="tooltip">{{ $relation->user->last_login_at->diffForHumans() }}</span>
                        @endif
                    </td>
                    <td class="!align-middle text-right">
                        @if(auth()->user()->can('switch', $relation) || auth()->user()->can('delete', $relation))
                            <div class="dropdown">
                                <a class="dropdown-toggle btn2 btn-sm" data-toggle="dropdown" aria-expanded="false" data-placement="right" href="#">
                                    <i class="fa-solid fa-ellipsis-h" data-tree="escape"></i>
                                    <span class="sr-only">{{ __('crud.actions.actions') }}</span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                    @can('switch', $relation)
                                        <li>
                                            <a href="{{ route('identity.switch', [$campaign, $relation]) }}" data-title="{{ __('campaigns.members.helpers.switch') }}" data-toggle="tooltip" class="switch-user">
                                                <i class="fa-solid fa-sign-in-alt" aria-hidden="true"></i>
                                                {{ __('campaigns.members.actions.switch') }}
                                            </a>
                                        </li>
                                        <li class="divider"></li>
                                    @endcan
                                    @can('delete', $relation)
                                        <li>
                                            <a href="#" class="text-red" title="{{ __('crud.remove') }}"
                                               data-toggle="dialog-ajax"
                                               data-target="member-dialog"
                                               data-url="{{ route('campaign_users.delete', [$campaign, $relation->id]) }}"
                                            >
                                                <x-icon class="trash"></x-icon>
                                                {{ __('campaigns.members.actions.remove') }}
                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                            </div>
                        @endif
                    </td>

                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</x-box>
<div class="mb-5">
{!! $users->onEachSide(0)->links() !!}
</div>


@section('modals')
    @parent

    <x-dialog id="member-dialog" :loading="true"></x-dialog>

@endsection
