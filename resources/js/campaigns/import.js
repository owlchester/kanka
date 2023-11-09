import axios from "axios";

$(document).ready(function() {
    initExport();
});

var fileProgress;

const initExport = () => {
    let form = document.getElementById('campaign-import-form');
    if (!form) {
        return;
    }

    fileProgress = $('.progress');

    form.onsubmit = (e) => {
        e.preventDefault();

        let count = 0;
        let data = new FormData();
        let files = document.getElementById('export-files');
        console.log('files', files.files);
        Array.from(files.files).forEach(file => {
            if (file.name.endsWith('.zip')) {
                count++;
                data.append('files[]', file);
            }
        });
        let campaign =  document.querySelector('input[name="campaign"]');
        data.append('campaign', campaign.value);
        let token =  document.querySelector('input[name="token"]');
        data.append('token', token.value);

        // Two files submitted? Do the thing
        if (count > 0 && count < 2) {
            startProcess(form, data);
        } else {
            alert('Please select the campaign export zip files.');
            let loading = document.querySelector('.loading');
            loading.classList.remove('loading');
            return false;
        }
    };
};

const startProcess = (form, data) => {
    console.log('start');

    // Now upload to the real endpoint
    let config = {
        headers: {
            'Content-Type': 'multipart/form-data'
        },
        onUploadProgress: function (progressEvent) {
            let percentCompleted = Math.round((progressEvent.loaded * 100) / progressEvent.total);
            $('[role="progressbar"]').css(
                'width',
                percentCompleted + '%'
            );
        }
    };

    fileProgress.show();

    axios
        .post(form.action, data, config)
        .then(function (res) {
            console.log('yo?');
            fileProgress.hide();

            if (res.data.success) {

            }
        })
        .catch(function (err) {
            alert('oops');
            fileProgress.hide();

            if (err.response && err.response.data.message) {
                fileError.text(err.response.data.message).fadeToggle();

                let errors = err.response.data.errors;
                let errorKeys = Object.keys(errors);
                errorKeys.forEach(k => {
                    window.showToast(errors[k], 'error');
                });
            }
        });
}
