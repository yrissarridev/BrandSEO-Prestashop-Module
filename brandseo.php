<?php
if (!defined('_PS_VERSION_')) {
    exit;
}

require_once __DIR__.'/classes/BrandSeoLanding.php';

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
            && $this->installSql()
            && $this->installAdminTab();
    }

    public function uninstall()
    {
        return $this->uninstallAdminTab()
            && $this->uninstallSql()
            && parent::uninstall();
    }

    private function installSql()
    {
        $queries = array();

        $queries[] = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'brandseo_landing` (
            `id_brandseo_landing` INT UNSIGNED NOT NULL AUTO_INCREMENT,
            `id_manufacturer` INT UNSIGNED DEFAULT NULL,
            `type` VARCHAR(32) NOT NULL DEFAULT "brand",
            `slug` VARCHAR(255) NOT NULL,
            `status` VARCHAR(32) NOT NULL DEFAULT "draft",
            `active` TINYINT(1) NOT NULL DEFAULT 0,
            `noindex` TINYINT(1) NOT NULL DEFAULT 1,
            `redirect_enabled` TINYINT(1) NOT NULL DEFAULT 0,
            `hero_image` VARCHAR(255) DEFAULT NULL,
            `logo_image` VARCHAR(255) DEFAULT NULL,
            `latitude` DECIMAL(10,7) DEFAULT NULL,
            `longitude` DECIMAL(10,7) DEFAULT NULL,
            `website` VARCHAR(255) DEFAULT NULL,
            `instagram` VARCHAR(255) DEFAULT NULL,
            `facebook` VARCHAR(255) DEFAULT NULL,
            `youtube` VARCHAR(255) DEFAULT NULL,
            `country` VARCHAR(128) DEFAULT NULL,
            `region` VARCHAR(128) DEFAULT NULL,
            `date_add` DATETIME NOT NULL,
            `date_upd` DATETIME NOT NULL,
            PRIMARY KEY (`id_brandseo_landing`),
            KEY `idx_manufacturer` (`id_manufacturer`),
            KEY `idx_type` (`type`),
            KEY `idx_slug` (`slug`),
            KEY `idx_status` (`status`)
        ) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8;';

        $queries[] = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'brandseo_landing_lang` (
            `id_brandseo_landing` INT UNSIGNED NOT NULL,
            `id_lang` INT UNSIGNED NOT NULL,
            `title` VARCHAR(255) DEFAULT NULL,
            `h1` VARCHAR(255) DEFAULT NULL,
            `meta_title` VARCHAR(255) DEFAULT NULL,
            `meta_description` VARCHAR(512) DEFAULT NULL,
            `excerpt` TEXT DEFAULT NULL,
            `history` MEDIUMTEXT DEFAULT NULL,
            `philosophy` MEDIUMTEXT DEFAULT NULL,
            `store_opinion` MEDIUMTEXT DEFAULT NULL,
            PRIMARY KEY (`id_brandseo_landing`, `id_lang`)
        ) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8;';

        foreach ($queries as $query) {
            if (!Db::getInstance()->execute($query)) {
                return false;
            }
        }

        return true;
    }

    private function uninstallSql()
    {
        Db::getInstance()->execute('DROP TABLE IF EXISTS `'._DB_PREFIX_.'brandseo_landing_lang`');
        Db::getInstance()->execute('DROP TABLE IF EXISTS `'._DB_PREFIX_.'brandseo_landing`');

        return true;
    }

    private function installAdminTab()
    {
        $idParent = (int) Tab::getIdFromClassName('AdminCatalog');

        $tab = new Tab();
        $tab->active = 1;
        $tab->class_name = 'AdminBrandSeo';
        $tab->module = $this->name;
        $tab->id_parent = $idParent;

        foreach (Language::getLanguages(false) as $lang) {
            $tab->name[(int) $lang['id_lang']] = 'BrandSEO';
        }

        return $tab->add();
    }

    private function uninstallAdminTab()
    {
        $idTab = (int) Tab::getIdFromClassName('AdminBrandSeo');

        if ($idTab) {
            $tab = new Tab($idTab);
            return $tab->delete();
        }

        return true;
    }

    public function getContent()
    {
        Tools::redirectAdmin($this->context->link->getAdminLink('AdminBrandSeo'));
    }
}
