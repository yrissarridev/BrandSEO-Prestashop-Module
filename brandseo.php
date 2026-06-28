<?php
if (!defined('_PS_VERSION_')) {
    exit;
}

require_once __DIR__.'/classes/BrandSeoLanding.php';
require_once __DIR__.'/helpers/BrandSeoInstaller.php';
require_once __DIR__.'/helpers/BrandSeoTabInstaller.php';

class Brandseo extends Module
{
    public function __construct()
    {
        $this->name = 'brandseo';
        $this->tab = 'administration';
        $this->version = '1.0.0';
        $this->author = 'Vinófilos';
        $this->need_instance = 0;
        $this->bootstrap = true;

        $this->ps_versions_compliancy = array(
            'min' => '1.7.0.0',
            'max' => '9.99.99'
        );

        parent::__construct();

        $this->displayName = 'BrandSEO';
        $this->description = 'Landings SEO para marcas/fabricantes conectadas al catálogo de PrestaShop.';
        $this->confirmUninstall = '¿Seguro que quieres desinstalar BrandSEO?';
    }

    public function install()
    {
        return parent::install()
            && BrandSeoInstaller::installDatabase()
            && BrandSeoTabInstaller::install($this->name)
            && $this->registerHook('displayBackOfficeHeader');
    }

    public function uninstall()
    {
        return BrandSeoTabInstaller::uninstall()
            && BrandSeoInstaller::uninstallDatabase()
            && parent::uninstall();
    }

    public function hookDisplayBackOfficeHeader()
    {
        $controller = Tools::getValue('controller');

        if (!in_array($controller, array('AdminBrandSeo', 'AdminBrandSeoEdit'))) {
            return;
        }

        $this->context->controller->addCSS($this->_path.'views/css/admin.css');
        $this->context->controller->addJS($this->_path.'views/js/admin.js');

        $this->context->controller->addCSS($this->_path.'views/css/blocks/hero.css');
        $this->context->controller->addJS($this->_path.'views/js/blocks/hero.js');

        $this->context->controller->addCSS($this->_path.'views/css/blocks/faq.css');
        $this->context->controller->addJS($this->_path.'views/js/blocks/faq.js');
    }

    public function getContent()
    {
        Tools::redirectAdmin($this->context->link->getAdminLink('AdminBrandSeo'));
    }
}
