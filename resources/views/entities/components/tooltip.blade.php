<div class="entity-tooltip-avatar">
    @if($avatar)
        <div>
        <div class="entity-image" style="background-image: url('{{ $avatar }} ');"></div>
        </div>
    @endif
    <div class="entity-names">
        <span class="entity-name">{!! $name !!}</div>
        @if($subtitle)
            <span class="entity-subtitle">{!! $subtitle !!}</span>
        @endif
    </div>
</div>
{!! $text !!}
