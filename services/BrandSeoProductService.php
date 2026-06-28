<?php

use PrestaShop\PrestaShop\Adapter\Image\ImageRetriever;
use PrestaShop\PrestaShop\Adapter\Product\PriceFormatter;
use PrestaShop\PrestaShop\Adapter\Product\ProductColorsRetriever;
use PrestaShop\PrestaShop\Adapter\Presenter\Product\ProductListingPresenter;
use PrestaShop\PrestaShop\Adapter\Presenter\Product\ProductPresenterFactory;
use PrestaShop\PrestaShop\Adapter\Product\ProductAssembler;

class BrandSeoProductService
{
    public function getLandingProducts($idManufacturer, $idLang)
    {
        $context = Context::getContext();

        $assembler = new ProductAssembler($context);
        $presenterFactory = new ProductPresenterFactory($context);
        $presentationSettings = $presenterFactory->getPresentationSettings();

        $presenter = new ProductListingPresenter(
            new ImageRetriever($context->link),
            $context->link,
            new PriceFormatter(),
            new ProductColorsRetriever(),
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
