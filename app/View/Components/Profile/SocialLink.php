<?php

namespace App\View\Components\Profile;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SocialLink extends Component
{
    public string $link;

    /**
     * Create a new component instance.
     */
    public function __construct(
        string $link
    ) {
        $this->link = $link;
        if (! preg_match('#^https?://#i', $this->link)) {
            $this->link = 'https://' . $this->link;
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.profile.social-link');
    }

    public function domain(): string
    {
        $host = parse_url($this->link, PHP_URL_HOST);

        return $host ? preg_replace('/^www\./i', '', $host) : '';
    }
}
