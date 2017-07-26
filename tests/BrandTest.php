<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Brand.php";

    $server = 'mysql:host=localhost:8889;dbname=shoestar_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class BrandTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Store::deleteAll();
            Brand::deleteAll();
            $GLOBALS['DB']->exec("DELETE FROM market_penetration;");
        }

        function testGetName()
        {
            $name = "The Shoe Brand";
            $new_brand = new Brand($name);

            $result = $new_brand->getName();

            $this->assertEquals($name, $result);
        }

        function testSetName()
        {
            $name = "The Shoe Brand Across the Way";
            $new_brand = new Brand($name);
            $new_name = "Border's Shoes";

            $new_brand->setName($new_name);
            $result = $new_brand->getName();

            $this->assertEquals($new_name, $result);
        }

        function testGetPriceRange()
        {
            $name = "The Shoeore";
            $price_range = 1;
            $new_brand = new Brand($name, $price_range);

            $result = $new_brand->getPriceRange();

            $this->assertEquals($price_range, $result);
        }

        function testSetPriceRange()
        {
            $name = "The Shoe Brand Stross the Way";
            $price_range = 2;
            $new_brand = new Brand($name, $price_range);
            $new_price_range = 3;

            $new_brand->setPriceRange($new_price_range);
            $result = $new_brand->getPriceRange();

            $this->assertEquals($new_price_range, $result);
        }

        function testSave()
        {
            $name = "The Doram Shoe";
            $price_range = 4;
            $new_brand = new Brand($name, $price_range);

            $result = $new_brand->save();

            $this->assertTrue($result, "Brand save attempt unsuccessful");
        }

        function testGetId()
        {
            $name = "Callus Shoes";
            $price_range = 5;
            $id = 1;
            $new_brand = new Brand($name, $price_range, $id);

            $result = $new_brand->getId();

            $this->assertEquals($id, $result);
        }

        function testDeleteAll()
        {
            $name = "Shazmo Shoes";
            $new_brand = new Brand($name);
            $new_brand->save();
            $name_2 = "Galactic Zapatos";
            $new_brand_2 = new Brand($name_2);
            $new_brand_2->save();

            Brand::deleteAll();
            $result = Brand::getAll();

            $this->assertEquals([], $result);
        }

        function testGetAll()
        {
            $name = "Big Gambino";
            $price_range = 5;
            $new_brand = new Brand($name, $price_range);
            $new_brand->save();

            $name_2 = "The Diver";
            $price_range_2 = 2;
            $new_brand_2 = new Brand($name_2, $price_range_2);
            $new_brand_2->save();
            $result = Brand::getAll();

            $this->assertEquals([$new_brand, $new_brand_2], $result);
        }

        function testFind()
        {
            $name = "Brand 1";
            $new_brand = new Brand($name);
            $new_brand->save();
            $name_2 = "Brand 2";
            $new_brand_2 = new Brand($name_2);
            $new_brand_2->save();
            $brand_id = $new_brand->getId();

            $result= Brand::find($brand_id);

            $this->assertEquals($new_brand, $result);
        }

        function testUpdateName()
        {
            $name = "Rathos Shoes";
            $new_brand = new Brand($name);
            $new_brand->save();
            $new_name = "Zapatoses";
            $brand_id = $new_brand->getId();

            $new_brand->updateName($new_name);
            $found_brand = Brand::find($brand_id);
            $result = $found_brand->getName();

            $this->assertEquals($new_name, $result);
        }

        function testUpdatePriceRange()
        {
            $name = "Hufflepuff";
            $price_range = 3;
            $new_brand = new Brand($name, $price_range);
            $new_brand->save();
            $new_price_range = 5;
            $brand_id = $new_brand->getId();

            $new_brand->updatePriceRange($new_price_range);
            $found_brand = Brand::find($brand_id);
            $result = $found_brand->getPriceRange();

            $this->assertEquals($new_price_range, $result);
        }

        function testDelete()
        {
            $name = "Ravenclaw";
            $new_brand = new Brand($name);
            $new_brand->save();
            $name_2 = "Shmaegel Shoe";
            $new_brand_2 = new Brand($name_2);
            $new_brand_2->save();

            $new_brand->delete();
            $result = Brand::getAll();

            $this->assertEquals([$new_brand_2], $result);
        }
    }
?>
