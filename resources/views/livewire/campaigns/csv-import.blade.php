<x-box>
    @if (!$canAssign)
        <form wire:submit="selectEntity">
            <div class="flex flex-col gap-4">
                <h2 class="text-2xl">{{ __('campaigns/import.csv.select_module') }}</h2>
                <x-helper>
                    <p>{{ __('campaigns/import.csv.type_helper') }}</p>
                </x-helper>

                <div class="field field-type flex flex-col gap-1">
                    <label class="font-semibold text-xs opacity-80">{{ __('crud.fields.entity_type') }}</label>
                    <select wire:model="entityType" class="form-control w-full" required>
                        @foreach ($entityTypes as $value => $label)
                            <option value="{{ $value }}">
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <input type="submit" value="{{ __('campaigns/import.csv.continue') }}" class="btn2 btn-primary" />
            </div>
        </form>
    @else
        <form wire:submit.prevent="submit">
            <div class="flex flex-col gap-4">


                <h2 class="text-2xl">{{ __('campaigns/import.csv.set_fields') }}</h2>

                <x-helper>
                    <p>
                        {{ __('campaigns/import.csv.fields_helper') }}
                    </p>
                </x-helper>

                @foreach ($fillableFields as $index => $field)
                    <div class="field field-type flex flex-col gap-1">
                        <label class="text-xs font-semibold opacity-80">
                            {{ $field }}
                        </label>

                        <select
                            wire:model.live="columnMap.{{ $index }}"
                            class="form-control w-full"
                            @if ($index == 'name') required @endif
                        >
                            <option value="">{{ __('campaigns/import.csv.set_column') }}</option>

                            @if ($index == 'name')
                                @foreach ($fullColumns as $value => $label)
                                    <option value="{{ $value }}">
                                        {{ $label }}
                                    </option>
                                @endforeach
                            @else
                                @foreach ($headers as $value => $label)
                                    <option value="{{ $value }}">
                                        {{ $label }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                @endforeach

                @if ($type->id == config('entities.ids.character'))
                    <div class="flex flex-col gap-1">
                        <div class="flex gap-2 justify-between">
                            <label class="text-xs font-semibold opacity-80">
                                {{ __('characters.sections.personality') }}
                            </label>
                            <button type="button" wire:click="addPersonality" class="btn2 btn-sm btn-outline">
                                <x-icon class="plus" /> {{ __('characters.actions.add_personality') }}
                            </button>
                        </div>

                        @foreach($personalities as $index => $selection)
                            <div class="flex gap-2 align-items-center">
                                <select wire:model="personalities.{{ $index }}" class="form-control">
                                    <option value=""> {{ __('campaigns/import.csv.select_one') }} </option>
                                    @foreach($headers as $value => $label)
                                        <option value="{{ $value }}">{{ $label }}</option>
                                    @endforeach
                                </select>

                                <button type="button"
                                        wire:click="removePersonality({{ $index }})"
                                        class="btn btn-sm btn-error btn-outline">
                                    <x-icon class="trash" tooltip :title="__('generic.remove')" />
                                </button>
                            </div>
                        @endforeach
                    </div>


                    <div class="flex flex-col gap-1">
                        <div class="flex gap-1 justify-between">
                            <label class="text-xs font-semibold opacity-80">
                                {{ __('characters.sections.appearance') }}
                            </label>

                            <button type="button" wire:click="addAppearance" class="btn2 btn-sm btn-outline">
                                <x-icon class="plus" /> {{ __('characters.actions.add_appearance') }}
                            </button>
                        </div>

                        @foreach($appearances as $index => $selection)
                            <div class="flex gap-2 align-items-center">
                                <select wire:model="appearances.{{ $index }}" class="form-control">
                                    <option value=""> {{ __('campaigns/import.csv.select_one') }} </option>
                                    @foreach($headers as $value => $label)
                                        <option value="{{ $value }}">{{ $label }}</option>
                                    @endforeach
                                </select>


                                <button type="button"
                                        wire:click="removeAppearance({{ $index }})"
                                        class="btn btn-sm btn-error btn-outline">
                                    <x-icon class="fa-regular fa-trash-can" tooltip :title="__('generic.remove')" />
                                </button>
                            </div>
                        @endforeach
                    </div>
                @endif

                <h2 class="text-xl">{{ $tagLabel }}</h2>


                <livewire:campaigns.tags
                    :campaign="$campaign"
                    wire:model="tags"
                />

                <div class="overflow-x-auto">
                    @if (count($columnMap) != 0)
                        <h2 class="text-2xl">{{ __('campaigns/import.csv.preview') }}</h2>

                        <table class="table-auto w-full border-collapse border">
                            <thead>
                                <tr>
                                    @foreach ($columnMap as $field => $columnIndex)
                                        <th class="border px-2 py-1 text-left">
                                            {{  $this->fieldName($field) }}
                                        </th>
                                    @endforeach
                                    @if (!empty($tags))
                                        <th class="border px-2 py-1 text-left">
                                            {{  $tagLabel }}
                                        </th>
                                    @endif

                                </tr>
                            </thead>

                            <tbody>
                                @foreach (array_slice($preview, 1) as $row)
                                    <tr>
                                        @foreach ($columnMap as $field => $columnIndex)
                                            <td class="border px-2 py-1">
                                                {{ $row[$columnIndex] ?? '' }}
                                            </td>
                                        @endforeach
                                        @if (!empty($tags))
                                            <td class="border px-2 py-1">
                                                @foreach ($tags as $tag)
                                                    {{ $tag['label']}}
                                                @endforeach
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <x-helper>
                            <p>{{ __('campaigns/import.csv.no_preview') }}</p>
                        </x-helper>
                    @endif
                </div>

                <input type="submit" value="{{ __('campaigns/import.csv.submit') }}" class="btn2 btn-primary" />
            </div>
        </form>
    @endif
</x-box>
