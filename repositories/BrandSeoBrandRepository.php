<?php

class BrandSeoBrandRepository
{
    public function getDashboardBrands()
    {
        return Db::getInstance()->executeS('
            SELECT 
                m.id_manufacturer,
                m.name,
                m.active,
                COUNT(p.id_product) AS total_products,
                l.id_brandseo_landing,
                l.status,
                l.noindex,
                l.redirect_enabled
            FROM `'._DB_PREFIX_.'manufacturer` m
            LEFT JOIN `'._DB_PREFIX_.'product` p 
                ON p.id_manufacturer = m.id_manufacturer
            LEFT JOIN `'._DB_PREFIX_.'brandseo_landing` l
                ON l.id_manufacturer = m.id_manufacturer
                AND l.type = "brand"
            GROUP BY m.id_manufacturer
            ORDER BY total_products DESC, m.name ASC
        ');
    }
}
