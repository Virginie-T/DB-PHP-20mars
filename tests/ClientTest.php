<?php

/**
* @backupGlobals disabled
* @backupStaticAttributes disabled
*/

    require_once 'src/Client.php';
    require_once 'src/Stylist.php';

    $DB = new PDO ('pgsql:host=localhost;dbname=hair_salon_test');


    class ClientTest extends PHPUnit_Framework_TestCase
    {

        protected function tearDown()
        {
            Client::deleteAll();
            Stylist::deleteAll();
        }

        function test_getName()
        {
            //Arrange
            $name = "italian";
            $id = null;
            $stylist_id = 1;
            $test_client = new Client($name, $id, $stylist_id);

            //Act
            $result = $test_client->getName();

            //Assert
            $this->assertEquals($name, $result);
        }

        function test_getId()
        {
            //Arrange
            $name = "mexican";
            $id = null;
            $test_stylist = new Stylist($name, $id);
            $test_stylist->save();

            $name = "Taco Bell";
            $stylist_id = $test_stylist->getId();
            $test_client = new Client($name, $id, $stylist_id);
            $test_client->save();

            //Act
            $result = $test_client->getId();

            //Assert
            $this->assertEquals(true, is_numeric($result));
        }

        function test_save()
        {
            //Arrange
            $name = "french";
            $id = null;

            $test_stylist = new Stylist($name, $id);
            $test_stylist->save();

            $name = "olive garden";
            $stylist_id = $test_stylist->getId();
            $test_client = new Client($name, $id, $stylist_id);

            //Act
            $test_client->save();

            //Assert
            $result = Client::getAll();
            $this->assertEquals($test_client, $result[0]);
        }

        function test_getAll()
        {
            //Arrange
            $name = "Burger king";
            $id = null;
            $name2 = "Mcdonalds";

            $name = "American";
            $test_stylist = new Stylist($name, $id);
            $test_stylist->save();

            $stylist_id = $test_stylist->getId();

            $test_client = new Client($name, $id, $stylist_id);
            $test_client->save();
            $test_client2 = new Client($name2, $id, $stylist_id);
            $test_client2->save();

            //Act
            $result = Client::getAll();

            //Assert
            $this->assertEquals([$test_client, $test_client2], $result);
        }

        function test_deleteAll()
        {
            //Arrange
            $name = "Burger king";
            $id = null;
            $name2 = "Mcdonalds";

            $name = "American";
            $test_stylist = new Stylist($name, $id);
            $test_stylist->save();

            $stylist_id = $test_stylist->getId();

            $test_client = new Client($name, $id, $stylist_id);
            $test_client->save();
            $test_client2 = new Client($name2, $id, $stylist_id);
            $test_client2->save();

            //Act
            $result = Client::deleteAll();

            //Assert
            $result = Client::getAll();
            $this->assertEquals([], $result);
        }

        function testUpdateName()
        {
            //Arrange
            $name = "Armenian";
            $id = null;
            $test_stylist = new Stylist($name, $id);
            $test_stylist->save();

            $stylist_id = $test_stylist->getId();
            $name = "fries";

            $test_client = new Client($name, $id, $stylist_id);
            $test_client->save();

            $new_name = "pizza";

            //Act
            $test_client->update($new_name);

            //Assert
            $this->assertEquals("pizza", $test_client->getName());
        }

        function testDeleteSingle()
        {
            //Arrange
            $name = "Polish";
            $id = null;
            $test_stylist = new Stylist($name, $id);
            $test_stylist->save();

            $name = "Bratwurst Hut";
            $stylist_id = $test_stylist->getId();
            $test_client = new Client($name, $id, $stylist_id);
            $test_client->save();

            $name2 = "Sausage Hut";
            $test_client2 = new Client($name2, $id, $stylist_id);
            $test_client2->save();

            //Act
            $test_client->deleteSingle();
            var_dump(Client::getAll());

            //Assert
            $this->assertEquals([$test_client2], Client::getAll());
        }
    }

?>
