<?php

namespace App\Http\Requests;

use App\Rules\CalendarFormat;
use App\Rules\CalendarMoonOffset;
use App\Traits\ApiRequest;
use App\Traits\EntityRequestRules;
use App\Traits\ResolvesNewForeignEntities;
use Illuminate\Foundation\Http\FormRequest;

class StoreCalendar extends FormRequest
{
    use ApiRequest;
    use EntityRequestRules;
    use ResolvesNewForeignEntities;

    protected array $foreignEntityFields = [];

    protected bool $foreignEntityParent = true;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'month_name' => 'required|array|min:1',
            'month_length' => 'required|array|min:1',
            'weekday' => 'required|array|min:2',
            'start_offset' => 'nullable|integer|min:0|max:99',
            'year_name' => 'nullable|array',
            'moon_name' => 'nullable|array',
            'moon_fullmoon' => 'nullable|array',
            'moon_offset' => 'required_with:moon_name|array',
            'moon_colour' => 'required_with:moon_name|array',
            'moon_id' => 'required_with:moon_name|nullable|array',
            'epoch_name' => 'nullable|array',
            'season_name' => 'nullable|array',
            'season_month' => 'nullable|array',
            'season_day' => 'nullable|array',
            'month_alias' => 'nullable|array',
            'month_type' => 'nullable|array',
            'year_number' => 'nullable|array',
            'eras' => 'nullable|array',
            'era_configured' => 'nullable|boolean',
            'eras.*.name' => 'required_with:eras.*.suffix|string|max:191',
            'eras.*.suffix' => 'required_with:eras.*.name|string|max:45',
            'eras.*.start_year' => 'nullable|integer',
            'eras.*.end_year' => 'nullable|integer',
            'era_name' => 'nullable|array',
            'era_name.*' => 'nullable|string|max:191',
            'era_suffix' => 'nullable|array',
            'era_suffix.*' => 'nullable|string|max:45',
            'era_start_year' => 'nullable|array',
            'era_start_year.*' => 'nullable|integer',
            'era_end_year' => 'nullable|array',
            'era_end_year.*' => 'nullable|integer',
            'week_number' => 'nullable|array',
            'week_name' => 'nullable|array',
            'current_year' => 'nullable|integer',
            'current_month' => 'nullable|integer|min:1',
            'current_day' => 'nullable|integer|min:1',
            'suffix' => 'nullable|string|max:45',
            'skip_year_zero' => 'nullable|boolean',
            'reset' => 'nullable|integer',
            'is_incrementing' => 'nullable|boolean',
            'leap_year_month' => 'nullable|integer|min:1',
            'show_birthdays' => 'boolean',
            'format' => ['nullable', 'bail', 'string', 'max:20', new CalendarFormat],
            //            'moon_offset' => [
            //                '*' => new CalendarMoonOffset()
            //            ],
        ];

        $rules['has_leap_year'] = 'boolean';
        $rules['leap_year_amount'] = 'exclude_if:has_leap_year,0|numeric|min:-128|max:128';
        $rules['leap_year_offset'] = 'exclude_if:has_leap_year,0|numeric|min:1|max:255';
        $rules['leap_year_start'] = 'exclude_if:has_leap_year,0|numeric|min:1|max:255';

        return $this->entityRules($rules);
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $eras = $this->input('eras');
            if (! is_array($eras)) {
                $names = (array) $this->input('era_name', []);
                $suffixes = (array) $this->input('era_suffix', []);
                $starts = (array) $this->input('era_start_year', []);
                $ends = (array) $this->input('era_end_year', []);
                $eras = [];
                foreach ($names as $i => $name) {
                    if (! empty($name) || ! empty($suffixes[$i]) || ($starts[$i] ?? '') !== '' || ($ends[$i] ?? '') !== '') {
                        $eras[] = ['name' => $name, 'suffix' => $suffixes[$i] ?? '', 'start_year' => $starts[$i] ?? null, 'end_year' => $ends[$i] ?? null];
                    }
                }
            }

            $ranges = [];
            foreach ($eras as $index => $era) {
                if (! is_array($era)) {
                    continue;
                }
                $start = $era['start_year'] ?? null;
                $end = $era['end_year'] ?? null;
                if (empty($era['name'] ?? null)) {
                    $validator->errors()->add("eras.{$index}.name", __('validation.required', ['attribute' => 'era name']));
                }
                if (empty($era['suffix'] ?? null)) {
                    $validator->errors()->add("eras.{$index}.suffix", __('validation.required', ['attribute' => 'era suffix']));
                }
                if (($start === null || $start === '') && ($end === null || $end === '')) {
                    $validator->errors()->add("eras.{$index}.start_year", __('validation.required_without', ['attribute' => 'start year', 'values' => 'end year']));

                    continue;
                }
                if ($start !== null && $start !== '' && $end !== null && $end !== '' && (int) $start > (int) $end) {
                    $validator->errors()->add("eras.{$index}.end_year", __('validation.after_or_equal', ['attribute' => 'end year', 'date' => 'start year']));

                    continue;
                }
                $ranges[] = [
                    'index' => $index,
                    'start' => $start === null || $start === '' ? PHP_INT_MIN : (int) $start,
                    'end' => $end === null || $end === '' ? PHP_INT_MAX : (int) $end,
                ];
            }
            usort($ranges, fn (array $a, array $b) => $a['start'] <=> $b['start']);
            for ($i = 1; $i < count($ranges); $i++) {
                if ($ranges[$i]['start'] <= $ranges[$i - 1]['end']) {
                    $validator->errors()->add("eras.{$ranges[$i]['index']}.start_year", __('calendars.validators.era_overlap'));
                }
            }
        });
    }

    public function quickCreatorRules(): array
    {
        return $this->entityRules([]);
    }
}
