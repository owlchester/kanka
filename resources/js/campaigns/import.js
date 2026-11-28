import axios from "axios";
import { createS3UploadClient } from "./s3UploadClient.js";

const DEFAULT_MAX_ZIP_SIZE = 512 * 1024 * 1024;
const DEFAULT_MAX_CSV_SIZE = 50 * 1024 * 1024;

const initExport = () => {
    const form = document.getElementById('campaign-import-form');
    if (!form) {
        return;
    }

    const allowedExtensions = (form.dataset.allowedExtensions || 'zip,csv')
        .split(',')
        .map((ext) => ext.trim().toLowerCase())
        .filter(Boolean);
    const maxSizes = {
        zip: Number(form.dataset.maxZipSize) || DEFAULT_MAX_ZIP_SIZE,
        csv: Number(form.dataset.maxCsvSize) || DEFAULT_MAX_CSV_SIZE,
    };
    const typeErrorMessage = form.dataset.errorType || 'Please select a .zip or .csv file.';
    const sizeErrorMessages = {
        zip: form.dataset.errorSizeZip || 'File is too large. Maximum size is 512 MiB.',
        csv: form.dataset.errorSizeCsv || 'File is too large. Maximum size is 50 MiB.',
    };

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
            showError(typeErrorMessage);
            return;
        }

        const ext = file.name.toLowerCase().split('.').pop();
        if (!allowedExtensions.includes(ext)) {
            showError(typeErrorMessage);
            return;
        }

        const maxSize = maxSizes[ext] ?? DEFAULT_MAX_ZIP_SIZE;
        if (file.size > maxSize) {
            showError(sizeErrorMessages[ext] || sizeErrorMessages.zip);
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

        const s3Axios = createS3UploadClient(axios);

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
