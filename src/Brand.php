<?php
    class Brand
    {
        private $name;
        private $price_range;
        private $id;

        function __construct($_name, $_price_range = 0, $_id = null)
        {
            $this->name = $_name;
            $this->price_range = $_price_range;
            $this->id = $_id;
        }

        function getName()
        {
            return $this->name;
        }

        function setName($_new_name)
        {
            $this->name = $_new_name;
        }

        function getPriceRange()
        {
            return $this->price_range;
        }

        function setPriceRange($_new_price_range)
        {
            $this->price_range = $_new_price_range;
        }

        function save()
        {
            $executed = $GLOBALS['DB']->exec("INSERT INTO brands (name, price_range) VALUES ('{$this->getName()}', '{$this->getPriceRange()}');");
            if ($executed) {
                $this->id = $GLOBALS['DB']->lastInsertId();
                return true;
            } else {
                return false;
            }
        }

        function getId()
        {
            return $this->id;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM brands;");
        }

        static function getAll()
        {
          $returned_brands = $GLOBALS['DB']->query("SELECT * FROM brands;");
          $brands = array();
          foreach ($returned_brands as $brand) {
              $name = $brand['name'];
              $price_range = $brand['price_range'];
              $id = $brand['id'];
              $new_brand = new Brand($name, $price_range, $id);
              array_push($brands, $new_brand);
          }
          return $brands;
        }

        static function find($search_id)
        {
            $new_brand = null;
            $returned_brands = $GLOBALS['DB']->prepare("SELECT * FROM brands WHERE id = :id;");
            $returned_brands->bindParam(':id', $search_id, PDO::PARAM_STR);
            $returned_brands->execute();
            foreach ($returned_brands as $brand) {
                $name = $brand['name'];
                $price_range = $brand['price_range'];
                $id = $brand['id'];
                if ($id == $search_id) {
                    $new_brand = new Brand($name, $price_range, $id);
                }
            }
            return $new_brand;
        }

        function updateName($_new_name)
        {
            $executed = $GLOBALS['DB']->exec("UPDATE brands SET name = '{$_new_name}' WHERE id = {$this->getId()};");
            if ($executed) {
                $this->setName($_new_name);
                return true;
            } else {
                return false;
            }
        }

        function updatePriceRange($_new_price_range)
        {
            $executed = $GLOBALS['DB']->exec("UPDATE brands SET price_range = '{$_new_price_range}' WHERE id = {$this->getId()};");
            if ($executed) {
                $this->setPriceRange($_new_price_range);
                return true;
            } else {
                return false;
            }
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM brands WHERE id = {$this->getId()};");
        }

        function setStore($_store_id)
        {
            $executed = $GLOBALS['DB']->exec("INSERT INTO market_penetration (store_id, brand_id) VALUES ('{$_store_id}', '{$this->getId()}');");
            if ($executed) {
                return true;
            } else {
                return false;
            }
        }
    }
?>
