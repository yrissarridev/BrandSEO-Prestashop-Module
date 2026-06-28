<?php

class BrandseoPingModuleFrontController extends ModuleFrontController
{
    public function initContent()
    {
        parent::initContent();

        header('Content-Type: application/json; charset=utf-8');

        echo json_encode(array(
            'module' => 'brandseo',
            'status' => 'ok',
            'version' => Module::getInstanceByName('brandseo')->version,
            'time' => date('c'),
        ));

        exit;
    }
}
