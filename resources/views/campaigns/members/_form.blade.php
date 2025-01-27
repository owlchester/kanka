<x-grid type="1/1">
    <x-helper>
        {!! __('campaigns/members.roles.helper', ['user' => '<a href="' . route('users.profile', $campaignUser->user) . '">' . $campaignUser->user->name . '</a>']) !!}
    </x-helper>
    <input type="hidden" name="save_roles" value="1">
    <x-forms.field field="roles" :label="__('campaigns.members.fields.roles')">
        @include('components.form.role', ['options' => [
            'multiple' => true,
            'model' => $campaignUser,
            'roles' => $roles ?? false
        ]])
    </x-forms.field>
</x-grid>
