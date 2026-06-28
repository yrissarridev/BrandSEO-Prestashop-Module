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
                <li><a href="#brandseo-general">General</a></li>
                <li><a href="#brandseo-contact">Contacto y redes</a></li>
                <li><a href="#brandseo-location">Ubicación</a></li>
                <li><a href="#brandseo-content">Contenido</a></li>
                <li><a href="#brandseo-publish">Publicación</a></li>
            </ul>

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
            <section id="brandseo-general" class="brandseo-editor-section">
                <h3 class="brandseo-editor-section-title">General</h3>

                <div class="form-group">
                    <label>Slug</label>
                    <input type="text" name="slug" value="{$landing->slug|escape:'html':'UTF-8'}">
                    <p class="help-block">URL futura: /brand/{$landing->slug|escape:'html':'UTF-8'}</p>
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
            </section>

            <section id="brandseo-contact" class="brandseo-editor-section">
                <h3 class="brandseo-editor-section-title">Contacto y redes</h3>

                <div class="form-group">
                    <label>Web</label>
                    <input type="text" name="website" value="{$landing->website|escape:'html':'UTF-8'}">
                </div>

                <div class="form-group">
                    <label>Instagram</label>
                    <input type="text" name="instagram" value="{$landing->instagram|escape:'html':'UTF-8'}">
                </div>

                <div class="form-group">
                    <label>Facebook</label>
                    <input type="text" name="facebook" value="{$landing->facebook|escape:'html':'UTF-8'}">
                </div>

                <div class="form-group">
                    <label>YouTube</label>
                    <input type="text" name="youtube" value="{$landing->youtube|escape:'html':'UTF-8'}">
                </div>
            </section>

            <section id="brandseo-location" class="brandseo-editor-section">
                <h3 class="brandseo-editor-section-title">Ubicación</h3>

                <div class="form-group">
                    <label>País</label>
                    <input type="text" name="country" value="{$landing->country|escape:'html':'UTF-8'}">
                </div>

                <div class="form-group">
                    <label>Región</label>
                    <input type="text" name="region" value="{$landing->region|escape:'html':'UTF-8'}">
                </div>
            </section>

            <section id="brandseo-content" class="brandseo-editor-section">
                <h3 class="brandseo-editor-section-title">Contenido</h3>

                {foreach from=$languages item=lang}
                    {assign var=id_lang value=$lang.id_lang}

                    <div class="brandseo-editor-section" style="box-shadow:none;">
                        <h4>Contenido · {$lang.name|escape:'html':'UTF-8'}</h4>

                        <div class="form-group">
                            <label>Título</label>
                            <input type="text" name="title_{$id_lang|intval}" value="{$landing->title[$id_lang]|escape:'html':'UTF-8'}">
                        </div>

                        <div class="form-group">
                            <label>H1</label>
                            <input type="text" name="h1_{$id_lang|intval}" value="{$landing->h1[$id_lang]|escape:'html':'UTF-8'}">
                        </div>

                        <div class="form-group">
                            <label>Meta title</label>
                            <input type="text" name="meta_title_{$id_lang|intval}" value="{$landing->meta_title[$id_lang]|escape:'html':'UTF-8'}">
                        </div>

                        <div class="form-group">
                            <label>Meta description</label>
                            <textarea name="meta_description_{$id_lang|intval}" rows="2">{$landing->meta_description[$id_lang]|escape:'html':'UTF-8'}</textarea>
                        </div>

                        <div class="form-group">
                            <label>Resumen</label>
                            <textarea name="excerpt_{$id_lang|intval}" rows="3">{$landing->excerpt[$id_lang]|escape:'html':'UTF-8'}</textarea>
                        </div>

                        <div class="form-group">
                            <label>Historia</label>
                            <textarea name="history_{$id_lang|intval}" rows="7">{$landing->history[$id_lang]|escape:'html':'UTF-8'}</textarea>
                        </div>

                        <div class="form-group">
                            <label>Filosofía</label>
                            <textarea name="philosophy_{$id_lang|intval}" rows="5">{$landing->philosophy[$id_lang]|escape:'html':'UTF-8'}</textarea>
                        </div>

                        <div class="form-group">
                            <label>Opinión de la tienda</label>
                            <textarea name="store_opinion_{$id_lang|intval}" rows="5">{$landing->store_opinion[$id_lang]|escape:'html':'UTF-8'}</textarea>
                        </div>
                    </div>
                {/foreach}
            </section>

            <section id="brandseo-publish" class="brandseo-editor-footer">
                <button type="submit" name="submitBrandSeoLanding" class="btn btn-primary">
                    <i class="icon-save"></i>
                    Guardar landing
                </button>

                <a href="{$back_url|escape:'html':'UTF-8'}" class="btn btn-default">
                    Volver
                </a>
            </section>
        </main>
    </div>
</form>
