<?php

namespace App\View\Components\Forms;

use App\Enums\Visibility;
use App\Models\Campaign;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class VisibilityPickerField extends Component
{
    public function __construct(
        public Campaign $campaign,
        public string $entityName,
        public array $options,
        public int $selected,
        public ?string $id = null,
    ) {
        $this->id = $id ?? uniqid('visibility-field-');
    }

    public function render(): View|Closure|string
    {
        return view('components.forms.visibility-picker-field', [
            'adminUrl' => route('campaigns.campaign_roles.admin', $this->campaign),
            'adminName' => $this->campaign->adminRoleName(),
            'iconMap' => $this->buildIconMap(),
            'visibilityKeys' => $this->buildVisibilityKeys(),
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

    /**
     * @return array<int, string>
     */
    protected function buildVisibilityKeys(): array
    {
        return [
            Visibility::All->value => 'all',
            Visibility::Admin->value => 'admin',
            Visibility::AdminSelf->value => 'admin-self',
            Visibility::Self->value => 'self',
            Visibility::Member->value => 'member',
        ];
    }
}
