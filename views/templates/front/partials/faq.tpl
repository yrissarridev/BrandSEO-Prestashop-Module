{if $brand_faqs|count}
<section class="brandseo-front-section brandseo-front-faq-section">

    <div class="brandseo-front-section-header">
        <h2>Preguntas frecuentes</h2>
    </div>

    <div class="brandseo-front-faq-list">

        {foreach from=$brand_faqs item=faq}
            <details class="brandseo-front-faq-item">
                <summary>{$faq.question|escape:'html':'UTF-8'}</summary>
                <div class="brandseo-front-faq-answer">
                    {$faq.answer nofilter}
                </div>
            </details>
        {/foreach}

    </div>

</section>
{/if}
