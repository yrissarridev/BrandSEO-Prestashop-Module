<section class="brandseo-front-section brandseo-front-empty-section">

    <div class="brandseo-front-empty-card">
        <h2>{$manufacturer->name|escape:'html':'UTF-8'}</h2>
        <p>Próximamente ampliaremos la información de esta marca.</p>

        {if $brand_products|count}
            <a href="#brand-products">Ver productos disponibles</a>
        {else}
            <a href="{$urls.base_url|escape:'html':'UTF-8'}">Volver a la tienda</a>
        {/if}
    </div>

</section>
