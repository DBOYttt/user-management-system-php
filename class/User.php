
<?php
if (!isset($_SESSION)) {
	session_start();
}
require_once('config.php');

class User extends Dbconfig {	
    protected $hostName;
    protected $userName;
    protected $password;
    protected $dbName;
    private $userTable = 'user';
    private $dbConnect = false;

    public function __construct(){
        if(!$this->dbConnect){ 		
            $database = new dbConfig();            
            $this->hostName = $database->serverName;
            $this->userName = $database->userName;
			if ($this->password === null) {
				$this->password = null;
			}
			else {
			$this -> password = $database ->password;
			}
            $this->dbName = $database->dbName;			
            $conn = new mysqli($this->hostName, $this->userName, $this->password, $this->dbName);
            if($conn->connect_error){
                die("Error failed to connect to MySQL: " . $conn->connect_error);
            } else{
                $this->dbConnect = $conn;
            }
        }
    }

    private function getData($sqlQuery) {
        $result = mysqli_query($this->dbConnect, $sqlQuery);
        if(!$result){
            die('Error in query: '. mysqli_error());
        }
        $data= array();
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $data[]=$row;            
        }
        return $data;
    }

    private function getNumRows($sqlQuery) {
        $result = mysqli_query($this->dbConnect, $sqlQuery);
        if(!$result){
            die('Error in query: '. mysqli_error());
        }
        $numRows = mysqli_num_rows($result);
        return $numRows;
    }	

    public function loginStatus (){
        if(empty($_SESSION["userid"])) {
            header("Location: login.php");
        }
    }

    public function login(){		
        $errorMessage = '';
        if(!empty($_POST["login"]) && $_POST["loginId"]!=''&& $_POST["loginPass"]!='') {	
            $loginId = $_POST['loginId'];
            $password = $_POST['loginPass'];
            $sqlQuery = "SELECT * FROM ".$this->userTable." 
                WHERE email='".$loginId."' AND password='".md5($password)."' AND status = 'active'";
            $resultSet = mysqli_query($this->dbConnect, $sqlQuery);
            $isValidLogin = mysqli_num_rows($resultSet);	
            if($isValidLogin){
                $userDetails = mysqli_fetch_assoc($resultSet);
                $_SESSION["userid"] = $userDetails['id'];
                $_SESSION["name"] = $userDetails['first_name']." ".$userDetails['last_name'];
                header("location: index.php"); 		
            } else {		
                $errorMessage = "Invalid login!";		 
            }
        } else if(!empty($_POST["loginId"])){
            $errorMessage = "Enter Both user and password!";	
        }
        return $errorMessage; 		
    }

    public function register(){		
        $message = '';
        if(!empty($_POST["register"]) && $_POST["email"] !='') {
            $sqlQuery = "SELECT * FROM ".$this->userTable." 
                WHERE email='".$_POST["email"]."'";
            $result = mysqli_query($this->dbConnect, $sqlQuery);
            $isUserExist = mysqli_num_rows($result);
            if($isUserExist) {
                $message = "User already exist with this email address.";
            } else {			
                $insertQuery = "INSERT INTO ".$this->userTable."(first_name, last_name, email, password, status) 
                VALUES ('".$_POST["firstname"]."', '".$_POST["lastname"]."', '".$_POST["email"]."', '".md5($_POST["passwd"])."', 'active')";
                $userSaved = mysqli_query($this->dbConnect, $insertQuery);if($userSaved) {				
                    $message = "User registered successfully.";
                } else {
                    $message = "User register request failed.";
                }
            }
        }
        return $message;
    }

    public function userDetails () {
        $sqlQuery = "SELECT * FROM ".$this->userTable." 
            WHERE id ='".$_SESSION["userid"]."'";
        $result = mysqli_query($this->dbConnect, $sqlQuery);	
        $userDetails = mysqli_fetch_assoc($result);
        return $userDetails;
    }

    public function editAccount () {
        $message = '';
        if(!empty($_POST["passwd"]) && $_POST["passwd"] != '' && $_POST["passwd"] != $_POST["cpasswd"]) {
            $message = "Confirm passwords do not match.";
        } else if(!empty($_POST["passwd"]) && $_POST["passwd"] != '' && $_POST["passwd"] == $_POST["cpasswd"]) {
            $updatePassword = ", password='".md5($_POST["passwd"])."' ";
            $updateQuery = "UPDATE ".$this->userTable." 
            SET first_name = '".$_POST["firstname"]."', last_name = '".$_POST["lastname"]."', email = '".$_POST["email"]."', mobile = '".$_POST["mobile"]."' $updatePassword
            WHERE id ='".$_SESSION["userid"]."'";
            $isUpdated = mysqli_query($this->dbConnect, $updateQuery);
            if($isUpdated) {
                $_SESSION["name"] = $_POST['firstname']." ".$_POST['lastname'];
                $message = "Account details saved.";
            }
        } else {
            $updateQuery = "UPDATE ".$this->userTable." 
            SET first_name = '".$_POST["firstname"]."', last_name = '".$_POST["lastname"]."', email = '".$_POST["email"]."', mobile = '".$_POST["mobile"]."'
            WHERE id ='".$_SESSION["userid"]."'";
            $isUpdated = mysqli_query($this->dbConnect, $updateQuery);
            if($isUpdated) {
                $_SESSION["name"] = $_POST['firstname']." ".$_POST['lastname'];
                $message = "Account details saved.";
            }
        }
        return $message;
    }
	public function adminLogin(){		
		$errorMessage = '';
		if(!empty($_POST["login"]) && $_POST["email"]!=''&& $_POST["password"]!='') {	
			$email = $_POST['email'];
			$password = $_POST['password'];
			$sqlQuery = "SELECT * FROM ".$this->userTable." 
				WHERE email='".$email."' AND password='".md5($password)."' AND status = 'active' AND type = 'administrator'";
			$resultSet = mysqli_query($this->dbConnect, $sqlQuery);
			$isValidLogin = mysqli_num_rows($resultSet);	
			if($isValidLogin){
				$userDetails = mysqli_fetch_assoc($resultSet);
				$_SESSION["adminUserid"] = $userDetails['id'];
				$_SESSION["admin"] = $userDetails['first_name']." ".$userDetails['last_name'];
				header("location: dashboard.php"); 		
			} else {		
				$errorMessage = "Invalid login!";		 
			}
		} else if(!empty($_POST["login"])){
			$errorMessage = "Enter Both user and password!";	
		}
		return $errorMessage; 		
	}
	public function adminLoginStatus (){
		if(empty($_SESSION["adminUserid"])) {
			header("Location: index.php");
		}
	}	
	public function totalUsers ($status) {
		$query = '';
		if($status) {
			$query = " AND status = '".$status."'";
		}
		$sqlQuery = "SELECT * FROM ".$this->userTable." 
		WHERE id !='".$_SESSION["adminUserid"]."' $query";
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		$numRows = mysqli_num_rows($result);
		return $numRows;
	}
	public function adminDetails () {
		$sqlQuery = "SELECT * FROM ".$this->userTable." 
			WHERE id ='".$_SESSION["adminUserid"]."'";
		$result = mysqli_query($this->dbConnect, $sqlQuery);	
		$userDetails = mysqli_fetch_assoc($result);
		return $userDetails;
	}	
	
	public function saveAdminPassword(){
		$message = '';
		if($_POST['password'] && $_POST['password'] != $_POST['cpassword']) {
			$message = "Password does not match the confirm password.";
		} else {			
			$sqlUpdate = "
				UPDATE ".$this->userTable." 
				SET password='".md5($_POST['password'])."'
				WHERE id='".$_SESSION['adminUserid']."' AND type='administrator'";	
			$isUpdated = mysqli_query($this->dbConnect, $sqlUpdate);	
			if($isUpdated) {
				$message = "Password saved successfully.";
			}				
		}
		return $message;
	}
	public function getUserList(){		
		$sqlQuery = "SELECT * FROM ".$this->userTable." WHERE id !='".$_SESSION['adminUserid']."' ";
		if(!empty($_POST["search"]["value"])){
			$sqlQuery .= '(id LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR first_name LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR last_name LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR designation LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR status LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR mobile LIKE "%'.$_POST["search"]["value"].'%") ';			
		}
		if(!empty($_POST["order"])){
			$sqlQuery .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
		} else {
			$sqlQuery .= 'ORDER BY id DESC ';
		}
		if($_POST["length"] != -1){
			$sqlQuery .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
		}	
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		
		$sqlQuery1 = "SELECT * FROM ".$this->userTable." WHERE id !='".$_SESSION['adminUserid']."' ";
		$result1 = mysqli_query($this->dbConnect, $sqlQuery1);
		$numRows = mysqli_num_rows($result1);
		
		$userData = array();	
		while( $users = mysqli_fetch_assoc($result) ) {		
			$userRows = array();
			$status = '';
			if($users['status'] == 'active')	{
				$status = '<span class="label label-success">Active</span>';
			} else if($users['status'] == 'pending') {
				$status = '<span class="label label-warning">Inactive</span>';
			} else if($users['status'] == 'deleted') {
				$status = '<span class="label label-danger">Deleted</span>';
			}
			$userRows[] = $users['id'];
			$userRows[] = ucfirst($users['first_name']." ".$users['last_name']);
			$userRows[] = $users['gender'];			
			$userRows[] = $users['email'];	
			$userRows[] = $users['mobile'];	
			$userRows[] = $users['type'];
			$userRows[] = $status;						
			$userRows[] = '<button type="button" name="update" id="'.$users["id"].'" class="btn btn-warning btn-xs update">Update</button>';
			$userRows[] = '<button type="button" name="delete" id="'.$users["id"].'" class="btn btn-danger btn-xs delete" >Delete</button>';
			$userData[] = $userRows;
		}
		$output = array(
			"draw"				=>	intval($_POST["draw"]),
			"recordsTotal"  	=>  $numRows,
			"recordsFiltered" 	=> 	$numRows,
			"data"    			=> 	$userData
		);
		echo json_encode($output);
	}

	public function sendMessage($message) {
		$userId = $_SESSION['userid'];
		$sqlQuery = "INSERT INTO chat (user_id, message) VALUES ('$userId', '$message')";
		mysqli_query($this->dbConnect, $sqlQuery);
	}

	public function getChatMessages() {
		$sqlQuery = "SELECT chat.message, chat.timestamp, user.first_name, user.last_name 
		FROM chat 
		JOIN user ON chat.user_id = user.id 
		ORDER BY chat.timestamp DESC";
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		$messages = mysqli_fetch_all($result, MYSQLI_ASSOC);
		return $messages;
	}

	public function deleteUser(){
		if($_POST["userid"]) {
			$sqlUpdate = "
				UPDATE ".$this->userTable." SET status = 'deleted'
				WHERE id = '".$_POST["userid"]."'";		
			mysqli_query($this->dbConnect, $sqlUpdate);		
		}
	}
	public function getUser(){
		$sqlQuery = "
			SELECT * FROM ".$this->userTable." 
			WHERE id = '".$_POST["userid"]."'";
		$result = mysqli_query($this->dbConnect, $sqlQuery);	
		$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
		echo json_encode($row);
	}
	public function updateUser() {
		if($_POST['userid']) {	
			$updateQuery = "UPDATE ".$this->userTable." 
			SET first_name = '".$_POST["firstname"]."', last_name = '".$_POST["lastname"]."', email = '".$_POST["email"]."', mobile = '".$_POST["mobile"]."' , designation = '".$_POST["designation"]."', gender = '".$_POST["gender"]."', status = '".$_POST["status"]."', type = '".$_POST['user_type']."'
			WHERE id ='".$_POST["userid"]."'";
			$isUpdated = mysqli_query($this->dbConnect, $updateQuery);		
		}	
	}	
}
