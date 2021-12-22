<?php
require "DataBaseConfig.php";

class DataBase
{
    public $connect;
    public $data;
    private $sql;
    protected $servername;
    protected $username;
    protected $password;
    protected $databasename;

    public function __construct()
    {
        $this->connect = null;
        $this->data = null;
        $this->sql = null;
        $dbc = new DataBaseConfig();
        $this->servername = $dbc->servername;
        $this->username = $dbc->username;
        $this->password = $dbc->password;
        $this->databasename = $dbc->databasename;
    }

    function dbConnect()
    {
        $this->connect = mysqli_connect($this->servername, $this->username, $this->password, $this->databasename);
        return $this->connect;
    }

    function prepareData($data)
    {
        return mysqli_real_escape_string($this->connect, stripslashes(htmlspecialchars($data)));
    }

    function logIn($table, $email, $password)
    {
        $email = $this->prepareData($email);
        $password = $this->prepareData($password);
        $this->sql = "select * from " . $table . " where email = '" . $email . "'";
        $result = mysqli_query($this->connect, $this->sql);
        $row = mysqli_fetch_assoc($result);
        if (mysqli_num_rows($result) != 0) {
            $dbusername = $row['email'];
            $dbpassword = $row['passwd'];
            if ($dbusername == $email && $password==$dbpassword) {
                $login = true;
            } else $login = false;
        } else $login = false;

        return $login;
    }

    function signUp($table, $firstname,$lastname, $email,$DOB,$phone, $password)
    {
        $firstname = $this->prepareData($firstname);
        $lastname = $this->prepareData($lastname);
        $DOB = $this->prepareData($DOB);
        $phone = $this->prepareData($phone);
        $password = $this->prepareData($password);
        $email = $this->prepareData($email);
        $this->sql =
            "INSERT INTO " . $table . " (firstname,lastname,DOB,phone, passwd, email) VALUES ('" . $firstname . "','". $lastname . "','" . $DOB . "','" . $phone . "','". $password . "','" . $email . "')";
        if (mysqli_query($this->connect, $this->sql)) {
            return true;
        } else return false;
    }
    function getLast4Movies()
    {
        $this->sql="SELECT * FROM movies ORDER by mid desc Limit 4";
        $result = array();
        $result['data']=array();
        $response=mysqli_query($this->connect, $this->sql);
        while($row=mysqli_fetch_array($response)){
            $index['mid']=$row['0'];
            $index['name']=$row['1'];
            $index['genre']=$row['2'];
            $index['imgpath']=$row['9'];
            $index['videopath']=$row['10'];
            $index['rdate']=$row['3'];
            $index['runtime']=$row['4'];
            $index['description']=$row['5'];
            $index['keywords_en']=$row['6'];
            array_push($result['data'],$index);

        }
        $result["sucess"]="1";
        echo json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
       
        
    }

    function getLast4Series()
    {
        $this->sql="SELECT * FROM series ORDER by sid desc Limit 4";
        $result = array();
        $result['data']=array();
        $response=mysqli_query($this->connect, $this->sql);
        while($row=mysqli_fetch_array($response)){
            $index['sid']=$row['0'];
            $index['name']=$row['1'];
            $index['genre']=$row['2'];
            $index['imgpath']=$row['10'];
            $index['episods']=$row['6'];
            $index['seasons']=$row['5'];
            $index['rdate']=$row['4'];
            $index['runtime']=$row['3'];
            $index['description']=$row['7'];
            $index['keywords_en']=$row['8'];
            array_push($result['data'],$index);

        }
        $result["sucess"]="1";
        echo json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
       
        
    }

}

?>
