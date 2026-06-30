<?php

class BrandSeoBrandRepository
{
    public function getDashboardBrands()
    {
        $idLang = (int) Context::getContext()->language->id;

        $result = Db::getInstance()->executeS('
            SELECT
                m.id_manufacturer,
                m.name,
                m.active,
                COUNT(DISTINCT p.id_product) AS total_products,
                l.id_brandseo_landing,
                l.status,
                l.noindex,
                l.redirect_enabled,
                l.website,
                l.country,
                l.region,
                ll.h1,
                ll.meta_title,
                ll.meta_description,
                ll.excerpt,
                ll.history,
                ll.philosophy,
                ll.store_opinion,
                MAX(CASE WHEN media.id_brandseo_media IS NULL THEN 0 ELSE 1 END) AS has_hero_image
            FROM `'._DB_PREFIX_.'manufacturer` m
            LEFT JOIN `'._DB_PREFIX_.'product` p
                ON p.id_manufacturer = m.id_manufacturer
            LEFT JOIN `'._DB_PREFIX_.'brandseo_landing` l
                ON l.id_manufacturer = m.id_manufacturer
                AND l.type = "brand"
            LEFT JOIN `'._DB_PREFIX_.'brandseo_landing_lang` ll
                ON ll.id_brandseo_landing = l.id_brandseo_landing
                AND ll.id_lang = '.(int) $idLang.'
            LEFT JOIN `'._DB_PREFIX_.'brandseo_media` media
                ON media.id_brandseo_landing = l.id_brandseo_landing
                AND media.block = "hero"
                AND media.type = "image"
                AND media.active = 1
            GROUP BY m.id_manufacturer
            ORDER BY total_products DESC, m.name ASC
        ');
        return ($result !== false) ? $result : array();
    }
}
