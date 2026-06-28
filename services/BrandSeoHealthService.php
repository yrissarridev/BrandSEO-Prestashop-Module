<?php

class BrandSeoHealthService
{
    private $rules;

    public function __construct()
    {
        $this->rules = array(
            'has_landing' => array(
                'label' => 'Landing creada',
                'points' => 15,
                'group' => 'core',
            ),
            'has_meta_title' => array(
                'label' => 'Meta title',
                'points' => 10,
                'group' => 'seo',
            ),
            'has_meta_description' => array(
                'label' => 'Meta description',
                'points' => 10,
                'group' => 'seo',
            ),
            'has_h1' => array(
                'label' => 'H1',
                'points' => 10,
                'group' => 'seo',
            ),
            'has_excerpt' => array(
                'label' => 'Resumen',
                'points' => 10,
                'group' => 'content',
            ),
            'has_history' => array(
                'label' => 'Historia',
                'points' => 20,
                'group' => 'content',
            ),
            'has_philosophy' => array(
                'label' => 'Filosofía',
                'points' => 10,
                'group' => 'content',
            ),
            'has_store_opinion' => array(
                'label' => 'Opinión de la tienda',
                'points' => 10,
                'group' => 'content',
            ),
            'has_website' => array(
                'label' => 'Web oficial',
                'points' => 5,
                'group' => 'trust',
            ),
            'has_location' => array(
                'label' => 'Ubicación',
                'points' => 10,
                'group' => 'trust',
            ),
        );
    }

    public function calculateFromDashboardRow(array $brand)
    {
        if (empty($brand['id_brandseo_landing'])) {
            return array(
                'score' => 0,
                'label' => 'Sin iniciar',
                'status' => 'empty',
                'missing' => array('Landing creada'),
                'groups' => array(
                    'seo' => 0,
                    'content' => 0,
                    'trust' => 0,
                ),
            );
        }

        $score = 0;
        $missing = array();
        $groups = array(
            'core' => array('earned' => 0, 'total' => 0),
            'seo' => array('earned' => 0, 'total' => 0),
            'content' => array('earned' => 0, 'total' => 0),
            'trust' => array('earned' => 0, 'total' => 0),
        );

        foreach ($this->rules as $ruleKey => $rule) {
            $passed = $this->passesRule($ruleKey, $brand);
            $points = (int) $rule['points'];
            $group = $rule['group'];

            if (!isset($groups[$group])) {
                $groups[$group] = array('earned' => 0, 'total' => 0);
            }

            $groups[$group]['total'] += $points;

            if ($passed) {
                $score += $points;
                $groups[$group]['earned'] += $points;
            } else {
                $missing[] = $rule['label'];
            }
        }

        $normalizedGroups = array();

        foreach ($groups as $group => $values) {
            $normalizedGroups[$group] = $values['total'] > 0
                ? (int) round(($values['earned'] / $values['total']) * 100)
                : 0;
        }

        return array(
            'score' => min(100, max(0, (int) $score)),
            'label' => $this->getScoreLabel($score),
            'status' => $this->getScoreStatus($score),
            'missing' => $missing,
            'groups' => $normalizedGroups,
        );
    }

    private function passesRule($ruleKey, array $brand)
    {
        switch ($ruleKey) {
            case 'has_landing':
                return !empty($brand['id_brandseo_landing']);

            case 'has_meta_title':
                return !empty($brand['meta_title']);

            case 'has_meta_description':
                return !empty($brand['meta_description']);

            case 'has_h1':
                return !empty($brand['h1']);

            case 'has_excerpt':
                return !empty($brand['excerpt']);

            case 'has_history':
                return !empty($brand['history']);

            case 'has_philosophy':
                return !empty($brand['philosophy']);

            case 'has_store_opinion':
                return !empty($brand['store_opinion']);

            case 'has_website':
                return !empty($brand['website']);

            case 'has_location':
                return !empty($brand['country']) || !empty($brand['region']);

            default:
                return false;
        }
    }

    private function getScoreLabel($score)
    {
        if ($score >= 85) {
            return 'Excelente';
        }

        if ($score >= 60) {
            return 'Mejorable';
        }

        if ($score > 0) {
            return 'Incompleta';
        }

        return 'Sin iniciar';
    }

    private function getScoreStatus($score)
    {
        if ($score >= 85) {
            return 'success';
        }

        if ($score >= 60) {
            return 'warning';
        }

        if ($score > 0) {
            return 'danger';
        }

        return 'empty';
    }
}
