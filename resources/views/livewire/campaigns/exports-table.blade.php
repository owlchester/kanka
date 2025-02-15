<div>
    <table class="table table-hover m-0 mb-2 w-full shadow-xs bg-box rounded">
        <thead>
            <tr>
                <th wire:click="sortBy('status')" style="cursor: pointer;">
                    <a href="#" >
                        @if ($sortColumn === 'status')
                            <span>{!! $this->sortIcon() !!}</span>
                        @endif
                        {{ __('campaigns/plugins.fields.status') }}
                    </a>
                </th>
                <th wire:click="sortBy('created_by')" style="cursor: pointer;">
                    <a href="#" >
                        @if ($sortColumn === 'created_by')
                            <span>{!! $this->sortIcon() !!}</span>
                        @endif
                        {{ __('campaigns.members.fields.name') }}
                    </a>
                </th>
                <th wire:click="sortBy('created_at')" style="cursor: pointer;">
                    <a href="#" >
                        @if ($sortColumn === 'created_at')
                            <span>{!! $this->sortIcon() !!}</span>
                        @endif
                        {{ __('campaigns.invites.fields.created') }}
                    </a>
                </th>
                <th>
                    {{ __('campaigns/export.progress') }}
                </th>
                <th>
                    {{ __('campaigns/export.size') }}
                </th>
                <th>
                    {{ __('campaigns/export.actions.download') }}
                </th>
            </tr>
        </thead>
        <tbody wire:poll.{{$updateInterval}}s>
            @forelse ($campaignExports as $campaignExport)
                <tr>
                    <td>{{ $this->status($campaignExport) }}</td>
                    <td>
                        @if ($campaignExport->created_by)
                            <a class="block break-all truncate" href="{!! route('users.profile', [$campaignExport->user]) !!}" target="_blank">
                                {{ $campaignExport->user->name }}
                            </a>
                        @endif
                    </td>
                    <td>
                        <span class="elapsed text-neutral-content text-xs" title="{{ $campaignExport->created_at }} UTC">
                            {{ $campaignExport->created_at->diffForHumans() }}
                        </span>
                    </td>
                    <td>
                        {!! $this->progress($campaignExport) !!}
                    </td>
                    <td>
                        {!! $this->size($campaignExport) !!}
                    </td>
                    <td>
                        {!! $this->download($campaignExport) !!}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">{{ __('crud.datagrid.empty') }}</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Pagination -->
    <div>
        {{ $campaignExports->links() }}
    </div>
</div>
