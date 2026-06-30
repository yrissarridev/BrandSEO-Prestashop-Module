<?php

require_once _PS_MODULE_DIR_.'brandseo/classes/BrandSeoLanding.php';
require_once _PS_MODULE_DIR_.'brandseo/services/BrandSeoMediaService.php';
require_once _PS_MODULE_DIR_.'brandseo/services/BrandSeoFaqService.php';
require_once _PS_MODULE_DIR_.'brandseo/services/BrandSeoRelatedBrandService.php';
require_once _PS_MODULE_DIR_.'brandseo/services/BrandSeoBlockSettingsService.php';

use PrestaShop\PrestaShop\Core\Product\Search\ProductSearchContext;
use PrestaShop\PrestaShop\Core\Product\Search\ProductSearchQuery;
use PrestaShop\PrestaShop\Core\Product\Search\SortOrder;
use PrestaShop\PrestaShop\Adapter\Manufacturer\ManufacturerProductSearchProvider;
use PrestaShop\PrestaShop\Adapter\Presenter\Product\ProductListingPresenter;
use PrestaShop\PrestaShop\Core\Product\ProductPresentationSettings;
use PrestaShop\PrestaShop\Adapter\Product\PriceFormatter;
use PrestaShop\PrestaShop\Adapter\Product\ProductColorsRetriever;
use PrestaShop\PrestaShop\Adapter\Image\ImageRetriever;

class BrandseoLandingModuleFrontController extends ModuleFrontController
{
    protected $previewMode = false;

    public function setMedia()
    {
        parent::setMedia();

        $this->registerStylesheet(
            'module-brandseo-landing',
            'modules/brandseo/views/css/front/landing.css',
            array('media' => 'all', 'priority' => 150)
        );
    }

    public function initContent()
    {
        parent::initContent();

        $slug = pSQL(Tools::getValue('slug'));
        $idLang = (int) $this->context->language->id;

        if (!$slug) {
            Tools::redirect('index.php?controller=404');
        }

        $whereStatus = $this->previewMode ? '' : 'AND status = "published" AND active = 1';

        $idLanding = (int) Db::getInstance()->getValue('
            SELECT id_brandseo_landing
            FROM `'._DB_PREFIX_.'brandseo_landing`
            WHERE slug = "'.$slug.'"
            '.$whereStatus.'
        ');

        if (!$idLanding) {
            Tools::redirect('index.php?controller=404');
        }

        $landing = new BrandSeoLanding($idLanding, $idLang);

        if (!Validate::isLoadedObject($landing)) {
            Tools::redirect('index.php?controller=404');
        }

        $manufacturer = new Manufacturer((int) $landing->id_manufacturer, $idLang);

        if (!Validate::isLoadedObject($manufacturer)) {
            Tools::redirect('index.php?controller=404');
        }

        $blockSettingsService = new BrandSeoBlockSettingsService();
        $heroSettings = $blockSettingsService->getSettings((int) $landing->id, 'hero');

        $mediaService = new BrandSeoMediaService();
        $heroMedia = $mediaService->getMediaForBlock((int) $landing->id, 'hero', $idLang);

        $heroImage = '';
        $heroLogo = '';
        $moduleBaseUrl = $this->context->link->getBaseLink().'modules/brandseo/';

        foreach ($heroMedia as $media) {
            if ($media['type'] === 'logo' && !$heroLogo) {
                $heroLogo = $moduleBaseUrl.ltrim($media['path'], '/');
            }

            if ($media['type'] === 'image' && !$heroImage) {
                $heroImage = $moduleBaseUrl.ltrim($media['path'], '/');
            }
        }

        $listing = $this->getBrandseoNativeListing($manufacturer);
        $brandProducts = $listing['products'];

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

        if (!empty($brandProducts)) {
            $jsonLd['hasOfferCatalog'] = array(
                '@type' => 'OfferCatalog',
                'name' => 'Productos de '.$manufacturer->name,
                'itemListElement' => array(),
            );

            foreach (array_slice($brandProducts, 0, 12) as $product) {
                $jsonLd['hasOfferCatalog']['itemListElement'][] = array(
                    '@type' => 'Offer',
                    'url' => isset($product['url']) ? $product['url'] : '',
                    'itemOffered' => array(
                        '@type' => 'Product',
                        'name' => isset($product['name']) ? $product['name'] : '',
                    ),
                );
            }
        }

        if (!empty($brandFaqs)) {
            $jsonLdFaq = array(
                '@context' => 'https://schema.org',
                '@type' => 'FAQPage',
                'mainEntity' => array(),
            );

            foreach ($brandFaqs as $faq) {
                $jsonLdFaq['mainEntity'][] = array(
                    '@type' => 'Question',
                    'name' => strip_tags($faq['question']),
                    'acceptedAnswer' => array(
                        '@type' => 'Answer',
                        'text' => strip_tags($faq['answer']),
                    ),
                );
            }
        } else {
            $jsonLdFaq = null;
        }

        $breadcrumbsJsonLd = array(
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => array(
                array(
                    '@type' => 'ListItem',
                    'position' => 1,
                    'name' => 'Inicio',
                    'item' => $this->context->link->getBaseLink(),
                ),
                array(
                    '@type' => 'ListItem',
                    'position' => 2,
                    'name' => 'Marcas',
                    'item' => $this->context->link->getBaseLink().'marcas',
                ),
                array(
                    '@type' => 'ListItem',
                    'position' => 3,
                    'name' => $manufacturer->name,
                    'item' => $canonical,
                ),
            ),
        );

        $this->context->smarty->assign(array(
            'landing' => $landing,
            'manufacturer' => $manufacturer,
            'hero_image' => $heroImage,
            'hero_logo' => $heroLogo,
            'hero_settings' => $heroSettings,
            'listing' => $listing,
            'brand_products' => $brandProducts,
            'brand_products_count' => count($brandProducts),
            'brand_faqs' => $brandFaqs,
            'related_brands' => $relatedBrands,
            'brandseo_preview_mode' => $this->previewMode,
            'brandseo_canonical' => $canonical,
            'brandseo_meta_title' => $metaTitle,
            'brandseo_meta_description' => $metaDescription,
            'brandseo_og_image' => $heroImage,
            'brandseo_jsonld' => json_encode($jsonLd, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE),
            'brandseo_jsonld_faq' => $jsonLdFaq ? json_encode($jsonLdFaq, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) : '',
            'brandseo_jsonld_breadcrumbs' => json_encode($breadcrumbsJsonLd, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE),
        ));

        $this->setTemplate('module:brandseo/views/templates/front/landing.tpl');
    }

    /**
     * Replica el pipeline nativo de ManufacturerController
     * (ProductSearchContext -> ManufacturerProductSearchProvider -> ProductAssembler -> ProductListingPresenter)
     * para obtener los productos de la marca exactamente como los devuelve PrestaShop
     * en /marcas/{id_manufacturer}, listos para 'catalog/_partials/products.tpl'.
     *
     * @param Manufacturer $manufacturer
     *
     * @return array ['products' => array, 'pagination' => array]
     */
    private function getBrandseoNativeListing(Manufacturer $manufacturer)
    {
        $context = (new ProductSearchContext())
            ->setIdShop($this->context->shop->id)
            ->setIdLang($this->context->language->id)
            ->setIdCurrency($this->context->currency->id)
            ->setIdCustomer($this->context->customer ? $this->context->customer->id : null);

        $resultsPerPage = (int) Configuration::get('PS_PRODUCTS_PER_PAGE');
        if ($resultsPerPage <= 0) {
            $resultsPerPage = 24;
        }

        $query = (new ProductSearchQuery())
            ->setIdManufacturer((int) $manufacturer->id)
            ->setSortOrder(new SortOrder('product', Tools::getProductsOrder('by'), Tools::getProductsOrder('way')))
            ->setResultsPerPage($resultsPerPage)
            ->setPage(1);

        $provider = new ManufacturerProductSearchProvider(
            $this->getTranslator(),
            $manufacturer
        );

        $result = $provider->runQuery($context, $query);
        $rawProducts = $result->getProducts();

        $assembler = new ProductAssembler($this->context);

        $settings = new ProductPresentationSettings();
        $settings->catalog_mode = Configuration::isCatalogMode();
        $settings->include_taxes = (new TaxConfiguration())->includeTaxes();
        $settings->allow_add_variant_to_cart_from_listing = (int) Configuration::get('PS_ATTRIBUTE_CATEGORY_DISPLAY');
        $settings->stock_management_enabled = Configuration::get('PS_STOCK_MANAGEMENT');
        $settings->showPrices = Configuration::showPrices();
        $settings->lastRemainingItems = Configuration::get('PS_LAST_QTIES');

        $presenter = new ProductListingPresenter(
            new ImageRetriever($this->context->link),
            $this->context->link,
            new PriceFormatter(),
            new ProductColorsRetriever(),
            $this->getTranslator()
        );

        $products = array();

        foreach ($rawProducts as $rawProduct) {
            $assembledProduct = $assembler->assembleProduct($rawProduct);
            $products[] = $presenter->present($settings, $assembledProduct, $this->context->language);
        }

        $totalItems = (int) $result->getTotalProductsCount();

        $pagination = array(
            'total_items' => $totalItems,
            'items_shown_from' => $totalItems ? 1 : 0,
            'items_shown_to' => count($products),
            'current_page' => 1,
            'pages_count' => 1,
            'pages' => array(),
            'should_be_displayed' => false,
        );

        return array(
            'products' => $products,
            'pagination' => $pagination,
        );
    }

    public function getTemplateVarPage()
    {
        $page = parent::getTemplateVarPage();

        $slug = pSQL(Tools::getValue('slug'));
        $idLang = (int) $this->context->language->id;
        $whereStatus = $this->previewMode ? '' : 'AND l.status = "published" AND l.active = 1';

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
            '.$whereStatus.'
        ');

        if ($row) {
            $page['meta']['title'] = !empty($row['meta_title']) ? $row['meta_title'] : $row['h1'];
            $page['meta']['description'] = !empty($row['meta_description']) ? $row['meta_description'] : $row['excerpt'];
            $page['canonical'] = $this->context->link->getBaseLink().'marcas/'.$row['slug'];
            $page['robots'] = (!empty($row['noindex']) || $this->previewMode) ? 'noindex,follow' : 'index,follow';
        }

        return $page;
    }
}
