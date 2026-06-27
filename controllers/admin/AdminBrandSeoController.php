<?php

require_once _PS_MODULE_DIR_.'brandseo/repositories/BrandSeoBrandRepository.php';
require_once _PS_MODULE_DIR_.'brandseo/services/BrandSeoLandingGenerator.php';

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

        $repository = new BrandSeoBrandRepository();
        $brands = $repository->getDashboardBrands();

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

    private function processGenerateLanding($idManufacturer)
    {
        $generator = new BrandSeoLandingGenerator();
        list($success, $message) = $generator->generateFromManufacturer($idManufacturer, $this->context);

        if ($success) {
            $this->confirmations[] = $message;
        } else {
            $this->errors[] = $message;
        }
    }
}
