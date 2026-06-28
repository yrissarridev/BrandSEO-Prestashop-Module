{extends file='page.tpl'}

{block name='page_title'}
Marcas
{/block}

{block name='page_content'}

<div class="brandseo-front brandseo-brands-page">

    <div class="brandseo-front-content">

        <section class="brandseo-front-section">

            <div class="brandseo-front-section-header">
                <h1>Marcas</h1>
                <p>Descubre bodegas, productores y marcas disponibles en Vinófilos.</p>
            </div>

            {if $brandseo_brands|count}
                <div class="brandseo-front-related-grid">
                    {foreach from=$brandseo_brands item=brand}
                        <a class="brandseo-front-related-card" href="{$brand.url|escape:'html':'UTF-8'}">
                            <strong>{$brand.name|escape:'html':'UTF-8'}</strong>
                            <span>{$brand.total_products|intval} productos</span>
                            {if $brand.excerpt}
                                <p>{$brand.excerpt|strip_tags|truncate:140:'...'|escape:'html':'UTF-8'}</p>
                            {/if}
                        </a>
                    {/foreach}
                </div>
            {/if}

        </section>

    </div>

</div>

{/block}
