<?php

namespace App\Http\Requests;

use App\Services\PaginationService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreSettingsLayout extends FormRequest
{
    /**
     * @var PaginationService
     */
    protected $pagination;

    /**
     * StoreSettingsLayout constructor.
     * @param PaginationService $paginationService
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
            'date_format' => '',
            'default_pagination' => 'required|numeric|max:' . $this->pagination->max(),
            'theme' => '',
//            'editor' => 'in:,summernote,markdown',
        ];
    }
}
