(function () {
    window.BrandSEO = window.BrandSEO || {};
    window.BrandSEO.Hero = window.BrandSEO.Hero || {};

    function setClassByPrefix(element, prefix, value) {
        var classes = element.className.split(/\s+/).filter(function (className) {
            return className.indexOf(prefix) !== 0;
        });

        classes.push(prefix + value);
        element.className = classes.join(' ');
    }

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

    function initHeroControls() {
        var frame = document.querySelector('[data-brandseo-hero-frame]');

        if (!frame) {
            return;
        }

        var heightInputs = document.querySelectorAll('[name="hero_height"]');
        var alignInputs = document.querySelectorAll('[name="hero_align"]');

        heightInputs.forEach(function (input) {
            input.addEventListener('change', function () {
                if (input.checked) {
                    setClassByPrefix(frame, 'hero-', input.value);
                }
            });

            if (input.checked) {
                setClassByPrefix(frame, 'hero-', input.value);
            }
        });

        alignInputs.forEach(function (input) {
            input.addEventListener('change', function () {
                if (input.checked) {
                    setClassByPrefix(frame, 'align-', input.value);
                }
            });

            if (input.checked) {
                setClassByPrefix(frame, 'align-', input.value);
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        initHeroPreviewTabs();
        initHeroControls();
    });
})();
