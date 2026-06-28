<?php

class BrandseoRobotsModuleFrontController extends ModuleFrontController
{
    public function initContent()
    {
        parent::initContent();

        header('Content-Type: text/plain; charset=utf-8');

        $base = rtrim($this->context->link->getBaseLink(), '/');

        echo "User-agent: *\n";
        echo "Allow: /marcas\n";
        echo "Sitemap: ".$base."/brandseo-sitemap.xml\n";

        exit;
    }
}
