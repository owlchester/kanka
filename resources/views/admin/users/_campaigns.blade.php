<?php
/** @var \App\User $model
 * @var \App\Models\Campaign $campaign
 */
?>

<div class="box box-solid">
    <div class="box-header with-border">
        <h4 class="box-title">Campaigns</h4>
    </div>
    <div class="box-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Campaign</th>
                    <th>User Roles</th>
                    <th>
                        <span class="hidden-xs">Members</span>
                        <i class="fa fa-users visible-xs"></i>
                    </th>
                    <th>
                        <span class="hidden-xs">Boosted</span>
                        <i class="fa fa-rocket visible-xs"></i>
                    </th>
                </tr>
                </thead>
                <tbody>

                @foreach ($model->campaigns as $campaign)
                    <tr>
                        <td>
                            {{ $campaign->id }}
                        </td>
                        <td>
                            <a href="{{ route('admin.campaigns.show', $campaign) }}">
                                {!! $campaign->name !!}
                            </a>
                            @if ($campaign->isPublic())
                                <i class="fa fa-eye" title="Campaign is public"></i>
                            @else
                                <i class="fa fa-lock" title="Campaign is private"></i>
                            @endif
                        </td>
                        <td>
                            @foreach ($model->campaignRoles->where('campaign_id', $campaign->id) as $role)
                                <span class="label label-default">{{ $role->name }}</span>
                            @endforeach
                        </td>
                        <td>
                            {{ $campaign->members->count() }}
                        </td>
                        <td>
                            @if ($campaign->superboosted())
                                <span class="label label-info hidden-xs">
                            Superboosted
                        </span>

                                <span class="label label-info visible-xs">
                            SB
                        </span>


                            @elseif ($campaign->boosted())
                                <span class="label label-info hidden-xs">Boosted</span>
                                <i class="fa fa-rocker visible-xs"></i>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
