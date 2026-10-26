const api = document.getElementById('newsletter-api');
const init = () => {
    const avatar = document.querySelector('[data-profile-avatar]');
    if (avatar) {
        const image = avatar.querySelector('[data-avatar-image]');
        const input = avatar.querySelector('[data-avatar-input]');
        const remove = avatar.querySelector('[data-avatar-remove]');
        const dropdown = avatar.querySelector('.dropdown-menu');
        const trigger = avatar.querySelector('[data-dropdown]');
        const uploadUrl = avatar.querySelector('[data-avatar-upload-url]').value;
        const removeUrl = avatar.querySelector('[data-avatar-remove-url]').value;
        const placeholder = avatar.querySelector('[data-avatar-placeholder]').value;
        const token = document.querySelector('meta[name="csrf-token"]')?.content;

        input.addEventListener('change', async () => {
            if (!input.files.length) return;
            const form = new FormData();
            form.append('avatar', input.files[0]);
            try {
                const response = await axios.post(uploadUrl, form, { headers: { 'X-CSRF-TOKEN': token, Accept: 'application/json' } });
                image.src = response.data.avatar;
                image.dataset.hasAvatar = 'true';
                avatar.querySelector('[data-profile-avatar-prompt]')?.classList.add('hidden');
                remove.classList.remove('hidden');
                trigger?._tippy?.setContent('<div class="dd-menu flex flex-col max-w-2xl">' + dropdown.innerHTML + '</div>');
                window.showToast(response.data.message);
            } catch (error) {
                window.showToast(error.response?.data?.message ?? 'Upload failed', 'error');
            } finally {
                input.value = '';
            }
        });

        document.addEventListener('click', async event => {
            if (!(event.target instanceof Element)) return;
            const select = event.target.closest('[data-avatar-select]');
            if (select) {
                event.preventDefault();
                input.click();
                avatar.querySelector('[data-dropdown]')?._tippy?.hide();
                return;
            }
            const removeOption = event.target.closest('[data-avatar-remove]');
            if (!removeOption) return;
            event.preventDefault();
            try {
                const response = await axios.delete(removeUrl, { headers: { 'X-CSRF-TOKEN': token, Accept: 'application/json' } });
                image.src = response.data.avatar || placeholder;
                image.dataset.hasAvatar = 'false';
                avatar.querySelector('[data-profile-avatar-prompt]')?.classList.remove('hidden');
                remove.classList.add('hidden');
                trigger?._tippy?.setContent('<div class="dd-menu flex flex-col max-w-2xl">' + dropdown.innerHTML + '</div>');
                window.showToast(response.data.message);
                trigger?._tippy?.hide();
            } catch (error) {
                window.showToast(error.response?.data?.message ?? 'Unable to remove image', 'error');
            }
        });
    }

    if (!api) {
        return;
    }

    const fields = document.querySelectorAll('input[name="mail_release"]');
    fields.forEach(field => {
        field.addEventListener('change', function (e) {
            let name = this.name;
            let data = {};
            data[name] = this.checked ? 1 : 0;

            axios.post(api.value, data)
                .then(res => {
                    window.showToast(res.data.message);
                });
        });
    });
};
init();
