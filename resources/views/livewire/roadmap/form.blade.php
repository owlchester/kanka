<form wire:submit="save">
    <div class="bg-purple text-white rounded-2xl p-5 flex flex-col gap-5">
        <h3>Share your ideas</h3>
        <p class="text-light">Have an idea to improve Kanka? Share it with our development team.</p>

        @if ($success)
            <div class="rounded bg-green-300 p-2 text-dark">
                Your idea has been submitted! Once approved, you will receive a notification and others will be able to upvote it.
            </div>
        @endif

        @auth()
            @cannot ('create', \App\Models\Feature::class)
                <p>You have reached the daily limit of 10 submitted ideas! Please try again tomorrow.</p>
            @else
                <div class="field field-name">
                    <label>One sentence that summarises your idea</label>
                    <input type="text" maxlength="80" class="rounded text-dark w-full p-2 bg-white" wire:model.blur="title" />
                    <div>
                        @error('title') <span class="text-red-300">{{ $message }}</span> @enderror
                    </div>

                    @if (isset($duplicates) && !empty($duplicates) && !$duplicates->isEmpty())
                        <div class="text-orange-300">
                            <p>This idea might already exist. Here are some similar named ideas already being voted on.</p>
                            <ul>
                                @foreach ($duplicates as $dup)
                                    <li>
                                        <span role="button" class="text-orange-300 hover:text-orange-500" wire:click="open({{ $dup }})">
                                        {!! $dup->name !!}
                                        </span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>

                <div class="field field-description">
                    <label>Why your idea is useful, who should benefit and how should it work?</label>
                    <textarea wire:model="description" class="rounded text-dark w-full p-2 bg-white" rows="5"></textarea>
                    <div>
                        @error('description') <span class="text-red-300">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="field field-description">
                    <label>An image is worth a thousand words. Show us how you think the idea should look like.</label>
                    <input type="file" wire:model="file" class="w-full bg-white rounded text-dark p-2" accept=".jpg, .jpeg, .png" id="upload-{{ $iteration }}">
                    <div>
                        @error('file') <span class="text-red-300">{{ $message }}</span> @enderror
                    </div>
                </div>

                <p class="text-light">Once reviewed, your idea will show up in the ideas section. If we have questions, we'll contact you on the <a href="https://kanka.io/go/discord" class="link link-light">Discord</a>.</p>

                <input type="submit" value="Submit idea" class="btn-round rounded-full" />
            @endif
        @else

            <a href="{{ route('login') }}" class="btn-round rounded-full text-center">Log in to submit ideas</a>
        @endauth
    </div>
</form>
