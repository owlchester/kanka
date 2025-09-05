<div class="box-comment bg-base-100 p-2 flex flex-col gap-1 @if($message['author'] == 'user') message-first @endif">
    
    <div class="message-author">
        @if($message['author'] == 'user')
            <strong class="user">{{ $user->name }}</strong>
        @else
            <strong class="character">
                <span>Bragi</span>
            </strong>
        @endif
    </div>

    <article class="w-full flex gap-4 @if($message['author'] == 'user') pull-right @endif">
        <div class="grow flex flex-col gap-1">
            <p class="m-0">{!! nl2br($message['message']) !!}</p>
        </div>
    </article>
</div>
