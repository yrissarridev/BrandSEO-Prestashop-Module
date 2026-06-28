(function () {
    window.BrandSEO = window.BrandSEO || {};
    window.BrandSEO.Hero = window.BrandSEO.Hero || {};

    function initHeroPreviewTabs() {
        var tabs = document.querySelectorAll('[data-brandseo-hero-preview]');
        var frame = document.querySelector('[data-brandseo-hero-frame]');

        if (!tabs.length || !frame) {
            return;
        }

        tabs.forEach(function (tab) {
            tab.addEventListener('click', function () {
                var mode = tab.getAttribute('data-brandseo-hero-preview');

                frame.classList.remove('desktop', 'tablet', 'mobile');
                frame.classList.add(mode);
            });
        });
    }

    document.addEventListener('DOMContentLoaded', initHeroPreviewTabs);
})();
