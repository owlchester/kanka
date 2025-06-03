<h2 class="">Preview</h2>
<div class="grid grid-cols-4 gap-2">
    <a href="#" class="btn2">
        Default
    </a>
    <a href="#" class="btn2 btn-primary">
        Primary
    </a>
    <a href="#" class="btn2 btn-secondary">
        Secondary
    </a>
    <a href="#" class="btn2 btn-accent">
        Accent
    </a>

    <a href="#" class="btn2 btn-info">
        Info
    </a>
    <a href="#" class="btn2 btn-success">
        Success
    </a>
    <a href="#" class="btn2 btn-warning">
        Warning
    </a>
    <a href="#" class="btn2 btn-error">
        Error
    </a>

    <div class="badge">Default</div>
    <div class="badge badge-primary">Primary</div>
    <div class="badge badge-secondary">Secondary</div>
    <div class="badge badge-accent">Accent</div>

    <div class="col-span-2 flex flex-col gap-5">
        <div class="nav-tabs-custom">
            <div class="flex gap-2 items-center ">
                <div class="grow overflow-x-auto">
                    <ul class="nav-tabs flex inline-flex items-stretch w-full" role="tablist">
                        <x-tab.tab target="entry" title="Tab"></x-tab.tab>
                        <x-tab.tab target="entry" :default="true" title="Tab"></x-tab.tab>
                        <x-tab.tab target="entry" title="Tab"></x-tab.tab>
                    </ul>
                </div>
            </div>
        </div>

        <div class="dropdown">
            <button type="button" class="btn2 btn-sm" data-dropdown
                    aria-expanded="false">
                <x-icon class="fa-solid fa-caret-down" />
                <span class="sr-only">{{ __('crud.actions.actions') }}</span>
                Dropdown menu
            </button>
            <div class="dropdown-menu hidden" role="menu">
                <x-dropdowns.item link="#">
                    Action 1
                </x-dropdowns.item>
                <x-dropdowns.item link="#">
                    Action 2
                </x-dropdowns.item>
                <x-dropdowns.divider />
                <x-dropdowns.item link="#" css="text-error hover:bg-error hover:text-error-content">
                    Action 3
                </x-dropdowns.item>
            </div>
        </div>

        <span class="btn2 btn-link btn-sm" data-toggle="tooltip-demo">Hover me tooltip</span>
    </div>

    <div class="col-span-2 bg-box p-4 rounded">
        <p>Rutrum adipiscing enim pellentesque mi <a href="#">link</a> eget amet nisl dolor maecenas adipiscing diam orci commodo suspendisse tincidunt tristique gravida leo arcu condimentum <span class="attribute inline-block">attribute mention</span> nunc.</p>
    </div>

    <div class="col-span-2 bg-box p-4 rounded">
        <p>Rutrum adipiscing enim pellentesque mi rutrum lacus eget amet nisl dolor maecenas adipiscing diam orci commodo suspendisse tincidunt tristique gravida leo arcu condimentum fusce nunc.</p>
        <p>Ipsum condimentum placerat tincidunt nunc facilisis eu sollicitudin phasellus metus arcu nec quam quam quam tincidunt leo ipsum scelerisque orci tristique quam aliquam adipiscing a.</p>
    </div>
    <div class="bg-base-200 p-4 rounded">
        <p>Vel ac commodo placerat enim lacus facilisis nisl tincidunt quisque accumsan portaest nunc aliquam tortor nunc gravida bibendum placerat tristique metus proin phasellus rutrum eget.</p>
    </div>
    <div class="bg-base-300 p-4 rounded">
        <p>Nulla purus dolor consectetur lorem maecenas nunc portaest euismod ex interdum maximus consectetur arcu cursus varius aliquam suspendisse vel interdum erat ac metus nec suspendisse.</p>
    </div>

    <div class="col-span-2 field-default">
        <input type="text" class="w-full" value="Default" placeholder="Placeholder" />
    </div>
    <div class="col-span-2 field-select">
        <select class="select2">
            <option>Option</option>
        </select>
    </div>

    <div class="col-span-2">
        <h1>Heading 1</h1>
        <h2>Heading 2</h2>
        <h3>Heading 3</h3>
        <h4>Heading 4</h4>
        <h5>Heading 5</h5>
        <h6>Heading 6</h6>
    </div>
    <div class="col-span-2">
        <x-box :padding="0">
            <x-menu>
                <x-menu>
                    <x-menu.element
                        :active="true"
                        route="#"
                    >
                        Menu item 1
                    </x-menu.element>
                    <x-menu.element
                        route="#"
                        :badge="2"
                    >
                        Menu item 1
                    </x-menu.element>
                    <x-menu.element
                        route="#"
                    >
                        Menu item 3
                    </x-menu.element>
                </x-menu>
            </x-menu>
        </x-box>
    </div>


    <div class="col-span-2">
        <x-alert type="success">
            Success alert
        </x-alert>
    </div>
    <div class="col-span-2">
        <x-alert type="info">
            Information alert
        </x-alert>
    </div>
    <div class="col-span-2">
        <x-alert type="error">
            Error alert
        </x-alert>
    </div>
    <div class="col-span-2">
        <x-alert type="warning">
            Warning alert
        </x-alert>
    </div>

    <div class="col-span-4">
        <pre><strong>Pre</strong> Vel ac commodo placerat enim lacus facilisis nisl tincidunt quisque accumsan portaest nunc aliquam tortor nunc gravida bibendum placerat tristique metus proin phasellus rutrum eget.
        </pre>
    </div>
    <div class="col-span-4 bg-box p-2 rounded">
        <blockquote class=""><strong>Blockquote</strong> Vel ac commodo placerat enim lacus facilisis nisl tincidunt quisque accumsan portaest nunc aliquam tortor nunc gravida bibendum placerat tristique metus proin phasellus rutrum eget.
        </blockquote>
    </div>
</div>
