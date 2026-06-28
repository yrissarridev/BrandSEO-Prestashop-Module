<div class="panel">
    <div class="panel-heading">
        <i class="icon-wrench"></i>
        BrandSEO · Mantenimiento
    </div>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Check</th>
                    <th>Estado</th>
                    <th>Detalle</th>
                </tr>
            </thead>
            <tbody>
                {foreach from=$checks item=check}
                    <tr>
                        <td>{$check.label|escape:'html':'UTF-8'}</td>
                        <td>
                            {if $check.status == 'ok'}
                                <span class="badge badge-success">OK</span>
                            {else}
                                <span class="badge badge-danger">ERROR</span>
                            {/if}
                        </td>
                        <td>{$check.message|escape:'html':'UTF-8'}</td>
                    </tr>
                {/foreach}
            </tbody>
        </table>
    </div>

    <a href="{$back_url|escape:'html':'UTF-8'}" class="btn btn-default">
        Volver
    </a>
</div>
