{extends file='page.tpl'}

{block name='page_title'}
{$landing->h1|escape:'html':'UTF-8'}
{/block}

{block name='page_content'}

<div class="brandseo-front">

    {include file='module:brandseo/views/templates/front/partials/hero.tpl'}

    <div class="brandseo-front-content">

        {include file='module:brandseo/views/templates/front/partials/history.tpl'}

        {include file='module:brandseo/views/templates/front/partials/philosophy.tpl'}

        {include file='module:brandseo/views/templates/front/partials/opinion.tpl'}

        {include file='module:brandseo/views/templates/front/partials/products.tpl'}

        {include file='module:brandseo/views/templates/front/partials/faq.tpl'}

    </div>

</div>

{/block}
