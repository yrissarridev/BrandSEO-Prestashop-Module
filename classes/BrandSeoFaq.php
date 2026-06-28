<?php

class BrandSeoFaq extends ObjectModel
{
    public $id_brandseo_faq;
    public $id_brandseo_landing;
    public $position = 0;
    public $active = 1;
    public $date_add;
    public $date_upd;

    public $question;
    public $answer;

    public static $definition = array(
        'table' => 'brandseo_faq',
        'primary' => 'id_brandseo_faq',
        'multilang' => true,
        'fields' => array(
            'id_brandseo_landing' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId', 'required' => true),
            'position' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt'),
            'active' => array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
            'date_add' => array('type' => self::TYPE_DATE),
            'date_upd' => array('type' => self::TYPE_DATE),

            'question' => array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isCleanHtml', 'size' => 255),
            'answer' => array('type' => self::TYPE_HTML, 'lang' => true, 'validate' => 'isCleanHtml'),
        ),
    );
}
