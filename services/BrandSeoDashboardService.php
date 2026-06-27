<?php

require_once _PS_MODULE_DIR_.'brandseo/repositories/BrandSeoBrandRepository.php';

class BrandSeoDashboardService
{
    private $brandRepository;

    public function __construct()
    {
        $this->brandRepository = new BrandSeoBrandRepository();
    }

    public function getDashboard()
    {
        $brands = $this->brandRepository->getDashboardBrands();

        $stats = array(
            'brands_total' => 0,
            'with_landing' => 0,
            'without_landing' => 0,
            'draft' => 0,
            'published' => 0,
            'noindex' => 0,
            'redirect_active' => 0,
            'products_total' => 0,
        );

        foreach ($brands as $brand) {
            $stats['brands_total']++;
            $stats['products_total'] += (int) $brand['total_products'];

            if (!empty($brand['id_brandseo_landing'])) {
                $stats['with_landing']++;

                if ($brand['status'] === 'published') {
                    $stats['published']++;
                } else {
                    $stats['draft']++;
                }

                if (!empty($brand['noindex'])) {
                    $stats['noindex']++;
                }

                if (!empty($brand['redirect_enabled'])) {
                    $stats['redirect_active']++;
                }
            } else {
                $stats['without_landing']++;
            }
        }

        return array(
            'brands' => $brands,
            'stats' => $stats,
        );
    }
}
