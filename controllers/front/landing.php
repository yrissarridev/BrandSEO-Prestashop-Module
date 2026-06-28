<?php

require_once _PS_MODULE_DIR_.'brandseo/classes/BrandSeoLanding.php';
require_once _PS_MODULE_DIR_.'brandseo/services/BrandSeoMediaService.php';

class BrandseoLandingModuleFrontController extends ModuleFrontController
{
    public function initContent()
    {
        parent::initContent();

        $slug = pSQL(Tools::getValue('slug'));
        $idLang = (int) $this->context->language->id;

        $idLanding = (int) Db::getInstance()->getValue('
            SELECT id_brandseo_landing
            FROM `'._DB_PREFIX_.'brandseo_landing`
            WHERE slug = "'.$slug.'"
            AND status = "published"
            AND active = 1
        ');

        if (!$idLanding) {
            Tools::redirect('404');
        }

        $landing = new BrandSeoLanding($idLanding, $idLang);

        if (!Validate::isLoadedObject($landing)) {
            Tools::redirect('404');
        }

        $manufacturer = new Manufacturer((int) $landing->id_manufacturer, $idLang);

        $mediaService = new BrandSeoMediaService();
        $heroMedia = $mediaService->getMediaForBlock((int) $landing->id, 'hero', $idLang);

        $heroImage = '';
        $heroLogo = '';

        foreach ($heroMedia as $media) {
            if ($media['type'] === 'logo' && !$heroLogo) {
                $heroLogo = $this->module->getPathUri().$media['path'];
            }

            if ($media['type'] === 'image' && !$heroImage) {
                $heroImage = $this->module->getPathUri().$media['path'];
            }
        }

        $canonical = $this->context->link->getBaseLink().'marcas/'.$landing->slug;

        $this->context->smarty->assign(array(
            'landing' => $landing,
            'manufacturer' => $manufacturer,
            'hero_image' => $heroImage,
            'hero_logo' => $heroLogo,
            'brandseo_canonical' => $canonical,
            'brandseo_meta_title' => $landing->meta_title ? $landing->meta_title : $landing->h1,
            'brandseo_meta_description' => $landing->meta_description,
        ));

        $this->setTemplate('module:brandseo/views/templates/front/landing.tpl');
    }

    public function getTemplateVarPage()
    {
        $page = parent::getTemplateVarPage();

        $slug = pSQL(Tools::getValue('slug'));
        $idLang = (int) $this->context->language->id;

        $row = Db::getInstance()->getRow('
            SELECT 
                l.slug,
                ll.h1,
                ll.meta_title,
                ll.meta_description
            FROM `'._DB_PREFIX_.'brandseo_landing` l
            LEFT JOIN `'._DB_PREFIX_.'brandseo_landing_lang` ll
                ON ll.id_brandseo_landing = l.id_brandseo_landing
                AND ll.id_lang = '.(int) $idLang.'
            WHERE l.slug = "'.$slug.'"
            AND l.status = "published"
            AND l.active = 1
        ');

        if ($row) {
            $page['meta']['title'] = !empty($row['meta_title']) ? $row['meta_title'] : $row['h1'];
            $page['meta']['description'] = !empty($row['meta_description']) ? $row['meta_description'] : '';
            $page['canonical'] = $this->context->link->getBaseLink().'marcas/'.$row['slug'];
            $page['robots'] = 'index,follow';
        }

        return $page;
    }
}
