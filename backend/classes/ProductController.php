<?php

namespace Devikaze\Backend;

class ProductController
{
    private $productRepository;

    public function __construct($db)
    {
        $this->productRepository = new ProductRepository($db);
    }


    public function handleRequest()
    {
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                if (isset($_GET['sku'])) {
                    $exists = $this->checkSkuExists($_GET['sku']);
                    echo json_encode(['exists' => $exists]);
                } else {
                    $this->getAllProducts();
                }
                break;
            case 'POST':
                $this->createProduct();
                break;
            case 'DELETE':
                $this->deleteProduct();
                break;
            default:
                echo json_encode(['error' => 'Invalid request method']);
                break;
        }
    }

    private function checkSkuExists($sku)
    {
        $query = "SELECT COUNT(*) as count FROM products WHERE sku = ?";
        $stmt = $this->productRepository->getDB()->prepare($query);
        $stmt->bind_param('s', $sku);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['count'] > 0;
    }

    private function getAllProducts()
    {
        $products = $this->productRepository->getAllProducts();
        echo json_encode($products);
    }

    private function createProduct()
    {
        $input = json_decode(file_get_contents('php://input'), true);
        $sku = $input['sku'] ?? null;
        $name = $input['name'] ?? null;
        $price = $input['price'] ?? null;
        $type = $input['type'] ?? null;

        var_dump($input);
        if ($sku && $name && $price && $type) {

            $product = $this->createProductInstance($sku, $name, $price, $type, $input);
            var_dump($product);
            $this->productRepository->saveProduct($product);
            echo json_encode(['message' => 'Product created successfully']);
        } else {
            echo json_encode(['error' => 'Missing required fields']);
        }
    }

    private function deleteProduct()
    {
        $input = json_decode(file_get_contents('php://input'), true);
        $skus = $input['skus'] ?? null; // Retrieve SKUs from the input array

        if ($skus && is_array($skus)) { // Ensure SKUs is an array
            $this->productRepository->deleteProducts($skus);
            echo json_encode(['message' => 'Product deleted successfully']);
        } else {
            echo json_encode(['error' => 'SKU is required and must be an array']);
        }
    }

    private function createProductInstance($sku, $name, $price, $type, $input)
    {
        $productClass = 'Devikaze\\Backend\\' . $type . 'Product';
        if (class_exists($productClass)) {
            $reflectionClass = new \ReflectionClass($productClass);
            $product = $reflectionClass->newInstance($sku, $name, $price, $type);
            var_dump($input);
            $product->setAttributes($input);
            return $product;
        }
        throw new \Exception('Invalid product type');
    }
}
