<?php
class DBController{
    //Database Connnection Properties
    protected $host = "localhost:3307";
    protected $user = 'root';
    protected $password = '';
    protected $database = 'karaoke_db';

    // connection property
    public $con = null;

    // call construction: tu dong goi khi tao doi tuong tu lop
    public function __construct()
    {   
        $this->con = mysqli_connect($this->host,$this->user,$this->password,$this->database);
        if($this->con->connect_error){
            // returns the error description from the last connection error, if any.
            echo "fail:".$this->con->connect_error;
        }
        // echo 'connection successful..!';

    }

    // duoc goi khi doi tuong bi huy hoac tap lenh bi dung hoac thoat
    public function __destruct()
    {
        $this->closeConnection();
    }

    // for mysql closing connection
    protected function closeConnection(){
        if($this->con != null){
            $this->con->close();
            $this->con = null;

        }
    }

// $conn = mysqli_connect('localhost:3307','root','','karaoke_db') or die('connection failed');



}