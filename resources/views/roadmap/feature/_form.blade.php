<form method="POST" action="{{ route('roadmap.store') }}">
    {{ csrf_field() }}
    <div class="bg-purple text-white rounded-2xl p-5 flex flex-col gap-5">
        <h3>Share your ideas</h3>
        <p class="text-light">Have an idea to improve Kanka? Share it with our development team.</p>

        @cannot ('create', \App\Models\Feature::class)
            <p>You have reached the daily limit of 10 submitted ideas! Please try again tomorrow.</p>
        @else
            <div class="field field-name">
                <label>One sentence that summarises your idea</label>
                <input type="text" maxlength="90" class="rounded text-dark  w-full p-2" name="name" />
            </div>

            <div class="field field-description">
                <label>Why your idea is useful, who should benefit and how should it work?</label>
                <textarea name="description" class="rounded text-dark w-full p-2" rows="5"></textarea>
            </div>

            <p class="text-light">Once reviewed, your idea will show up in the ideas section. If we have questions, we'll contact you on the <a href="https://kanka.io/go/discord">Discord</a>.</p>

            <input type="submit" value="Submit idea" class="btn-round rounded-full" />
        @endif
    </div>
</form>
