<div class="card profile-badges text-center my-5">
    <div class="card-body">
        <h5 class="card-title">{{ __('users/profile.fields.achievements') }}</h5>
        @if($user->isWordsmith())
        <a href="{{ route('community-events.index') }}" class="badge badge-wordsmith" data-title="{{ __('users/profile.achievements.wordsmith') }}" data-toggle="tooltip">

            <i class="fa-solid fa-feather-pointed" aria-hidden="true"></i>
        </a>
        @endif
    </div>
</div>

