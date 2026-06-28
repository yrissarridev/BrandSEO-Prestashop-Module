{if $related_brands|count}
<section class="brandseo-front-section brandseo-front-related-section">

    <div class="brandseo-front-section-header">
        <h2>Otras marcas que te pueden interesar</h2>
    </div>

    <div class="brandseo-front-related-grid">
        {foreach from=$related_brands item=brand}
            <a class="brandseo-front-related-card" href="{$brand.url|escape:'html':'UTF-8'}">
                <strong>{$brand.name|escape:'html':'UTF-8'}</strong>
                <span>{$brand.total_products|intval} productos</span>
            </a>
        {/foreach}
    </div>

</section>
{/if}
