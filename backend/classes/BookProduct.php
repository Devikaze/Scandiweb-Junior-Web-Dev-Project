<?php

namespace Devikaze\Backend;

class BookProduct extends Product
{
    private $weight;

    public function __construct($sku, $name, $price, $type)
    {
        parent::__construct($sku, $name, $price, $type);
    }

    public function getAttribute()
    {
        return $this->weight . ' Kg';
    }

    public function getKeyAttribute()
    {
        return 'Weight';
    }

    public function getWeight()
    {
        return $this->weight;
    }

    public function setAttributes(array $attributes)
    {
        $this->weight = $attributes['weight'] ?? null;
    }

    public function getType()
    {
        return 'Book';
    }
}
