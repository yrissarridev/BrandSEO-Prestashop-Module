<div class="brandseo-dashboard">
    <div class="brandseo-header">
        <h2 class="brandseo-header-title">BrandSEO</h2>
        <p class="brandseo-header-text">
            Dashboard de marcas/fabricantes para crear landings SEO conectadas al catálogo.
            Las landings nuevas se crean como <strong>borrador</strong>, con <strong>noindex</strong> y sin 301.
            Versión: <strong>{$module_version|escape:'html':'UTF-8'}</strong>
        </p>
    </div>

    <div class="brandseo-cards">
        <div class="brandseo-card">
            <p class="brandseo-card-label">Brands</p>
            <p class="brandseo-card-value">{$stats.brands_total|intval}</p>
            <p class="brandseo-card-help">Marcas detectadas</p>
        </div>

        <div class="brandseo-card">
            <p class="brandseo-card-label">Sin landing</p>
            <p class="brandseo-card-value">{$stats.without_landing|intval}</p>
            <p class="brandseo-card-help">Pendientes de crear</p>
        </div>

        <div class="brandseo-card">
            <p class="brandseo-card-label">Borradores</p>
            <p class="brandseo-card-value">{$stats.draft|intval}</p>
            <p class="brandseo-card-help">Creadas pero no publicadas</p>
        </div>

        <div class="brandseo-card">
            <p class="brandseo-card-label">Publicadas</p>
            <p class="brandseo-card-value">{$stats.published|intval}</p>
            <p class="brandseo-card-help">Landings activas</p>
        </div>

        <div class="brandseo-card">
            <p class="brandseo-card-label">Health medio</p>
            <p class="brandseo-card-value">{$stats.health_average|intval}%</p>
            <p class="brandseo-card-help">Calidad media global</p>
        </div>
    </div>

    {if $insights|count}
        <div class="brandseo-panel">
            <h3 class="brandseo-panel-title">Acciones recomendadas</h3>

            <div class="brandseo-insights">
                {foreach from=$insights item=insight}
                    <div class="brandseo-insight brandseo-insight-{$insight.type|escape:'html':'UTF-8'}">
                        <p class="brandseo-insight-title">
                            <i class="{$insight.icon|escape:'html':'UTF-8'}"></i>
                            {$insight.title|escape:'html':'UTF-8'}
                        </p>
                        <p class="brandseo-insight-description">
                            {$insight.description|escape:'html':'UTF-8'}
                        </p>
                        <span class="brandseo-insight-action">
                            {$insight.action_label|escape:'html':'UTF-8'} →
                        </span>
                    </div>
                {/foreach}
            </div>
        </div>
    {/if}

    <div class="brandseo-panel">
        <h3 class="brandseo-panel-title">Brands / Fabricantes</h3>

        <div class="brandseo-toolbar">
            <div class="brandseo-search">
                <input type="text" data-brandseo-search placeholder="Buscar marca..." class="form-control">
            </div>

            <button type="button" class="brandseo-filter active" data-brandseo-filter="all">Todas</button>
            <button type="button" class="brandseo-filter" data-brandseo-filter="without_landing">Sin landing</button>
            <button type="button" class="brandseo-filter" data-brandseo-filter="draft">Borradores</button>
            <button type="button" class="brandseo-filter" data-brandseo-filter="published">Publicadas</button>
        </div>

        <table class="brandseo-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Brand</th>
                    <th>Health</th>
                    <th>Prioridad</th>
                    <th>Productos</th>
                    <th>Estado landing</th>
                    <th>Noindex</th>
                    <th>301</th>
                    <th class="brandseo-actions brandseo-actions-head">Acción</th>
                </tr>
            </thead>
            <tbody>
                {foreach from=$brands item=b}
                    {assign var=row_status value='without_landing'}
                    {if $b.id_brandseo_landing}
                        {if $b.status == 'published'}
                            {assign var=row_status value='published'}
                        {else}
                            {assign var=row_status value='draft'}
                        {/if}
                    {/if}

                    <tr data-brandseo-row data-brand-name="{$b.name|escape:'html':'UTF-8'}" data-brand-status="{$row_status|escape:'html':'UTF-8'}">
                        <td>{$b.id_manufacturer|intval}</td>

                        <td>
                            <strong>{$b.name|escape:'html':'UTF-8'}</strong>
                        </td>

                        <td>
                            <div class="brandseo-health brandseo-health-{$b.health.status|escape:'html':'UTF-8'}" title="{$b.health.label|escape:'html':'UTF-8'}">
                                <span class="brandseo-health-score">{$b.health.score|intval}%</span>
                                <span class="brandseo-health-bar">
                                    <span class="brandseo-health-bar-fill" style="width: {$b.health.score|intval}%;"></span>
                                </span>
                            </div>
                        </td>

                        <td>
                            <div class="brandseo-priority brandseo-priority-{$b.priority.status|escape:'html':'UTF-8'}" title="{$b.priority.score|intval}">
                                <span class="brandseo-priority-dot"></span>
                                <span>{$b.priority.label|escape:'html':'UTF-8'}</span>
                            </div>
                        </td>

                        <td>{$b.total_products|intval}</td>

                        <td>
                            {if $b.id_brandseo_landing}
                                {if $b.status == 'published'}
                                    <span class="label label-success">Publicada</span>
                                {else}
                                    <span class="label label-warning">Borrador</span>
                                {/if}
                            {else}
                                <span class="label label-danger">Sin landing</span>
                            {/if}
                        </td>

                        <td>
                            {if $b.id_brandseo_landing}
                                {if $b.noindex}
                                    <span class="label label-warning">Sí</span>
                                {else}
                                    <span class="label label-success">No</span>
                                {/if}
                            {else}
                                —
                            {/if}
                        </td>

                        <td>
                            {if $b.id_brandseo_landing}
                                {if $b.redirect_enabled}
                                    <span class="label label-success">Activo</span>
                                {else}
                                    <span class="label label-default">Inactivo</span>
                                {/if}
                            {else}
                                —
                            {/if}
                        </td>

                        <td class="brandseo-actions">
                            {if !$b.id_brandseo_landing}
                                <a class="btn btn-default"
                                   href="{$current_url|escape:'html':'UTF-8'}&generateLanding=1&id_manufacturer={$b.id_manufacturer|intval}">
                                    <i class="icon-plus"></i>
                                    Generar landing
                                </a>
                            {else}
                                <a class="btn btn-default brandseo-action-complete"
                                   href="{$link->getAdminLink('AdminBrandSeoEdit')|escape:'html':'UTF-8'}&id_brandseo_landing={$b.id_brandseo_landing|intval}">
                                    <i class="icon-pencil"></i>
                                    {if $b.health.score >= 85}
                                        Gestionar
                                    {else}
                                        Completar
                                    {/if}
                                </a>
                            {/if}
                        </td>
                    </tr>
                {/foreach}
            </tbody>
        </table>
    </div>
</div>
