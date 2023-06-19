<?php /** @var \App\Models\Character $model */
$appearances = $model->characterTraits()->appearance()->orderBy('default_order')->get();
?>

@if (count($appearances) > 0)
    <div class="box box-solid character-appearances">
        <div class="box-header with-border">
            <h3 class="box-title cursor-pointer element-toggle" data-toggle="collapse" data-target="#character-appearance-body" data-short="character-appearance-toggle">
                <i class="fa-solid fa-chevron-up icon-show" aria-hidden="true"></i>
                <i class="fa-solid fa-chevron-down icon-hide" aria-hidden="true"></i>
                {{ __('characters.sections.appearance') }}
            </h3>
        </div>
        <div class="box-body collapse !visible in" id="character-appearance-body">
            <x-grid>
        @foreach ($appearances as $trait)
                <p class="entity-appearance-{{ \Illuminate\Support\Str::slug($trait->name) }}">
                    <b>{{ $trait->name }}</b><br />
                    {{ $trait->entry }}
                </p>
        @endforeach
            </x-grid>
        </div>
    </div>
@endif
