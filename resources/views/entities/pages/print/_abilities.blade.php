@inject('abilities', 'App\Services\Entity\AbilityService')
@php $entityAbilities = $abilities->campaign($campaign)->entity($entity)->abilities() @endphp

<div class="print-box-abilities">

    <h2>{{ __('crud.tabs.abilities') }}</h2>

    @foreach ($entityAbilities['parents'] as $parent)
        <h3 class="box-title">{{ $parent['name'] }}</h3>
        <div class="parent-ability parent-ability-{{ $parent['id'] }}">
            @foreach ($parent['abilities'] as $ability)
                <div class="ability ability-{{ $ability['ability_id'] }}">
                    <h3>
                        <strong>{{ $ability['name'] }}</strong>
                        @if ($ability['type']) - <i>{{ $ability['type'] }}</i>@endif
                    </h3>

                    <x-box >
                        {!! $ability['entry'] !!}

                        @if ($ability['note'])
                            <p class="help-block">{!! $ability['note'] !!}</p>
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

    @foreach ($entityAbilities['abilities'] as $ability)
        <div class="ability ability-{{ $ability['ability_id'] }}">
            <h3>
                <strong>{{ $ability['name'] }}</strong>
                @if ($ability['type']) - <i>{{ $ability['type'] }}</i>@endif
            </h3>

            <x-box>
                {!! $ability['entry'] !!}

                @if ($ability['note'])
                    <p class="help-block">{!! $ability['note'] !!}</p>
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
