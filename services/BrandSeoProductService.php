<?php

class BrandSeoProductService
{
    public function getLandingProducts($idManufacturer, $idLang)
    {
        $assembler = new ProductAssembler(Context::getContext());
        $presenterFactory = new ProductPresenterFactory(Context::getContext());
        $presentationSettings = $presenterFactory->getPresentationSettings();

        $presenter = new ProductListingPresenter(
            new ImageRetriever(Context::getContext()->link),
            Context::getContext()->link,
            new PriceFormatter(),
            new ProductColorsRetriever(),
            Context::getContext()->getTranslator()
        );

        $rows = Db::getInstance()->executeS('
            SELECT p.id_product
            FROM `'._DB_PREFIX_.'product` p
            INNER JOIN `'._DB_PREFIX_.'product_shop` ps
                ON ps.id_product = p.id_product
                AND ps.id_shop = '.(int) Context::getContext()->shop->id.'
            WHERE p.id_manufacturer = '.(int) $idManufacturer.'
            AND ps.active = 1
            ORDER BY p.date_add DESC
            LIMIT 12
        ');

        $products = array();

        foreach ($rows as $row) {
            $rawProduct = array('id_product' => (int) $row['id_product']);
            $assembledProduct = $assembler->assembleProduct($rawProduct);

            $products[] = $presenter->present(
                $presentationSettings,
                $assembledProduct,
                Context::getContext()->language
            );
        }

        return $products;
    }
}
