<?php

class BrandSeoMediaRepository
{
    public function getByLandingAndBlock($idLanding, $block, $idLang)
    {
        $result = Db::getInstance()->executeS('
            SELECT
                m.id_brandseo_media,
                m.id_brandseo_landing,
                m.block,
                m.type,
                m.path,
                m.mime,
                m.width,
                m.height,
                m.filesize,
                m.position,
                m.active,
                ml.title,
                ml.alt,
                ml.description
            FROM `'._DB_PREFIX_.'brandseo_media` m
            LEFT JOIN `'._DB_PREFIX_.'brandseo_media_lang` ml
                ON ml.id_brandseo_media = m.id_brandseo_media
                AND ml.id_lang = '.(int) $idLang.'
            WHERE m.id_brandseo_landing = '.(int) $idLanding.'
            AND m.block = "'.pSQL($block).'"
            ORDER BY m.position ASC, m.id_brandseo_media ASC
        ');
        return ($result !== false) ? $result : array();
    }
}
