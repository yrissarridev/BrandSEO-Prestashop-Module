<?php

class BrandSeoProductRepository
{
    public function getProductsByManufacturer($idManufacturer, $idLang, $limit = 12)
    {
        $result = Db::getInstance()->executeS('
            SELECT
                p.id_product,
                pl.name,
                pl.link_rewrite,
                p.price,
                image.id_image
            FROM `'._DB_PREFIX_.'product` p
            INNER JOIN `'._DB_PREFIX_.'product_lang` pl
                ON pl.id_product = p.id_product
                AND pl.id_lang = '.(int) $idLang.'
            LEFT JOIN `'._DB_PREFIX_.'image` image
                ON image.id_product = p.id_product
                AND image.cover = 1
            WHERE p.id_manufacturer = '.(int) $idManufacturer.'
            AND p.active = 1
            ORDER BY p.date_add DESC
            LIMIT '.(int) $limit.'
        ');
        return ($result !== false) ? $result : array();
    }
}
