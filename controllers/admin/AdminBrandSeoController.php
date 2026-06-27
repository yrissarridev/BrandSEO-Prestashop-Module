<?php

require_once _PS_MODULE_DIR_.'brandseo/classes/BrandSeoLanding.php';

class AdminBrandSeoController extends ModuleAdminController
{
    public function __construct()
    {
        $this->bootstrap = true;
        parent::__construct();
    }

    public function initContent()
    {
        parent::initContent();

        if (Tools::isSubmit('generateLanding')) {
            $this->processGenerateLanding((int) Tools::getValue('id_manufacturer'));
        }

        $brands = $this->getBrands();

        $this->context->smarty->assign(array(
            'module_version' => $this->module->version,
            'brands' => $brands,
            'current_url' => self::$currentIndex.'&token='.$this->token,
        ));

        $this->content = $this->context->smarty->fetch(
            _PS_MODULE_DIR_.'brandseo/views/templates/admin/dashboard.tpl'
        );

        $this->context->smarty->assign(array(
            'content' => $this->content,
        ));
    }

    private function getBrands()
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

    private function processGenerateLanding($idManufacturer)
    {
        if (!$idManufacturer) {
            $this->errors[] = 'Marca no válida.';
            return;
        }

        if (BrandSeoLanding::getIdByManufacturer($idManufacturer)) {
            $this->warnings[] = 'Esta marca ya tiene una landing creada.';
            return;
        }

        $manufacturer = new Manufacturer($idManufacturer, (int) $this->context->language->id);

        if (!Validate::isLoadedObject($manufacturer)) {
            $this->errors[] = 'No se encontró la marca.';
            return;
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

        if ($landing->add()) {
            $this->confirmations[] = 'Landing generada en borrador para '.$manufacturer->name.'.';
        } else {
            $this->errors[] = 'No se pudo generar la landing.';
        }
    }
}
