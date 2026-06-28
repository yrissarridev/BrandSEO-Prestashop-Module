<?php

require_once _PS_MODULE_DIR_.'brandseo/classes/Block/BrandSeoBlock.php';

class BrandSeoBlockRegistry
{
    public function getAvailableBlocks()
    {
        return array(
            $this->createBlock('hero', 'Hero', 'Cabecera visual de la landing con imagen, logo, título y resumen.', 'icon-picture'),
            $this->createBlock('content', 'Contenido', 'Historia, filosofía y opinión editorial de la tienda.', 'icon-align-left'),
            $this->createBlock('media', 'Media', 'Logo, imagen hero, galería y vídeos.', 'icon-camera'),
            $this->createBlock('products', 'Productos', 'Productos asociados automáticamente a la marca.', 'icon-shopping-cart'),
            $this->createBlock('faq', 'FAQ', 'Preguntas frecuentes con potencial de rich snippets.', 'icon-question'),
            $this->createBlock('map', 'Mapa', 'Ubicación, coordenadas y enlaces de navegación.', 'icon-map-marker'),
            $this->createBlock('seo', 'SEO', 'Metadatos, robots, schema y vista previa SEO.', 'icon-search'),
            $this->createBlock('publish', 'Publicación', 'Estado, noindex y redirección 301.', 'icon-check'),
        );
    }

    private function createBlock($type, $label, $description, $icon)
    {
        $block = new BrandSeoBlock($type, $label, $description, $icon);

        $data = $block->toArray();
        $data['template'] = './blocks/'.$type.'.tpl';

        return $data;
    }
}
