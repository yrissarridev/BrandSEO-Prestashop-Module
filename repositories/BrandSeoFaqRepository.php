<?php

class BrandSeoFaqRepository
{
    public function getByLanding($idLanding, $idLang)
    {
        $result = Db::getInstance()->executeS('
            SELECT
                f.id_brandseo_faq,
                f.id_brandseo_landing,
                f.position,
                f.active,
                fl.question,
                fl.answer
            FROM `'._DB_PREFIX_.'brandseo_faq` f
            LEFT JOIN `'._DB_PREFIX_.'brandseo_faq_lang` fl
                ON fl.id_brandseo_faq = f.id_brandseo_faq
                AND fl.id_lang = '.(int) $idLang.'
            WHERE f.id_brandseo_landing = '.(int) $idLanding.'
            ORDER BY f.position ASC, f.id_brandseo_faq ASC
        ');
        return ($result !== false) ? $result : array();
    }
}
