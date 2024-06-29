
const initHistoryFilters = () => {
    const form = document.querySelector('form.history-filters');
    const filters = document.querySelectorAll('.history-filters select');
    filters.forEach(filter => {
        filter.addEventListener('change', function () {
            document.querySelector('.filters-loading').classList.remove('hidden');
            form.requestSubmit();
            filters.disabled = true;
        });
    });
};
initHistoryFilters();
