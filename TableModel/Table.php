<?php
class UserVO {
    protected $id;
    protected $name;
    protected $age;
    protected $cityname;

    public function setId($id) {
        $this->id = $id;
    }
    
    public function getId() {
        return $this->id;
    }
    
    public function setUsername($name) {
        $this->name = $name;
    }
    
    public function getUsername() {
        return $this->name;
    }
    
    public function setCity($cityname) {
        $this->cityname = $cityname;
    }
    
    public function getCity() {
        return $this->cityname;
    }
    public function setAge($age) {
        $this->age = $age;
    }
    
    public function getAge() {
        return $this->age;
    }
}
class UserDAO {
    protected $connect;
    protected $db;
	
	public function UserDAO() {
        $read_ini = parse_ini_file("mysql.ini", false);
        $mysql_connect_info=Array();
        $i=0;
        foreach ($read_ini as $k=>$v){
	    $mysql_connect_info[$i]=$v;
	    $i++;
        };
        $this->connect=mysql_connect($mysql_connect_info[0],$mysql_connect_info[1],$mysql_connect_info[2]) or die(mysql_error());
        $this->db = mysql_select_db($mysql_connect_info[3],$this->connect) or die(mysql_error());        
        $sql1="SET NAMES UTF8";
        mysql_query($sql1, $this->connect) or die(mysql_error());
        
    }
	protected function execute($sql) {
        $res = mysql_query($sql, $this->connect) or die(mysql_error());
        if(mysql_num_rows($res) > 0) {
            for($i = 0; $i < mysql_num_rows($res); $i++) {
                $row = mysql_fetch_assoc($res);
                $userVO[$i] = new UserVO();
                $userVO[$i]->setId($row['id']);
                $userVO[$i]->setUsername($row['name']);
                $userVO[$i]->setAge($row['age']);
                $userVO[$i]->setCity($row['cityname']);
            }

        }
        return $userVO;
    }
    public function getByUserId($userId) {
        $sql = "SELECT id,name,age,cityname FROM users NATURAL JOIN cities WHERE id=".$userId;
        return $this->execute($sql);
    }
    public function getUsers() {
        $sql = "SELECT id,name,age,cityname FROM users NATURAL JOIN cities";
        return $this->execute($sql);
    }
	public function save($userVO) {
        $affectedRows = 0;
        if($userVO->getId()!= "") {
            $currUserVO = $this->getByUserId($userVO->getId());
        }
        if(sizeof($currUserVO) > 0) {
            $sql = "UPDATE users SET ".
                "name='".$userVO->getUsername()."', ".
                "age=".$userVO->getAge().", ".
                "city_id=(SELECT city_id FROM cities WHERE cityname='".$userVO->getCity()."')".
                " WHERE id=".$userVO->getId();
            mysql_query($sql, $this->connect) or die(mysql_error());
            $affectedRows = mysql_affected_rows();
        }
        else {
            $sql = "INSERT INTO cities (cityname)
                   SELECT * FROM (SELECT '".$userVO->getCity()."') AS tmp
                    WHERE NOT EXISTS (
                        SELECT cityname FROM cities WHERE cityname = '".$userVO->getCity()."'
                        ) LIMIT 1;";
            mysql_query($sql, $this->connect) or die(mysql_error());
            $sql = "INSERT INTO users (name,age,city_id) VALUES('".$userVO->getUsername()."',".$userVO->getAge().",(SELECT city_id FROM cities WHERE cityname='".$userVO->getCity()."'))";
            mysql_query($sql, $this->connect) or die(mysql_error());
        }
        
        return $affectedRows;
    }
    public function GetAllUsersCities() {
        $sql = "SELECT cityname FROM cities";
        $res = mysql_query($sql, $this->connect) or die(mysql_error());
        if(mysql_num_rows($res) > 0) {
            for($i = 0; $i < mysql_num_rows($res); $i++) {
                $row = mysql_fetch_assoc($res);
                $citylist[$i]=$row['cityname'];
            }
        }
        return $citylist;
    }
    public function __destruct() {
        mysql_close($this->connect);
    }
}