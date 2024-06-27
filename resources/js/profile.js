const api = document.getElementById('newsletter-api');
const init = () => {
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


