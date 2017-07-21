<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Brand.php";
    require_once "src/Store.php";

    $server = 'mysql:host=localhost:8889;dbname=shoestar_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class StoreTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Store::deleteAll();
            Brand::deleteAll();
            $GLOBALS['DB']->exec("DELETE FROM market_penetration;");
        }
        function testGetName()
        {
            $name = "The Shoe Store";
            $new_store = new Store($name);

            $result = $new_store->getName();

            $this->assertEquals($name, $result);
        }

        function testSetName()
        {
            $name = "The Shoe Store Across the Way";
            $new_store = new Store($name);
            $new_name = "Border's Shoes";

            $new_store->setName($new_name);
            $result = $new_store->getName();

            $this->assertEquals($new_name, $result);
        }

        function testGetLocation()
        {
            $name = "The Shoeore";
            $location = "Portland";
            $new_store = new Store($name, $location);

            $result = $new_store->getLocation();

            $this->assertEquals($location, $result);
        }

        function testSetLocation()
        {
            $name = "The Shoe Store Stross the Way";
            $location = "Newberg";
            $new_store = new Store($name, $location);
            $new_location = "Border's Shoes on Ice";

            $new_store->setLocation($new_location);
            $result = $new_store->getLocation();

            $this->assertEquals($new_location, $result);
        }

        function testSave()
        {
            $name = "The Doram Shoe";
            $location = "Newberg";
            $new_store = new Store($name, $location);

            $result = $new_store->save();

            $this->assertTrue($result, "Store save attempt unsuccessful");
        }

        function testGetId()
        {
            $name = "Callus Shoes";
            $location = "Lametown";
            $new_store = new Store($name, $location);
            $new_store->save();

            $result = $new_store->getId();

            $this->assertTrue(is_numeric($result));
        }

        function testDeleteAll()
        {
            $name = "Shazmo Shoes";
            $new_store = new Store($name);
            $new_store->save();
            $name_2 = "Galactic Zapatos";
            $new_store_2 = new Store($name_2);
            $new_store_2->save();

            Store::deleteAll();
            $result = Store::getAll();

            $this->assertEquals([], $result);
        }

        function testGetAll()
        {
            $name = "Big Gambino";
            $location = "Feet of Gambeezy";
            $new_store = new Store($name, $location);
            $new_store->save();

            $name_2 = "The Diver";
            $location_2 = "The Deep";
            $new_store_2 = new Store($name_2, $location_2);
            $new_store_2->save();
            $result = Store::getAll();

            $this->assertEquals([$new_store, $new_store_2], $result);
        }

        function testFind()
        {
            $name = "Store 1";
            $new_store = new Store($name);
            $new_store->save();
            $name_2 = "Store 2";
            $new_store_2 = new Store($name_2);
            $new_store_2->save();
            $store_id = $new_store->getId();

            $result= Store::find($store_id);

            $this->assertEquals($new_store, $result);
        }

        function testUpdateName()
        {
            $name = "Rathos Shoes";
            $new_store = new Store($name);
            $new_store->save();
            $new_name = "Zapatoses";
            $store_id = $new_store->getId();

            $new_store->updateName($new_name);
            $found_store = Store::find($store_id);
            $result = $found_store->getName();

            $this->assertEquals($new_name, $result);
        }

        function testUpdateLocation()
        {
            $name = "Hufflepuff";
            $location = "Hogwarts";
            $new_store = new Store($name, $location);
            $new_store->save();
            $new_location = "London";
            $store_id = $new_store->getId();

            $new_store->updateLocation($new_location);
            $found_store = Store::find($store_id);
            $result = $found_store->getLocation();

            $this->assertEquals($new_location, $result);
        }

        function testDelete()
        {
            $name = "Ravenclaw";
            $new_store = new Store($name);
            $new_store->save();
            $name_2 = "Shmaegel Shoe";
            $new_store_2 = new Store($name_2);
            $new_store_2->save();

            $new_store->delete();
            $result = Store::getAll();

            $this->assertEquals([$new_store_2], $result);
        }

        function testGetBrands()
        {
            $name = "The content";
            $new_store = new Store($name);
            $new_store->save();

            $brand_name = "fransisco's";
            $price_range = 2;
            $new_brand = new Brand($brand_name, $price_range);
            $new_brand->save();
            var_dump($new_brand->getId());

            $new_store->setBrand($new_brand->getId());
            $result = $new_store->getBrands();

            $this->assertEquals([$new_brand], $result);
        }
    }
?>
