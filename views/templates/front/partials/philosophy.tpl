{if $landing->philosophy}
<section class="brandseo-side-card">
    <h2>Filosofía</h2>
    <div>
        {$landing->philosophy nofilter}
    </div>
</section>
{/if}

{if $landing->website || $landing->instagram || $landing->facebook || $landing->youtube}
<section class="brandseo-side-card brandseo-side-social">
    <h2>Encuéntranos en</h2>
    <div class="brandseo-social-links">
        {if $landing->website}
            <a href="{$landing->website|escape:'html':'UTF-8'}" target="_blank" rel="noopener noreferrer" class="brandseo-social-link">
                <i class="fa fa-globe"></i>
                <span>Web oficial</span>
            </a>
        {/if}
        {if $landing->instagram}
            <a href="{$landing->instagram|escape:'html':'UTF-8'}" target="_blank" rel="noopener noreferrer" class="brandseo-social-link">
                <i class="fa fa-instagram"></i>
                <span>Instagram</span>
            </a>
        {/if}
        {if $landing->facebook}
            <a href="{$landing->facebook|escape:'html':'UTF-8'}" target="_blank" rel="noopener noreferrer" class="brandseo-social-link">
                <i class="fa fa-facebook"></i>
                <span>Facebook</span>
            </a>
        {/if}
        {if $landing->youtube}
            <a href="{$landing->youtube|escape:'html':'UTF-8'}" target="_blank" rel="noopener noreferrer" class="brandseo-social-link">
                <i class="fa fa-youtube-play"></i>
                <span>YouTube</span>
            </a>
        {/if}
    </div>
</section>
{/if}
