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

    function addMovieComment($table, $uid,$text, $mid)
    {
        $date = date('Y-m-d');
        $text = $this->prepareData($text);
        $this->sql =
            "INSERT INTO " . $table . " (user_id,text,date,mid) VALUES (" . $uid . ",'". $text . "',CURRENT_DATE," . $mid .")";
        if (mysqli_query($this->connect, $this->sql)) {
            return true;
        } else return false;
    }
    function addSerieComment($table, $uid,$text, $sid)
    {
        $date = date('Y-m-d');
        $this->sql =
        "INSERT INTO " . $table . " (user_id,text,date,sid) VALUES (" . $uid . ",'". $text . "',CURRENT_DATE," . $sid .")";
        if (mysqli_query($this->connect, $this->sql)) {
            return true;
        } else return false;
    }

    function getUser($email,$password)
    {
        $this->sql="SELECT * FROM user1 where email like '%".$email."%' and passwd like '%".$password."%'";
        $result = array();
        
        $response=mysqli_query($this->connect, $this->sql);
        while($row=mysqli_fetch_array($response)){
            $index['id']=$row['0'];
            $index['firstname']=$row['1'];
            $index['lastname']=$row['2'];

        }
        $result['user']=$index;
        $result["get user sucess"]="1";
        echo json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
       
        
    }

    function getSerieComment($sid)
    {
        $this->sql="SELECT * FROM comments where sid =$sid";
        $result = array();
        $result['comments']=array();
        $response=mysqli_query($this->connect, $this->sql);
        while($row=mysqli_fetch_array($response)){
            $index['cid']=$row['0'];
            $index['user_id']=$row['1'];
            $index['text']=$row['2'];
            $index['date']=$row['3'];
            $index['sid']=$row['5'];
            array_push($result['comments'],$index);
        }
        
        $result["get serie comment sucess"]="1";
        echo json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
       
        
    }

    function getMovieComment($mid)
    {
        $this->sql="SELECT * FROM comments where mid =$mid";
        $result = array();
        $result['comments']=array();
        $response=mysqli_query($this->connect, $this->sql);
        while($row=mysqli_fetch_array($response)){
            $index['cid']=$row['0'];
            $index['user_id']=$row['1'];
            $index['text']=$row['2'];
            $index['date']=$row['3'];
            $index['mid']=$row['4'];
            array_push($result['comments'],$index);
        }
        
        $result["get movie comment sucess"]="1";
        echo json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
       
        
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

    function getAllMovies()
    {
        $this->sql="SELECT * FROM movies";
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

    function getAllSeries()
    {
        $this->sql="SELECT * FROM series";
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


    function getSeasonsBySid($sid)
    {
        $this->sql="SELECT * FROM seasons where sid=$sid";
        $result = array();
        $result['data']=array();
        $response=mysqli_query($this->connect, $this->sql);
        while($row=mysqli_fetch_array($response)){
            $index['id']=$row['0'];
            $index['name']=$row['1'];
            $index['sid']=$row['2'];
            $index['description']=$row['3'];
            $index['imgpath']=$row['4'];
            $index['NEP']=$row['5'];
            array_push($result['data'],$index);

        }
        $result["sucess"]="1";
        echo json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
       
        
    }

    function getEpisodsBySid($sid)
    {
        $this->sql="SELECT * FROM episods where sid=$sid";
        $result = array();
        $result['data']=array();
        $response=mysqli_query($this->connect, $this->sql);
        while($row=mysqli_fetch_array($response)){
            $index['id']=$row['0'];
            $index['name']=$row['1'];
            $index['videopath']=$row['2'];
            $index['runtime']=$row['3'];
            $index['description']=$row['4'];
            $index['viewers']=$row['5'];
            $index['season']=$row['5'];
            $index['sid']=$row['5'];
            array_push($result['data'],$index);

        }
        $result["sucess"]="1";
        echo json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
       
        
    }

    function findMovieByDescription($desc)
    {
        $this->sql="SELECT * FROM movies where description like '%".$desc."%' ";
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
        if(count($result['data'])!=0){
            $result["found in description"]="1";
            echo json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }else{
            echo "not found";
        }    
    }

    function findMovieByTitle($title)
    {
        $this->sql="SELECT * FROM movies where name like '%".$title."%' ";
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
        if(count($result['data'])!=0){
            $result["found in title"]="1";
            echo json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }else{
            echo "not found";
        }
    }

    function findMovieByKeyword($key)
    {
        $this->sql="SELECT * FROM movies where keywords_en like '%".$key."%' or keywords_fr like '%".$key."%' ";
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
        if(count($result['data'])!=0){
            $result["found in keywords"]="1";
            echo json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }else{
            echo "not found";
        }    
    }

    function findSerieByDescription($desc)
    {
        $this->sql="SELECT * FROM series where description like '%".$desc."%' ";
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
        if(count($result['data'])!=0){
            $result["found in description"]="1";
            echo json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }else{
            echo "not found";
        }    
    }

    function findSerieByTitle($title)
    {
        $this->sql="SELECT * FROM series where name like '%".$title."%' ";
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
        if(count($result['data'])!=0){
            $result["found in title"]="1";
            echo json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }else{
            echo "not found";
        }    
    }

    function findSerieByKeyword($key)
    {
        $this->sql="SELECT * FROM series where keywords_en like '%".$key."%' or keywords_fr like '%".$key."%' ";
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
        if(count($result['data'])!=0){
            $result["found in keywords"]="1";
            echo json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }else{
            echo "not found";
        }
    }


}

?>
