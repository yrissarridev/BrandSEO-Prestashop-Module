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

    <div class="brandseo-panel">
        <h3 class="brandseo-panel-title">Brands / Fabricantes</h3>

        <table class="brandseo-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Brand</th>
                    <th>Health</th>
                    <th>Productos</th>
                    <th>Estado landing</th>
                    <th>Noindex</th>
                    <th>301</th>
                    <th class="brandseo-actions">Acción</th>
                </tr>
            </thead>
            <tbody>
                {foreach from=$brands item=b}
                    <tr>
                        <td>{$b.id_manufacturer|intval}</td>
                        <td><strong>{$b.name|escape:'html':'UTF-8'}</strong></td>
                        <td>
                            <div class="brandseo-health brandseo-health-{$b.health.status|escape:'html':'UTF-8'}" title="{$b.health.label|escape:'html':'UTF-8'}">
                                <span class="brandseo-health-score">{$b.health.score|intval}%</span>
                                <span class="brandseo-health-bar">
                                    <span class="brandseo-health-bar-fill" style="width: {$b.health.score|intval}%;"></span>
                                </span>
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
                                <a class="btn btn-default"
                                   href="{$link->getAdminLink('AdminBrandSeoEdit')|escape:'html':'UTF-8'}&id_brandseo_landing={$b.id_brandseo_landing|intval}">
                                    <i class="icon-pencil"></i>
                                    Editar
                                </a>
                            {/if}
                        </td>
                    </tr>
                {/foreach}
            </tbody>
        </table>
    </div>
</div>

<style>
.brandseo-health {
    display: inline-flex !important;
    align-items: center;
    gap: 8px;
    min-width: 130px;
}
.brandseo-health-score {
    font-weight: 700;
    min-width: 42px;
    display: inline-block;
}
.brandseo-health-bar {
    width: 86px;
    height: 8px;
    background: #edf1f5;
    border-radius: 99px;
    overflow: hidden;
    display: inline-block;
}
.brandseo-health-bar-fill {
    display: block;
    height: 100%;
    border-radius: 99px;
    background: #90a4ae;
}
.brandseo-health-success .brandseo-health-bar-fill { background: #2e7d32; }
.brandseo-health-warning .brandseo-health-bar-fill { background: #f9a825; }
.brandseo-health-danger .brandseo-health-bar-fill { background: #c62828; }
.brandseo-health-empty .brandseo-health-bar-fill { background: #90a4ae; }
</style>
