<?php

require_once _PS_MODULE_DIR_.'brandseo/repositories/BrandSeoRelatedBrandRepository.php';

class BrandSeoRelatedBrandService
{
    private $repository;

    public function __construct()
    {
        $this->repository = new BrandSeoRelatedBrandRepository();
    }

    public function getRelatedBrands($excludeManufacturerId, $idLang)
    {
        $rows = $this->repository->getRelatedBrands($excludeManufacturerId, $idLang, 6);
        $base = Context::getContext()->link->getBaseLink();

        foreach ($rows as &$row) {
            $row['url'] = $base.'marcas/'.$row['slug'];
        }

        unset($row);

        return $rows;
    }
}
