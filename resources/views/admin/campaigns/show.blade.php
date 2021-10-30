<?php
/**
 * @var \App\Models\Campaign $model
 * @var \App\Models\CampaignUser $member
 */
?>


<div class="row margin-bottom">
    <div class="col-md-12">
        @include('layouts.datagrid.search', ['route' => route('admin.campaigns.index')])
    </div>
</div>



<div class="row">
    <div class="col-md-6">
        <div class="box box-solid">
            <div class="box-header with-border">
                <h4 class="box-title">{!! $model->name !!} #{{ $model->id }}</h4>
            </div>
            <div class="box-body">
                <dl class="dl-horizontal">
                    <dt>Visibility</dt>
                    <dd>{{ $model->visibility }}</dd>
                    <dt>Boost status</dt>
                    <dd>
                        @if ($model->boost_count > 1)
                            <span class="label label-info hidden-xs">
                            Superboosted
                        </span>

                            <span class="label label-info visible-xs">
                            SB
                        </span>


                        @elseif ($model->boost_count == 1)
                            <span class="label label-info hidden-xs">Boosted</span>
                            <i class="fa fa-rocker visible-xs"></i>
                        @endif
                    </dd>

                    <dt>Application status</dt>
                    <dd>{{ $model->is_open ? 'Open' : 'Closed' }}</dd>
                </dl>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="box box-solid">
            <div class="box-header with-border">
                <h4 class="box-title">Featured status</h4>
                <div class="box-tools">
                    <a href="#" role="button" class="btn btn-box-tool">
                        <i class="fas fa-pencil"></i>
                    </a>
                </div>
            </div>
            <div class="box-body">
                <dl class="dl-horizontal">
                    <dt>Is Featured</dt>
                    <dd>{{ $model->is_featured ? 'Yes' : 'No' }}</dd>
                    <dt>Feature Reason</dt>
                    <dd>TBD</dd>
                </dl>
            </div>

        </div>
    </div>
</div>


<div class="box box-solid">
    <div class="box-header with-border">
        <h4 class="box-title">Members</h4>
    </div>
    <div class="box-body">
        <div class="table-responsive">
        <table class="table table-hover">
            <thead>
            <tr>
                <th>#</th>
                <th>User</th>
                <th>Roles</th>
            </tr>
            </thead>
            <tbody>

            @foreach ($model->members()->with(['user', 'user.campaignRoles'])->get() as $member)
                <tr>
                    <td>
                        #{{ $member->id }}
                    </td>
                    <td>
                        <a href="{{ route('admin.users.show', $member->user->id) }}">
                        {!! $member->user->name !!}
                        </a>
                    </td>
                    <td>
                        @foreach ($member->user->campaignRoles()->where('campaign_id', $model->id)->get() as $role)
                            <span title="#{{ $role->id }}">
                            {!! $role->name !!}
                            </span>
                        @endforeach
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        </div>
    </div>
</div>
