<?php /**
 * @var \App\Models\CommunityEvent $model
 * @var \App\Models\CommunityEventEntry $entry
 * */?>
<h2 class="cart-title mb 1">
    {{ __('front/community-events.participate.title') }}
</h2>

@include('partials.success')
@include('partials.errors')

@if (!auth()->check())
    <p class="text-warning">{{ __('front/community-events.participate.login') }}</p>
@elseif($participated = $model->userEntry(auth()->user()->id))
    <p class="text-muted"> {{ __('front/community-events.participate.participated') }}</p>
    {!! Form::model($participated, ['route' => ['community-events.community-event-entries.update', $model, $participated], 'method' => 'PATCH']) !!}

    <div class="col-md-6 mb-3">
        <a href="{{ $participated->link }}" target="_blank" class="float-right"><i class="fa fa-external-link"></i></a>
        <label for="link">{{ __('front/community-events.fields.entity_link') }}</label>
        {!! Form::text('link', null, ['class' => 'form-control', 'placeholder' => __('front/community-events.placeholders.entity_link'), 'required']) !!}
    </div>

    <div class="col-md-6 mb-3">
        <label for="comment">{{ __('front/community-events.fields.comment') }}</label>
        {!! Form::textarea('comment', null, ['class' => 'form-control', 'placeholder' => __('front/community-events.placeholders.comment'), 'rows' => 3]) !!}
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <input type="submit" class="btn btn-primary" value="{{ __('front/community-events.actions.update') }}" />
            {!! Form::close() !!}
        </div>
        <div class="col-md-6 text-right">
            {!! Form::open(['method' => 'DELETE','route' => ['community-events.community-event-entries.destroy', $model, $participated], 'style'=>'display:inline', 'id' => 'delete-confirm-form']) !!}
            <input type="submit" class="btn btn-danger" value="{{__('crud.remove')}}" />
            {!! Form::close() !!}
        </div>
    </div>
@else
    <p class="text-muted"> {{ __('front/community-events.participate.description') }}</p>

    {!! Form::open(['route' => ['community-events.community-event-entries.store', $model], 'method' => 'POST']) !!}

    <div class="col-md-6 mb-3">
        <label for="link">{{ __('front/community-events.fields.entity_link') }}</label>
        {!! Form::text('link', null, ['class' => 'form-control', 'placeholder' => __('front/community-events.placeholders.entity_link'), 'required']) !!}
    </div>

    <div class="col-md-6 mb-3">
        <label for="comment">{{ __('front/community-events.fields.comment') }}</label>
        {!! Form::textarea('comment', null, ['class' => 'form-control', 'placeholder' => __('front/community-events.placeholders.comment'), 'rows' => 3]) !!}
    </div>

    <div class="col-md-6 mb-3">
        <input type="submit" class="btn btn-primary" value="{{ __('front/community-events.actions.send') }}" />
    </div>
    {!! Form::close() !!}
@endif
