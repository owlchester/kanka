<x-form :action="['campaign.gallery.save-focus', $campaign, $image]">
    <input type="submit" class="btn2 btn-error btn-outline" value="{{ __('campaigns/gallery.actions.reset_focus') }}">
</x-form>

<x-form :action="['campaign.gallery.save-focus', $campaign, $image]">
    <input type="hidden" name="focus_x" />
    <input type="hidden" name="focus_y" />
    <input type="submit" class="btn2 btn-primary" value="{{ __('entities/image.actions.save_focus') }}">
</x-form>

