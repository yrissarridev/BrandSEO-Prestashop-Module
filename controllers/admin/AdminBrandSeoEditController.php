<?php

require_once _PS_MODULE_DIR_.'brandseo/classes/BrandSeoLanding.php';
require_once _PS_MODULE_DIR_.'brandseo/services/BrandSeoHealthService.php';
require_once _PS_MODULE_DIR_.'brandseo/services/Block/BrandSeoBlockRegistry.php';
require_once _PS_MODULE_DIR_.'brandseo/services/BrandSeoFaqService.php';
require_once _PS_MODULE_DIR_.'brandseo/services/BrandSeoMediaService.php';
require_once _PS_MODULE_DIR_.'brandseo/services/Media/BrandSeoUploader.php';
require_once _PS_MODULE_DIR_.'brandseo/services/BrandSeoBlockSettingsService.php';

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

        if (!$idLanding) {
            Tools::redirectAdmin($this->context->link->getAdminLink('AdminBrandSeo'));
        }

        $landing = new BrandSeoLanding($idLanding);

        if (!Validate::isLoadedObject($landing)) {
            Tools::redirectAdmin($this->context->link->getAdminLink('AdminBrandSeo'));
        }

        if (Tools::isSubmit('submitBrandSeoLanding')) {
            $this->processSaveBrandSeoLanding($landing);
        }

        if (Tools::isSubmit('submitBrandSeoHeroImage')) {
            $this->processUploadHeroImage($landing);
        }

        if (Tools::isSubmit('submitBrandSeoHeroLogo')) {
            $this->processUploadHeroLogo($landing);
        }

        $idLang = (int) $this->context->language->id;
        $manufacturer = new Manufacturer((int) $landing->id_manufacturer, $idLang);

        $blockRegistry = new BrandSeoBlockRegistry();
        $availableBlocks = $blockRegistry->getAvailableBlocks();

        $faqService = new BrandSeoFaqService();
        $faqs = $faqService->getFaqsForEditor((int) $landing->id, $idLang);

        $blockSettingsService = new BrandSeoBlockSettingsService();
        $heroSettings = $blockSettingsService->getSettings((int) $landing->id, 'hero');

        $mediaService = new BrandSeoMediaService();
        $heroMedia = $mediaService->getMediaForBlock((int) $landing->id, 'hero', $idLang);
        $heroImages = array();
        $heroLogos = array();
        $heroBackgroundUrl = '';

        foreach ($heroMedia as $mediaItem) {
            if ($mediaItem['type'] === 'logo') {
                $heroLogos[] = $mediaItem;
            } else {
                $heroImages[] = $mediaItem;

                if (!$heroBackgroundUrl && !empty($mediaItem['path'])) {
                    $heroBackgroundUrl = $this->module->getPathUri().$mediaItem['path'];
                }
            }
        }
        $galleryMedia = $mediaService->getMediaForBlock((int) $landing->id, 'gallery', $idLang);

        $healthService = new BrandSeoHealthService();
        $health = $healthService->calculateFromDashboardRow(array(
            'id_brandseo_landing' => (int) $landing->id,
            'meta_title' => isset($landing->meta_title[$idLang]) ? $landing->meta_title[$idLang] : '',
            'meta_description' => isset($landing->meta_description[$idLang]) ? $landing->meta_description[$idLang] : '',
            'h1' => isset($landing->h1[$idLang]) ? $landing->h1[$idLang] : '',
            'excerpt' => isset($landing->excerpt[$idLang]) ? $landing->excerpt[$idLang] : '',
            'history' => isset($landing->history[$idLang]) ? $landing->history[$idLang] : '',
            'philosophy' => isset($landing->philosophy[$idLang]) ? $landing->philosophy[$idLang] : '',
            'store_opinion' => isset($landing->store_opinion[$idLang]) ? $landing->store_opinion[$idLang] : '',
            'has_hero_image' => !empty($heroImages) ? 1 : 0,
            'website' => $landing->website,
            'country' => $landing->country,
            'region' => $landing->region,
        ));

        $this->context->smarty->assign(array(
            'landing' => $landing,
            'manufacturer' => $manufacturer,
            'health' => $health,
            'available_blocks' => $availableBlocks,
            'faqs' => $faqs,
            'hero_settings' => $heroSettings,
            'hero_media' => $heroMedia,
            'hero_images' => $heroImages,
            'hero_background_url' => $heroBackgroundUrl,
            'hero_logos' => $heroLogos,
            'module_dir_url' => $this->module->getPathUri(),
            'gallery_media' => $galleryMedia,
            'id_lang' => $idLang,
            'languages' => Language::getLanguages(true),
            'back_url' => $this->context->link->getAdminLink('AdminBrandSeo'),
            'current_url' => self::$currentIndex.'&token='.$this->token.'&id_brandseo_landing='.(int) $landing->id,
        ));

        $this->content = $this->context->smarty->fetch(
            _PS_MODULE_DIR_.'brandseo/views/templates/admin/edit.tpl'
        );

        $this->context->smarty->assign(array(
            'content' => $this->content,
        ));
    }


    private function processUploadHeroImage(BrandSeoLanding $landing)
    {
        $uploader = new BrandSeoUploader();
        list($success, $message) = $uploader->uploadHeroImage(
            'hero_image_file',
            (int) $landing->id,
            (int) $this->context->language->id
        );

        if ($success) {
            $this->confirmations[] = $message;
        } else {
            $this->errors[] = $message;
        }
    }


    private function processUploadHeroLogo(BrandSeoLanding $landing)
    {
        $uploader = new BrandSeoUploader();
        list($success, $message) = $uploader->uploadHeroLogo(
            'hero_logo_file',
            (int) $landing->id,
            (int) $this->context->language->id
        );

        if ($success) {
            $this->confirmations[] = $message;
        } else {
            $this->errors[] = $message;
        }
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


        $blockSettingsService = new BrandSeoBlockSettingsService();
        $blockSettingsService->saveSettings((int) $landing->id, 'hero', array(
            'height' => Tools::getValue('hero_height', 'medium'),
            'align' => Tools::getValue('hero_align', 'center'),
            'overlay' => (int) Tools::getValue('hero_overlay', 48),
        ));

        if ($landing->update()) {
            $this->confirmations[] = 'Landing guardada correctamente.';
        } else {
            $this->errors[] = 'No se pudo guardar la landing.';
        }
    }
}
