<form class="pagination-ajax-body max-w-2xl">
    <x-dialog.header>
        {!! $entity->name !!}
        @if (isset($post)) - {!! $post->name !!} @endif
    </x-dialog.header>
    <x-dialog.article>
        <div class="modal-loading text-center text-xl p-5 hidden">
            <x-icon class="load" />
        </div>
        <div class="pagination-ajax-content w-full">


            {{--                <table class="table table-hover break-all">--}}
            {{--                    <thead>--}}
            {{--                        <tr>--}}
            {{--                            <th>{{ __('entities/logs.fields.action') }}</th>--}}
            {{--                            <th>{{ __('campaigns.members.fields.name') }}</th>--}}
            {{--                            <th>{{ __('entities/logs.fields.date') }}</th>--}}
            {{--                            <th></th>--}}
            {{--                        </tr>--}}
            {{--                    </thead>--}}
            {{--                    <tbody>--}}
            {{--                    @foreach ($logs as $log)--}}
            {{--                        @if ($log->action < 7 || $log->post)--}}
            {{--                            <tr>--}}
            {{--                                <td class="wrap-break-word">--}}
            {{--                                    {{ __('entities/logs.actions.' . $log->actionCode(), ['post' => $log->post?->name]) }}--}}
            {{--                                </td>--}}
            {{--                                <td class="">@if ($log->user)--}}
            {{--                                         <a href="{{  route('users.profile', $log->user) }}">{!! $log->user->name !!}</a>--}}
            {{--                                    @else--}}
            {{--                                        {{  __('crud.history.unknown') }}--}}
            {{--                                    @endif--}}

            {{--                                    @if ($log->impersonator)--}}
            {{--                                        ({{ __('entities/logs.impersonated', ['name' => $log->impersonator->name]) }})--}}
            {{--                                    @endif--}}
            {{--                                </td>--}}
            {{--                                <td>--}}
            {{--                                    <span data-title="{{ $log->created_at }} UTC" data-toggle="tooltip" class="text-xs">--}}
            {{--                                        {{ $log->created_at->diffForHumans() }}--}}
            {{--                                    </span>--}}
            {{--                                </td>--}}
            {{--                                <td class="text-right">--}}
            {{--                                    @if ($campaign->superboosted())--}}
            {{--                                        @if(!empty($log->changes))--}}
            {{--                                            <a href="#log-{{ $log->id }}" data-animate="collapse">--}}
            {{--                                                <x-icon class="fa-solid fa-scroll" />--}}
            {{--                                                <span class="hidden md:inline">{{ __('entities/logs.actions.view') }}</span>--}}
            {{--                                            </a>--}}
            {{--                                        @endif--}}
            {{--                                    @else--}}
            {{--                                    <a href="#log-cta" data-animate="collapse">--}}
            {{--                                        <x-icon class="fa-solid fa-scroll" />--}}
            {{--                                        <span class="hidden md:inline">{{ __('entities/logs.actions.view') }}</span>--}}
            {{--                                    </a>--}}
            {{--                                    @endif--}}
            {{--                                </td>--}}
            {{--                            </tr>--}}
            {{--                        @endif--}}
            {{--                        @if ($campaign->superboosted() && !empty($log->changes))--}}
            {{--                        <tr id="log-{{ $log->id }}" class="hidden">--}}
            {{--                            <td colspan="4">--}}
            {{--                                <dl class="dl-horizontal">--}}
            {{--                                    @foreach ($log->changes as $attribute => $value)--}}
            {{--                                        @if (is_array($value)) @continue @endif--}}
            {{--                                        <dt>{!! $log->attributeKey($transKey, $attribute) !!}</dt>--}}
            {{--                                        <dd class="break-all">{{ $value }}</dd>--}}
            {{--                                    @endforeach--}}
            {{--                                </dl>--}}
            {{--                            </td>--}}
            {{--                        </tr>--}}
            {{--                        @endif--}}
            {{--                    @endforeach--}}
            {{--                    @if (!$campaign->superboosted())--}}
            {{--                    <tr id="log-cta" class="hidden">--}}
            {{--                        <td colspan="4">--}}
            {{--                                <x-helper>{!! __('entities/logs.call-to-action', [--}}
            {{--'amount' => config('entities.logs'),--}}
            {{--]) !!}</x-helper>--}}
            {{--                            @can('boost', auth()->user())--}}
            {{--                                <a href="{{ route('settings.premium', ['campaign' => $campaign]) }}" class="btn2 bg-boost text-white">--}}
            {{--                                    {!! __('settings/premium.actions.unlock', ['campaign' => $campaign->name]) !!}--}}
            {{--                                </a>--}}
            {{--                            @else--}}
            {{--                                <a href="{{ \App\Facades\Domain::toFront('premium')  }}" class="btn2 bg-boost text-white">--}}
            {{--                                    {!! __('callouts.premium.learn-more') !!}--}}
            {{--                                </a>--}}
            {{--                            @endif--}}
            {{--                        </td>--}}
            {{--                    </tr>--}}
            {{--                    @endif--}}
            {{--                    </tbody>--}}
            {{--                </table>--}}
        </div>
    </x-dialog.article>

</form>
