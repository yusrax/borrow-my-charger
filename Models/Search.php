<?php

class Search extends ChargePointDataSet
{


    /** Connecting to the Database with the parent constructor call
     */
    public function __construct()
    {
        parent::__construct();
    }

    /** Getting number of results retrieved from search query
     * @param string $parameter
     * @return false|float $result
     */
    public function numOfResults($parameter)
    {
        //sql prepared statement that queries the Charge Point attributes
        $sqlQuery = "SELECT * FROM ChargePoint WHERE Address1 LIKE CONCAT( '%',?,'%') OR Address2 LIKE CONCAT( '%',?,'%')
        OR Postcode LIKE CONCAT('%',?,'%')  OR Lat LIKE CONCAT( '%',?,'%') OR Lng LIKE CONCAT( '%',?,'%') OR Cost LIKE 
        CONCAT( '%',?,'%')";
        $stmt = $this->_dbHandle->prepare($sqlQuery);

        //preventing sql injection by binding parameters
        $stmt->bindValue(1, $parameter);
        $stmt->bindValue(2, $parameter);
        $stmt->bindValue(3, $parameter);
        $stmt->bindValue(4, $parameter);
        $stmt->bindValue(5, $parameter);
        $stmt->bindValue(6, $parameter);
        $stmt->execute();

        //checking if query fetches any results
        $items = $stmt->rowCount();
        if ($items > 0) {
            $limit = 10;
            //returning number of pages required to display query results
            $result = ceil($items / $limit);
        } else {
            //returning false if there are no results
            $result = false;
        } return $result;

    }

    /** Retrieving results from cearch query with a limit for pagination
     * @param string $parameter
     * @param int $number
     * @return array $dataSet
     */
    public function search($parameter,$number)
    {   $limit = 10;

        //calculating offset to avoid data redundancy
        $offset = ($number-1)*$limit;

        //sql prepared statement to retrieve search results with limit to correspond to pagination
        $sqlQuery = "SELECT * FROM ChargePoint JOIN Users ON Users.idUsers= ChargePoint.Owner WHERE Address1 LIKE 
        CONCAT( '%',?,'%') OR Address2 LIKE CONCAT( '%',?,'%') OR Postcode LIKE CONCAT('%',?,'%')  OR Lat LIKE 
        CONCAT( '%',?,'%') OR Lng LIKE CONCAT( '%',?,'%') OR Cost LIKE CONCAT( '%',?,'%') 
         LIMIT ?,?";
        $stmt = $this->_dbHandle->prepare($sqlQuery);

        //preventing sql injection and ensuring sql does not fail by limit range parameters to int
        $stmt->bindValue(1, $parameter);
        $stmt->bindValue(2, $parameter);
        $stmt->bindValue(3, $parameter);
        $stmt->bindValue(4, $parameter);
        $stmt->bindValue(5, $parameter);
        $stmt->bindValue(6, $parameter);
        $stmt->bindValue(7, $offset, PDO::PARAM_INT);
        $stmt->bindValue(8, $limit, PDO::PARAM_INT);
        $stmt->execute();

        //fetching all Charge Points and storing them as an array to make ChargePointData object
        $dataSet = [];
        while ($row = $stmt->fetch()){
            $dataSet[] = new ChargePointData($row);
        }
        return $dataSet;
    }

}