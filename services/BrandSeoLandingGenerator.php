<?php

require_once _PS_MODULE_DIR_.'brandseo/classes/BrandSeoLanding.php';

class BrandSeoLandingGenerator
{
    public function generateFromManufacturer($idManufacturer, Context $context)
    {
        $idManufacturer = (int) $idManufacturer;

        if (!$idManufacturer) {
            return array(false, 'Marca no válida.');
        }

        if (BrandSeoLanding::getIdByManufacturer($idManufacturer)) {
            return array(false, 'Esta marca ya tiene una landing creada.');
        }

        $manufacturer = new Manufacturer($idManufacturer, (int) $context->language->id);

        if (!Validate::isLoadedObject($manufacturer)) {
            return array(false, 'No se encontró la marca.');
        }

        $landing = new BrandSeoLanding();
        $landing->id_manufacturer = (int) $manufacturer->id;
        $landing->type = 'brand';
        $landing->slug = Tools::link_rewrite($manufacturer->name);
        $landing->status = 'draft';
        $landing->active = 0;
        $landing->noindex = 1;
        $landing->redirect_enabled = 0;

        foreach (Language::getLanguages(false) as $lang) {
            $idLang = (int) $lang['id_lang'];

            $landing->title[$idLang] = $manufacturer->name;
            $landing->h1[$idLang] = $manufacturer->name;
            $landing->meta_title[$idLang] = $manufacturer->name.' | Marca';
            $landing->meta_description[$idLang] = 'Descubre los productos de '.$manufacturer->name.'.';
            $landing->excerpt[$idLang] = '';
            $landing->history[$idLang] = '';
            $landing->philosophy[$idLang] = '';
            $landing->store_opinion[$idLang] = '';
        }

        if (!$landing->add()) {
            return array(false, 'No se pudo generar la landing.');
        }

        return array(true, 'Landing generada en borrador para '.$manufacturer->name.'.');
    }
}
