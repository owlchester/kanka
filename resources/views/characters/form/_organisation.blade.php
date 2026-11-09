<div class="member-row min-w-0 rounded-lg border border-base-300 bg-base-100 p-4 md:p-5" data-membership-row>
    <fieldset class="flex min-w-0 flex-col gap-4" data-membership-fields>
        <legend class="sr-only">{{ __('characters.organisations.create.title') }}</legend>
        <x-forms.field field="membership-organisation" :id="'membership-organisation-' . $key" :label="$singular">
            <select name="organisations[{{ $key }}]" id="membership-organisation-{{ $key }}" class="w-full {{ $isTemplate ? 'tmp-org' : 'select2' }}"
                data-url="{{ route('search-list', [$campaign, config('entities.ids.organisation')]) }}"
                data-placeholder="{{ __('crud.placeholders.search') }}"
                data-language="{{ LaravelLocalization::getCurrentLocale() }}"
                data-allow-clear="false">
                @if (!empty($row['organisation_id']))
                    <option value="{{ $row['organisation_id'] }}" selected>{{ $row['name'] }}</option>
                @endif
            </select>
            @error('organisations.' . $key)<span class="text-sm text-error">{{ $message }}</span>@enderror
        </x-forms.field>

        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            <x-forms.field field="membership-role" :id="'membership-role-' . $key" :label="__('organisations.members.fields.role')">
                <input type="text" name="organisation_roles[{{ $key }}]" id="membership-role-{{ $key }}" value="{{ $row['role'] }}" placeholder="{{ __('organisations.members.placeholders.role') }}" maxlength="191" spellcheck="true" class="w-full" />
                @error('organisation_roles.' . $key)<span class="text-sm text-error">{{ $message }}</span>@enderror
            </x-forms.field>
            <x-forms.field field="membership-status" :id="'membership-status-' . $key" :label="__('organisations.members.fields.status')">
                <x-forms.select :name="'organisation_statuses[' . $key . ']'" :id="'membership-status-' . $key" :options="$statuses" :selected="$row['status']" />
            </x-forms.field>
        </div>

        <div class="flex flex-wrap items-start justify-between gap-3 border-t border-base-300 pt-3">
            <details class="min-w-0 grow" data-membership-settings>
                <summary class="cursor-pointer text-sm text-neutral-content">
                    {{ __('characters.organisations.form.settings') }}
                    <span class="text-xs" data-membership-summary>{{ $isAdmin && $row['private'] ? ' · ' . __('characters.organisations.form.private') : '' }}{{ (int) $row['pin'] > 0 ? ' · ' . ($options[$row['pin']] ?? '') : '' }}</span>
                </summary>
                <div class="flex flex-col gap-4 pt-4">
                    <x-forms.field field="membership-pin" :id="'membership-pin-' . $key" :label="__('characters.organisations.form.pinned')" :helper="__('organisations.members.helpers.pinned')">
                        <x-forms.select :name="'organisation_pins[' . $key . ']'" :id="'membership-pin-' . $key" :options="$options" :selected="$row['pin']" :extra="['data-membership-pin' => '1']" />
                    </x-forms.field>
                    @if ($isAdmin)
                        <div class="flex flex-col gap-1">
                            <input type="hidden" name="organisation_privates[{{ $key }}]" value="0" />
                            <label class="flex cursor-pointer items-center gap-2 text-sm" for="membership-private-{{ $key }}">
                                <input type="checkbox" name="organisation_privates[{{ $key }}]" id="membership-private-{{ $key }}" value="1" @checked($row['private']) data-membership-private />
                                <span>{{ __('characters.organisations.form.private') }}</span>
                            </label>
                            <p class="text-xs text-neutral-content">{{ __('characters.organisations.form.private_hint', ['admin' => $campaign->adminRoleName()]) }}</p>
                        </div>
                    @endif
                </div>
            </details>
            <button type="button" class="shrink-0 cursor-pointer text-sm text-neutral-content hover:text-error focus-visible:text-error" data-remove-membership>
                <x-icon class="trash" />
                {{ __('characters.organisations.form.remove') }}
            </button>
        </div>
    </fieldset>
    <div class="hidden flex-wrap items-center justify-between gap-3 text-sm" data-membership-removed role="status">
        <span>{{ __('characters.organisations.form.removed') }}</span>
        <button type="button" class="btn2 btn-sm btn-outline" data-undo-membership>{{ __('characters.organisations.form.undo') }}</button>
    </div>
</div>
