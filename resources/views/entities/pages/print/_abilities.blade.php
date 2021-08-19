@inject('abilities', 'App\Services\Entity\AbilityService')
@php $entityAbilities = $abilities->entity($entity)->abilities() @endphp

<div class="print-box-abilities">

    <h2>{{ __('crud.tabs.abilities') }}</h2>

    @foreach ($entityAbilities['parents'] as $parent)
        <div class="box box-solid parent-ability parent-ability-{{ $parent['id'] }}">
            <div class="box-header">
            <h3 class="box-title">{{ $parent['name'] }}</h3>
            </div>
            <div class="box-body">
            @foreach ($parent['abilities'] as $ability)
                <div class="box box-solid ability ability-{{ $ability['ability_id'] }}">
                    <div class="box-header">
                        <strong>{{ $ability['name'] }}</strong>
                        @if ($ability['type']) - <i>{{ $ability['type'] }}</i>@endif
                    </div>

                    <div class="box-body">
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
                    </div>
                </div>
            @endforeach
            </div>
        </div>
    @endforeach

    @foreach ($entityAbilities['abilities'] as $ability)
        <div class="box box-solid ability ability-{{ $ability['ability_id'] }}">
            <div class="box-header">
                <strong>{{ $ability['name'] }}</strong>
                @if ($ability['type']) - <i>{{ $ability['type'] }}</i>@endif
            </div>

            <div class="box-body">
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
            </div>
        </div>
    @endforeach
</div>
