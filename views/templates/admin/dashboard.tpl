<div class="panel">
    <h3>
        <i class="icon-star"></i>
        BrandSEO
    </h3>

    <p>
        Dashboard de marcas/fabricantes para crear landings SEO conectadas al catálogo.
        Las landings nuevas se crean como <strong>borrador</strong>, con <strong>noindex</strong> y sin 301.
    </p>

    <p>
        Versión: <strong>{$module_version|escape:'html':'UTF-8'}</strong>
    </p>
</div>

<div class="row">
    <div class="col-lg-3">
        <div class="panel">
            <h3>Brands</h3>
            <p style="font-size:28px;font-weight:bold;margin:0;">{$stats.brands_total|intval}</p>
            <p class="help-block">Marcas detectadas</p>
        </div>
    </div>

    <div class="col-lg-3">
        <div class="panel">
            <h3>Sin landing</h3>
            <p style="font-size:28px;font-weight:bold;margin:0;">{$stats.without_landing|intval}</p>
            <p class="help-block">Pendientes de crear</p>
        </div>
    </div>

    <div class="col-lg-3">
        <div class="panel">
            <h3>Borradores</h3>
            <p style="font-size:28px;font-weight:bold;margin:0;">{$stats.draft|intval}</p>
            <p class="help-block">Creadas pero no publicadas</p>
        </div>
    </div>

    <div class="col-lg-3">
        <div class="panel">
            <h3>Publicadas</h3>
            <p style="font-size:28px;font-weight:bold;margin:0;">{$stats.published|intval}</p>
            <p class="help-block">Landings activas</p>
        </div>
    </div>
</div>

<div class="panel">
    <h3>Brands / Fabricantes</h3>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Brand</th>
                <th>Productos</th>
                <th>Estado landing</th>
                <th>Noindex</th>
                <th>301</th>
                <th class="text-right">Acción</th>
            </tr>
        </thead>
        <tbody>
            {foreach from=$brands item=b}
                <tr>
                    <td>{$b.id_manufacturer|intval}</td>
                    <td><strong>{$b.name|escape:'html':'UTF-8'}</strong></td>
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

                    <td class="text-right">
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
