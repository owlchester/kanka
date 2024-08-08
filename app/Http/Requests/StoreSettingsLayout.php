<?php

namespace App\Http\Requests;

use App\Services\PaginationService;
use Illuminate\Foundation\Http\FormRequest;

class StoreSettingsLayout extends FormRequest
{
    /**
     * @var PaginationService
     */
    protected $pagination;

    /**
     * StoreSettingsLayout constructor.
     */
    public function __construct(PaginationService $paginationService)
    {
        $this->pagination = $paginationService;
    }
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
        return [
            'date_format' => 'nullable|string|max:5',
            'pagination' => 'nullable|numeric|max:' . $this->pagination->max(),
            'theme' => 'nullable',
            //            'editor' => 'in:,summernote,markdown',
        ];
    }
}
