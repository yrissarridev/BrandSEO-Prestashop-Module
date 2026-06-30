{assign var=hero_height value=$hero_settings.height|default:'medium'}
{assign var=hero_align  value=$hero_settings.align|default:'center'}
{assign var=hero_overlay value=$hero_settings.overlay|default:48}

<section class="brandseo-front-hero brandseo-front-hero--{$hero_height|escape:'html':'UTF-8'} brandseo-front-hero--{$hero_align|escape:'html':'UTF-8'}"{if $hero_image} style="background-image:url('{$hero_image|escape:'html':'UTF-8'}');"{/if}>

    <div class="brandseo-front-hero-overlay" style="opacity:{math equation='x/100' x=$hero_overlay};"></div>

    <div class="brandseo-front-hero-inner">

        {if $hero_logo}
            <img
                class="brandseo-front-logo"
                src="{$hero_logo|escape:'html':'UTF-8'}"
                alt="{$manufacturer->name|escape:'html':'UTF-8'}">
        {/if}

        <h1>{$landing->h1|escape:'html':'UTF-8'}</h1>

        {if $landing->excerpt}
            <p class="brandseo-front-hero-text">
                {$landing->excerpt|escape:'html':'UTF-8'}
            </p>
        {/if}

        {if $landing->region}
        <div class="brandseo-front-hero-stats">

            <div class="brandseo-front-hero-stat">
                <strong>{$landing->region|escape:'html':'UTF-8'}</strong>
                <span>Región</span>
            </div>

        </div>
        {/if}

        <a class="brandseo-front-hero-button" href="#brand-products">
            Descubrir vinos
        </a>

    </div>

</section>
