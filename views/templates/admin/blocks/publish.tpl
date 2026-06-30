<section id="brandseo-publish" class="brandseo-editor-footer">
    <h3 class="brandseo-editor-section-title">Publicación</h3>

    <div class="form-group">
        <label>Slug</label>
        <input type="text" id="brandseo-slug" name="slug" value="{$landing->slug|escape:'html':'UTF-8'}">
        <p class="help-block">URL futura: /marcas/{$landing->slug|escape:'html':'UTF-8'}</p>
    </div>

    <div class="form-group">
        <label>Estado</label>
        <select name="status">
            <option value="draft" {if $landing->status == 'draft'}selected{/if}>Borrador</option>
            <option value="published" {if $landing->status == 'published'}selected{/if}>Publicada</option>
            <option value="archived" {if $landing->status == 'archived'}selected{/if}>Archivada</option>
        </select>
    </div>

    <div class="form-group">
        <label>Noindex</label>
        <select name="noindex">
            <option value="1" {if $landing->noindex}selected{/if}>Sí</option>
            <option value="0" {if !$landing->noindex}selected{/if}>No</option>
        </select>
        <p class="help-block">Recomendado: Sí mientras esté en borrador.</p>
    </div>

    <div class="form-group">
        <label>301</label>
        <select name="redirect_enabled">
            <option value="0" {if !$landing->redirect_enabled}selected{/if}>Inactivo</option>
            <option value="1" {if $landing->redirect_enabled}selected{/if}>Activo</option>
        </select>
        <p class="help-block">No activar hasta tener frontend final.</p>
    </div>

    <button type="submit" name="submitBrandSeoLanding" class="btn btn-primary">
        <i class="icon-save"></i>
        Guardar landing
    </button>

    <a href="{$front_preview_url|escape:'html':'UTF-8'}" target="_blank" class="btn btn-default">
        <i class="icon-eye-open"></i>
        Vista previa
    </a>

    {if $landing->status == 'published'}
        <a href="{$front_public_url|escape:'html':'UTF-8'}" target="_blank" class="btn btn-success">
            <i class="icon-external-link"></i>
            Ver pública
        </a>
    {/if}

    <a href="{$back_url|escape:'html':'UTF-8'}" class="btn btn-default">
        Volver
    </a>
</section>
