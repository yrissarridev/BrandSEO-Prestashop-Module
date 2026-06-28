<section id="brandseo-hero" class="brandseo-editor-section">
    <h3 class="brandseo-editor-section-title">Hero Builder</h3>

    <p class="help-block">
        Diseña la cabecera principal de la futura landing. La subida real de imágenes se añadirá en el siguiente paso.
    </p>

    <div class="brandseo-hero-builder">
        <div class="brandseo-hero-controls">
            <div class="brandseo-dropzone">
                <strong>Hero image</strong>
                <span>Arrastra una imagen aquí o pulsa para subir</span>
            </div>

            <div class="brandseo-dropzone">
                <strong>Logo</strong>
                <span>Arrastra el logo aquí o pulsa para subir</span>
            </div>

            <div class="brandseo-hero-option-group">
                <label>Slug</label>
                <input type="text" name="slug" value="{$landing->slug|escape:'html':'UTF-8'}">
                <p class="help-block">URL futura: /brand/{$landing->slug|escape:'html':'UTF-8'}</p>
            </div>

            <div class="brandseo-hero-option-group">
                <label>Estado</label>
                <select name="status">
                    <option value="draft" {if $landing->status == 'draft'}selected{/if}>Borrador</option>
                    <option value="published" {if $landing->status == 'published'}selected{/if}>Publicada</option>
                    <option value="archived" {if $landing->status == 'archived'}selected{/if}>Archivada</option>
                </select>
            </div>

            <div class="brandseo-hero-option-group">
                <label>Altura</label>
                <div class="brandseo-hero-radio-group">
                    <label><input type="radio" name="hero_height" value="small"> Pequeña</label>
                    <label><input type="radio" name="hero_height" value="medium" checked> Media</label>
                    <label><input type="radio" name="hero_height" value="large"> Grande</label>
                </div>
            </div>

            <div class="brandseo-hero-option-group">
                <label>Alineación</label>
                <div class="brandseo-hero-radio-group">
                    <label><input type="radio" name="hero_align" value="left"> Izquierda</label>
                    <label><input type="radio" name="hero_align" value="center" checked> Centro</label>
                    <label><input type="radio" name="hero_align" value="right"> Derecha</label>
                </div>
            </div>
        </div>

        <div class="brandseo-hero-preview">
            <div class="brandseo-hero-preview-tabs">
                <button type="button" class="brandseo-hero-preview-tab" data-brandseo-hero-preview="desktop">Desktop</button>
                <button type="button" class="brandseo-hero-preview-tab" data-brandseo-hero-preview="tablet">Tablet</button>
                <button type="button" class="brandseo-hero-preview-tab" data-brandseo-hero-preview="mobile">Móvil</button>
            </div>

            <div class="brandseo-hero-preview-frame desktop" data-brandseo-hero-frame>
                <div>
                    <div class="brandseo-hero-preview-logo">LOGO</div>
                    <h2 class="brandseo-hero-preview-title">{$manufacturer->name|escape:'html':'UTF-8'}</h2>
                    <p class="brandseo-hero-preview-text">
                        Vista previa responsive del hero de la landing.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
