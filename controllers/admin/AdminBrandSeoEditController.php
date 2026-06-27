<?php

require_once _PS_MODULE_DIR_.'brandseo/classes/BrandSeoLanding.php';

class AdminBrandSeoEditController extends ModuleAdminController
{
    public function __construct()
    {
        $this->bootstrap = true;
        parent::__construct();
    }

    public function initContent()
    {
        parent::initContent();

        $idLanding = (int) Tools::getValue('id_brandseo_landing');
        $landing = new BrandSeoLanding($idLanding);

        if (!Validate::isLoadedObject($landing)) {
            $this->errors[] = 'Landing no encontrada.';
            $this->redirect_after = $this->context->link->getAdminLink('AdminBrandSeo');
            return;
        }

        if (Tools::isSubmit('submitBrandSeoLanding')) {
            $this->processSaveBrandSeoLanding($landing);
        }

        $idLang = (int) $this->context->language->id;
        $manufacturer = new Manufacturer((int) $landing->id_manufacturer, $idLang);

        $this->context->smarty->assign(array(
            'landing' => $landing,
            'manufacturer' => $manufacturer,
            'id_lang' => $idLang,
            'languages' => Language::getLanguages(true),
            'back_url' => $this->context->link->getAdminLink('AdminBrandSeo'),
            'current_url' => self::$currentIndex.'&token='.$this->token.'&id_brandseo_landing='.(int)$landing->id,
        ));

        $this->content = $this->context->smarty->fetch(
            _PS_MODULE_DIR_.'brandseo/views/templates/admin/edit.tpl'
        );

        $this->context->smarty->assign(array(
            'content' => $this->content,
        ));
    }

    private function processSaveBrandSeoLanding(BrandSeoLanding $landing)
    {
        $landing->slug = Tools::link_rewrite(Tools::getValue('slug'));
        $landing->status = pSQL(Tools::getValue('status'));
        $landing->noindex = (int) Tools::getValue('noindex');
        $landing->redirect_enabled = (int) Tools::getValue('redirect_enabled');
        $landing->website = Tools::getValue('website') ? pSQL(Tools::getValue('website')) : null;
        $landing->instagram = Tools::getValue('instagram') ? pSQL(Tools::getValue('instagram')) : null;
        $landing->facebook = Tools::getValue('facebook') ? pSQL(Tools::getValue('facebook')) : null;
        $landing->youtube = Tools::getValue('youtube') ? pSQL(Tools::getValue('youtube')) : null;
        $landing->country = Tools::getValue('country') ? pSQL(Tools::getValue('country')) : null;
        $landing->region = Tools::getValue('region') ? pSQL(Tools::getValue('region')) : null;

        $landing->active = ($landing->status === 'published') ? 1 : 0;

        foreach (Language::getLanguages(true) as $lang) {
            $idLang = (int) $lang['id_lang'];

            $landing->title[$idLang] = Tools::getValue('title_'.$idLang);
            $landing->h1[$idLang] = Tools::getValue('h1_'.$idLang);
            $landing->meta_title[$idLang] = Tools::getValue('meta_title_'.$idLang);
            $landing->meta_description[$idLang] = Tools::getValue('meta_description_'.$idLang);
            $landing->excerpt[$idLang] = Tools::getValue('excerpt_'.$idLang);
            $landing->history[$idLang] = Tools::getValue('history_'.$idLang);
            $landing->philosophy[$idLang] = Tools::getValue('philosophy_'.$idLang);
            $landing->store_opinion[$idLang] = Tools::getValue('store_opinion_'.$idLang);
        }

        if ($landing->update()) {
            $this->confirmations[] = 'Landing guardada correctamente.';
        } else {
            $this->errors[] = 'No se pudo guardar la landing.';
        }
    }
}
