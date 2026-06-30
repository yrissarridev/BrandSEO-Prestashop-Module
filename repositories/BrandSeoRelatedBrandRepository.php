<?php

class BrandSeoRelatedBrandRepository
{
    public function getRelatedBrands($excludeManufacturerId, $idLang, $limit = 6)
    {
        $result = Db::getInstance()->executeS('
            SELECT
                m.id_manufacturer,
                m.name,
                l.slug,
                COUNT(DISTINCT p.id_product) AS total_products
            FROM `'._DB_PREFIX_.'manufacturer` m
            INNER JOIN `'._DB_PREFIX_.'brandseo_landing` l
                ON l.id_manufacturer = m.id_manufacturer
                AND l.status = "published"
                AND l.active = 1
            LEFT JOIN `'._DB_PREFIX_.'product` p
                ON p.id_manufacturer = m.id_manufacturer
                AND p.active = 1
            WHERE m.id_manufacturer != '.(int) $excludeManufacturerId.'
            GROUP BY m.id_manufacturer
            HAVING total_products > 0
            ORDER BY total_products DESC, m.name ASC
            LIMIT '.(int) $limit.'
        ');
        return ($result !== false) ? $result : array();
    }
}
