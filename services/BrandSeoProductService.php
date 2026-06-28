<?php

require_once _PS_MODULE_DIR_.'brandseo/repositories/BrandSeoProductRepository.php';

class BrandSeoProductService
{
    private $repository;

    public function __construct()
    {
        $this->repository = new BrandSeoProductRepository();
    }

    public function getLandingProducts($idManufacturer, $idLang)
    {
        $products = $this->repository->getProductsByManufacturer($idManufacturer, $idLang, 12);
        $link = Context::getContext()->link;

        foreach ($products as &$product) {
            $idProduct = (int) $product['id_product'];

            $product['url'] = $link->getProductLink($idProduct, $product['link_rewrite']);
            $product['image_url'] = '';

            if (!empty($product['id_image'])) {
                $product['image_url'] = $link->getImageLink(
                    $product['link_rewrite'],
                    $idProduct.'-'.(int) $product['id_image'],
                    ImageType::getFormattedName('home')
                );
            }

            $price = Product::getPriceStatic($idProduct, true);
            $product['price_formatted'] = Tools::displayPrice($price);
        }

        unset($product);

        return $products;
    }
}
