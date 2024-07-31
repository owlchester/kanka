import axios from "axios";

const loader = document.querySelector('#gallery-loader');
const gallery = document.querySelector('#gallery-images');
const search = document.querySelector('#gallery-search');
const bulkDelete = document.querySelector('#bulk-delete');
const bulkForm = document.querySelector('form#gallery-bulk');

const galleryForm = document.getElementById('gallery-form');

const fileProgress = document.querySelector('.progress');
const fileError = document.querySelector('.gallery-error');

let maxFiles;
let maxError;


const initGallery = () => {
    const config = document.querySelector('#gallery-config');
    maxFiles = config.dataset.max;
    maxError = config.dataset.error;

    search.addEventListener('blur', function(e) {
        e.preventDefault();
        initSearch();
    });
    search.addEventListener('keydown', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            initSearch();
        }
    });

    registerUploadEvents();

    bulkForm.onsubmit = function (e) {
        e.preventDefault();

        const data = new FormData();
        document.querySelectorAll('li[data-selected="1"]')?.forEach(ele => {
            data.append('file[]', ele.dataset.id);
        });

        const folder = document.querySelector('input[name="folder_id"]');
        if (folder) {
            data.append('folder_id', folder.value);
        }

        axios.post(bulkForm.getAttribute('action'), data)
            .then(res => {
                document.querySelectorAll('li[data-selected="1"]')?.forEach(ele => ele.remove());
                let target = document.getElementById('bulk-destroy-dialog');
                target.close();

                bulkDelete.classList.add('btn-disabled');

                window.showToast(res.data.toast);
                return false;
            });
        return false;
    };
};

const registerUploadEvents = () => {
    if (!galleryForm) {
        return;
    }
    galleryForm.ondrop = (ev) => {
        ev.preventDefault();
        ev.stopPropagation();

        if (ev.dataTransfer.items) {
            let data = new FormData();
            let fileCount = 0;
            // Use DataTransferItemList interface to access the file(s)
            [...ev.dataTransfer.items].forEach((item, i) => {
                // If dropped items aren't files, reject them
                if (item.kind === 'file') {
                    data.append('file[]', item.getAsFile());
                    fileCount++;
                }
            });

            if (fileCount > maxFiles) {
                alertTooManyFiles();
                return;
            }

            let folder = document.querySelector('input[name="folder_id"]');
            if (folder) {
                data.append('folder_id', folder.value);
            }
            uploadFiles(data);
            galleryForm.classList.remove('drop-shadow', 'dropping');
        } else {
            // Use DataTransfer interface to access the file(s)
            [...ev.dataTransfer.files].forEach((file, i) => {
                //console.log(`… file[${i}].name = ${file.name}`);
            });
        }
    };
    galleryForm.ondragover = (e) => {
        e.preventDefault();
        galleryForm.classList.add('drop-shadow', 'dropping');
    };
    galleryForm.ondragleave = (e) => {
        galleryForm.classList.remove('drop-shadow', 'dropping');
    };
};

/**
 *
 */
function initSearch() {
    gallery.classList.add('hidden');
    loader.classList.remove('hidden');

    axios.get(search.dataset.url + '?q=' + search.value)
        .then(res => {
            loader.classList.add('hidden');
            gallery.innerHTML = res.data;
            gallery.classList.remove('hidden');
            registerEvents();
        });
}

/**
 *
 */
const initUploader = () => {
    if (!galleryForm) {
        return;
    }
    galleryForm.onchange = (event) => {
        event.preventDefault();

        let galleryFiles = document.getElementById('file-upload');

        if (galleryFiles.files.length > maxFiles) {
            alertTooManyFiles();
            return;
        }

        let data = new FormData();
        /*for (const i in galleryFiles.files) {
            let key = 'file[]';
            data.append(key, galleryFiles.files[i]);
        }*/
        Array.from(galleryFiles.files).forEach(file => {
            data.append('file[]', file);
        });

        let folder = document.querySelector('input[name="folder_id"]');
        if (folder) {
            data.append('folder_id', folder.value);
        }

        uploadFiles(data);
    };
};

const alertTooManyFiles = () => {
    window.showToast(maxError, 'error');
};

const uploadFiles = (data) => {
    let config = {
        headers: {
            'Content-Type': 'multipart/form-data'
        },
        onUploadProgress: function (progressEvent) {
            let percentCompleted = Math.round((progressEvent.loaded * 100) / progressEvent.total);
            document.querySelector('[role="progressbar"]').style.width = percentCompleted + '%';
        }
    };

    fileProgress.classList.remove('hidden');

    axios
        .post(galleryForm.action, data, config)
        .then(function (res) {

            fileProgress.classList.add('hidden');

            if (res.data.success) {
                res.data.images.forEach(image => {

                    // Do we have a folder to add to?
                    const folders = document.querySelectorAll('li[data-folder]');
                    if (folders.length > 1) {
                        const lastFolder = folders[folders.length - 1];
                        //console.log('last folder', lastFolder, image);
                        lastFolder.insertAdjacentHTML('afterend', image);
                    } else {
                        gallery.insertAdjacentHTML('afterbegin', image);
                    }
                });
                updateStorage(res.data.storage);
                registerEvents();
            }
        })
        .catch(function (err) {
            fileProgress.classList.add('hidden');

            if (err.response && err.response.data.message) {
                fileError.innerHTML = err.response.data.message;
                fileError.classList.remove('hidden');

                let errors = err.response.data.errors;
                let errorKeys = Object.keys(errors);
                errorKeys.forEach(k => {
                    window.showToast(errors[k], 'error');
                });
            }

            registerEvents();
        });
};


const registerEvents = () => {
    document.querySelectorAll('#gallery-images li')?.forEach(ele => {
        if (ele.dataset.binded === '1') {
            return;
        }
        ele.dataset.binded = '1';
        ele.addEventListener('click', function (e) {
            if (e.shiftKey) {
                if (!ele.dataset.id) {
                    return;
                }
                ele.classList.toggle('border-2');
                ele.classList.toggle('border-blue-500');
                if (ele.getAttribute('data-selected') === '1') {
                    ele.setAttribute('data-selected', '');
                } else {
                   ele.setAttribute('data-selected', 1);
                }
                registerShift();
                return;
            }
            let folder = ele.dataset.folder;
            if (folder) {
                window.location = folder;
                return;
            }
            window.openDialog('primary-dialog', ele.dataset.url);
        });
    });
};

const registerShift = () => {
    let selected = document.querySelectorAll('li[data-selected="1"]');
    if (selected.length === 0) {
        bulkDelete.classList.add('btn-disabled');
    } else {
        bulkDelete.classList.remove('btn-disabled');
    }
};

const updateStorage = (storage) => {
    let progress = document.getElementById('storage-progress');
    progress.style.width = storage.percentage + '%';
    progress.className = storage.progress;

    let used = document.getElementById('storage-used');
    used.innerHTML = storage.used;
};


initGallery();
initUploader();
registerEvents();
