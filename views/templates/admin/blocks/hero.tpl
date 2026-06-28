<section id="brandseo-hero" class="brandseo-editor-section">
    <h3 class="brandseo-editor-section-title">Hero / General</h3>

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
</section>
