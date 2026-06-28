<section class="brandseo-front-hero"
{if $hero_image}
style="background-image:linear-gradient(rgba(38,50,56,.55),rgba(38,50,56,.55)),url('{$hero_image|escape:'html':'UTF-8'}');"
{/if}>

    <div class="brandseo-front-hero-inner">

        {if $hero_logo}
            <img
                class="brandseo-front-logo"
                src="{$hero_logo|escape:'html':'UTF-8'}"
                alt="{$manufacturer->name|escape:'html':'UTF-8'}">
        {/if}

        <h1>{$landing->h1|escape:'html':'UTF-8'}</h1>

        {if $landing->excerpt}
            <p>{$landing->excerpt|escape:'html':'UTF-8'}</p>
        {/if}

    </div>

</section>
