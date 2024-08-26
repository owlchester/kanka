<div>
    <x-form :action="['campaign.gallery.save-focus', $campaign, $image, 'focusEntity' => isset($focusEntity)]">
        <input type="submit" class="btn2 btn-error btn-outline" value="{{ __('campaigns/gallery.actions.reset_focus') }}">
    </x-form>
</div>
<div>
    <x-form :action="['campaign.gallery.save-focus', $campaign, $image, 'focusEntity' => isset($focusEntity)]">
        <input type="hidden" name="focus_x" />
        <input type="hidden" name="focus_y" />
        <button type="submit" class="btn2 btn-primary">
            {{ __('entities/image.actions.save_focus') }}
        </button>
    </x-form>
</div>
