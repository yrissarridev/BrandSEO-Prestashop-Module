<?php

require_once _PS_MODULE_DIR_.'brandseo/classes/BrandSeoBlockSetting.php';

class BrandSeoBlockSettingsRepository
{
    public function get($idLanding, $block)
    {
        $row = Db::getInstance()->getRow('
            SELECT settings_json
            FROM `'._DB_PREFIX_.'brandseo_block_settings`
            WHERE id_brandseo_landing = '.(int) $idLanding.'
            AND block = "'.pSQL($block).'"
        ');

        if (!$row || empty($row['settings_json'])) {
            return array();
        }

        $settings = json_decode($row['settings_json'], true);

        return is_array($settings) ? $settings : array();
    }

    public function save($idLanding, $block, array $settings)
    {
        $idExisting = (int) Db::getInstance()->getValue('
            SELECT id_brandseo_block_setting
            FROM `'._DB_PREFIX_.'brandseo_block_settings`
            WHERE id_brandseo_landing = '.(int) $idLanding.'
            AND block = "'.pSQL($block).'"
        ');

        $json = json_encode($settings);

        if ($idExisting) {
            $setting = new BrandSeoBlockSetting($idExisting);
        } else {
            $setting = new BrandSeoBlockSetting();
            $setting->id_brandseo_landing = (int) $idLanding;
            $setting->block = pSQL($block);
        }

        $setting->settings_json = $json;

        return $idExisting ? $setting->update() : $setting->add();
    }
}
