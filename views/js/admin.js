(function () {
    window.BrandSEO = window.BrandSEO || {};

    function initDashboardFilters() {
        var search = document.querySelector('[data-brandseo-search]');
        var filters = document.querySelectorAll('[data-brandseo-filter]');
        var rows = document.querySelectorAll('[data-brandseo-row]');

        if (!rows.length) {
            return;
        }

        var activeFilter = 'all';

        function applyFilters() {
            var query = search ? search.value.toLowerCase().trim() : '';

            rows.forEach(function (row) {
                var name = (row.getAttribute('data-brand-name') || '').toLowerCase();
                var status = row.getAttribute('data-brand-status') || '';
                var visibleBySearch = !query || name.indexOf(query) !== -1;
                var visibleByFilter = activeFilter === 'all' || status === activeFilter;

                row.style.display = (visibleBySearch && visibleByFilter) ? '' : 'none';
            });
        }

        if (search) {
            search.addEventListener('input', applyFilters);
        }

        filters.forEach(function (button) {
            button.addEventListener('click', function () {
                filters.forEach(function (b) { b.classList.remove('active'); });
                button.classList.add('active');
                activeFilter = button.getAttribute('data-brandseo-filter') || 'all';
                applyFilters();
            });
        });
    }

    document.addEventListener('DOMContentLoaded', initDashboardFilters);
})();
