<?php /** @var \App\Models\AppRelease $release */?>
<div class="dashboard-releases">
@foreach ($releases as $release)
    @if($release->isPast())
        @continue
    @endif
        <div class="box box-widget">
            <div class="box-header with-border">
                <div class="user-block">
                    <img class="img-circle" src="/images/favicon/apple-touch-icon-76x76.png" alt="Kanka" title="Kanka">
                    <span class="username">
                        <a href="{{ $release->link }}" target="_blank">{!! $release->name !!}</a>
                    </span>
                    <span class="description">
                        {{ $release->published_at->isoFormat('MMMM D, Y') }}
                    </span>
                </div>
                <div class="box-tools">
                    <button type="button" class="btn btn-box-tool" data-release="remove" data-url="{{ route('settings.release', $release) }}">
                        <i class="fa fa-times"></i>
                    </button>
                </div>
                @auth
                @endauth
            </div>
            <div class="box-body release-excerpt">
                <p class="overflow-wrap">{!! nl2br($release->excerpt) !!}</p>
            </div>
        </div>
@endforeach
</div>
