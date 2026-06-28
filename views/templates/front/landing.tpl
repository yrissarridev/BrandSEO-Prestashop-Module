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

    <style>
        .brandseo-front-hero {
            min-height: 420px;
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: #fff;
            border-radius: 12px;
            overflow: hidden;
            margin-bottom: 32px;
            padding: 40px 24px;
        }

        .brandseo-front-hero-inner {
            max-width: 860px;
        }

        .brandseo-front-logo {
            max-width: 180px;
            max-height: 90px;
            object-fit: contain;
            margin-bottom: 20px;
            filter: drop-shadow(0 2px 8px rgba(0,0,0,.35));
        }

        .brandseo-front-hero h1 {
            color: #fff;
            font-size: 42px;
            line-height: 1.15;
            margin: 0 0 14px;
        }

        .brandseo-front-hero p {
            font-size: 18px;
            line-height: 1.55;
            margin: 0 auto;
            max-width: 760px;
        }

        .brandseo-front-content {
            max-width: 920px;
            margin: 0 auto;
        }

        .brandseo-front-section {
            margin-bottom: 34px;
            font-size: 16px;
            line-height: 1.7;
        }

        .brandseo-front-section h2 {
            font-size: 28px;
            margin-bottom: 14px;
        }

        .brandseo-front-opinion {
            background: #f7f7f7;
            border-radius: 12px;
            padding: 24px;
        }

        @media (max-width: 768px) {
            .brandseo-front-hero {
                min-height: 360px;
            }

            .brandseo-front-hero h1 {
                font-size: 30px;
            }

            .brandseo-front-hero p {
                font-size: 16px;
            }
        }
    </style>
{/block}
