@inject('abilities', 'App\Services\Abilities\AbilityService')
@php $entityAbilities = $abilities->campaign($campaign)->entity($entity)->get() @endphp

<div class="print-box-abilities">

    <h2>{{ __('entities.abilities') }}</h2>

    @foreach ($entityAbilities['groups'] as $parent)
        <h3 class="box-title text-xl">{{ $parent['name'] }}</h3>
        <div class="parent-ability parent-ability-{{ $parent['id'] }}">
            @foreach ($parent['abilities'] as $ability)
                <div class="ability ability-{{ $ability['ability_id'] }}">
                    <h3 class="text-xl">
                        <strong>{{ $ability['name'] }}</strong>
                        @if ($ability['type']) - <i>{{ $ability['type'] }}</i>@endif
                    </h3>

                    <x-box >
                        {!! $ability['entry'] !!}

                        @if ($ability['note'])
                            <x-helper>
                                <p>{!! $ability['note'] !!}</p>
                            </x-helper>
                        @endif

                        @if(!empty($ability['charges']))
                            <div class="ability-charges">
                            @for ($i = 1; $i <= $ability['charges']; $i++)
                                @if ($i <= $ability['used_charges'])
                                [ x ]
                                @else
                                [ &nbsp; ]
                                @endif
                            @endfor
                            </div>
                        @endif
                    </x-box>
                </div>
            @endforeach
            </div>
        </div>
    @endforeach
</div>
