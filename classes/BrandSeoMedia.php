<?php

class BrandSeoMedia extends ObjectModel
{
    public $id_brandseo_media;
    public $id_brandseo_landing;
    public $block;
    public $type = 'image';
    public $path;
    public $mime;
    public $width;
    public $height;
    public $filesize;
    public $position = 0;
    public $active = 1;
    public $date_add;
    public $date_upd;

    public $title;
    public $alt;
    public $description;

    public static $definition = array(
        'table' => 'brandseo_media',
        'primary' => 'id_brandseo_media',
        'multilang' => true,
        'fields' => array(
            'id_brandseo_landing' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId', 'required' => true),
            'block' => array('type' => self::TYPE_STRING, 'validate' => 'isGenericName', 'required' => true, 'size' => 64),
            'type' => array('type' => self::TYPE_STRING, 'validate' => 'isGenericName', 'required' => true, 'size' => 64),
            'path' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 255),
            'mime' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 128),
            'width' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt'),
            'height' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt'),
            'filesize' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt'),
            'position' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt'),
            'active' => array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
            'date_add' => array('type' => self::TYPE_DATE),
            'date_upd' => array('type' => self::TYPE_DATE),

            'title' => array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isCleanHtml', 'size' => 255),
            'alt' => array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isCleanHtml', 'size' => 255),
            'description' => array('type' => self::TYPE_HTML, 'lang' => true, 'validate' => 'isCleanHtml'),
        ),
    );
}
