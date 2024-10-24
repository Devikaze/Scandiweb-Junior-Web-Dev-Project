<?php

namespace Devikaze\Backend;

class ProductRepository
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getDB()
    {
        return $this->db;
    }

    public function getAllProducts()
    {
        $query = "SELECT sku, name, price, type, size, weight, height, width, length FROM products";
        $result = $this->db->query($query);
        $products = array();

        while ($row = $result->fetch_assoc()) {
            $productClass = 'Devikaze\\Backend\\' . $row['type'] . 'Product';
            if (class_exists($productClass)) {
                $product = new $productClass($row['sku'], $row['name'], $row['price'], $row['type']);
                $product->setAttributes($row);
                $products[] = [
                    'sku' => $product->getSku(),
                    'name' => $product->getName(),
                    'price' => $product->getPrice(),
                    $product->getKeyAttribute() => $product->getAttribute()
                ];
            }
        }

        return $products;
    }

    public function saveProduct($product)
    {
        $query = "INSERT INTO products (sku, name, price, type, size, weight, height, width, length) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $sku = $product->getSku();
        $name = $product->getName();
        $price = $product->getPrice();
        $type = $product->getType();
        $size = $product instanceof DVDProduct ? $product->getSize() : null;
        $weight = $product instanceof BookProduct ? $product->getWeight() : null;
        $height = $product instanceof FurnitureProduct ? $product->getHeight() : null;
        $width = $product instanceof FurnitureProduct ? $product->getWidth() : null;
        $length = $product instanceof FurnitureProduct ? $product->getLength() : null;

        $stmt->bind_param(
            'ssssiiiii',
            $sku,
            $name,
            $price,
            $type,
            $size,
            $weight,
            $height,
            $width,
            $length
        );

        $stmt->execute();
    }

    public function deleteProducts(array $skus)
    {
        $query = "DELETE FROM products WHERE sku IN (" . implode(',', array_fill(0, count($skus), '?')) . ")";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param(str_repeat('s', count($skus)), ...$skus);
        $stmt->execute();
    }
}
