<?php

class Registrations {
    protected $pageNum;
    protected $searchQuery;

    public function __construct($searchQuery = null, $pageNum = 1) {
        $this->searchQuery = $searchQuery;
        $this->pageNum = $pageNum;
    }

    public function fetch() {
        global $db;

        $offset = ($this->pageNum - 1) * 25; 

        $registrations = array();
        $params = array();

        if($this->searchQuery) {
            $this->searchQuery = strip_tags(htmlspecialchars($this->searchQuery));
            $this->searchQuery = "WHERE firstname LIKE '%{$this->searchQuery}%'";
        }

        $prep = $db->prepare("SELECT * FROM registrations {$this->searchQuery}");
        $prep->execute();
        $prep->store_result();
        $total_registrations = $prep->num_rows;

        $prep = $db->prepare("SELECT * FROM registrations {$this->searchQuery} LIMIT $offset, 25");

        $prep->execute();

        $result = $prep->get_result();
        while ($registration = $result->fetch_assoc()) {
            $registration = array_map("utf8_encode", $registration);
            $registrations[] = $registration;
        }

        return array($total_registrations, $registrations);
    }
}

class Registration {

    protected $Course;
    protected $Group;
    protected $Gym;

    //Details
    protected $Firstname;
    protected $Lastname;
    protected $Gender;
    protected $Phone;
    protected $Email;
    protected $Birthday;
    protected $Address;
    protected $PostalCode;
    protected $City;

    public function __construct($Course, $Group, $Firstname, $Lastname, $Gender, $Phone, $Birthday, $Address, $PostalCode, $City, $Email) {
        
        if(!$Course || !$Group || !$Firstname || !$Lastname || !$Gender || !$Phone || !$Email || !$Birthday || !$Address || !$PostalCode || !$City)
            return;

        $this->Course = $Course;
        $this->Group = $Group;
        $this->Firstname = $Firstname;
        $this->Lastname = $Lastname;
        $this->Gender = $Gender;
        $this->Phone = $Phone;
        $this->Email = $Email;
        $this->Birthday = $Birthday;
        $this->Address = $Address;
        $this->PostalCode = $PostalCode;
        $this->City = $City;
    }

    private function generateRef() {
        $today = date("Ymd");
        $rand = strtoupper(substr(uniqid(sha1(time())),0,4));
        return $unique = randomLetters(3) . $today . $rand;
    }

    public function Register() {
        global $db;

        $prep = $db->prepare("INSERT INTO registrations (reference, course, training_group, firstname, lastname, gender, phone, birthday, address, postal_code, city, email) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $prep->bind_param("ssssssssssss", $refId, $course, $trainingGroup, $firstname, $lastname, $gender, $phone, $birthday, $address, $postalCode, $city, $email);

        $refId = $this->generateRef();
        $course = escapeString(urldecode($this->Course));
        $trainingGroup = utf8_decode(escapeString(urldecode($this->Group)));
        $firstname = escapeString($this->Firstname);
        $lastname = escapeString($this->Lastname);
        $gender = escapeString($this->Gender);
        $phone = escapeString($this->Phone);
        $birthday = escapeString($this->Birthday);
        $address = escapeString($this->Address);
        $postalCode = (int)$this->PostalCode;
        $city = escapeString($this->City);
        $email = escapeString($this->Email);


        if($prep->execute())
            return array(true, $refId);

        return array(false, "");
    }

}

?>