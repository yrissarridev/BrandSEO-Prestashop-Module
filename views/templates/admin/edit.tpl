<div class="brandseo-header">
    <h2 class="brandseo-header-title">Editar BrandSEO: {$manufacturer->name|escape:'html':'UTF-8'}</h2>
    <p class="brandseo-header-text">
        Completa la información de marca, SEO, contenido y publicación.
        <a href="{$back_url|escape:'html':'UTF-8'}">Volver al dashboard</a>
    </p>
</div>

<form method="post" action="{$current_url|escape:'html':'UTF-8'}" enctype="multipart/form-data">
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

                {if $health.checklist|count}
                    <div class="brandseo-completion-panel">
                        <h4>Checklist</h4>

                        <ul>
                            {foreach from=$health.checklist item=item}
                                <li class="brandseo-check-{$item.status|escape:'html':'UTF-8'}">
                                    <span>{$item.icon|escape:'html':'UTF-8'}</span>
                                    {$item.label|escape:'html':'UTF-8'}
                                </li>
                            {/foreach}
                        </ul>
                    </div>
                {/if}

                
<div class="brandseo-completion-panel">

    <h4>Checklist</h4>

    <ul>

        {foreach from=$health.checklist item=item}

            <li class="brandseo-check-{$item.status|escape:'html':'UTF-8'}">

                {$item.icon|escape:'html':'UTF-8'} {$item.label|escape:'html':'UTF-8'}

            </li>

        {/foreach}

    </ul>

</div>

{if $health.groups}
                    <div class="brandseo-health-groups">
                        {foreach from=$health.groups key=group item=value}
                            <div class="brandseo-health-group">
                                <span>{$group|escape:'html':'UTF-8'}</span>
                                <strong>{$value|intval}%</strong>
                            </div>
                        {/foreach}
                    </div>
                {/if}

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
