import axios from "axios";


const progressUploading = document.querySelector('.progress-uploading');
const progressValidating = document.querySelector('.progress-validating');
let fileProgress;

const initExport = () => {
    const form = document.getElementById('campaign-import-form');
    if (!form) {
        return;
    }

    fileProgress = document.querySelector('.progress');

    form.onsubmit = (e) => {
        e.preventDefault();

        let count = 0;
        let data = new FormData();
        let files = document.getElementById('export-files');
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
            if (loading) {
                loading.classList.remove('loading');
            }
            return false;
        }
    };
};

const startProcess = (form, data) => {
    form.classList.add('hidden');

    // Now upload to the real endpoint
    let config = {
        headers: {
            'Content-Type': 'multipart/form-data'
        },
        onUploadProgress: function (progressEvent) {
            let percentCompleted = Math.round((progressEvent.loaded * 100) / progressEvent.total);
            document.querySelector('[role="progressbar"]').style.width = percentCompleted + '%';

            if (percentCompleted === 100) {
                progressUploading.classList.add('hidden');
                progressValidating.classList.remove('hidden');
            }
            const progress = document.querySelector('.progress-percent');
            progress.classList.remove('hidden');
            progress.innerHTML = percentCompleted;
        }
    };

    fileProgress.classList.remove('hidden');
    progressUploading.classList.remove('hidden');
    progressValidating.classList.add('hidden');

    axios
        .post(form.action, data, config)
        .then(function (res) {
            fileProgress.classList.add('hidden');

            if (res.data.success) {
                window.location.reload();
            }
        })
        .catch(function (err) {
            form.classList.remove('hidden');
            fileProgress.classList.add('hidden');

            if (err.response && err.response.data.message) {
                fileError.text(err.response.data.message).fadeToggle();

                let errors = err.response.data.errors;
                let errorKeys = Object.keys(errors);
                errorKeys.forEach(k => {
                    window.showToast(errors[k], 'error');
                });
            }

            let loading = document.querySelector('.loading');
            if (loading) {
                loading.classList.remove('loading');
            }
        });
};

initExport();
