<?php

namespace Devikaze\Backend;

class DVDProduct extends Product
{
    private $size;

    public function __construct($sku, $name, $price, $type)
    {
        parent::__construct($sku, $name, $price, $type);
    }

    public function getAttribute()
    {
        return $this->size . ' MB';
    }

    public function getKeyAttribute()
    {
        return 'size';
    }

    public function getSize()
    {
        return $this->size;
    }

    public function setAttributes(array $attributes)
    {
        $this->size = $attributes['size'] ?? null;
    }

    public function getType()
    {
        return 'DVD';
    }
}
