<section id="brandseo-faq" class="brandseo-editor-section">
    <h3 class="brandseo-editor-section-title">FAQ</h3>

    <p class="help-block">
        Preguntas frecuentes para mejorar la experiencia del usuario y preparar Schema FAQ.
    </p>

    <div class="brandseo-faq-list">
        {if $faqs|count}
            {foreach from=$faqs item=faq}
                <div class="brandseo-faq-item">
                    <strong>{$faq.question|escape:'html':'UTF-8'}</strong>
                    <p>{$faq.answer|escape:'html':'UTF-8'}</p>
                </div>
            {/foreach}
        {else}
            <div class="brandseo-faq-empty">
                <strong>Sin preguntas frecuentes todavía.</strong>
                <p>Añade preguntas frecuentes para mejorar la landing y preparar rich snippets.</p>
            </div>
        {/if}
    </div>

    <button type="button" class="btn btn-default disabled">
        <i class="icon-plus"></i>
        Añadir pregunta
    </button>
</section>
