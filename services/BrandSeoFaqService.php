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

    public function getFaqsForFront($idLanding, $idLang)
    {
        $faqs = $this->repository->getByLanding($idLanding, $idLang);
        $filtered = array();

        foreach ($faqs as $faq) {
            if (!empty($faq['active']) && !empty($faq['question']) && !empty($faq['answer'])) {
                $filtered[] = $faq;
            }
        }

        return $filtered;
    }
}
