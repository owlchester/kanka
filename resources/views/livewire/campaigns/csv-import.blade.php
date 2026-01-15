<x-box>
    @if (!$canAssign)
        <form wire:submit="selectEntity">
            <div class="p-5 flex flex-col gap-5">
                <h3>Select entity type</h3>
                <p class="text-light">Select the entity type you want to import the new modules into</p>

                <div class="field field-type">
                    <label>Select entity type</label>
                    <select wire:model="entityType" class="form-control w-full" required>
                        @foreach ($entityTypes as $value => $label)
                            <option value="{{ $value }}">
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <input type="submit" value="Continue" class="btn2 btn-primary" />
            </div>
        </form>
    @else

<div class="overflow-x-auto">
    @if (!empty($preview))
        <table class="table-auto w-full border-collapse border border-gray-200">
            <thead>
                <tr>
                    @foreach ($preview[0] as $header)
                        <th class="border border-gray-200 px-3 py-2 text-left font-semibold">
                            {{ $header }}
                        </th>
                    @endforeach
                </tr>
            </thead>

            <tbody>
                @foreach (array_slice($preview, 1) as $row)
                    <tr>
                        @foreach ($row as $cell)
                            <td class="border border-gray-200 px-3 py-2">
                                {{ $cell }}
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p class="text-sm text-gray-500">
            No preview data available.
        </p>
    @endif
</div>



        <form wire:submit.prevent="setColumn">
            <div class="p-5 flex flex-col gap-5">
                <h3>Set fields</h3>
                <p class="text-light">
                    Select a column to assign to each of the fillable fields of the entity
                </p>

                @foreach ($fillableFields as $index => $field)
                    <div class="field field-type">
                        <label class="capitalize">
                            {{ str_replace('_', ' ', $field) }}
                        </label>

                        <select
                            wire:model="columnMap.{{ $field }}"
                            class="form-control w-full"
                            required
                        >
                            <option value="">— Select a column —</option>

                            @if ($index == 0)
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

                <input type="submit" value="Submit" class="btn2 btn-primary" />
            </div>
        </form>

    @endif
</x-box>
