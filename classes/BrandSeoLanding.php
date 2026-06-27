<?php

class BrandSeoLanding extends ObjectModel
{
    public $id_brandseo_landing;
    public $id_manufacturer;
    public $type = 'brand';
    public $slug;
    public $status = 'draft';
    public $active = 0;
    public $noindex = 1;
    public $redirect_enabled = 0;

    public $hero_image;
    public $logo_image;
    public $latitude;
    public $longitude;
    public $website;
    public $instagram;
    public $facebook;
    public $youtube;
    public $country;
    public $region;

    public $date_add;
    public $date_upd;

    public $title;
    public $h1;
    public $meta_title;
    public $meta_description;
    public $excerpt;
    public $history;
    public $philosophy;
    public $store_opinion;

    public static $definition = array(
        'table' => 'brandseo_landing',
        'primary' => 'id_brandseo_landing',
        'multilang' => true,
        'fields' => array(
            'id_manufacturer' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
            'type' => array('type' => self::TYPE_STRING, 'validate' => 'isGenericName', 'size' => 32),
            'slug' => array('type' => self::TYPE_STRING, 'validate' => 'isLinkRewrite', 'required' => true, 'size' => 255),
            'status' => array('type' => self::TYPE_STRING, 'validate' => 'isGenericName', 'size' => 32),
            'active' => array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
            'noindex' => array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
            'redirect_enabled' => array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),

            'hero_image' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 255),
            'logo_image' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 255),
            'latitude' => array('type' => self::TYPE_FLOAT, 'validate' => 'isFloat'),
            'longitude' => array('type' => self::TYPE_FLOAT, 'validate' => 'isFloat'),
            'website' => array('type' => self::TYPE_STRING, 'validate' => 'isUrl', 'size' => 255),
            'instagram' => array('type' => self::TYPE_STRING, 'validate' => 'isUrl', 'size' => 255),
            'facebook' => array('type' => self::TYPE_STRING, 'validate' => 'isUrl', 'size' => 255),
            'youtube' => array('type' => self::TYPE_STRING, 'validate' => 'isUrl', 'size' => 255),
            'country' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 128),
            'region' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 128),

            'date_add' => array('type' => self::TYPE_DATE),
            'date_upd' => array('type' => self::TYPE_DATE),

            'title' => array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isCleanHtml', 'size' => 255),
            'h1' => array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isCleanHtml', 'size' => 255),
            'meta_title' => array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isCleanHtml', 'size' => 255),
            'meta_description' => array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isCleanHtml', 'size' => 512),
            'excerpt' => array('type' => self::TYPE_HTML, 'lang' => true, 'validate' => 'isCleanHtml'),
            'history' => array('type' => self::TYPE_HTML, 'lang' => true, 'validate' => 'isCleanHtml'),
            'philosophy' => array('type' => self::TYPE_HTML, 'lang' => true, 'validate' => 'isCleanHtml'),
            'store_opinion' => array('type' => self::TYPE_HTML, 'lang' => true, 'validate' => 'isCleanHtml'),
        ),
    );

    public static function getIdByManufacturer($idManufacturer)
    {
        return (int) Db::getInstance()->getValue(
            'SELECT id_brandseo_landing
             FROM `'._DB_PREFIX_.'brandseo_landing`
             WHERE id_manufacturer = '.(int) $idManufacturer.'
             AND type = "brand"'
        );
    }
}
