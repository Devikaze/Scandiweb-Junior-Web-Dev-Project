<?php

namespace Devikaze\Backend;

class FurnitureProduct extends Product
{
    private $height;
    private $width;
    private $length;

    public function __construct($sku, $name, $price, $type)
    {
        parent::__construct($sku, $name, $price, $type);
    }

    public function getAttribute()
    {
        return $this->height . 'x' . $this->width . 'x' . $this->length;
    }

    public function getKeyAttribute()
    {
        return 'Dimensions';
    }

    public function getHeight()
    {
        return $this->height;
    }

    public function getWidth()
    {
        return $this->width;
    }

    public function getLength()
    {
        return $this->length;
    }

    public function setAttributes(array $attributes)
    {
        $this->height = $attributes['height'] ?? null;
        $this->width = $attributes['width'] ?? null;
        $this->length = $attributes['length'] ?? null;
    }

    public function getType()
    {
        return 'Furniture';
    }
}
