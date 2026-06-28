{if $landing->store_opinion}
<section class="brandseo-front-section brandseo-front-opinion-section">

    <div class="brandseo-front-opinion-card">

        <div class="brandseo-front-opinion-label">
            Opinión Vinófilos
        </div>

        <blockquote>

            {$landing->store_opinion nofilter}

        </blockquote>

    </div>

</section>
{/if}
