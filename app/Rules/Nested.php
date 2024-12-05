<?php

namespace App\Rules;

use App\Models\Quest;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class Nested implements ValidationRule
{
    protected string $className;
    protected mixed $self;

    public function __construct(string $className, mixed $self)
    {
        $this->className = $className;
        $this->self = $self;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Don't allow setting the parent to an entity that is included in the target's children
        if (empty($value)) {
            return;
        }

        $model = new $this->className();
        /** @var ?Quest $parent */
        $parent = $model->where('id', $value)->first();
        if (!$parent) {
            return;
        }

        $bloodline = $parent->ancestors()->pluck('id')->toArray();
        if (in_array($this->self->id, $bloodline)) {
            $fail('validation.nested_loop')->translate(['parent' => $parent->name]);
        }
    }
}
