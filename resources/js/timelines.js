let oldEra;

/**
 * Dynamically update the element's "position" dropdown field based on the selected era.
 */
const registerElementForm = () => {
    const field = document.getElementById('element-era-id');
    if (!field) {
        return;
    }
    oldEra = field.value;
    field.addEventListener('change', function () {
        // Load era list
        loadTimelineEra(field.value);
    });
};

/**
 *
 * @param eraID
 */
const loadTimelineEra = (eraID) => {
    eraID = parseInt(eraID);
    let url = document.querySelector('input[name="era-data-url"]').dataset.url.replace('/0/', '/' + eraID + '/');
    let oldPosition = document.querySelector('input[name="oldPosition"]').dataset.url;

    axios.get(url)
        .then(res => {
            let eraField = document.querySelector('select[name="position"]');
            eraField.innerHTML = '';
            let id = 1;
            const options = Object.entries(res.data.positions);
            options.forEach(function (position, i) {
                const newOption = document.createElement('option');
                newOption.text = position[1];
                if (oldPosition && !i && (oldEra == eraID)) {
                    newOption.value = 1;
                    eraField.appendChild(newOption);
                }
                if (i) {
                    newOption.value = id;
                    eraField.appendChild(newOption);
                }
                id++;
            });
        });
};

registerElementForm();
