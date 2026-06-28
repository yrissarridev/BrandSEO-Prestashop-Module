<?php

require_once _PS_MODULE_DIR_.'brandseo/classes/Block/BrandSeoBlock.php';

class BrandSeoBlockRegistry
{
    public function getAvailableBlocks()
    {
        return array(
            (new BrandSeoBlock(
                'hero',
                'Hero',
                'Cabecera visual de la landing con imagen, logo, título y resumen.',
                'icon-picture'
            ))->toArray(),

            (new BrandSeoBlock(
                'content',
                'Contenido',
                'Historia, filosofía y opinión editorial de la tienda.',
                'icon-align-left'
            ))->toArray(),

            (new BrandSeoBlock(
                'media',
                'Media',
                'Logo, imagen hero, galería y vídeos.',
                'icon-camera'
            ))->toArray(),

            (new BrandSeoBlock(
                'products',
                'Productos',
                'Productos asociados automáticamente a la marca.',
                'icon-shopping-cart'
            ))->toArray(),

            (new BrandSeoBlock(
                'faq',
                'FAQ',
                'Preguntas frecuentes con potencial de rich snippets.',
                'icon-question'
            ))->toArray(),

            (new BrandSeoBlock(
                'map',
                'Mapa',
                'Ubicación, coordenadas y enlaces de navegación.',
                'icon-map-marker'
            ))->toArray(),

            (new BrandSeoBlock(
                'seo',
                'SEO',
                'Metadatos, robots, schema y vista previa SEO.',
                'icon-search'
            ))->toArray(),

            (new BrandSeoBlock(
                'publish',
                'Publicación',
                'Estado, noindex y redirección 301.',
                'icon-check'
            ))->toArray(),
        );
    }
}
