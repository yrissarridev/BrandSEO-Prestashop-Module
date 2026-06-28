{extends file='page.tpl'}

{block name='page_title'}
    {$landing->h1|escape:'html':'UTF-8'}
{/block}

{block name='page_content'}
    <div class="brandseo-front">
        <section class="brandseo-front-hero" {if $hero_image}style="background-image: linear-gradient(rgba(38,50,56,.55), rgba(38,50,56,.55)), url('{$hero_image|escape:'html':'UTF-8'}');"{/if}>
            <div class="brandseo-front-hero-inner">
                {if $hero_logo}
                    <img class="brandseo-front-logo" src="{$hero_logo|escape:'html':'UTF-8'}" alt="{$manufacturer->name|escape:'html':'UTF-8'}">
                {/if}

                <h1>{$landing->h1|escape:'html':'UTF-8'}</h1>

                {if $landing->excerpt}
                    <p>{$landing->excerpt|escape:'html':'UTF-8'}</p>
                {/if}
            </div>
        </section>

        <div class="brandseo-front-content">
            {if $landing->history}
                <section class="brandseo-front-section">
                    <h2>Historia</h2>
                    <div>{$landing->history nofilter}</div>
                </section>
            {/if}

            {if $landing->philosophy}
                <section class="brandseo-front-section">
                    <h2>Filosofía</h2>
                    <div>{$landing->philosophy nofilter}</div>
                </section>
            {/if}

            {if $landing->store_opinion}
                <section class="brandseo-front-section brandseo-front-opinion">
                    <h2>Opinión de la tienda</h2>
                    <div>{$landing->store_opinion nofilter}</div>
                </section>
            {/if}
        </div>
    </div>
{/block}
