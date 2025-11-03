<div>
    <div class="flex items-center mb-5">
        <span role="button" wire:click="inProgress()" class="px-2 border-b border-blue-900 hover:font-bold hover:border-b-2 @if (!isset($status) || $status === 'in-progress') font-bold border-b-2 @endif">
            In progress
        </span>
        <span role="button" wire:click="ideas()" class="px-2 border-b border-blue-900 hover:font-bold hover:border-b-2 @if (isset($status) && $status === 'ideas') font-bold border-b-2 @endif">
            Ideas
        </span>
        <span role="button" wire:click="done()" class="px-2 border-b border-blue-900 hover:font-bold hover:border-b-2 @if (isset($status) && $status === 'done') font-bold border-b-2 @endif">
            Done
        </span>
    </div>
    @if (!isset($status) || $status === 'in-progress')
    <div id="in-progress">
        <div class="flex flex-col gap-10">
            @php /** @var \App\Models\FeatureCategory $category **/ @endphp
            @foreach ($categories as $category)
                @if ($category->nothingPlanned())
                    @continue
                @endif
                <div class="rounded-2xl bg-gray-200 overflow-hidden">
                    <h3 class="bg-purple text-white p-5">{{ $category->name }}</h3>
                    <div class="p-5 grid grid-cols-1 xl:grid-cols-4 gap-5">
                        <div class="border-r xl:col-span-2">
                            <h4 class="mb-5">Now</h4>
                            <div class="grid xl:grid-cols-2 gap-5">
                                @foreach ($category->now as $feat)
                                    @include('roadmap.feature._progress', ['feature' => $feat])
                                @endforeach
                            </div>
                        </div>
                        <div class="border-r">
                            <h4 class="mb-5">Next</h4>
                            <div class="flex flex-col gap-5">
                                @foreach ($category->next as $feat)
                                    @include('roadmap.feature._progress', ['feature' => $feat])
                                @endforeach
                            </div>
                        </div>
                        <div class="">
                            <h4 class="mb-5">Later</h4>
                            <div class="flex flex-col gap-5">
                                @foreach ($category->later as $feat)
                                    @include('roadmap.feature._progress', ['feature' => $feat])
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @elseif ($status === 'ideas')
    <div id="ideas">
        <div class="grid xl:grid-cols-4 gap-5">
            <div class="xl:col-span-3 flex flex-col gap-5">
                @livewire('roadmap.ideas')
            </div>

            @livewire('roadmap.form')

        </div>
    </div>
    @elseif ($status === 'done')
        <div id="done">
            <div class="flex flex-col gap-10">
                @php /** @var \App\Models\FeatureCategory $category **/ @endphp
                @foreach ($categories as $category)
                    @if ($category->nothingDone())
                        @continue
                    @endif
                    <div class="rounded-2xl bg-gray-200 overflow-hidden">
                        <h3 class="bg-purple text-white p-5">{{ $category->name }}</h3>
                        <div class="p-5 grid grid-cols-1 xl:grid-cols-4 gap-5">
                            <div class="border-r xl:col-span-4">
                                <div class="grid xl:grid-cols-4 gap-5">
                                    @foreach ($category->done as $feat)
                                        @include('roadmap.feature._progress', ['feature' => $feat])
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    @endif


    @script
    <script>
        const openIdea = (url) => {
            window.openDialog('feature-dialog', url);
        };

        @if ($feature)
        //console.log('opening idea');
        openIdea('{{ route('roadmap.feature.show', $feature) }}');
        @endif

        Livewire.on('open-idea-dialog', (data) => {
            //console.log('opening', data.url);
            openIdea(data.url);
        });

        const target = document.getElementById('feature-dialog');
        target.addEventListener('close', function (event) {
            $wire.dispatch('idea-closed');
        });
    </script>
    @endscript
</div>
