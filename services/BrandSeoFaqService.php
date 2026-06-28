<?php

require_once _PS_MODULE_DIR_.'brandseo/repositories/BrandSeoFaqRepository.php';

class BrandSeoFaqService
{
    private $repository;

    public function __construct()
    {
        $this->repository = new BrandSeoFaqRepository();
    }

    public function getFaqsForEditor($idLanding, $idLang)
    {
        return $this->repository->getByLanding($idLanding, $idLang);
    }
}
