<?php
include('DB.php');

class Shop {
  private $connection;

  public function __construct() {
    $this->connection = (new DB())->getConnection();
  }

  public function addQuantity(int $productId, int $quantity) {
    if($this->hasProductById($productId)) {
      $stmt = $this->connection->prepare("UPDATE shops SET quantity = quantity + ? WHERE id = ?");
      $stmt->bindValue(1, $quantity, PDO::PARAM_INT);
      $stmt->bindValue(2, $productId, PDO::PARAM_INT);
  
      $stmt->execute([$quantity, $productId]);
    }
  }

  public function buyProduct(int $productId, int $quantity) {
    if($this->hasEnoughQuantity($productId, $quantity)){
      $stmt = $this->connection->prepare("UPDATE shops SET quantity = quantity - ? WHERE id = ?");
      $stmt->bindValue(1, $quantity, PDO::PARAM_INT);
      $stmt->bindValue(2, $productId, PDO::PARAM_INT);
  
      $stmt->execute([$quantity, $productId]);
    } else {
      echo "This quantity is too much or there is no such product in stock! \n";
    }
  }

  public function addNewProduct(string $name, int $quantity) {
    if(!$this->hasProductByName($name)) {
      $stmt = $this->connection->prepare("INSERT INTO shops (name, quantity) VALUES (?, ?)");
      $stmt->bindValue(1, $name, PDO::PARAM_STR);
      $stmt->bindValue(2, $quantity, PDO::PARAM_INT);
  
      $stmt->execute([$name, $quantity]);
    } else {
      echo "Already has this product! \n";
    }
  }

  private function hasProductById(int $productId) {
    $stmt = $this->connection->prepare("SELECT * FROM shops WHERE id = ?");
    $stmt->bindValue(1, $productId, PDO::PARAM_INT);

    $stmt->execute([$productId]);
    $product = $stmt->fetch();

    return $product;
  }

  private function hasProductByName(string $name) {
    $stmt = $this->connection->prepare("SELECT * FROM shops WHERE name = ?");
    $stmt->bindValue(1, $name, PDO::PARAM_STR);

    $stmt->execute([$name]);
    $product = $stmt->fetch();

    return $product;
  }

  private function hasEnoughQuantity(int $productId, int $quantity) {
    $product = $this->hasProductById($productId);

    if($product)
      return (int)$product["quantity"] >= $quantity;
    else
      return false;
  }
}

