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

(function () {
    function bindOpenGraphPreview() {
        var titleInput = document.querySelector('[id^="brandseo-meta-title-"]');
        var descriptionInput = document.querySelector('[id^="brandseo-meta-description-"]');
        var ogTitle = document.getElementById('brandseo-og-title');
        var ogDescription = document.getElementById('brandseo-og-description');

        if (titleInput && ogTitle) {
            titleInput.addEventListener('input', function () {
                ogTitle.textContent = titleInput.value.trim() || 'Título Open Graph';
            });
        }

        if (descriptionInput && ogDescription) {
            descriptionInput.addEventListener('input', function () {
                ogDescription.textContent = descriptionInput.value.trim() || 'Descripción Open Graph.';
            });
        }
    }

    document.addEventListener('DOMContentLoaded', bindOpenGraphPreview);
})();

(function () {
    function bindSlugPreview() {
        var slugInput = document.getElementById('brandseo-slug');
        var googleUrl = document.getElementById('brandseo-google-url');

        if (!slugInput || !googleUrl) {
            return;
        }

        function update() {
            var slug = slugInput.value.trim() || 'nueva-marca';
            googleUrl.textContent = 'tienda.vinofilos.es/brand/' + slug;
        }

        slugInput.addEventListener('input', update);
        update();
    }

    document.addEventListener('DOMContentLoaded', bindSlugPreview);
})();

(function(){

function seoAudit(){

    var title=document.querySelector('[id^="brandseo-meta-title-"]');
    var description=document.querySelector('[id^="brandseo-meta-description-"]');
    var excerpt=document.querySelector('[id^="brandseo-excerpt-"]');

    var score=0;

    function update(){

        score=0;

        if(title && title.value.length>=50 && title.value.length<=60){
            document.getElementById('audit-title').textContent='🟢 Meta title';
            score+=25;
        }else{
            document.getElementById('audit-title').textContent='🟠 Meta title';
        }

        if(description && description.value.length>=140 && description.value.length<=160){
            document.getElementById('audit-description').textContent='🟢 Meta description';
            score+=25;
        }else{
            document.getElementById('audit-description').textContent='🟠 Meta description';
        }

        var hero=document.querySelector('.brandseo-hero-preview-image');

        if(hero){
            document.getElementById('audit-hero').textContent='🟢 Imagen Hero';
            score+=25;
        }else{
            document.getElementById('audit-hero').textContent='🔴 Imagen Hero';
        }

        if(excerpt && excerpt.value.length>=120){
            document.getElementById('audit-excerpt').textContent='🟢 Introducción';
            score+=25;
        }else{
            document.getElementById('audit-excerpt').textContent='🟠 Introducción';
        }

        document.getElementById('brandseo-seo-score').textContent=score+'%';

    }

    if(title) title.addEventListener('input',update);
    if(description) description.addEventListener('input',update);
    if(excerpt) excerpt.addEventListener('input',update);

    update();

}

document.addEventListener('DOMContentLoaded',seoAudit);

})();

(function () {
    function initSeoAudit() {
        var title = document.querySelector('[id^="brandseo-meta-title-"]');
        var description = document.querySelector('[id^="brandseo-meta-description-"]');
        var excerpt = document.querySelector('[id^="brandseo-excerpt-"]');

        var titleAudit = document.getElementById('audit-title');
        var descriptionAudit = document.getElementById('audit-description');
        var heroAudit = document.getElementById('audit-hero');
        var excerptAudit = document.getElementById('audit-excerpt');
        var scoreNode = document.getElementById('brandseo-seo-score');

        if (!scoreNode) {
            return;
        }

        function setText(node, text) {
            if (node) {
                node.textContent = text;
            }
        }

        function update() {
            var score = 0;

            if (title && title.value.length >= 50 && title.value.length <= 60) {
                setText(titleAudit, '🟢 Meta title');
                score += 25;
            } else {
                setText(titleAudit, '🟠 Meta title');
            }

            if (description && description.value.length >= 140 && description.value.length <= 160) {
                setText(descriptionAudit, '🟢 Meta description');
                score += 25;
            } else {
                setText(descriptionAudit, '🟠 Meta description');
            }

            if (document.querySelector('.brandseo-hero-preview-image')) {
                setText(heroAudit, '🟢 Imagen Hero');
                score += 25;
            } else {
                setText(heroAudit, '🔴 Imagen Hero');
            }

            if (excerpt && excerpt.value.length >= 120) {
                setText(excerptAudit, '🟢 Introducción');
                score += 25;
            } else {
                setText(excerptAudit, '🟠 Introducción');
            }

            scoreNode.textContent = score + '%';
        }

        if (title) {
            title.addEventListener('input', update);
        }

        if (description) {
            description.addEventListener('input', update);
        }

        if (excerpt) {
            excerpt.addEventListener('input', update);
        }

        update();
    }

    document.addEventListener('DOMContentLoaded', initSeoAudit);
})();
