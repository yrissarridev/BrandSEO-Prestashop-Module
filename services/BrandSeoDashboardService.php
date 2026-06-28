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
            $brand['priority'] = $this->calculatePriority($brand);

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
    private function calculatePriority(array $brand)
    {
        $products = (int) $brand['total_products'];
        $health = isset($brand['health']['score']) ? (int) $brand['health']['score'] : 0;

        if ($products <= 0) {
            return array(
                'score' => 0,
                'label' => 'Sin prioridad',
                'status' => 'empty',
            );
        }

        $productWeight = min(100, $products);
        $healthGap = 100 - $health;
        $score = (int) round(($productWeight * 0.65) + ($healthGap * 0.35));

        if ($score >= 75) {
            $label = 'Muy alta';
            $status = 'danger';
        } elseif ($score >= 50) {
            $label = 'Alta';
            $status = 'warning';
        } elseif ($score >= 25) {
            $label = 'Media';
            $status = 'info';
        } else {
            $label = 'Baja';
            $status = 'success';
        }

        return array(
            'score' => $score,
            'label' => $label,
            'status' => $status,
        );
    }

}
