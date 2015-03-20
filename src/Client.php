<?php

    class Client {

            private $name;
            private $id;
            private $stylist_id;


            function __construct($name, $id, $stylist_id)
            {
                $this->name = $name;
                $this->id = $id;
                $this->stylist_id = $stylist_id;
            }

            function getName()
            {
                return $this->name;
            }

            function setName($new_name)
            {
                return $this->name = (string) $new_name;
            }

            function getId()
            {
                return $this->id;
            }

            function setId($new_id)
            {
                return $this->id = (int) $new_id;
            }

            function getStylistId()
            {
                return $this->stylist_id;
            }

            function setStylistId($new_stylist_id)
            {
                $this->stylist_id = (int) $new_stylist_id;
            }

            function save()
            {
                $statement = $GLOBALS['DB']->query("INSERT INTO clients (name, stylist_id) VALUES ('{$this->getName()}', {$this->getStylistId()}) RETURNING id;");
                $result = $statement->fetch(PDO::FETCH_ASSOC);
                $this->setId($result['id']);
            }

            static function getAll()
            {
                $returned_client = $GLOBALS['DB']->query("SELECT * FROM clients;");
                $clients = array();
                foreach($returned_client as $client) {
                    $name = $client['name'];
                    $id = $client['id'];
                    $stylist_id = $client['stylist_id'];
                    $new_client = new Client($name, $id, $stylist_id);
                    array_push($clients, $new_client);
                }
                return $clients;
            }

            static function deleteAll()
            {
                $GLOBALS['DB']->exec("DELETE FROM clients *;");
            }

            function deleteClients()
            {
                $GLOBALS['DB']->exec("DELETE FROM clients WHERE stylist_id = {$this->getStylistId()};");
            }

            function update($new_name)
            {
                $GLOBALS['DB']->exec("UPDATE clients SET name = '{$new_name}' WHERE id = {$this->getId()};");
                $this->setName($new_name);
            }

            function deleteSingle()
            {
                $GLOBALS['DB']->exec("DELETE FROM clients WHERE id = {$this->getId()};");
            }

            static function find($stylist_id)
            {
                $found_client = null;
                $clients = Client::getAll();
                foreach($clients as $client) {
                    $client_id = $client->getId();
                    if ($client_id == $cuisine_id) {
                        $found_client = $client;
                    }
                  }
                    return $found_client;
            }

    }

?>
