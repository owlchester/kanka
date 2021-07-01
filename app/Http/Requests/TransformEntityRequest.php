<?php

namespace App\Http\Requests;

use App\Services\EntityService;
use Illuminate\Foundation\Http\FormRequest;

class TransformEntityRequest extends FormRequest
{
    protected $entities = '';

    /**
     * MoveEntityRequest constructor.
     * @param EntityService $entityService
     */
    public function __construct(EntityService $entityService)
    {
        parent::__construct();

        $entities = [];
        foreach ($entityService->entities() as $entity => $class) {
            $entities[] = $entity;
        }

        $this->entities = implode(',', $entities);
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
            'target' => 'required|in:' . $this->entities,
        ];
    }
}
