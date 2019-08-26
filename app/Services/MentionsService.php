<?php


namespace App\Services;


use App\Models\MiscModel;
use App\Traits\MentionTrait;

class MentionsService
{
    use MentionTrait;
    /**
     * @param MiscModel $model
     * @param string $field
     * @return string
     */
    public function map(MiscModel $model, $field = 'entry'): string
    {
        $text = $model->$field;

        $data = $this->extract($text);



        return $text;
    }
}
