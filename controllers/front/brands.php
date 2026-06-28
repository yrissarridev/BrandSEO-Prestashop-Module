<?php

class BrandseoBrandsModuleFrontController extends ModuleFrontController
{
    public function setMedia()
    {
        parent::setMedia();

        $this->registerStylesheet(
            'module-brandseo-landing',
            'modules/'.$this->module->name.'/views/css/front/landing.css',
            array('media' => 'all', 'priority' => 150)
        );
    }

    public function initContent()
    {
        parent::initContent();

        $base = $this->context->link->getBaseLink();

        $brands = Db::getInstance()->executeS('
            SELECT 
                m.name,
                l.slug,
                ll.excerpt,
                COUNT(DISTINCT p.id_product) AS total_products
            FROM `'._DB_PREFIX_.'brandseo_landing` l
            INNER JOIN `'._DB_PREFIX_.'manufacturer` m
                ON m.id_manufacturer = l.id_manufacturer
            LEFT JOIN `'._DB_PREFIX_.'brandseo_landing_lang` ll
                ON ll.id_brandseo_landing = l.id_brandseo_landing
                AND ll.id_lang = '.(int) $this->context->language->id.'
            LEFT JOIN `'._DB_PREFIX_.'product` p
                ON p.id_manufacturer = m.id_manufacturer
                AND p.active = 1
            WHERE l.status = "published"
            AND l.active = 1
            AND l.noindex = 0
            GROUP BY l.id_brandseo_landing
            ORDER BY m.name ASC
        ');

        foreach ($brands as &$brand) {
            $brand['url'] = $base.'marcas/'.$brand['slug'];
        }

        unset($brand);

        $this->context->smarty->assign(array(
            'brandseo_brands' => $brands,
        ));

        $this->setTemplate('module:brandseo/views/templates/front/brands.tpl');
    }

    public function getTemplateVarPage()
    {
        $page = parent::getTemplateVarPage();

        $page['meta']['title'] = 'Marcas | Vinófilos';
        $page['meta']['description'] = 'Descubre las marcas y bodegas disponibles en Vinófilos.';
        $page['canonical'] = $this->context->link->getBaseLink().'marcas';

        return $page;
    }
}
