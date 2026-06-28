<?php

require_once _PS_MODULE_DIR_.'brandseo/controllers/admin/AdminBrandSeoController.php';

class AdminBrandSeoMaintenanceController extends ModuleAdminController
{
    public function __construct()
    {
        $this->bootstrap = true;
        parent::__construct();
    }

    public function initContent()
    {
        parent::initContent();

        $checks = array();

        $checks[] = $this->checkTable('brandseo_landing');
        $checks[] = $this->checkTable('brandseo_landing_lang');
        $checks[] = $this->checkTable('brandseo_media');
        $checks[] = $this->checkTable('brandseo_media_lang');
        $checks[] = $this->checkTable('brandseo_faq');
        $checks[] = $this->checkTable('brandseo_faq_lang');
        $checks[] = $this->checkTable('brandseo_block_settings');

        $checks[] = array(
            'label' => 'Uploads hero',
            'status' => is_writable(_PS_MODULE_DIR_.'brandseo/uploads/hero') ? 'ok' : 'error',
            'message' => _PS_MODULE_DIR_.'brandseo/uploads/hero',
        );

        $checks[] = array(
            'label' => 'Cache prod',
            'status' => is_writable(_PS_ROOT_DIR_.'/var/cache/prod') ? 'ok' : 'error',
            'message' => _PS_ROOT_DIR_.'/var/cache/prod',
        );

        $this->context->smarty->assign(array(
            'checks' => $checks,
            'back_url' => $this->context->link->getAdminLink('AdminBrandSeo'),
        ));

        $this->setTemplate('maintenance.tpl');
    }

    private function checkTable($table)
    {
        $exists = (bool) Db::getInstance()->getValue('
            SELECT COUNT(*)
            FROM information_schema.TABLES
            WHERE TABLE_SCHEMA = DATABASE()
            AND TABLE_NAME = "'._DB_PREFIX_.pSQL($table).'"
        ');

        return array(
            'label' => _DB_PREFIX_.$table,
            'status' => $exists ? 'ok' : 'error',
            'message' => $exists ? 'Existe' : 'No existe',
        );
    }
}
