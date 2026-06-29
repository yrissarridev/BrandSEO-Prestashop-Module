{if $listing.products|count}
<section id="brand-products" class="brandseo-front-section brandseo-products-v2">

    <div class="brandseo-products-v2-header">
        <h2>Vinos de {$manufacturer->name|escape:'html':'UTF-8'}</h2>
    </div>

    <div class="brandseo-prestashop-products">
        {include file='catalog/_partials/products.tpl' listing=$listing}
    </div>

</section>
{/if}
