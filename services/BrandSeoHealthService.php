<?php

class BrandSeoHealthService
{
    private $rules;

    public function __construct()
    {
        $this->rules = array(
            'has_landing' => array(
                'label' => 'Landing creada',
                'points' => 10,
                'group' => 'core',
            ),
            'has_hero_image' => array(
                'label' => 'Imagen Hero',
                'points' => 15,
                'group' => 'media',
            ),
            'has_meta_title' => array(
                'label' => 'Meta title',
                'points' => 15,
                'group' => 'seo',
            ),
            'has_meta_description' => array(
                'label' => 'Meta description',
                'points' => 15,
                'group' => 'seo',
            ),
            'has_h1' => array(
                'label' => 'H1',
                'points' => 10,
                'group' => 'seo',
            ),
            'has_excerpt' => array(
                'label' => 'Introducción',
                'points' => 15,
                'group' => 'content',
            ),
            'has_history' => array(
                'label' => 'Historia',
                'points' => 15,
                'group' => 'content',
            ),
            'has_website' => array(
                'label' => 'Web oficial',
                'points' => 5,
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
                'checklist' => array(
                    array('label' => 'Landing creada', 'status' => 'missing', 'icon' => '✗'),
                ),
                'groups' => array(
                    'core' => 0,
                    'seo' => 0,
                    'content' => 0,
                    'media' => 0,
                    'trust' => 0,
                ),
            );
        }

        $score = 0;
        $missing = array();
        $checklist = array();
        $groups = array(
            'core' => array('earned' => 0, 'total' => 0),
            'seo' => array('earned' => 0, 'total' => 0),
            'content' => array('earned' => 0, 'total' => 0),
            'media' => array('earned' => 0, 'total' => 0),
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
                $checklist[] = array(
                    'label' => $rule['label'],
                    'status' => 'ok',
                    'icon' => '✓',
                );
            } else {
                $missing[] = $rule['label'];
                $checklist[] = array(
                    'label' => $rule['label'],
                    'status' => 'missing',
                    'icon' => '✗',
                );
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
            'checklist' => $checklist,
            'groups' => $normalizedGroups,
        );
    }

    private function passesRule($ruleKey, array $brand)
    {
        switch ($ruleKey) {
            case 'has_landing':
                return !empty($brand['id_brandseo_landing']);

            case 'has_hero_image':
                return !empty($brand['has_hero_image']);

            case 'has_meta_title':
                return $this->lengthBetween(isset($brand['meta_title']) ? $brand['meta_title'] : '', 50, 60);

            case 'has_meta_description':
                return $this->lengthBetween(isset($brand['meta_description']) ? $brand['meta_description'] : '', 140, 160);

            case 'has_h1':
                return !empty($brand['h1']);

            case 'has_excerpt':
                return mb_strlen(trim(isset($brand['excerpt']) ? $brand['excerpt'] : ''), 'UTF-8') >= 120;

            case 'has_history':
                return !empty($brand['history']);

            case 'has_website':
                return !empty($brand['website']);

            default:
                return false;
        }
    }

    private function lengthBetween($value, $min, $max)
    {
        $length = mb_strlen(trim((string) $value), 'UTF-8');

        return $length >= $min && $length <= $max;
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
