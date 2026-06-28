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
