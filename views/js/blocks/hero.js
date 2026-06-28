(function () {
    window.BrandSEO = window.BrandSEO || {};
    window.BrandSEO.Hero = window.BrandSEO.Hero || {};

    function removeClassPrefix(element, prefix) {
        element.className = element.className
            .split(/\s+/)
            .filter(function (className) {
                return className.indexOf(prefix) !== 0;
            })
            .join(' ');
    }

    function setClassByPrefix(element, prefix, value) {
        removeClassPrefix(element, prefix);
        element.classList.add(prefix + value);
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

        document.querySelectorAll('[name="hero_height"]').forEach(function (input) {
            input.addEventListener('change', function () {
                if (input.checked) {
                    setClassByPrefix(frame, 'hero-', input.value);
                }
            });

            if (input.checked) {
                setClassByPrefix(frame, 'hero-', input.value);
            }
        });

        document.querySelectorAll('[name="hero_align"]').forEach(function (input) {
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

    function initHeroLivePreview() {
        var titleInput = document.querySelector('[id^="brandseo-title-"]');
        var excerptInput = document.querySelector('[id^="brandseo-excerpt-"]');
        var previewTitle = document.getElementById('brandseo-preview-title');
        var previewExcerpt = document.getElementById('brandseo-preview-excerpt');

        if (titleInput && previewTitle) {
            titleInput.addEventListener('input', function () {
                previewTitle.textContent = titleInput.value.trim() || 'Nueva marca';
            });
        }

        if (excerptInput && previewExcerpt) {
            excerptInput.addEventListener('input', function () {
                previewExcerpt.textContent = excerptInput.value.trim() || 'Descubre esta marca y su filosofía.';
            });
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        initHeroPreviewTabs();
        initHeroControls();
        initHeroLivePreview();
    });
})();
