<?php
require_once ('UserData.php');


class ChargePointData extends UserData
{
    /**
     * @var int $id
     * @var string $address1
     * @var string $address2
     * @var string $postcode
     * @var string $lat
     * @var string $lng
     * @var float $cost
     */
    protected $id, $address1, $address2 , $postcode , $lat, $lng , $cost ;

    /** Retrieving charge point information
     * @param array $dbRow
     */
    public function __construct($dbRow) {

        $this->id = $dbRow['idChargePoint'];
        $this->address1 = $dbRow['Address1'];
        $this->address2 = $dbRow['Address2'];
        $this->postcode = $dbRow['Postcode'];
        $this->lat = $dbRow['Lat'];
        $this->lng = $dbRow['Lng'];
        $this->cost = $dbRow['Cost'];

        //calling on parent mutators to set user attributes
        parent::setName($dbRow['Realname']);
        parent::setPhoto($dbRow['ProfilePhoto']);
        parent::setPhoneNo($dbRow['PhoneNo']);

    }

    /** retrieve charge ID
     * @return int
     */
    public function getChargeID() {
        return $this->id;
    }

    /** retrieve address
     * @return string
     */
    public function getAddress1() {
        return $this->address1;
    }

    /** retrieve city
     * @return string
     */
    public function getAddress2() {
        return $this->address2;
    }

    /** retrieve postcode
     * @return string
     */
    public function getPostcode() {
        return $this->postcode;
    }

    /** retrieve latitude
     * @return string
     */
    public function getLat() {
        return $this->lat;
    }

    /** retrieve longitude
     * @return string
     */
    public function getLng() {
        return $this->lng;
    }

    /** retrieve cost
     * @return string
     */
    public function getCost() {
        return '£'.$this->cost;
    }

    /** retrieve owner's name
     * @return string
     */
    public function getName()
    {
        return parent::getName();
    }

    /** retrieve owner's phone number
     * @return string
     */
    public function getPhoneNo()
    {
        return parent::getPhoneNo();
    }

    /** retrieve owner's profile picture
     * @return string
     */
    public function getPhoto()
    {
        return parent::getPhoto();
    }


}