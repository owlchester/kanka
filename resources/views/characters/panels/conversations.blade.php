<div class="box box-solid">
    <div class="box-body">
        <h2 class="page-header ">
            {{ trans('characters.show.tabs.conversations') }}
        </h2>

        <?php  $r = $model->conversations()->orderBy('name', 'ASC')->with(['participants'])->paginate(); ?>
        <table id="character-conversations" class="table table-hover {{ $r->count() === 0 ? 'export-hidden' : '' }}">
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

        {{ $r->links() }}
    </div>
</div>
