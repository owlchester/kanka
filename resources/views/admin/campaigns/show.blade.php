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
                    <dd>{{ $model->isPublic() ? 'Public' : 'Private' }}</dd>
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
                            <i class="fa-solid fa-rocker visible-xs"></i>
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
                    <a href="#" class="btn btn-box-tool" data-toggle="modal" data-target="#campaign-featured">
                        <i class="fa-solid fa-pencil-alt"></i>
                    </a>

                </div>
            </div>
            <div class="box-body">
                <dl class="dl-horizontal">
                    <dt>Is Featured</dt>
                    <dd>{{ $model->is_featured ? 'Yes' : 'No' }}</dd>
                    @if ($model->is_featured)
                    <dt>Until</dt>
                    <dd>
                        @if ($model->featured_until)
                        <span class="" data-toggle="tooltip" title="{{ $model->featured_until}} UTC">
                        {{ $model->featured_until->diffForHumans() }}
                        </span>
                        @endif
                    </dd>
                    <dt>Reason</dt>
                    <dd>
                        {!! $model->featured_reason !!}
                    </dd>
                    @endif
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



<div class="modal fade" id="campaign-featured" role="dialog" aria-labelledby="deleteConfirmLabel">
    <div class="modal-dialog" role="document">

        {!! Form::model($model, ['route' => ['admin.campaigns.featured', $model]]) !!}
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('crud.click_modal.close') }}"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="clickModalLabel">
                    Featured status
                </h4>
            </div>
            <div class="modal-body">
                @include('admin.campaigns.forms.featured')
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </div>
        {!! Form::close() !!}

    </div>
</div>
