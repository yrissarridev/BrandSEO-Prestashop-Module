<?php

class BrandSeoBlockSetting extends ObjectModel
{
    public $id_brandseo_block_setting;
    public $id_brandseo_landing;
    public $block;
    public $settings_json;
    public $date_add;
    public $date_upd;

    public static $definition = array(
        'table' => 'brandseo_block_settings',
        'primary' => 'id_brandseo_block_setting',
        'fields' => array(
            'id_brandseo_landing' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId', 'required' => true),
            'block' => array('type' => self::TYPE_STRING, 'validate' => 'isGenericName', 'required' => true, 'size' => 64),
            'settings_json' => array('type' => self::TYPE_HTML, 'validate' => 'isCleanHtml', 'required' => true),
            'date_add' => array('type' => self::TYPE_DATE),
            'date_upd' => array('type' => self::TYPE_DATE),
        ),
    );
}
