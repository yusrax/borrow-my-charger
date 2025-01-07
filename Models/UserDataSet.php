<?php
require_once ('Database.php');
require_once ('UserData.php');
require_once ('ChargePointData.php');

class UserDataSet

{
    /**
     * @var Database|PDO|null $_dbHandle
     */
    protected $_dbHandle, $_dbInstance;

    /**
     *  Establishing and retrieving database connection
     */
    public function __construct()
    {
        $this->_dbInstance = Database::getInstance();
        $this->_dbHandle = $this->_dbInstance->getdbConnection();
    }


    /** Checking if an account exists
     * @param string $username
     * @return bool $result
     */
    public function checkUsername($username)
    {

        //sql prepared statement to get username from database
        $sqlQuery = 'SELECT * FROM Users WHERE Username = ?';
        $stmt = $this->_dbHandle->prepare($sqlQuery);

        //executing sql passing an array of the parameter to prevent sql injection
        $stmt->execute(array($username));

        //retrieving the results and verifying username
        $row = $stmt->fetch();
        if ($username == $row['Username']) {
            $result = true;
        } else {
            $result = false;
        }
        $stmt = null;
        return $result;
    }

    /** Verifying password entries
     * @param string $username
     * @param string $pwd
     * @return bool $result
     */
    public function verify($username, $pwd)
    {
        //sql prepared query to get user details with username
        $sqlQuery = 'SELECT * FROM Users WHERE Username = ?';
        $stmt = $this->_dbHandle->prepare($sqlQuery);

        //executing sql passing an array of the parameter to prevent sql injection
        $stmt->execute(array($username));

        //verifying if password matches
        $row = $stmt->fetch();
        if (password_verify($pwd, $row['Password'])) {
            $result = $row;
        } else {
            $result = false;
        }
        return $result;

    }



    /** Registering a new user
     * @param string $username
     * @param string $full_name
     * @param string $pwd
     * @param string $avatar
     * @param string $phoneNo
     */
    public function register($username, $full_name, $pwd, $avatar, $phoneNo)
    {
        //hashing password before inserting into database
        $pwdHashed = password_hash($pwd, PASSWORD_DEFAULT);

        //prepared sql query to add new user
        $sqlQuery = 'INSERT INTO Users (Username , Realname , Password, ProfilePhoto, PhoneNo) VALUES (?,?,?,?,?)';
        $stmt = $this->_dbHandle->prepare($sqlQuery);

        //executing sql to add user passing an array of the parameter to prevent sql injection
        $stmt->execute(array($username, $full_name, $pwdHashed, $avatar, $phoneNo));
    }

    /** Updating the user's name
     * @param string $newName
     */
    public function updateName($newName)
    {
        //prepared sql query to replace the user's name
        $sqlQuery = 'UPDATE Users SET Realname = ? WHERE Username = ?';
        $stmt = $this->_dbHandle->prepare($sqlQuery);

        //executing sql and passing an array of the parameter to prevent sql injection
        $stmt->execute(array($newName, $_SESSION["email"]));

        //setting a session variable to maintain state
        $_SESSION["name"] = $newName;
        header("location: profile.php?updatesuccessful");
    }

    /** Updating the user's email
     * @param string $newUsername
     */
    public function updateUsername($newUsername)
    {
        //prepared sql query to replace the user's email
        $sqlQuery = 'UPDATE Users SET Username  = ? WHERE Username = ?';
        $stmt = $this->_dbHandle->prepare($sqlQuery);

        //executing sql and passing an array of the parameter to prevent sql injection
        $stmt->execute(array($newUsername, $_SESSION["email"]));

        //setting a session variable to maintain state
        $_SESSION["email"] = $newUsername;
        header("location: profile.php?updatesuccessful");
    }

    /** Updating the user's phone number
     * @param string $newNumber
     */
    public function updateNumber($newNumber)
    {
        //prepared sql query to replace the user's number
        $sqlQuery = 'UPDATE Users SET PhoneNo  = ? WHERE  Username = ?';
        $stmt = $this->_dbHandle->prepare($sqlQuery);

        //executing sql and passing an array of the parameter to prevent sql injection
        $stmt->execute(array($newNumber, $_SESSION["email"]));

        //setting a session variable to maintain state
        $_SESSION["email"] = $newNumber;
        header("location: profile.php?updatesuccessful");
    }

    /** Displaying the users Charge Point
     * @param int $userID
     */
    public function viewChargePoint($userID)
    {
        //prepared sql query to display the user's Charge Point
        $sqlQuery = 'SELECT * FROM ChargePoint WHERE Owner = ?';
        $stmt = $this->_dbHandle->prepare($sqlQuery);

        //executing sql and binding parameter to prevent sql injection
        $stmt->bindValue(1, $userID);
        $stmt->execute();

        //getting chargePoint details if user has a Charge Point
        if ($stmt->rowCount() > 0){
                $chargePoint = $stmt->fetch();
            $_SESSION["Address"] = $chargePoint["Address1"];
            $_SESSION["City"] = $chargePoint["Address2"];
            $_SESSION["Postcode"] = $chargePoint["Postcode"];
            $_SESSION["Lat"] = $chargePoint["Lat"];
            $_SESSION["Lng"] = $chargePoint["Lng"];
            $_SESSION["Cost"] = $chargePoint["Cost"];
            }

    }
    


}


    
    
    
    
    
    
    
    
    
    
    


    




    






