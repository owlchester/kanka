import tippy from 'tippy.js';

const initVisibilityPickers = () => {
    document.querySelectorAll('.visibility-picker').forEach((picker) => {
        const trigger = picker.querySelector('.visibility-picker-trigger');
        const dropdown = picker.querySelector('.visibility-picker-dropdown');

        if (!trigger || !dropdown || trigger._vPickerInit) {
            return;
        }
        trigger._vPickerInit = true;

        const instance = tippy(trigger, {
            content: dropdown,
            theme: 'kanka-dropdown',
            placement: 'bottom',
            allowHTML: true,
            interactive: true,
            trigger: 'click',
            zIndex: 890,
            appendTo: picker,
            onShow: () => dropdown.classList.remove('hidden'),
            onHide: () => dropdown.classList.add('hidden'),
        });

        dropdown.querySelectorAll('.visibility-picker-option').forEach((option) => {
            option.addEventListener('click', () => {
                const visibilityId = parseInt(option.dataset.value);
                const currentSelected = parseInt(picker.dataset.selected);
                const url = picker.dataset.url;

                if (visibilityId === currentSelected || option.dataset.loading === '1') {
                    return;
                }

                // Show spinner on clicked option
                option.dataset.loading = '1';
                const statusEl = option.querySelector('.visibility-picker-status');
                statusEl.innerHTML = '<i class="fa-solid fa-spinner fa-spin text-primary" aria-hidden="true"></i>';

                // Remove check from previous selection
                const prevOption = dropdown.querySelector('.visibility-picker-option[aria-checked="true"]');
                if (prevOption && prevOption !== option) {
                    prevOption.querySelector('.visibility-picker-status').innerHTML = '';
                }

                axios.post(url, { visibility_id: visibilityId })
                    .then((res) => {
                        // Update state
                        picker.dataset.selected = visibilityId;

                        // Update trigger icon
                        const triggerIcon = trigger.querySelector('i');
                        triggerIcon.className = option.dataset.icon;

                        // Update aria + styling on all options
                        dropdown.querySelectorAll('.visibility-picker-option').forEach((opt) => {
                            const isSelected = parseInt(opt.dataset.value) === visibilityId;
                            opt.setAttribute('aria-checked', isSelected ? 'true' : 'false');
                            opt.classList.toggle('bg-primary/5', isSelected);
                            opt.classList.toggle('ring-1', isSelected);
                            opt.classList.toggle('ring-primary/30', isSelected);

                            const status = opt.querySelector('.visibility-picker-status');
                            status.innerHTML = isSelected
                                ? '<i class="fa-regular fa-check text-primary" aria-hidden="true"></i>'
                                : '';
                        });

                        option.dataset.loading = '0';
                    })
                    .catch(() => {
                        // Revert: restore check on previous selection
                        option.dataset.loading = '0';
                        statusEl.innerHTML = '';

                        if (prevOption) {
                            prevOption.querySelector('.visibility-picker-status').innerHTML =
                                '<i class="fa-regular fa-check text-primary" aria-hidden="true"></i>';
                        }

                        window.showToast('Failed to update visibility.', 'error');
                    });
            });
        });
    });
};

initVisibilityPickers();

window.onEvent(function () {
    initVisibilityPickers();
});
