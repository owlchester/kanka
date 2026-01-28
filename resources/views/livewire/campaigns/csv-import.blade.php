<x-box>
    @if (!$canAssign)
        <form wire:submit="selectEntity">
            <div class="p-5 flex flex-col gap-5">
                <h3>{{ __('campaigns/import.csv.select_type') }}</h3>
                <p class="text-light">{{ __('campaigns/import.csv.type_helper') }}</p>

                <div class="field field-type">
                    <label>{{ __('campaigns/import.csv.select_type') }}</label>
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
            <div class="p-5 flex flex-col gap-5">


                <h3>{{ __('campaigns/import.csv.set_fields') }}</h3>
                <p class="text-light">
                    {{ __('campaigns/import.csv.fields_helper') }}
                </p>

                @foreach ($fillableFields as $index => $field)
                    <div class="field field-type">
                        <label>
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
                    <div class="mb-4">
                        <label class="d-block">{{ __('campaigns/import.csv.personality') }}</label>
                        
                        @foreach($personalities as $index => $selection)
                            <div class="d-flex gap-2 mb-2 align-items-center">
                                <select wire:model="personalities.{{ $index }}" class="form-control">
                                    <option value=""> {{ __('campaigns/import.csv.select_one') }} </option>
                                    @foreach($headers as $value => $label)
                                        <option value="{{ $value }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                                
                                <button type="button" 
                                        wire:click="removePersonality({{ $index }})" 
                                        class="btn btn-sm btn-outline-danger"
                                        style="padding: 0.25rem 0.5rem;">
                                    <x-icon class="fa-regular fa-trash-can" tooltip :title="__('generic.remove')" />
                                </button>
                            </div>
                        @endforeach

                        <button type="button" wire:click="addPersonality" class="btn2 btn-sm">
                            <x-icon class="fa-solid fa-plus" /> {{ __('campaigns/import.csv.add_personality') }}
                        </button>
                    </div>


                    <div class="mb-4">
                        <label class="d-block">{{ __('campaigns/import.csv.appearance') }}</label>
                        
                        @foreach($appearances as $index => $selection)
                            <div class="d-flex gap-2 mb-2 align-items-center">
                                <select wire:model="appearances.{{ $index }}" class="form-control">
                                    <option value=""> {{ __('campaigns/import.csv.select_one') }} </option>
                                    @foreach($headers as $value => $label)
                                        <option value="{{ $value }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                                
                                <button type="button" 
                                        wire:click="removeAppearance({{ $index }})" 
                                        class="btn btn-sm btn-outline-danger"
                                        style="padding: 0.25rem 0.5rem;">
                                    <x-icon class="fa-regular fa-trash-can" tooltip :title="__('generic.remove')" />
                                </button>
                            </div>
                        @endforeach

                        <button type="button" wire:click="addAppearance" class="btn2 btn-sm">
                            <x-icon class="fa-solid fa-plus" /> {{ __('campaigns/import.csv.add_appearance') }}
                        </button>
                    </div>
                @endif
                <h2>{{ $tagLabel }}</h2>


                <livewire:campaigns.tags
                    :campaign="$campaign"
                    wire:model="tags"
                />

                <div class="overflow-x-auto">
                    @if (count($columnMap) != 0)
                        <h3>{{ __('campaigns/import.csv.preview') }}</h3>

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
                        <p class="text-sm text-gray-500">
                            {{ __('campaigns/import.csv.no_preview') }}
                        </p>
                    @endif
                </div>

                <input type="submit" value="{{ __('campaigns/import.csv.submit') }}" class="btn2 btn-primary" />
            </div>
        </form>
    @endif
</x-box>
