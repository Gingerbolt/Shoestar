<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Store.php";
    // 
    // $server = 'mysql:host=localhost:8889;dbname=shoestar_test';
    // $username = 'root';
    // $password = 'root';
    // $DB = new PDO($server, $username, $password);

    class StoreTest extends PHPUnit_Framework_TestCase
    {
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
    }
?>
