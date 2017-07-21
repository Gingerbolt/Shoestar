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
    }
?>
