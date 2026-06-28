<div class="brandseo-header">
    <h2 class="brandseo-header-title">Editar BrandSEO: {$manufacturer->name|escape:'html':'UTF-8'}</h2>
    <p class="brandseo-header-text">
        Completa la información de marca, SEO, contenido y publicación.
        <a href="{$back_url|escape:'html':'UTF-8'}">Volver al dashboard</a>
    </p>
</div>

<form method="post" action="{$current_url|escape:'html':'UTF-8'}">
    <div class="brandseo-editor">
        <aside class="brandseo-editor-sidebar">
            <p class="brandseo-editor-sidebar-title">BrandSEO Studio</p>

            <ul class="brandseo-editor-nav">
                {foreach from=$available_blocks item=block}
                    <li>
                        <a href="#brandseo-{$block.type|escape:'html':'UTF-8'}">
                            <i class="{$block.icon|escape:'html':'UTF-8'}"></i>
                            {$block.label|escape:'html':'UTF-8'}
                        </a>
                    </li>
                {/foreach}
            </ul>

            <div class="brandseo-editor-health">
                <p class="brandseo-editor-sidebar-title">Bloques disponibles</p>
                <ul class="brandseo-editor-health-list">
                    {foreach from=$available_blocks item=block}
                        <li>
                            <i class="{$block.icon|escape:'html':'UTF-8'}"></i>
                            {$block.label|escape:'html':'UTF-8'}
                        </li>
                    {/foreach}
                </ul>
            </div>

            <div class="brandseo-editor-health">
                <p class="brandseo-editor-health-score">{$health.score|intval}%</p>
                <p class="brandseo-editor-health-label">Brand Health · {$health.label|escape:'html':'UTF-8'}</p>

                {if $health.missing|count}
                    <strong>Pendiente</strong>
                    <ul class="brandseo-editor-health-list">
                        {foreach from=$health.missing item=item}
                            <li>{$item|escape:'html':'UTF-8'}</li>
                        {/foreach}
                    </ul>
                {/if}
            </div>
        </aside>

        <main class="brandseo-editor-main">
            {foreach from=$available_blocks item=block}
                {include file=$block.template}
            {/foreach}
        </main>
    </div>
</form>
