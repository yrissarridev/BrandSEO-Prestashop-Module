<?php

class BrandSeoInsightService
{
    public function getInsights(array $stats, array $brands)
    {
        $insights = array();

        if ((int) $stats['without_landing'] > 0) {
            $insights[] = array(
                'type' => 'danger',
                'priority' => 100,
                'icon' => 'icon-plus',
                'title' => (int) $stats['without_landing'].' marcas sin landing',
                'description' => 'Empieza creando landings SEO para las marcas con más productos.',
                'action_label' => 'Ver marcas pendientes',
                'filter' => 'without_landing',
            );
        }

        if ((int) $stats['draft'] > 0) {
            $insights[] = array(
                'type' => 'warning',
                'priority' => 90,
                'icon' => 'icon-pencil',
                'title' => (int) $stats['draft'].' borrador pendiente',
                'description' => 'Hay landings creadas que todavía necesitan contenido antes de publicarse.',
                'action_label' => 'Completar borradores',
                'filter' => 'draft',
            );
        }

        if ((int) $stats['noindex'] > 0) {
            $insights[] = array(
                'type' => 'info',
                'priority' => 80,
                'icon' => 'icon-eye-close',
                'title' => (int) $stats['noindex'].' landing con noindex',
                'description' => 'Revisa si alguna landing ya está lista para ser indexada.',
                'action_label' => 'Revisar noindex',
                'filter' => 'noindex',
            );
        }

        $lowHealth = $this->countLowHealthBrands($brands);

        if ($lowHealth > 0) {
            $insights[] = array(
                'type' => 'warning',
                'priority' => 70,
                'icon' => 'icon-warning',
                'title' => $lowHealth.' marca con Health bajo',
                'description' => 'Prioriza las marcas con más productos y menor calidad editorial.',
                'action_label' => 'Ver Health bajo',
                'filter' => 'low_health',
            );
        }

        usort($insights, array($this, 'sortByPriority'));

        return $insights;
    }

    private function countLowHealthBrands(array $brands)
    {
        $count = 0;

        foreach ($brands as $brand) {
            if (!empty($brand['id_brandseo_landing'])
                && isset($brand['health']['score'])
                && (int) $brand['health']['score'] > 0
                && (int) $brand['health']['score'] < 60) {
                $count++;
            }
        }

        return $count;
    }

    private function sortByPriority($a, $b)
    {
        return (int) $b['priority'] - (int) $a['priority'];
    }
}
