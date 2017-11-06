@extends('layouts.app', [
    'title' => trans('journals.show.title', ['journal' => $journal->name]),
    'description' => trans('journals.show.description'),
    'breadcrumbs' => [
        ['url' => route('journals.index'), 'label' => trans('journals.index.title')],
        $journal->name,
    ]
])

@section('content')
    <div class="row">
        <div class="col-md-3">

            <!-- Profile Image -->
            <div class="box">
                <div class="box-body box-profile">

                    @if ($journal->image)
                    <a href="/storage/{{ $journal->image }}">
                        <img class="profile-user-img img-responsive img-circle" src="/storage/{{ $journal->image }}" alt="{{ $journal->name }} picture">
                    </a>
                    @endif

                    <h3 class="profile-username text-center">{{ $journal->name }}</h3>

                    <ul class="list-group list-group-unbordered">
                        @if ($journal->type)
                        <li class="list-group-item">
                            <b>{{ trans('journals.fields.type') }}</b> <a class="pull-right">{{ $journal->type }}</a>
                        </li>
                        @endif
                        @if ($journal->date)
                        <li class="list-group-item">
                            <b>{{ trans('journals.fields.date') }}</b> <a class="pull-right">{{ $journal->date }}</a>
                        </li>
                        @endif
                    </ul>

                    <a href="{{ route('journals.edit', $journal->id) }}" class="btn btn-primary btn-block">
                        <i class="fa fa-pencil" aria-hidden="true"></i> {{ trans('crud.update') }}
                    </a>

                    <button class="btn btn-block btn-danger delete-confirm" data-name="{{ $journal->name }}" data-toggle="modal" data-target="#delete-confirm">
                        <i class="fa fa-trash" aria-hidden="true"></i> {{ trans('crud.remove') }}
                    </button>
                    {!! Form::open(['method' => 'DELETE','route' => ['journals.destroy', $journal->id], 'style'=>'display:inline', 'id' => 'delete-confirm-form']) !!}
                    {!! Form::close() !!}
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>

        <div class="col-md-9">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#information" data-toggle="tab" aria-expanded="false">History</a></li>
                    <!--<li><a href="#journal" data-toggle="tab" aria-expanded="false">Characters</a></li>-->
                </ul>

                <div class="tab-content">
                    <div class="tab-pane active" id="information">
                        @if (!empty($journal->history))
                        <div class="post">
                            <h3>History</h3>
                            <p>{!! $journal->history !!}</p>
                        </div>
                        @endif
                    </div>
                    <div class="tab-pane" id="journal">
                    </div>
                </div>
            </div>
            </div>

            <!-- actions -->
        </div>
    </div>
@endsection
