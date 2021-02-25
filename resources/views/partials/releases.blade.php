<div class="row dashboard-releases">
@foreach ($releases as $release)
    <div class="col-md-{{ count($releases) == 1 ? 12 : 6 }}">
        <div class="box box-widget">
            <div class="box-header with-border">
                <div class="user-block">
                    @if ($release->author && $release->author->avatar)
                        <img class="img-circle" src="{{ $release->author->getAvatarUrl() }}" alt="{{ $release->author->name }}" title="{{ $release->author->name }}">
                    @endif
                    <span class="username">
                        <a href="{{ $release->link }}" target="_blank">{{ $release->name }}</a>
                    </span>
                    <span class="description">{{ $release->published_at->isoFormat('MMMM D, Y') }}</span>
                </div>
                <div class="box-tools">
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-url="{{ route('settings.release', $release) }}">
                        <i class="fa fa-times"></i>
                    </button>
                </div>
                @auth
                @endauth
            </div>
            <div class="box-body">
                {{ $release->excerpt }}
            </div>
        </div>
    </div>
@endforeach
</div>
