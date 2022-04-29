<?php
/**
 * @var \App\Models\TimelineElement[]|\Illuminate\Pagination\LengthAwarePaginator $timelines
 *
 */
?>
<div class="box box-solid box-entity-timelines" id="entity-timelines">
    <div class="box-header">
        <h3 class="box-title">
            {{ __('crud.tabs.timelines') }}
        </h3>
    </div>
    <div class="box-body">

        <p class="help-block">
            {{ __('entities/timelines.helper') }}
        </p>

        <table id="entity_timelines" class="table table-hover">
            <thead>
            <tr>
                <th class="avatar"><br></th>
                <th>
                    {{ __('entities.timeline') }}
                </th>
                <th>
                    {{ __('timelines/elements.fields.era') }}
                </th>
                <th>
                    {{ __('timelines/elements.fields.date') }}
                </th>
                @if (Auth::check())
                    <th>
                        {{ __('crud.fields.visibility') }}
                    </th>
                @endif
                <th class="text-right">
                    <br />
                </th>
            </tr>
            </thead>
            <tbody>
            @foreach ($timelines as $element)
                @if (empty($element->entity->child))
                    @continue
                @endif
                <tr>
                    <td>
                        <a class="entity-image" style="background-image: url('{{ $element->timeline->getImageUrl(40) }}');" title="{{ $element->timeline->name }}" href="{{ $element->timeline->getLink() }}"></a>
                    </td>
                    <td class="breakable">
                        {!! $element->timeline->tooltipedLink() !!}
                    </td>
                    <td class="breakable">
                        <a href="{{ route('timelines.show', [$element->timeline_id, '#era'. $element->era_id]) }}">
                            {{ $element->era->name }}
                        </a>
                    </td>
                    <td class="breakable">
                        <a href="{{ route('timelines.show', [$element->timeline_id, '#element' . $element->id]) }}">
                            {{ $element->date }}
                            <a/>
                    </td>
                    @if (Auth::check())
                        <td>
                            @include('cruds.partials.visibility', ['model' => $element])
                        </td>
                    @endif
                    <td class="text-right">

                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

    </div>
    @if ($timelines->hasPages())
        <div class="box-footer text-right">
            {{ $timelines->fragment('entity-timelines')->links() }}
        </div>
    @endif
</div>
