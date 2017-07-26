<?php

    class Store
    {
        private $name;
        private $location;
        private $id;

        function __construct($_name, $_location = null, $_id = null)
        {
            $this->name = $_name;
            $this->location = $_location;
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

        function getLocation()
        {
            return $this->location;
        }

        function setLocation($_new_location)
        {
            $this->location = $_new_location;
        }

        function save()
        {
            $executed = $GLOBALS['DB']->exec("INSERT INTO stores (name, location) VALUES ('{$this->getName()}', '{$this->getLocation()}');");
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
            $GLOBALS['DB']->exec("DELETE FROM stores;");
        }

        static function getAll()
        {
          $returned_stores = $GLOBALS['DB']->query("SELECT * FROM stores;");
          $stores = array();
          foreach ($returned_stores as $store) {
              $name = $store['name'];
              $location = $store['location'];
              $id = $store['id'];
              $new_store = new Store($name, $location, $id);
              array_push($stores, $new_store);
          }
          return $stores;
        }

        static function find($search_id)
        {
            $new_store = null;
            $returned_stores = $GLOBALS['DB']->prepare("SELECT * FROM stores WHERE id = :id;");
            $returned_stores->bindParam(':id', $search_id, PDO::PARAM_STR);
            $returned_stores->execute();
            foreach ($returned_stores as $store) {
                $name = $store['name'];
                $location = $store['location'];
                $id = $store['id'];
                if ($id == $search_id) {
                    $new_store = new Store($name, $location, $id);
                }
            }
            return $new_store;
        }

        function updateName($_new_name)
        {
            $executed = $GLOBALS['DB']->exec("UPDATE stores SET name = '{$_new_name}' WHERE id = {$this->getId()};");
            if ($executed) {
                $this->setName($_new_name);
                return true;
            } else {
                return false;
            }
        }

        function updateLocation($_new_location)
        {
            $executed = $GLOBALS['DB']->exec("UPDATE stores SET location = '{$_new_location}' WHERE id = {$this->getId()};");
            if ($executed) {
                $this->setLocation($_new_location);
                return true;
            } else {
                return false;
            }
        }

        function delete()
        {
            $executed = $GLOBALS['DB']->exec("DELETE FROM stores WHERE id = {$this->getId()};");
            if(!$executed)
            {
              return false;
            } else {
              $GLOBALS['DB']->exec("DELETE FROM market_penetration WHERE store_id = {$this->getId()};");
            }
        }

        function getBrands()
        {
            $returned_brands = $GLOBALS['DB']->query("SELECT brands.* FROM stores JOIN market_penetration ON (market_penetration.store_id = stores.id) JOIN brands ON (brands.id = market_penetration.brand_id) WHERE stores.id = {$this->getID()};");
            $brands = array();
            foreach($returned_brands as $brand) {
                $name = $brand['name'];
                $price_range = $brand['price_range'];
                $id = $brand['id'];
                $new_brand = new Brand($name, $price_range, $id);
                array_push($brands, $new_brand);
            }
            return $brands;
        }

        function setBrand($new_brand)
        {
            $executed = $GLOBALS['DB']->exec("INSERT INTO market_penetration (store_id, brand_id) VALUES ({$this->getId()}, {$new_brand->getId()})");
            if ($executed) {
                return true;
            } else {
                return false;
            }
        }
    }
?>
