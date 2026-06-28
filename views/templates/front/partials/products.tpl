{if $brand_products|count}
<section id="brand-products" class="brandseo-front-section brandseo-front-products-section">

    <div class="brandseo-front-section-header">
        <h2>Vinos de {$manufacturer->name|escape:'html':'UTF-8'}</h2>
    </div>

    <div class="brandseo-front-products-grid">

        {foreach from=$brand_products item=product}
            <div class="brandseo-front-product-card">

                <a class="brandseo-front-product-image" href="{$product.url|escape:'html':'UTF-8'}">
                    {if $product.image_url}
                        <img
                            src="{$product.image_url|escape:'html':'UTF-8'}"
                            alt="{$product.name|escape:'html':'UTF-8'}"
                            loading="lazy">
                    {else}
                        <span>Sin imagen</span>
                    {/if}
                </a>

                <div class="brandseo-front-product-info">
                    <h3>
                        <a href="{$product.url|escape:'html':'UTF-8'}">
                            {$product.name|escape:'html':'UTF-8'}
                        </a>
                    </h3>

                    <div class="brandseo-front-product-price">
                        {$product.price_formatted|escape:'html':'UTF-8'}
                    </div>

                    <a class="brandseo-front-product-button" href="{$product.url|escape:'html':'UTF-8'}">
                        Ver producto
                    </a>
                </div>

            </div>
        {/foreach}

    </div>

</section>
{/if}
