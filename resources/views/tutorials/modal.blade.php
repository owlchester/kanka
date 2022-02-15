
<div class="modal fade tutorial-modal" id="tutorial-modal" role="dialog" aria-labelledby="tutorialModal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="tutorialModalTitle">{{ __('tutorials/' . $title) }}</h4>
            </div>
            <div class="modal-body">
                @foreach($contents as $paragraph)
                    <p>{{ __('tutorials/' . $paragraph) }}</p>
                @endforeach
            </div>
            <div class="modal-footer">
                <button class="btn btn-warning pull-left" data-tutorial="disable" data-url="{{ route('settings.tutorial.disable') }}">
                    {{ __('tutorials/actions.disable') }}
                </button>
                <button class="btn btn-success" data-tutorial="next" data-url="{{ route('settings.tutorial.done', ['tutorial' => $key]) }}">
                    {{ __('tutorials/actions.next') }}
                </button>
            </div>
        </div>
    </div>
</div>
