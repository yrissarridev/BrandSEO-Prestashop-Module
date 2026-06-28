<?php

class BrandSeoTabInstaller
{
    public static function install($moduleName)
    {
        $idParent = (int) Tab::getIdFromClassName('AdminCatalog');

        if (!self::installTab($moduleName, 'AdminBrandSeo', 'BrandSEO', $idParent, 1)) {
            return false;
        }

        $idBrandSeoTab = (int) Tab::getIdFromClassName('AdminBrandSeo');

        return self::installTab($moduleName, 'AdminBrandSeoEdit', 'Editar BrandSEO', $idBrandSeoTab, 1);
    }

    public static function uninstall()
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

    private static function installTab($moduleName, $className, $name, $idParent, $active)
    {
        $idExisting = (int) Tab::getIdFromClassName($className);

        if ($idExisting) {
            $tab = new Tab($idExisting);
            $tab->active = (int) $active;
            $tab->module = $moduleName;
            $tab->id_parent = (int) $idParent;

            foreach (Language::getLanguages(true) as $lang) {
                $tab->name[(int) $lang['id_lang']] = $name;
            }

            return $tab->update();
        }

        $tab = new Tab();
        $tab->active = (int) $active;
        $tab->class_name = $className;
        $tab->module = $moduleName;
        $tab->id_parent = (int) $idParent;

        foreach (Language::getLanguages(true) as $lang) {
            $tab->name[(int) $lang['id_lang']] = $name;
        }

        return $tab->add();
    }
}
