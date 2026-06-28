<section id="brandseo-hero" class="brandseo-editor-section">
    <h3 class="brandseo-editor-section-title">Hero Builder</h3>

    <p class="help-block">
        Diseña la cabecera principal de la futura landing.
    </p>

    {assign var=hero_background value=''}
    {if $hero_images|count}
        {foreach from=$hero_images item=media name=hero_media_bg}
            {if $smarty.foreach.hero_media_bg.first}
                {assign var=hero_background value=$module_dir_url|cat:$media.path}
            {/if}
        {/foreach}
    {/if}

    {assign var=hero_logo value=''}
    {if $hero_logos|count}
        {foreach from=$hero_logos item=logo name=hero_logo_loop}
            {if $smarty.foreach.hero_logo_loop.first}
                {assign var=hero_logo value=$module_dir_url|cat:$logo.path}
            {/if}
        {/foreach}
    {/if}

    <div class="brandseo-hero-builder">
        <div class="brandseo-hero-controls">
            <div class="brandseo-hero-option-group">
                <label>Imagen Hero</label>
                <div class="brandseo-dropzone">
                    <strong>Sube una imagen JPG, PNG o WebP</strong>
                    <input type="file" name="hero_image_file" accept="image/jpeg,image/png,image/webp">
                    <button type="submit" name="submitBrandSeoHeroImage" class="btn btn-default" style="margin-top:10px;">
                        <i class="icon-upload"></i>
                        Subir hero
                    </button>
                </div>

                {if $hero_background}
                    <p class="help-block">Imagen actual: {$hero_background|escape:'html':'UTF-8'}</p>
                {/if}
            </div>

            <div class="brandseo-hero-option-group">
                <label>Logo</label>
                <div class="brandseo-dropzone">
                    <strong>Logo de la marca</strong>
                    <span>JPG, PNG o WebP</span>
                    <input type="file" name="hero_logo_file" accept="image/jpeg,image/png,image/webp">
                    <button type="submit" name="submitBrandSeoHeroLogo" class="btn btn-default" style="margin-top:10px;">
                        <i class="icon-upload"></i>
                        Subir logo
                    </button>
                </div>

                {if $hero_logo}
                    <p class="help-block">Logo actual: {$hero_logo|escape:'html':'UTF-8'}</p>
                {/if}
            </div>

            {foreach from=$languages item=lang}
                {assign var=id_lang value=$lang.id_lang}
                {if $id_lang == $id_lang}
                    <div class="brandseo-hero-option-group">
                        <label>Título del Hero</label>
                        <input type="text" id="brandseo-title-{$id_lang|intval}" name="title_{$id_lang|intval}" value="{$landing->title[$id_lang]|escape:'html':'UTF-8'}">
                    </div>

                    <div class="brandseo-hero-option-group">
                        <label>Resumen / Introducción</label>
                        <textarea id="brandseo-excerpt-{$id_lang|intval}" name="excerpt_{$id_lang|intval}" rows="4">{$landing->excerpt[$id_lang]|escape:'html':'UTF-8'}</textarea>
                    </div>
                {/if}
            {/foreach}

            <div class="brandseo-hero-option-group">
                <label>Altura</label>
                <div class="brandseo-hero-radio-group">
                    <label><input type="radio" name="hero_height" value="small"> Pequeña</label>
                    <label><input type="radio" name="hero_height" value="medium" checked> Media</label>
                    <label><input type="radio" name="hero_height" value="large"> Grande</label>
                </div>
            </div>

            <div class="brandseo-hero-option-group">
                <label>Alineación</label>
                <div class="brandseo-hero-radio-group">
                    <label><input type="radio" name="hero_align" value="left"> Izquierda</label>
                    <label><input type="radio" name="hero_align" value="center" checked> Centro</label>
                    <label><input type="radio" name="hero_align" value="right"> Derecha</label>
                </div>
            </div>

            <div class="brandseo-hero-option-group">
                <label>Oscurecer fondo</label>
                <input type="range" name="hero_overlay" min="0" max="80" value="48" data-brandseo-hero-overlay>
                <p class="help-block">Ajusta la legibilidad del texto sobre la imagen.</p>
            </div>
        </div>

        <div class="brandseo-hero-preview">
            <div class="brandseo-hero-preview-tabs">
                <button type="button" class="brandseo-hero-preview-tab" data-brandseo-hero-preview="desktop">Desktop</button>
                <button type="button" class="brandseo-hero-preview-tab" data-brandseo-hero-preview="tablet">Tablet</button>
                <button type="button" class="brandseo-hero-preview-tab" data-brandseo-hero-preview="mobile">Móvil</button>
            </div>

            <div class="brandseo-hero-preview-frame desktop brandseo-hero-preview-fixed" data-brandseo-hero-frame style="--brandseo-hero-overlay: .48;">
                {if $hero_background}
                    <img class="brandseo-hero-preview-image" src="{$hero_background|escape:'html':'UTF-8'}" alt="">
                {/if}

                <div class="brandseo-hero-preview-overlay" data-brandseo-hero-overlay-layer></div>

                <div class="brandseo-hero-preview-content brandseo-hero-preview-content-fixed">
                    {if $hero_logo}
                        <img class="brandseo-hero-preview-logo-img" src="{$hero_logo|escape:'html':'UTF-8'}" alt="">
                    {else}
                        <div class="brandseo-hero-preview-logo">LOGO</div>
                    {/if}
                    <h2 id="brandseo-preview-title" class="brandseo-hero-preview-title">
                        {if $landing->title[$id_lang]}
                            {$landing->title[$id_lang]|escape:'html':'UTF-8'}
                        {else}
                            {$manufacturer->name|escape:'html':'UTF-8'}
                        {/if}
                    </h2>
                    <p id="brandseo-preview-excerpt" class="brandseo-hero-preview-text brandseo-hero-preview-text-fixed">
                        {if $landing->excerpt[$id_lang]}
                            {$landing->excerpt[$id_lang]|escape:'html':'UTF-8'}
                        {else}
                            Descubre esta marca y su filosofía.
                        {/if}
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
