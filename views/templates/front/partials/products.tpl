{if $brand_products|count}
<section id="brand-products" class="brandseo-front-section brandseo-products-v2">

    <div class="brandseo-products-v2-header">
        <h2>Vinos de {$manufacturer->name|escape:'html':'UTF-8'}</h2>
        <a href="#brand-products">Ver todos los vinos</a>
    </div>

    <div class="brandseo-products-v2-grid">
        {foreach from=$brand_products item=product}
            <article class="brandseo-product-v2-card">

                <a class="brandseo-product-v2-image" href="{$product.url|escape:'html':'UTF-8'}">
                    {if $product.image_url}
                        <img src="{$product.image_url|escape:'html':'UTF-8'}" alt="{$product.name|escape:'html':'UTF-8'}" loading="lazy">
                    {else}
                        <span>Sin imagen</span>
                    {/if}
                </a>

                <div class="brandseo-product-v2-body">
                    <h3>
                        <a href="{$product.url|escape:'html':'UTF-8'}">
                            {$product.name|escape:'html':'UTF-8'}
                        </a>
                    </h3>

                    <div class="brandseo-product-v2-price">
                        {$product.price_formatted|escape:'html':'UTF-8'}
                    </div>

                    <div class="brandseo-product-v2-actions">
                        <a class="brandseo-product-v2-cart" href="{$product.add_to_cart_url|escape:'html':'UTF-8'}">
                            Añadir al carrito
                        </a>

                        <a class="brandseo-product-v2-more" href="{$product.url|escape:'html':'UTF-8'}">
                            ♥
                        </a>
                    </div>
                </div>

            </article>
        {/foreach}
    </div>

</section>
{/if}
