<div class="option flex gap-2">

    @include('entities.creator.selection._main', [
        'singular' => 'dice_roll',
        'plural' => 'dice_rolls',
        'id' => config('entities.ids.dice_roll'),
    ])
    @include('entities.creator.selection._full', ['key' => 'dice_rolls'])
</div>
