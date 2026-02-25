<div class="flex flex-col gap-4">
    <div class="flex items-start gap-4">
        @if ($application->user->hasAvatar())
            <x-users.avatar :user="$application->user" class="h-14 w-14 rounded-full" size="80" />
        @endif

        <div class="flex flex-col">
            <div class="flex items-baseline gap-3">
                <span class="text-xl font-bold">{!! $application->user->name !!}</span>

                @php
                    $expLabel = match($application->experience) {
                        0 => __('campaigns/applications.experience.new'),
                        1 => __('campaigns/applications.experience.intermediate'),
                        2 => __('campaigns/applications.experience.veteran'),
                        default => 'Unknown'
                    };
                @endphp
                <span class="badge badge-primary badge-outline capitalize">
                    {{ $expLabel }}
                </span>
            </div>

            <span class="text-neutral-content text-sm" title="{{ $application->created_at }}">
                Applied {{ $application->created_at->diffForHumans() }}
            </span>
        </div>
    </div>

    <hr />

    <div class="space-y-1">
        <p class="text-sm font-medium text-base-content/70">
            {{ __('campaigns/applications.fields.character_concept') }}
        </p>
        <div class="text-sm">
            @if($application->character_concept)
                {!! nl2br(e($application->character_concept)) !!}
            @else
                <span class="italic opacity-50">{{ __('campaigns/applications.placeholders.character_concept') }}</span>
            @endif
        </div>
    </div>

    @if($application->external_link)
        <div class="space-y-1">
            <p class="text-sm font-medium text-base-content/70">
                {{ __('campaigns/applications.fields.external_link') }}
            </p>
            <div class="flex items-center gap-2 text-sm">
                <i class="fa-solid fa-link" aria-hidden="true"></i>
                <a href="{{ $application->external_link }}" target="_blank" class="text-link break-all">
                    {{ $application->external_link }}
                </a>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-base-200 p-4 rounded-lg">

        <div class="space-y-3">
            <p class="text-sm font-medium text-base-content/70">
                {{ __('campaigns/applications.headers.availability') }}
            </p>

            <div class="flex flex-wrap gap-2">
                @forelse($application->availability_days ?? [] as $day)
                    <span class="badge badge-primary badge-outline capitalize">
                        {{ __('campaigns/applications.weekdays.' . $day) }}
                    </span>
                @empty
                    <span class="text-sm opacity-60">Unspecified</span>
                @endforelse
            </div>

            <div class="text-sm">
                <span class="opacity-70">Time:</span>
                <span class="font-medium">
                    {{ $application->time_start ? \Carbon\Carbon::parse($application->time_start)->format('H:i') : '?' }}
                    -
                    {{ $application->time_end ? \Carbon\Carbon::parse($application->time_end)->format('H:i') : '?' }}
                </span>
                <div class="text-xs opacity-60 mt-1">
                    ({{ $application->timezone ?? 'UTC' }})
                </div>
            </div>
        </div>

        <div class="space-y-4">
            <p class="text-sm font-medium text-base-content/70">
                {{ __('campaigns/applications.headers.preferences') }}
            </p>

            <div>
                <div class="flex justify-between text-xs opacity-70 mb-2">
                    <span>{{ __('campaigns/applications.labels.rp_heavy') }}</span>
                    <span>{{ __('campaigns/applications.labels.combat_focused') }}</span>
                </div>
                <div class="relative w-full h-6 flex items-center">
                    <div class="relative w-full h-1.5 rounded-full bg-base-300">
                        <div class="absolute h-full rounded-full bg-primary" style="width: {{ ($application->pref_rp_combat ?? 1) * 50 }}%;"></div>
                    </div>
                    <div class="absolute w-5 h-5 bg-base-100 border-2 border-primary rounded-full shadow-md z-10 transition-all duration-300"
                        style="left: {{ ($application->pref_rp_combat ?? 1) * 50 }}%; transform: translateX(-50%);">
                        <div class="absolute inset-1 bg-primary/20 rounded-full"></div>
                    </div>
                </div>
            </div>

            <div>
                <div class="flex justify-between text-xs opacity-70 mb-2">
                    <span>{{ __('campaigns/applications.labels.serious') }}</span>
                    <span>{{ __('campaigns/applications.labels.casual') }}</span>
                </div>
                <div class="relative w-full h-6 flex items-center">
                    <div class="relative w-full h-1.5 rounded-full bg-base-300">
                        <div class="absolute h-full rounded-full bg-primary" style="width: {{ ($application->pref_tone ?? 1) * 50 }}%;"></div>
                    </div>
                    <div class="absolute w-5 h-5 bg-base-100 border-2 border-primary rounded-full shadow-md z-10 transition-all duration-300"
                        style="left: {{ ($application->pref_tone ?? 1) * 50 }}%; transform: translateX(-50%);">
                        <div class="absolute inset-1 bg-primary/20 rounded-full"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($application->additional_notes)
        <div class="space-y-1">
            <p class="text-sm font-medium text-base-content/70">
                {{ __('campaigns/applications.fields.additional_notes') }}
            </p>
            <div class="text-sm">
                {!! nl2br(e($application->additional_notes)) !!}
            </div>
        </div>
    @endif
</div>
