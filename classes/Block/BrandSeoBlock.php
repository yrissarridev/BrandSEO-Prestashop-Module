<?php

class BrandSeoBlock
{
    private $type;
    private $label;
    private $description;
    private $icon;
    private $enabled;

    public function __construct($type, $label, $description, $icon, $enabled = true)
    {
        $this->type = $type;
        $this->label = $label;
        $this->description = $description;
        $this->icon = $icon;
        $this->enabled = (bool) $enabled;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getLabel()
    {
        return $this->label;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getIcon()
    {
        return $this->icon;
    }

    public function isEnabled()
    {
        return $this->enabled;
    }

    public function toArray()
    {
        return array(
            'type' => $this->type,
            'label' => $this->label,
            'description' => $this->description,
            'icon' => $this->icon,
            'enabled' => $this->enabled,
        );
    }
}
