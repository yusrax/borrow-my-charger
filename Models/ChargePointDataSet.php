<?php
require_once ('Database.php');
require_once ('ChargePointData.php');

class ChargePointDataSet
{
    /**
     * @var Database|PDO|null
     */
    protected $_dbHandle, $_dbInstance;

    /**
     *  Establishing and retrieving database connection
     */
    public function __construct()
    {
        $this->_dbInstance = Database::getInstance(); //creating database connection
        $this->_dbHandle = $this->_dbInstance->getdbConnection(); //retrieving database connection
    }

    public function fetchAllChargePoints() {
        $sqlQuery = 'SELECT * FROM ChargePoint JOIN Users ON Users.idUsers=ChargePoint.Owner';

        $result = $this->_dbHandle->query($sqlQuery);
        $chargePoints = [];

        while ($row = $result->fetch()) {
            $chargePoints[] = new ChargePointData($row);
        }

        return $chargePoints;
    }

    public function fetchAllChargePointsJson() {
        $chargePoints = $this->fetchAllChargePoints();
        $chargePointsArray = [];

        foreach ($chargePoints as $chargePoint) {
            $chargePointsArray[] = [
                'id' => $chargePoint->getChargeID(),
                'lat' => $chargePoint->getLat(),
                'lng' => $chargePoint->getLng(),
                'name' => $chargePoint->getName(),
                'postcode' => $chargePoint->getPostcode(),
                'photo' => $chargePoint->getPhoto(),
                'cost' => $chargePoint->getCost(),
                'number' => $chargePoint->getPhoneNo(),
                'address' => $chargePoint->getAddress1() . ', ' . $chargePoint->getAddress2() . ', ' . $chargePoint->getPostcode()
            ];
        }



        return json_encode($chargePointsArray);
    }





    /**
     * Getting Charge Point that correspond to User ID
     * @param int $id
     * @return ChargePointData
     */
    public function getDetail($id)
    {
        //sql prepared statement to retrieve details of the given Charge point
        $sqlQuery = 'SELECT * FROM ChargePoint JOIN Users ON Users.idUsers= ChargePoint.Owner WHERE idChargePoint= ?';
        $stmt = $this->_dbHandle->prepare($sqlQuery);


        //preventing sql injection
        $stmt->bindValue(1, $id);
        $stmt->execute();

        //fetching results and creating a new Charge Point Data object to retrieve attributes
        $row = $stmt->fetch();
        return new ChargePointData($row);
    }

    /**
     * Registering a new Charge Point
     *
     * @param string $address
     * @param string $city
     * @param string $postcode
     * @param string $lat
     * @param string $lng
     * @param float $cost
     * @param int $owner
     *
     */
    public function register ( $address, $city, $postcode, $lat, $lng, $cost, $owner )
    {
        //sql prepared statement to register a new Charge Point
        $sqlQuery = 'INSERT INTO ChargePoint (Address1, Address2, Postcode, Lat, Lng, Cost, Owner ) VALUES (?,?,?,?,?,?,?)';
        $stmt = $this->_dbHandle->prepare($sqlQuery);

        //inserting an array of parameters to execute sql query and prevent sql injection
        $stmt->execute(array($address, $city, $postcode, $lat, $lng, $cost, $owner));


        //creating new session variables to maintain state
        $_SESSION["Address"] = $address;
        $_SESSION["City"] = $city;
        $_SESSION["Postcode"] = $postcode;
        $_SESSION["Lat"] = $lat;
        $_SESSION["Lng"] = $lng;
        $_SESSION["Cost"] = $cost;
        header("location: profile.php?success=chargepointregistered");
    }

    /**
     * Updating Charge Point address
     * @param string $address
     *
     */
    public function updateAddress($address)
    {
        //sql prepared statement to change address
        $sqlQuery = 'UPDATE ChargePoint SET Address1  = ? WHERE Owner = ?';
        $stmt = $this->_dbHandle->prepare($sqlQuery);

        // inserting an array of variables to execute query and prevent sql injection
        $stmt->execute(array($address, $_SESSION["UserId"]));

        // using a session variable to maintain state
        $_SESSION["Address"] = $address;
        header("location: profile.php?updatesuccessful");
    }

    /**
     * Updating Charge Point city
     * @param string $city
     *
     */
    public function updateCity($city)
    {
        //sql prepared statement to change Charge Point city
        $sqlQuery = 'UPDATE ChargePoint SET Address2  = ? WHERE Owner = ?';
        $stmt = $this->_dbHandle->prepare($sqlQuery);

        //inserting an array of variables to execute query and prevent sql injection
        $stmt->execute(array($city, $_SESSION["UserId"]));

        // using a session variable to maintain state
        $_SESSION["City"] = $city;
        header("location: profile.php?updatesuccessful");
    }

    /**
     * Updating Charge Point postcode
     * @param string $postcode
     *
     */
    public function updatePostcode($postcode)
    {
        //sql prepared statement to change Charge Point postcode
        $sqlQuery = 'UPDATE ChargePoint SET Postcode  = ? WHERE Owner = ?';
        $stmt = $this->_dbHandle->prepare($sqlQuery);

        //inserting an array of variables to execute query and prevent sql injection
        $stmt->execute(array($postcode, $_SESSION["UserId"]));

        // using a session variable to maintain state
        $_SESSION["Postcode"] = $postcode;
        header("location: profile.php?updatesuccessful");
    }

    /**
     * Updating Charge Point latitude
     * @param float $lat
     *
     */
    public function updateLat($lat)
    {
        //sql prepared statement to change Charge Point latitude
        $sqlQuery = 'UPDATE ChargePoint SET Lat  = ? WHERE Owner = ?';
        $stmt = $this->_dbHandle->prepare($sqlQuery);

        //inserting an array of variables to execute query and prevent sql injection
        $stmt->execute(array($lat, $_SESSION["UserId"]));

        // using a session variable to maintain state
        $_SESSION["Lat"] = $lat;
        header("location: profile.php?updatesuccessful");
    }

    /**
     * Updating Charge Point longitude
     * @param float $lng
     *
     */
    public function updateLng($lng)
    {
        //sql prepared statement to change Charge Point longitude
        $sqlQuery = 'UPDATE ChargePoint SET Lng  = ? WHERE Owner = ?';
        $stmt = $this->_dbHandle->prepare($sqlQuery);

        //inserting an array of variables to execute query and prevent sql injection
        $stmt->execute(array($lng, $_SESSION["UserId"]));

        // using a session variable to maintain state
        $_SESSION["Postcode"] = $lng;
        header("location: profile.php?updatesuccessful");
    }

    /**
     * Updating Charge Point cost
     * @param float $cost
     */
    public function updateCost($cost)
    {
        //sql prepared statement to change Charge Point longitude
        $sqlQuery = 'UPDATE ChargePoint SET Cost  = ? WHERE Owner = ?';
        $stmt = $this->_dbHandle->prepare($sqlQuery);

        //inserting an array of variables to execute query and prevent sql injection
        $stmt->execute(array($cost, $_SESSION["UserId"]));

        // using a session variable to maintain state
        $_SESSION["Postcode"] = $cost;
        header("location: profile.php?updatesuccessful");
    }



}