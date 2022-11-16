<?php

class KaracaProducts
{
    private $user;

    public function setUser($user)
    {
        $this->user = $user;
    }

    private function message()
    {
        $message = "This dataset was provided by Karaca for " . $this->user->name . " company.";
        return $message;
    }

    public function listProducts()
    {
        $products = json_decode(file_get_contents('products.json'));

        $xml = new SimpleXMLElement('<xml/>');
        $info = $xml->addChild('info');

        $info->addChild('description', $this->message());

        $productsChild = $xml->addChild('products');

        foreach ($products as $product) {
            $productElement = $productsChild->addChild('product');

            $productElement->addAttribute('id', $product->id);
            $productElement->addChild('name', $product->name);
            $productElement->addChild('price', $product->price);
            $productElement->addChild('category', $product->category);
        }
        return $xml;
    }

}
?>