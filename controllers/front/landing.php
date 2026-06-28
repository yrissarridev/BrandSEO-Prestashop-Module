<?php

require_once _PS_MODULE_DIR_.'brandseo/classes/BrandSeoLanding.php';
require_once _PS_MODULE_DIR_.'brandseo/services/BrandSeoMediaService.php';
require_once _PS_MODULE_DIR_.'brandseo/services/BrandSeoProductService.php';
require_once _PS_MODULE_DIR_.'brandseo/services/BrandSeoFaqService.php';
require_once _PS_MODULE_DIR_.'brandseo/services/BrandSeoRelatedBrandService.php';

class BrandseoLandingModuleFrontController extends ModuleFrontController
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

        $productService = new BrandSeoProductService();
        $brandProducts = $productService->getLandingProducts((int) $landing->id_manufacturer, $idLang);

        $faqService = new BrandSeoFaqService();
        $brandFaqs = $faqService->getFaqsForFront((int) $landing->id, $idLang);

        $relatedService = new BrandSeoRelatedBrandService();
        $relatedBrands = $relatedService->getRelatedBrands((int) $landing->id_manufacturer, $idLang);

        $canonical = $this->context->link->getBaseLink().'marcas/'.$landing->slug;
        $metaTitle = $landing->meta_title ? $landing->meta_title : $landing->h1;
        $metaDescription = $landing->meta_description ? $landing->meta_description : $landing->excerpt;

        $jsonLd = array(
            '@context' => 'https://schema.org',
            '@type' => 'Brand',
            'name' => $manufacturer->name,
            'url' => $canonical,
            'description' => $metaDescription,
        );

        if ($heroImage) {
            $jsonLd['image'] = $heroImage;
        }

        if ($landing->website) {
            $jsonLd['sameAs'] = array($landing->website);
        }

        $this->context->smarty->assign(array(
            'landing' => $landing,
            'manufacturer' => $manufacturer,
            'hero_image' => $heroImage,
            'hero_logo' => $heroLogo,
            'brand_products' => $brandProducts,
            'brand_products_count' => count($brandProducts),
            'brand_faqs' => $brandFaqs,
            'related_brands' => $relatedBrands,
            'brandseo_canonical' => $canonical,
            'brandseo_meta_title' => $metaTitle,
            'brandseo_meta_description' => $metaDescription,
            'brandseo_og_image' => $heroImage,
            'brandseo_jsonld' => json_encode($jsonLd, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE),
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
                l.noindex,
                ll.h1,
                ll.meta_title,
                ll.meta_description,
                ll.excerpt
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
            $page['meta']['description'] = !empty($row['meta_description']) ? $row['meta_description'] : $row['excerpt'];
            $page['canonical'] = $this->context->link->getBaseLink().'marcas/'.$row['slug'];
            $page['robots'] = !empty($row['noindex']) ? 'noindex,follow' : 'index,follow';
        }

        return $page;
    }
}
