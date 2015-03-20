<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Stylist.php";

    $DB = new PDO ('pgsql:host=localhost;dbname=hair_salon_test');

    class StylistTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Stylist::deleteAll();
            Client::deleteAll();
        }

        function test_getName()
        {
            //Arrange
            $name = "Stylist1";
            $id = null;
            $test_stylist = new Stylist($name, $id);

            //Act
            $result = $test_stylist->getName();

            //Assert
            $this->assertEquals($name, $result);
        }

        function test_getId()
        {
            //arrange
            $name = "Stylist2";
            $id = 1;
            $test_stylist = new Stylist($name, $id);

            //act
            $result = $test_stylist->getId();

            //assert
            $this->assertEquals(1, $result);
        }

        function test_setId()
        {
            //Arrange
            $name = "Stylist3";
            $id = null;
            $test_stylist = new Stylist($name, $id);

            //Act
            $test_stylist->setId(2);

            //Assert
            $result = $test_stylist->getId();
            $this->assertEquals(2, $result);
        }

        function test_save()
        {
            //arrange
            $name = "Stylist4";
            $id = null;
            $test_stylist = new Stylist($name, $id);
            $test_stylist->save();

            //act
            $result = Stylist::getAll();

            //assert
            $this->assertEquals($test_stylist, $result[0]);
        }

        function test_getAll()
        {
            //Arrange
            $name = "Stylist5";
            $id = null;
            $name2 = "Stylist6";
            $id2 = null;
            $test_stylist = new Stylist($name, $id);
            $test_stylist->save();
            $test_stylist2 = new Stylist($name2, $id2);
            $test_stylist2->save();

            //Act
            $result = Stylist::getAll();

            //Assert
            $this->assertEquals([$test_stylist, $test_stylist2], $result);
        }

        function test_deleteAll()
        {
            //arrange
            $name = 'Stylist7';
            $id = null;
            $test_stylist = new Stylist($name, $id);
            $test_stylist->save();

            //act
            Stylist::deleteAll();
            $result = Stylist::getAll();

            //assert
            $this->assertEquals([], $result);

        }

        function testUpdate()
        {
            //Arrange
            $name = "Stylist8";
            $id = null;
            $test_stylist = new Stylist($name, $id);
            $test_stylist->save();

            $new_name = "Stylist9";

            //Act
            $test_stylist->update($new_name);

            //Assert
            $this->assertEquals("Stylist9", $test_stylist->getName());
        }

//        function testDeleteStylistClient()
//        {
//            //arrange
//            $name = "Arabic";
//            $id = null;
//            $test_stylist = new Stylist($name, $id);
//            $test_stylist->save();
//
//            //act
//            $test_stylist->delete();
//
//            //assert
//            $this->assertEquals([], Client::getAll());
//        }
    }

 ?>
