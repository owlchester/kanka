<div class="element" data-id="story">
    {!! Form::hidden('posts[]', 'story') !!}
    <div class="dragger">
        <span class="fa-solid fa-ellipsis-v visible-md visible-lg"></span>
        <div class="visible-xs visible-sm">
            <span class="fa-solid fa-arrow-up"></span><br />
            <span class="fa-solid fa-arrow-down"></span>
        </div>
    </div>
    <div class="name">
        <i class="fa-solid fa-align-justify"></i> {{ __('crud.fields.entry') }}
    </div>
    <div class="icons">
    </div>
</div>
