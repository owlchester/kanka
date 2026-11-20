<?php

namespace App\Services\Caches\Traits\User;

trait TutorialCache
{
    public function dismissedTutorial(string $tutorial): bool
    {
        return in_array($tutorial, $this->primary($this->activeUser()->id)->get('tutorials'));
    }

    protected function prepareTutorials(): array
    {
        return $this->activeUser()
            ->tutorials
            ->pluck('code')
            ->toArray();
    }
}
