{extends file='page.tpl'}

{block name='page_title'}
{$landing->h1|escape:'html':'UTF-8'}
{/block}

{block name='head_seo'}
    {$smarty.block.parent}

    {if $brandseo_canonical}
        <link rel="canonical" href="{$brandseo_canonical|escape:'html':'UTF-8'}">
    {/if}

    <meta property="og:type" content="website">
    <meta property="og:title" content="{$brandseo_meta_title|escape:'html':'UTF-8'}">
    <meta property="og:description" content="{$brandseo_meta_description|escape:'html':'UTF-8'}">
    <meta property="og:url" content="{$brandseo_canonical|escape:'html':'UTF-8'}">

    {if $brandseo_og_image}
        <meta property="og:image" content="{$brandseo_og_image|escape:'html':'UTF-8'}">
    {/if}

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{$brandseo_meta_title|escape:'html':'UTF-8'}">
    <meta name="twitter:description" content="{$brandseo_meta_description|escape:'html':'UTF-8'}">

    {if $brandseo_og_image}
        <meta name="twitter:image" content="{$brandseo_og_image|escape:'html':'UTF-8'}">
    {/if}

    {if $brandseo_jsonld}
        <script type="application/ld+json">{$brandseo_jsonld nofilter}</script>
    {/if}

    {if $brandseo_jsonld_faq}
        <script type="application/ld+json">{$brandseo_jsonld_faq nofilter}</script>
    {/if}

    {if $brandseo_jsonld_breadcrumbs}
        <script type="application/ld+json">{$brandseo_jsonld_breadcrumbs nofilter}</script>
    {/if}
{/block}

{block name='page_content'}

<div class="brandseo-front brandseo-v2">

    {if $brandseo_preview_mode}
        <div class="brandseo-preview-banner">Vista previa · Esta landing no está publicada</div>
    {/if}

    {include file='module:brandseo/views/templates/front/partials/breadcrumb.tpl'}

    {include file='module:brandseo/views/templates/front/partials/hero.tpl'}

    <div class="brandseo-v2-container">

        {if !$landing->history && !$landing->philosophy && !$landing->store_opinion && !$brand_products|count && !$brand_faqs|count}
            {include file='module:brandseo/views/templates/front/partials/no-content.tpl'}
        {/if}

        <div class="brandseo-v2-main-grid">

            <aside class="brandseo-v2-left">
                {include file='module:brandseo/views/templates/front/partials/history.tpl'}
                {include file='module:brandseo/views/templates/front/partials/philosophy.tpl'}
            </aside>

            <main class="brandseo-v2-right">
                {include file='module:brandseo/views/templates/front/partials/products.tpl'}
            </main>

        </div>

        {include file='module:brandseo/views/templates/front/partials/opinion.tpl'}

        <div class="brandseo-v2-bottom-grid">
            {include file='module:brandseo/views/templates/front/partials/faq.tpl'}
            {include file='module:brandseo/views/templates/front/partials/related.tpl'}
        </div>

        {include file='module:brandseo/views/templates/front/partials/cta.tpl'}

    </div>

</div>

{/block}
