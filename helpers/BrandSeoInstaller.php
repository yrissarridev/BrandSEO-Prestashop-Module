<?php

class BrandSeoInstaller
{
    public static function installDatabase()
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



        $queries[] = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'brandseo_media` (
            `id_brandseo_media` INT UNSIGNED NOT NULL AUTO_INCREMENT,
            `id_brandseo_landing` INT UNSIGNED NOT NULL,
            `block` VARCHAR(64) NOT NULL,
            `type` VARCHAR(64) NOT NULL DEFAULT "image",
            `path` VARCHAR(255) DEFAULT NULL,
            `mime` VARCHAR(128) DEFAULT NULL,
            `width` INT UNSIGNED DEFAULT NULL,
            `height` INT UNSIGNED DEFAULT NULL,
            `filesize` INT UNSIGNED DEFAULT NULL,
            `position` INT UNSIGNED NOT NULL DEFAULT 0,
            `active` TINYINT(1) NOT NULL DEFAULT 1,
            `date_add` DATETIME NOT NULL,
            `date_upd` DATETIME NOT NULL,
            PRIMARY KEY (`id_brandseo_media`),
            KEY `idx_landing` (`id_brandseo_landing`),
            KEY `idx_block` (`block`),
            KEY `idx_type` (`type`),
            KEY `idx_position` (`position`)
        ) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8;';

        $queries[] = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'brandseo_media_lang` (
            `id_brandseo_media` INT UNSIGNED NOT NULL,
            `id_lang` INT UNSIGNED NOT NULL,
            `title` VARCHAR(255) DEFAULT NULL,
            `alt` VARCHAR(255) DEFAULT NULL,
            `description` TEXT DEFAULT NULL,
            PRIMARY KEY (`id_brandseo_media`, `id_lang`)
        ) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8;';

        $queries[] = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'brandseo_faq` (
            `id_brandseo_faq` INT UNSIGNED NOT NULL AUTO_INCREMENT,
            `id_brandseo_landing` INT UNSIGNED NOT NULL,
            `position` INT UNSIGNED NOT NULL DEFAULT 0,
            `active` TINYINT(1) NOT NULL DEFAULT 1,
            `date_add` DATETIME NOT NULL,
            `date_upd` DATETIME NOT NULL,
            PRIMARY KEY (`id_brandseo_faq`),
            KEY `idx_landing` (`id_brandseo_landing`),
            KEY `idx_position` (`position`)
        ) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8;';

        $queries[] = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'brandseo_faq_lang` (
            `id_brandseo_faq` INT UNSIGNED NOT NULL,
            `id_lang` INT UNSIGNED NOT NULL,
            `question` VARCHAR(255) DEFAULT NULL,
            `answer` TEXT DEFAULT NULL,
            PRIMARY KEY (`id_brandseo_faq`, `id_lang`)
        ) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8;';

        foreach ($queries as $query) {
            if (!Db::getInstance()->execute($query)) {
                return false;
            }
        }

        return true;
    }

    public static function uninstallDatabase()
    {
        Db::getInstance()->execute('DROP TABLE IF EXISTS `'._DB_PREFIX_.'brandseo_media_lang`');
        Db::getInstance()->execute('DROP TABLE IF EXISTS `'._DB_PREFIX_.'brandseo_media`');
        Db::getInstance()->execute('DROP TABLE IF EXISTS `'._DB_PREFIX_.'brandseo_faq_lang`');
        Db::getInstance()->execute('DROP TABLE IF EXISTS `'._DB_PREFIX_.'brandseo_faq`');
        Db::getInstance()->execute('DROP TABLE IF EXISTS `'._DB_PREFIX_.'brandseo_landing_lang`');
        Db::getInstance()->execute('DROP TABLE IF EXISTS `'._DB_PREFIX_.'brandseo_landing`');

        return true;
    }
}
