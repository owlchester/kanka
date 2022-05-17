<div class="modal fade" id="{{ $id }}" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content rounded-2xl">
            <div class="modal-body text-center">
                <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    {!! $title !!}
                </h4>

                @foreach ($textes as $text)
                    <p class="my-5">{!! $text !!}</p>
                @endforeach
            </div>
        </div>
    </div>
</div>
