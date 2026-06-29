import axios from "axios";

const MAX_SIZE = 536870912;

const initExport = () => {
    const form = document.getElementById('campaign-import-form');
    if (!form) {
        return;
    }

    const fileProgress = document.querySelector('.progress');
    const progressBar = document.querySelector('[role="progressbar"]');
    const progressPercent = document.querySelector('.progress-percent');
    const progressUploading = document.querySelector('.progress-uploading');
    const progressValidating = document.querySelector('.progress-validating');

    const showError = (message) => {
        form.classList.remove('hidden');
        fileProgress.classList.add('hidden');
        window.showToast(message, 'error');
    };

    form.onsubmit = async (e) => {
        e.preventDefault();

        const fileInput = document.getElementById('export-files');
        const file = fileInput.files[0];

        if (!file) {
            showError('Please select a .zip or .csv file.');
            return;
        }

        const ext = file.name.toLowerCase().split('.').pop();
        if (ext !== 'zip' && ext !== 'csv') {
            showError('Please select a .zip or .csv file.');
            return;
        }

        if (file.size > MAX_SIZE) {
            showError('File is too large. Maximum size is 512 MiB.');
            return;
        }

        form.classList.add('hidden');
        fileProgress.classList.remove('hidden');
        progressUploading.classList.remove('hidden');
        progressValidating.classList.add('hidden');
        progressBar.style.width = '0%';
        progressPercent.innerHTML = '0';

        let presignData;
        try {
            const presignRes = await axios.post(form.dataset.presignUrl, { ext });
            presignData = presignRes.data;
        } catch {
            showError('Failed to prepare upload. Please try again.');
            return;
        }

        const s3Axios = axios.create();
        delete s3Axios.defaults.headers.common['X-Requested-With'];
        delete s3Axios.defaults.headers.common['X-XSRF-TOKEN'];
        delete s3Axios.defaults.headers.common['Authorization'];

        try {
            await s3Axios.put(presignData.url, file, {
                headers: { 'Content-Type': file.type, ...presignData.headers },
                onUploadProgress: (progressEvent) => {
                    const percent = Math.round((progressEvent.loaded * 100) / progressEvent.total);
                    progressBar.style.width = percent + '%';
                    progressPercent.innerHTML = percent;

                    if (percent === 100) {
                        progressUploading.classList.add('hidden');
                        progressValidating.classList.remove('hidden');
                    }
                },
            });
        } catch {
            showError('Failed to upload file to storage.');
            return;
        }

        try {
            const confirmRes = await axios.post(form.dataset.confirmUrl);
            if (confirmRes.data.success) {
                window.location.reload();
            }
        } catch {
            showError('Failed to confirm upload. Please try again.');
        }
    };
};

initExport();
