<?php

require_once _PS_MODULE_DIR_.'brandseo/repositories/BrandSeoMediaRepository.php';

class BrandSeoMediaService
{
    private $repository;

    public function __construct()
    {
        $this->repository = new BrandSeoMediaRepository();
    }

    public function getMediaForBlock($idLanding, $block, $idLang)
    {
        return $this->repository->getByLandingAndBlock($idLanding, $block, $idLang);
    }
}
