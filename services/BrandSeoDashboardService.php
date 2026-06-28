<?php

require_once _PS_MODULE_DIR_.'brandseo/repositories/BrandSeoBrandRepository.php';
require_once _PS_MODULE_DIR_.'brandseo/services/BrandSeoHealthService.php';
require_once _PS_MODULE_DIR_.'brandseo/services/BrandSeoInsightService.php';

class BrandSeoDashboardService
{
    private $brandRepository;
    private $healthService;
    private $insightService;

    public function __construct()
    {
        $this->brandRepository = new BrandSeoBrandRepository();
        $this->healthService = new BrandSeoHealthService();
        $this->insightService = new BrandSeoInsightService();
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
            'health_total' => 0,
            'health_average' => 0,
        );

        foreach ($brands as &$brand) {
            $brand['health'] = $this->healthService->calculateFromDashboardRow($brand);

            $stats['brands_total']++;
            $stats['products_total'] += (int) $brand['total_products'];
            $stats['health_total'] += (int) $brand['health']['score'];

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
        unset($brand);

        if ($stats['brands_total'] > 0) {
            $stats['health_average'] = (int) round($stats['health_total'] / $stats['brands_total']);
        }

        return array(
            'brands' => $brands,
            'stats' => $stats,
            'insights' => $this->insightService->getInsights($stats, $brands),
        );
    }
}
