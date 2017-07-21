<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

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
            $name_id = "Callus Shoes";
            $location_id = "Lametown";
            $id_id = 1;
            $new_store_id = new Store($name_id, $location_id, $id_id);

            $result_id = $new_store_id->getId();

            $this->assertEquals($id_id, $result_id);
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
    }
?>
