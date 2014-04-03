<?php

namespace SarDatabases;

class SarMysql 
{
    public $host = '';
    public $user = '';
    public $password = '';
    public $db_name = '';
    private $link;
    private $result;
    private $message = '';

    function __construct($TypeOfConnection = "local")
    {
        $host = $this->getConfig()["sardatabases"]["host"][$this->getConfig()["sardatabases"]["environment"]];

        if (empty($env) || empty($systemName)) {
            return false;
        }
        // $this->conn->$systemName

        switch ($TypeOfConnection) {
            case "local":
            default:
                $this->host = $this->conn->host; //"localhost";
                $this->user = $this->conn->user; //"admin_external";
                $this->password = $this->conn->password; //"9FLZBQFSeCYfYwPs";
                $this->db_name = $this->conn->db_name; //"slank3";
                break;
        }


    }


    public function count()
    {
        return $this->collection->count();
    }

    public function getConfig()
    {
        return include (dirname(__DIR__ )). '/../config/module.config.php';
    }

    /**
     * Inserts array
     * @param $array
     * @return mixed
     */
    public function insertOne($array = array('x' => 1))
    {
        $this->_insert_no_cow($this->collection, $array);
        return (string)$array["_id"];
    }

    /**
     * Wrapping function to prevent triggering copy-on-write in order to make the _id available
     * @param $collection
     * @param $document
     */
    private function _insert_no_cow($collection, $document)
    {
        $collection->insert($document);
    }

    /**
     * @param $array
     * @return mixed
     */
    public function find($array)
    {
        return $this->collection->find($array);
    }

    /**
     * @param $array
     * @return mixed
     */
    public function delete($array)
    {
        return $this->collection->remove($array);
    }

    /**
     * Deletes a MongoId from the mongo database
     * @param $mongoId
     * @return mixed
     */
    public function deleteOne($mongoId)
    {
        return $this->collection->remove(array("_id" => new \MongoId($mongoId)));
    }

    /**
     * @param $mongoId
     * @param $array
     * @return mixed
     */
    public function updateOne($mongoId, $array)
    {
        $this->_modify_no_cow($this->collection, $mongoId, $array);
        return $array;
    }

    /**
     * Wrapping function to prevent triggering copy-on-write in order to make the _id available
     * @param $collection
     * @param $mongoId
     * @param $array
     */
    private function _modify_no_cow($collection, $mongoId, $array)
    {
        //$collection->findAndModify(array("_id"=>new \MongoId($mongoId)), $array);
        $collection->update(array("_id" => new \MongoId($mongoId)), $array);
    }

}
