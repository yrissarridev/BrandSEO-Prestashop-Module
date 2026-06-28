<?php

require_once _PS_MODULE_DIR_.'brandseo/repositories/BrandSeoBlockSettingsRepository.php';

class BrandSeoBlockSettingsService
{
    private $repository;

    public function __construct()
    {
        $this->repository = new BrandSeoBlockSettingsRepository();
    }

    public function getSettings($idLanding, $block)
    {
        $settings = $this->repository->get($idLanding, $block);

        if ($block === 'hero') {
            return array_merge($this->getDefaultHeroSettings(), $settings);
        }

        return $settings;
    }

    public function saveSettings($idLanding, $block, array $settings)
    {
        return $this->repository->save($idLanding, $block, $settings);
    }

    private function getDefaultHeroSettings()
    {
        return array(
            'height' => 'medium',
            'align' => 'center',
            'overlay' => 48,
        );
    }
}
