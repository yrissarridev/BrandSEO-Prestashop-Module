<?php

require_once _PS_MODULE_DIR_.'brandseo/controllers/front/landing.php';

class BrandseoPreviewModuleFrontController extends BrandseoLandingModuleFrontController
{
    protected $previewMode = true;

    public function init()
    {
        parent::init();

        // Preview is restricted to authenticated back-office employees only.
        $idEmployee = (int) $this->context->cookie->id_employee;
        if (!$idEmployee) {
            Tools::redirect('index.php?controller=404');
        }

        $employee = new Employee($idEmployee);
        if (!$employee->isLoggedBack()) {
            Tools::redirect('index.php?controller=404');
        }
    }
}
