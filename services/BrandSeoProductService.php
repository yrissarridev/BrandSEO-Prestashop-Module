<?php

require_once _PS_ROOT_DIR_.'/src/Adapter/Image/ImageRetriever.php';
require_once _PS_ROOT_DIR_.'/src/Adapter/Product/PriceFormatter.php';
require_once _PS_ROOT_DIR_.'/src/Adapter/Product/ProductColorsRetriever.php';
require_once _PS_ROOT_DIR_.'/src/Adapter/Presenter/Product/ProductListingPresenter.php';
require_once _PS_ROOT_DIR_.'/src/Adapter/Presenter/Product/ProductPresenterFactory.php';
require_once _PS_ROOT_DIR_.'/src/Adapter/Product/ProductAssembler.php';

class BrandSeoProductService
{
    public function getLandingProducts($idManufacturer, $idLang)
    {
        $context = Context::getContext();

        $assembler = new PrestaShop\PrestaShop\Adapter\Product\ProductAssembler($context);
        $presenterFactory = new PrestaShop\PrestaShop\Adapter\Presenter\Product\ProductPresenterFactory($context);
        $presentationSettings = $presenterFactory->getPresentationSettings();

        $presenter = new PrestaShop\PrestaShop\Adapter\Presenter\Product\ProductListingPresenter(
            new PrestaShop\PrestaShop\Adapter\Image\ImageRetriever($context->link),
            $context->link,
            new PrestaShop\PrestaShop\Adapter\Product\PriceFormatter(),
            new PrestaShop\PrestaShop\Adapter\Product\ProductColorsRetriever(),
            $context->getTranslator()
        );

        $rows = Db::getInstance()->executeS('
            SELECT p.id_product
            FROM `'._DB_PREFIX_.'product` p
            INNER JOIN `'._DB_PREFIX_.'product_shop` ps
                ON ps.id_product = p.id_product
                AND ps.id_shop = '.(int) $context->shop->id.'
            WHERE p.id_manufacturer = '.(int) $idManufacturer.'
            AND ps.active = 1
            ORDER BY p.date_add DESC
            LIMIT 12
        ');

        $products = array();

        foreach ($rows as $row) {
            $assembledProduct = $assembler->assembleProduct(array(
                'id_product' => (int) $row['id_product'],
            ));

            $products[] = $presenter->present(
                $presentationSettings,
                $assembledProduct,
                $context->language
            );
        }

        return $products;
    }
}
