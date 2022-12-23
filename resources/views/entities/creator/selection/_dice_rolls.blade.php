<div class="option flex">

    @include('entities.creator.selection._main', [
        'singular' => 'dice_roll',
        'plural' => 'dice_rolls',
        'icon' => 'ra ra-dice-five'
    ])
    @include('entities.creator.selection._full', ['key' => 'dice_rolls'])
</div>
