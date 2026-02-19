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

    <hr class="border-gray-200 dark:border-gray-700 my-2">
    <div class="space-y-1">
        <h4 class="text-sm font-bold text-gray-500 uppercase tracking-wide">
            {{ __('campaigns/applications.fields.character_concept') }}
        </h4>
        <div class="text-neutral-content prose prose-sm max-w-none">
            @if($application->character_concept)
                {!! nl2br(e($application->character_concept)) !!}
            @else
                <span class="italic opacity-50">{{ __('campaigns/applications.placeholders.character_concept') }}</span>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-2 bg-base-200 p-4 rounded-lg">
        
        <div class="space-y-3">
            <h4 class="text-sm font-bold text-gray-500 uppercase tracking-wide border-b border-gray-600 pb-1 mb-2">
                {{ __('campaigns/applications.headers.availability') }}
            </h4>
            
            <div class="flex flex-wrap gap-2">
                @forelse($application->availability_days ?? [] as $day)
                    <span class="badge badge-primary badge-outline capitalize">
                        {{ __('campaigns/applications.weekdays.' . $day) }}
                    </span>
                @empty
                    <span class="text-sm opacity-60">Unspecified</span>
                @endforelse
            </div>
            <br/>
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

<div class="space-y-8">
    <h4 class="text-sm font-bold text-gray-500 uppercase tracking-wide border-b border-gray-600 pb-1 mb-2">
        {{ __('campaigns/applications.headers.preferences') }}
    </h4>

    <div>
        <div class="flex justify-between text-xs opacity-70 mb-2">
            <span>{{ __('campaigns/applications.labels.rp_heavy') }}</span>
            <span>{{ __('campaigns/applications.labels.combat_focused') }}</span>
        </div>
        <div class="relative w-full h-6 flex items-center">
            <progress 
                class="progress progress-primary w-full h-1.5" 
                value="{{ ($application->pref_rp_combat ?? 1) * 50 }}" 
                max="100">
            </progress>
            
            <div class="absolute w-5 h-5 bg-white border-2 border-primary rounded-full shadow-md z-10 transition-all duration-300"
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
            <progress 
                class="progress progress-secondary w-full h-1.5" 
                value="{{ ($application->pref_tone ?? 1) * 50 }}" 
                max="100">
            </progress>
            
            <div class="absolute w-5 h-5 bg-white border-2 border-secondary rounded-full shadow-md z-10 transition-all duration-300"
                style="left: {{ ($application->pref_tone ?? 1) * 50 }}%; transform: translateX(-50%);">
                <div class="absolute inset-1 bg-secondary/20 rounded-full"></div>
            </div>
        </div>
    </div>
</div>
    </div>

    @if($application->external_link || $application->additional_notes)
        <div class="mt-4 pt-4 border-t border-base-200 space-y-4">
            @if($application->external_link)
                <div class="flex flex-col gap-1">
                    <span class="text-xs font-bold uppercase text-base-content opacity-60">
                        {{ __('campaigns/applications.fields.external_link') }}
                    </span>
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-link text-primary text-sm"></i>
                        <a href="{{ $application->external_link }}" target="_blank" class="link link-primary text-sm break-all">
                            {{ $application->external_link }}
                        </a>
                    </div>
                </div>
            @endif

            @if($application->additional_notes)
                <div class="flex flex-col gap-1">
                    <span class="text-xs font-bold uppercase text-base-content opacity-60">
                        {{ __('campaigns/applications.fields.additional_notes') }}
                    </span>
                    <div class="alert alert-ghost bg-base-200 p-3 text-sm rounded-md flex items-start gap-2">
                        <span class="italic text-base-content opacity-90">
                            {{ $application->additional_notes }}
                        </span>
                    </div>
                </div>
            @endif
        </div>
    @endif
</div>