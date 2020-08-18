<div class="panel">
    <div id="entity-creator-selection">
        <div class="panel-heading">
            <button type="button" class="close" data-dismiss="modal" aria-label="{{ trans('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span></button>
            <h4>{{ trans('entities.creator.title') }}</h4>
        </div>
        <div class="panel-body">
            <p class="alert alert-success entity-creator-success" style="display: none"></p>
            <p class="help-block">{{ __('entities.creator.helper') }}</p>
            <div class="row entity-creator">
                @if (isset($entities['characters']))
                    <div class="col-md-4 col-sm-6 col-xs-4">
                        <a href="#" data-toggle="entity-creator" data-url="{{ route('entity-creator.form', ['type' => 'characters']) }}">
                            <i class="fa fa-user fa-2x"></i>
                            {{ __('entities.character') }}
                        </a>
                    </div>
                @endif

                @if (isset($entities['families']))
                    <div class="col-md-4 col-sm-6 col-xs-4">
                        <a href="#" data-toggle="entity-creator" data-url="{{ route('entity-creator.form', ['type' => 'families']) }}">
                            <i class="ra ra-double-team ra-2x"></i>
                            {{ __('entities.family') }}
                        </a>
                    </div>
                @endif

                @if (isset($entities['locations']))
                    <div class="col-md-4 col-sm-6 col-xs-4">
                        <a href="#" data-toggle="entity-creator" data-url="{{ route('entity-creator.form', ['type' => 'locations']) }}">
                            <i class="ra ra-tower ra-2x"></i>
                            {{ __('entities.location') }}
                        </a>
                    </div>
                @endif

                @if (isset($entities['organisations']))
                    <div class="col-md-4 col-sm-6 col-xs-4">
                        <a href="#" data-toggle="entity-creator" data-url="{{ route('entity-creator.form', ['type' => 'organisations']) }}">
                            <i class="ra ra-hood ra-2x"></i>
                            {{ __('entities.organisation') }}
                        </a>
                    </div>
                @endif

                @if (isset($entities['items']))
                    <div class="col-md-4 col-sm-6 col-xs-4">
                        <a href="#" data-toggle="entity-creator" data-url="{{ route('entity-creator.form', ['type' => 'items']) }}">
                            <i class="ra ra-gem-pendant ra-2x"></i>
                            {{ __('entities.item') }}
                        </a>
                    </div>
                @endif

                @if (isset($entities['notes']))
                    <div class="col-md-4 col-sm-6 col-xs-4">
                        <a href="#" data-toggle="entity-creator" data-url="{{ route('entity-creator.form', ['type' => 'notes']) }}">
                            <i class="fas fa-book-open fa-2x"></i>
                            {{ __('entities.note') }}
                        </a>
                    </div>
                @endif

                @if (isset($entities['events']))
                    <div class="col-md-4 col-sm-6 col-xs-4">
<a href="#" data-toggle="entity-creator" data-url="{{ route('entity-creator.form', ['type' => 'events']) }}">
                            <i class="fas fa-bolt fa-2x"></i>
                            {{ __('entities.event') }}
                        </a>
                    </div>
                @endif

                @if (isset($entities['calendars']))
                    <div class="col-md-4 col-sm-6 col-xs-4">
<a href="#" data-toggle="entity-creator" data-url="{{ route('entity-creator.form', ['type' => 'calendar']) }}">
                            <i class="fa fa-calendar fa-2x"></i>
                            {{ __('entities.calendar') }}
                        </a>
                    </div>
                @endif

                @if (isset($entities['races']))
                    <div class="col-md-4 col-sm-6 col-xs-4">
<a href="#" data-toggle="entity-creator" data-url="{{ route('entity-creator.form', ['type' => 'races']) }}">
                            <i class="ra ra-wyvern ra-2x"></i>
                            {{ __('entities.race') }}
                        </a>
                    </div>
                @endif

                @if (isset($entities['quests']))
                    <div class="col-md-4 col-sm-6 col-xs-4">
                        <a href="#" data-toggle="entity-creator" data-url="{{ route('entity-creator.form', ['type' => 'quests']) }}">
                            <i class="ra ra-wooden-sign ra-2x"></i>
                            {{ __('entities.quest') }}
                        </a>
                    </div>
                @endif

                @if (isset($entities['journals']))
                    <div class="col-md-4 col-sm-6 col-xs-4">
                        <a href="#" data-toggle="entity-creator" data-url="{{ route('entity-creator.form', ['type' => 'journals']) }}">
                            <i class="ra ra-quill-ink ra-2x"></i>
                            {{ __('entities.journal') }}
                        </a>
                    </div>
                @endif

                @if (isset($entities['abilities']))
                    <div class="col-md-4 col-sm-6 col-xs-4">
                        <a href="#" data-toggle="entity-creator" data-url="{{ route('entity-creator.form', ['type' => 'abilities']) }}">
                            <i class="ra ra-fire-symbol ra-2x"></i>
                            {{ __('entities.ability') }}
                        </a>
                    </div>
                @endif

                <div class="col-md-4 col-sm-6 col-xs-4">
                    <a href="#" data-toggle="entity-creator" data-url="{{ route('entity-creator.form', ['type' => 'tags']) }}">
                        <i class="fa fa-tags fa-2x"></i>
                        {{ __('entities.tag') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="entity-creator-loader hidden panel-body">
        <div class="row">
            <div class="col-md-12 text-center">
                <i class="fa fa-spin fa-spinner fa-5x"></i>
            </div>
        </div>
    </div>
    <div class="entity-creator-form-panel hidden">
    </div>
</div>
