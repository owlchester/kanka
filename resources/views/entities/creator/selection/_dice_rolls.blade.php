<div class="option flex">

    @include('entities.creator.selection._main', [
        'singular' => 'dice_roll',
        'plural' => 'dice_rolls',
        'icon' => config('entities.icons.dice_roll'),
        'id' => config('entities.ids.dice_roll'),
    ])
    @include('entities.creator.selection._full', ['key' => 'dice_rolls'])
</div>
