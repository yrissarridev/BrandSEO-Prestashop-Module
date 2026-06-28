<?php
if (!defined('_PS_VERSION_')) {
    exit;
}

require_once __DIR__.'/classes/BrandSeoLanding.php';
require_once __DIR__.'/helpers/BrandSeoInstaller.php';

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
            && $this->installAdminTabs()
            && $this->registerHook('displayBackOfficeHeader');
    }

    public function uninstall()
    {
        return $this->uninstallAdminTabs()
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
    }

    private function installAdminTabs()
    {
        $idParent = (int) Tab::getIdFromClassName('AdminCatalog');

        if (!$this->installTab('AdminBrandSeo', 'BrandSEO', $idParent, 1)) {
            return false;
        }

        $idBrandSeoTab = (int) Tab::getIdFromClassName('AdminBrandSeo');

        return $this->installTab('AdminBrandSeoEdit', 'Editar BrandSEO', $idBrandSeoTab, 1);
    }

    private function installTab($className, $name, $idParent, $active)
    {
        $idExisting = (int) Tab::getIdFromClassName($className);

        if ($idExisting) {
            $tab = new Tab($idExisting);
            $tab->active = (int) $active;
            $tab->module = $this->name;
            $tab->id_parent = (int) $idParent;

            foreach (Language::getLanguages(true) as $lang) {
                $tab->name[(int) $lang['id_lang']] = $name;
            }

            return $tab->update();
        }

        $tab = new Tab();
        $tab->active = (int) $active;
        $tab->class_name = $className;
        $tab->module = $this->name;
        $tab->id_parent = (int) $idParent;

        foreach (Language::getLanguages(true) as $lang) {
            $tab->name[(int) $lang['id_lang']] = $name;
        }

        return $tab->add();
    }

    private function uninstallAdminTabs()
    {
        $classes = array('AdminBrandSeoEdit', 'AdminBrandSeo');

        foreach ($classes as $className) {
            $idTab = (int) Tab::getIdFromClassName($className);

            if ($idTab) {
                $tab = new Tab($idTab);
                if (!$tab->delete()) {
                    return false;
                }
            }
        }

        return true;
    }

    public function getContent()
    {
        Tools::redirectAdmin($this->context->link->getAdminLink('AdminBrandSeo'));
    }
}
