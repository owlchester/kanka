<div class="card profile-badges text-center my-5">
    <div class="card-body">
        <h5 class="card-title">{{ __('users/profile.fields.achievements') }}</h5>
        @if($user->isWordsmith())
        <span class="badge badge-wordsmith" data-title="{{ __('users/profile.achievements.wordsmith') }}" data-toggle="tooltip">
            <x-icon class="fa-regular fa-feather-pointed" />
        </span>
        @endif
    </div>
</div>

