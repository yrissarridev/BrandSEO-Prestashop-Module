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
                            <span class="btn btn-default disabled">
                                Landing creada
                            </span>
                        {/if}
                    </td>
                </tr>
            {/foreach}
        </tbody>
    </table>
</div>
