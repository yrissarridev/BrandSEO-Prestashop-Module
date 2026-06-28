{if isset($listing.products) && $listing.products|count}
<section id="brand-products" class="brandseo-front-section brandseo-products-v2">

    <div class="brandseo-products-v2-header">
        <h2>Vinos de {$manufacturer->name|escape:'html':'UTF-8'}</h2>
    </div>

    <div class="brandseo-native-product-listing">
        {include file='catalog/listing/product-list.tpl' listing=$listing}
    </div>

</section>
{/if}
