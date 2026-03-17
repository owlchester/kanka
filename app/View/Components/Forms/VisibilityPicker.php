<?php

namespace App\View\Components\Forms;

use App\Enums\Visibility;
use App\Models\Campaign;
use App\Models\Entity;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class VisibilityPicker extends Component
{
    public function __construct(
        public Entity $entity,
        public Campaign $campaign,
        public int $selected,
        public string $url,
        public array $options,
        public ?string $id = null,
    ) {
        $this->id = $id ?? uniqid('visibility-');
    }

    public function render(): View|Closure|string
    {
        return view('components.forms.visibility-picker', [
            'adminUrl' => route('campaigns.campaign_roles.admin', $this->campaign),
            'adminName' => $this->campaign->adminRoleName(),
            'entityName' => $this->entity->name,
            'iconMap' => $this->buildIconMap(),
        ]);
    }

    /**
     * @return array<int, string>
     */
    protected function buildIconMap(): array
    {
        return [
            Visibility::All->value => 'fa-regular fa-eye',
            Visibility::Admin->value => 'fa-regular fa-lock',
            Visibility::AdminSelf->value => 'fa-regular fa-user-lock',
            Visibility::Self->value => 'fa-regular fa-user-secret',
            Visibility::Member->value => 'fa-regular fa-users',
        ];
    }
}
