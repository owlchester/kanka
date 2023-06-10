<h2 class="mb-5">Preview</h2>
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

    <div class="col-span-2">
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
    </div>

    <div class="col-span-2 bg-box p-4 rounded">
        <p>Rutrum adipiscing enim pellentesque mi rutrum lacus eget amet nisl dolor maecenas adipiscing diam orci commodo suspendisse tincidunt tristique gravida leo arcu condimentum fusce nunc.</p>
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
        <input type="text" class="form-control" value="Default" placeholder="Placeholder" />
    </div>
    <div class="col-span-2 field-select">
        <select class="select2">
            <option>Option</option>
        </select>
    </div>

    <div class="col-span-4">
        <h1>Heading 1</h1>
        <h2>Heading 2</h2>
        <h3>Heading 3</h3>
        <h4>Heading 4</h4>
        <h5>Heading 5</h5>
        <h6>Heading 6</h6>
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
</div>
