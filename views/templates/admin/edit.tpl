<div class="panel">
    <h3>
        <i class="icon-pencil"></i>
        Editar BrandSEO: {$manufacturer->name|escape:'html':'UTF-8'}
    </h3>

    <p>
        <a href="{$back_url|escape:'html':'UTF-8'}" class="btn btn-default">
            <i class="icon-arrow-left"></i>
            Volver al dashboard
        </a>
    </p>
</div>

<form method="post" action="{$current_url|escape:'html':'UTF-8'}" class="form-horizontal">
    <div class="panel">
        <h3>General</h3>

        <div class="form-group">
            <label class="control-label col-lg-3">Slug</label>
            <div class="col-lg-6">
                <input type="text" name="slug" value="{$landing->slug|escape:'html':'UTF-8'}">
                <p class="help-block">URL futura: /brand/{$landing->slug|escape:'html':'UTF-8'}</p>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-lg-3">Estado</label>
            <div class="col-lg-3">
                <select name="status">
                    <option value="draft" {if $landing->status == 'draft'}selected{/if}>Borrador</option>
                    <option value="published" {if $landing->status == 'published'}selected{/if}>Publicada</option>
                    <option value="archived" {if $landing->status == 'archived'}selected{/if}>Archivada</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-lg-3">Noindex</label>
            <div class="col-lg-3">
                <select name="noindex">
                    <option value="1" {if $landing->noindex}selected{/if}>Sí</option>
                    <option value="0" {if !$landing->noindex}selected{/if}>No</option>
                </select>
                <p class="help-block">Recomendado: Sí mientras esté en borrador.</p>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-lg-3">301</label>
            <div class="col-lg-3">
                <select name="redirect_enabled">
                    <option value="0" {if !$landing->redirect_enabled}selected{/if}>Inactivo</option>
                    <option value="1" {if $landing->redirect_enabled}selected{/if}>Activo</option>
                </select>
                <p class="help-block">No activar hasta tener frontend final.</p>
            </div>
        </div>
    </div>

    <div class="panel">
        <h3>Contacto y redes</h3>

        <div class="form-group">
            <label class="control-label col-lg-3">Web</label>
            <div class="col-lg-6">
                <input type="text" name="website" value="{$landing->website|escape:'html':'UTF-8'}">
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-lg-3">Instagram</label>
            <div class="col-lg-6">
                <input type="text" name="instagram" value="{$landing->instagram|escape:'html':'UTF-8'}">
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-lg-3">Facebook</label>
            <div class="col-lg-6">
                <input type="text" name="facebook" value="{$landing->facebook|escape:'html':'UTF-8'}">
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-lg-3">YouTube</label>
            <div class="col-lg-6">
                <input type="text" name="youtube" value="{$landing->youtube|escape:'html':'UTF-8'}">
            </div>
        </div>
    </div>

    <div class="panel">
        <h3>Ubicación</h3>

        <div class="form-group">
            <label class="control-label col-lg-3">País</label>
            <div class="col-lg-4">
                <input type="text" name="country" value="{$landing->country|escape:'html':'UTF-8'}">
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-lg-3">Región</label>
            <div class="col-lg-4">
                <input type="text" name="region" value="{$landing->region|escape:'html':'UTF-8'}">
            </div>
        </div>
    </div>

    {foreach from=$languages item=lang}
        {assign var=id_lang value=$lang.id_lang}
        <div class="panel">
            <h3>Contenido · {$lang.name|escape:'html':'UTF-8'}</h3>

            <div class="form-group">
                <label class="control-label col-lg-3">Título</label>
                <div class="col-lg-7">
                    <input type="text" name="title_{$id_lang|intval}" value="{$landing->title[$id_lang]|escape:'html':'UTF-8'}">
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-lg-3">H1</label>
                <div class="col-lg-7">
                    <input type="text" name="h1_{$id_lang|intval}" value="{$landing->h1[$id_lang]|escape:'html':'UTF-8'}">
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-lg-3">Meta title</label>
                <div class="col-lg-7">
                    <input type="text" name="meta_title_{$id_lang|intval}" value="{$landing->meta_title[$id_lang]|escape:'html':'UTF-8'}">
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-lg-3">Meta description</label>
                <div class="col-lg-7">
                    <textarea name="meta_description_{$id_lang|intval}" rows="2">{$landing->meta_description[$id_lang]|escape:'html':'UTF-8'}</textarea>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-lg-3">Resumen</label>
                <div class="col-lg-7">
                    <textarea name="excerpt_{$id_lang|intval}" rows="3">{$landing->excerpt[$id_lang]|escape:'html':'UTF-8'}</textarea>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-lg-3">Historia</label>
                <div class="col-lg-7">
                    <textarea name="history_{$id_lang|intval}" rows="7">{$landing->history[$id_lang]|escape:'html':'UTF-8'}</textarea>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-lg-3">Filosofía</label>
                <div class="col-lg-7">
                    <textarea name="philosophy_{$id_lang|intval}" rows="5">{$landing->philosophy[$id_lang]|escape:'html':'UTF-8'}</textarea>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-lg-3">Opinión de la tienda</label>
                <div class="col-lg-7">
                    <textarea name="store_opinion_{$id_lang|intval}" rows="5">{$landing->store_opinion[$id_lang]|escape:'html':'UTF-8'}</textarea>
                </div>
            </div>
        </div>
    {/foreach}

    <div class="panel">
        <button type="submit" name="submitBrandSeoLanding" class="btn btn-primary">
            <i class="icon-save"></i>
            Guardar landing
        </button>
    </div>
</form>
