<div class="box box-solid">
    <div class="box-header">
        <h3 class="box-title">
            {{ __('characters.show.tabs.conversations') }}
        </h3>
    </div>
    <div class="box-body">

        <?php  $r = $model->conversations()->orderBy('name', 'ASC')->with(['participants'])->paginate(); ?>
        <table id="character-conversations" class="table table-hover ">
            <tbody><tr>
                <th class="avatar"><br /></th>
                <th>{{ trans('conversations.fields.name') }}</th>
                <th class="visible-sm">{{ trans('conversations.fields.type') }}</th>
                <th>{{ trans('conversations.fields.participants') }}</th>
                <th>&nbsp;</th>
            </tr>
            @foreach ($r as $conversation)
                <tr>
                    <td>
                        <a class="entity-image" style="background-image: url('{{ $conversation->getImageUrl(40) }}');" title="{{ $conversation->name }}" href="{{ route('conversations.show', $conversation->id) }}"></a>
                    </td>
                    <td>
                        <a href="{{ route('conversations.show', $conversation->id) }}" data-toggle="tooltip" title="{{ $conversation->tooltip() }}">{{ $conversation->name }}</a>
                    </td>
                    <td class="visible-sm">{{ $conversation->type }}</td>
                    <td>
                        {{ $conversation->participants()->count() }}
                    </td>
                    <td class="text-right">
                        <a href="{{ route('conversations.show', [$conversation]) }}" class="btn btn-xs btn-primary">
                            <i class="fa fa-eye" aria-hidden="true"></i> <span class="visible-sm">{{ trans('crud.view') }}</span>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    @if ($r->hasPages())
        <div class="box-footer text-right">
            {{ $r->links() }}
        </div>
    @endif
</div>
