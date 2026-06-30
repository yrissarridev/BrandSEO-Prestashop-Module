<section id="brandseo-seo" class="brandseo-editor-section">
    <h3 class="brandseo-editor-section-title">SEO Preview</h3>

    <p class="help-block">
        Previsualiza cómo podría verse esta landing en Google.
    </p>

    {foreach from=$languages item=lang}
        {assign var=id_lang value=$lang.id_lang}

        <div class="brandseo-seo-layout">
            <div class="brandseo-seo-fields">
                <h4>Metadatos · {$lang.name|escape:'html':'UTF-8'}</h4>

                <div class="form-group">
                    <label>Meta title</label>
                    <input
                        type="text"
                        id="brandseo-meta-title-{$id_lang|intval}"
                        name="meta_title_{$id_lang|intval}"
                        value="{$landing->meta_title[$id_lang]|escape:'html':'UTF-8'}">
                    <p class="help-block">
                        Recomendado: 50–60 caracteres.
                        <span class="brandseo-meta-count" data-meta-count-for="brandseo-meta-title-{$id_lang|intval}">0</span>
                    </p>
                </div>

                <div class="form-group">
                    <label>Meta description</label>
                    <textarea
                        id="brandseo-meta-description-{$id_lang|intval}"
                        name="meta_description_{$id_lang|intval}"
                        rows="3">{$landing->meta_description[$id_lang]|escape:'html':'UTF-8'}</textarea>
                    <p class="help-block">
                        Recomendado: 140–160 caracteres.
                        <span class="brandseo-meta-count" data-meta-count-for="brandseo-meta-description-{$id_lang|intval}">0</span>
                    </p>
                </div>
            </div>

            <div class="brandseo-google-preview">
                <span class="brandseo-google-url" id="brandseo-google-url">
                    marcas/{$landing->slug|escape:'html':'UTF-8'}
                </span>

                <h4 id="brandseo-google-title">
                    {if $landing->meta_title[$id_lang]}
                        {$landing->meta_title[$id_lang]|escape:'html':'UTF-8'}
                    {else}
                        {$landing->title[$id_lang]|escape:'html':'UTF-8'}
                    {/if}
                </h4>

                <p id="brandseo-google-description">
                    {if $landing->meta_description[$id_lang]}
                        {$landing->meta_description[$id_lang]|escape:'html':'UTF-8'}
                    {else}
                        {$landing->excerpt[$id_lang]|escape:'html':'UTF-8'}
                    {/if}
                </p>
            </div>

            <div class="brandseo-og-preview">
                <div class="brandseo-og-image">
                    {if $hero_background_url}
                        <img src="{$hero_background_url|escape:'html':'UTF-8'}" alt="">
                    {else}
                        <span>Imagen Open Graph</span>
                    {/if}
                </div>

                <div class="brandseo-og-content">
                    <span class="brandseo-og-domain">marcas/{$landing->slug|escape:'html':'UTF-8'}</span>

                    <h4 id="brandseo-og-title">
                        {if $landing->meta_title[$id_lang]}
                            {$landing->meta_title[$id_lang]|escape:'html':'UTF-8'}
                        {else}
                            {$landing->title[$id_lang]|escape:'html':'UTF-8'}
                        {/if}
                    </h4>

                    <p id="brandseo-og-description">
                        {if $landing->meta_description[$id_lang]}
                            {$landing->meta_description[$id_lang]|escape:'html':'UTF-8'}
                        {else}
                            {$landing->excerpt[$id_lang]|escape:'html':'UTF-8'}
                        {/if}
                    </p>
                </div>
            </div>

            <div class="brandseo-seo-audit">
                <h4>SEO Audit</h4>

                <ul>
                    <li id="audit-title">⚪ Meta title</li>
                    <li id="audit-description">⚪ Meta description</li>
                    <li id="audit-hero">⚪ Imagen Hero</li>
                    <li id="audit-excerpt">⚪ Introducción</li>
                </ul>

                <div class="brandseo-seo-score">
                    <strong id="brandseo-seo-score">0%</strong>
                </div>
            </div>
        </div>
    {/foreach}
</section>
