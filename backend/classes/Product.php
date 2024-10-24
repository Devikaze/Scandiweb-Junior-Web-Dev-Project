<?php

namespace Devikaze\Backend;

abstract class Product
{
    protected $sku;
    protected $name;
    protected $price;
    protected $type;

    public function __construct($sku, $name, $price, $type)
    {
        $this->sku = $sku;
        $this->name = $name;
        $this->price = $price;
        $this->type = $type;
    }

    abstract public function getAttribute();
    abstract public function setAttributes(array $attributes);
    abstract public function getKeyAttribute();
    abstract public function getType();


    public function getSku()
    {
        return $this->sku;
    }

    public function getName()
    {
        return $this->name;
    }


    public function getPrice()
    {
        return $this->price;
    }
}
