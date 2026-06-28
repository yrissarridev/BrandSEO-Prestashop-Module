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

(function () {
    function bindSeoPreview() {
        var titleInput = document.querySelector('[id^="brandseo-meta-title-"]');
        var descriptionInput = document.querySelector('[id^="brandseo-meta-description-"]');
        var previewTitle = document.getElementById('brandseo-google-title');
        var previewDescription = document.getElementById('brandseo-google-description');

        if (titleInput && previewTitle) {
            titleInput.addEventListener('input', function () {
                previewTitle.textContent = titleInput.value.trim() || 'Título SEO de la landing';
            });
        }

        if (descriptionInput && previewDescription) {
            descriptionInput.addEventListener('input', function () {
                previewDescription.textContent = descriptionInput.value.trim() || 'Descripción SEO de la landing.';
            });
        }
    }

    document.addEventListener('DOMContentLoaded', bindSeoPreview);
})();

(function () {
    function scoreLength(length, min, max) {
        if (length >= min && length <= max) {
            return 'ok';
        }

        if (length > 0 && length < min) {
            return 'warn';
        }

        return 'bad';
    }

    function initMetaCounters() {
        document.querySelectorAll('[data-meta-count-for]').forEach(function (counter) {
            var inputId = counter.getAttribute('data-meta-count-for');
            var input = document.getElementById(inputId);

            if (!input) {
                return;
            }

            var isDescription = inputId.indexOf('description') !== -1;
            var min = isDescription ? 140 : 50;
            var max = isDescription ? 160 : 60;

            function update() {
                var length = input.value.length;
                counter.textContent = length + '/' + max;
                counter.classList.remove('ok', 'warn', 'bad');
                counter.classList.add(scoreLength(length, min, max));
            }

            input.addEventListener('input', update);
            update();
        });
    }

    document.addEventListener('DOMContentLoaded', initMetaCounters);
})();
