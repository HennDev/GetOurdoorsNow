<?php
	
	function unknownErr()
	{
		echo "Unknown error has occurred";
	}
	
class Database
{
    private static $dbName = 'GetOutdoorsNow' ;
    private static $dbHost = 'localhost' ;
    private static $dbUsername = 'db_owner';
    private static $dbUserPassword = 'mKxKGVQenVFUFMVZ';
     
    private static $cont  = null;
     
    public function __construct() {
        die('Init function is not allowed');
    }
     
    public static function connect()
    {
       // One connection through whole application
       if ( null == self::$cont )
       {     
        try
        {
          self::$cont =  new PDO( "mysql:host=".self::$dbHost.";"."dbname=".self::$dbName, self::$dbUsername, self::$dbUserPassword); 
        }
        catch(PDOException $e)
        {
          die($e->getMessage()); 
        }
       }
       return self::$cont;
    }
     
    public static function disconnect()
    {
        self::$cont = null;
    }       
}


class Outfitter 
{
	public $id;
	public $name;
	public $email;
	public $state_ID;
	public $city;
	public $address;
	public $type;
	public $phone;
	public $lodging;
	public $region;
	public $userEmail;
	public $description;
	public $state;
	public $zip;
    public $descrShort;
	
	public static function withID( $myID ) {
    	$instance = new Outfitter();
    	$instance->id = $myID;
    	return $instance;
    }
    
    public static function withAllButID( $name,$email,$state_ID,$city,$address,$type,$phone,$lodging,$region,$userEmail = null,$description,$zip,$descrShort) {
    	$instance = new Outfitter();
    	$instance->name = $name;
    	$instance->email = $email;
    	$instance->state_ID = $state_ID;
    	$instance->city = $city;
    	$instance->address = $address;
    	$instance->type = $type;
    	$instance->phone = $phone;
    	$instance->lodging = $lodging;
    	$instance->region = $region;
    	$instance->userEmail = $userEmail;
    	$instance->description = $description;
		$instance->zip = $zip;
        $instance->descrShort = $descrShort;
    	
    	return $instance;
    }
	
	public static function withAll($id,$name,$email,$state_ID,$city,$address,$type,$phone,$lodging,$region,$userEmail = null,$description,$zip,$descrShort) {
    	$instance = new Outfitter();
    	$instance->id = $id;
    	$instance->name = $name;
    	$instance->email = $email;
    	$instance->state_ID = $state_ID;
    	$instance->city = $city;
    	$instance->address = $address;
    	$instance->type = $type;
    	$instance->phone = $phone;
    	$instance->lodging = $lodging;
    	$instance->region = $region;
    	$instance->userEmail = $userEmail;
    	$instance->description = $description;
		$instance->zip = $zip;
        $instance->descrShort = $descrShort;
    	return $instance;
    }

	public static function getSingleOutfitter($myID)
	{
		$instance = new Outfitter();

		$pdo = Database::connect();

		$statement = $pdo->prepare("SELECT * FROM Outfitters of left join us_states state on of.state_ID = state.state_id WHERE id = :id");

		// $statement is now a PDOStatement object, with its own methods to use it, e.g.
		// execute the query, passing in the parameters to replace
		$statement->execute(array(':id' => $myID));
		// fetch results as array
		$results = $statement->fetch(PDO::FETCH_ASSOC);

		$pdo = Database::disconnect();

		if(count($results)==0)
		{
			return -1;
		}
		else
		{

			$instance->id = $myID;
			$instance->name = $results["name"];
			$instance->email = $results["email"];
			$instance->state_ID = $results["state_ID"];
			$instance->city = $results["city"];
			$instance->address = $results["address"];
			$instance->type = $results["type"];
			$instance->phone = $results["phone"];
			$instance->lodging = $results["lodging"];
			$instance->region = $results["region_id"];
			$instance->description = $results["description"];
			$instance->state_ID = $results["state_ID"];
			$instance->state = $results["state"];
			$instance->zip = $results["zip"];
            $instance->descrShort = $results["descrShort"];

			return $instance;
		}
	}
    
	public function getOutfitter()
	{
		$valid = false;
		$pdo = Database::connect();
		
		$statement = $pdo->prepare("SELECT * FROM Outfitters of left join us_states state on of.state_ID = state.state_id WHERE id = :id");
			
		// $statement is now a PDOStatement object, with its own methods to use it, e.g.
		// execute the query, passing in the parameters to replace
		$statement->execute(array(':id' => $this->id));
		// fetch results as array
		$results = $statement->fetchAll(PDO::FETCH_CLASS, "Outfitter");
		
		$pdo = Database::disconnect();
		
		if(count($results)==0)
		{
			return -1;
		}
		else
		{
			return $results;	
		}
	}
	
	public function deleteOutfitter()
	{
		$valid = false;
		$pdo = Database::connect();
		
		$statement1 = $pdo->prepare("DELETE FROM Outfitters WHERE id = :id");
		$statement1->execute(array(':id' => $this->id));
		// fetch results as rount
		
		$statement = $pdo->prepare("DELETE FROM users_outfitters WHERE outfitterID = :id");
		$statement->execute(array(':id' => $this->id));
		$resultsUsersOutfitters = $statement->rowCount();
		
		$pdo = Database::disconnect();

		if($statement1)
		{
			return true;
		}
		else
		{
			return false;	
		}
	}
	
	public function createOutfitter()
	{
		$valid = false;
		$pdo = Database::connect();
		
		try 
		{
			$sql = "INSERT INTO Outfitters (name,email,state_ID,city,address,type,phone,lodging,region_id,description,zip,descrShort,createdDate) values(:name,:email,:state_ID,:city,:address,:type,:phone,:lodging,:region,:description,:zip, :descrShort,:createdDate)";
            $statement = $pdo->prepare($sql);
			$statement->execute(array(':name'=>$this->name,
														':email'=>$this->email,
														':state_ID'=>$this->state_ID,
														':city'=>$this->city,
														':address'=>$this->address,
														':type'=>$this->type,
														':phone'=>$this->phone,
														':lodging'=>$this->lodging,
														':region'=>$this->region,
														':description'=>$this->description,
														':zip'=>$this->zip,
                                                        ':descrShort'=>$this->descrShort,
                                                        ':createdDate'=>date("Y-m-d H:i:s", time())

            ));

			$pdo = Database::disconnect();

            if($statement->rowCount() != 1)
            {
                $filename =  $_SERVER['DOCUMENT_ROOT'] . '/errorLogs/dbErrors.txt';
                $errorText = date("Y-m-d H:i:s")."   Sql: $sql Error: ".$statement->errorInfo()[2];
                $myfile = file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/errorLogs/dbErrors.txt', $errorText.PHP_EOL , FILE_APPEND);
            }

            return $statement;
		}
        catch (Exception $e)
		{
			$pdo = Database::disconnect();	
			//echo 'Caught exception: ',  $e->getMessage(), "\n";
            $myfile = file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/errorLogs/dbErrors.txt', $e->getMessage().PHP_EOL , FILE_APPEND);
            return -1;
		}
	}
	
	public function linkOutfitter()
	{
		$success = false;
		$pdo = Database::connect();
		
		try 
		{
			$sql = "INSERT INTO Outfitters (name,email,state_ID,city,address,type,phone,lodging,region_id"
                                . ",userEmail,description,zip,descrShort,createdDate) values(:name,:email,:state_ID,:city,:address,:type,:phone,:lodging,:region,:userEmail,:description,:zip,:descrShort,:createdDate)";
			$statement = $pdo->prepare($sql);
			$statement->execute(array(':name'=>$this->name,
														':email'=>$this->email,
														':state_ID'=>$this->state_ID,
														':city'=>$this->city,
														':address'=>$this->address,
														':type'=>$this->type,
														':phone'=>$this->phone,
														':lodging'=>$this->lodging,
														':region'=>$this->region,
														':userEmail'=>$this->userEmail,
														':description'=>$this->description,
														':zip'=>$this->zip,
                                                        ':descrShort'=>$this->descrShort,
                                                        ':createdDate'=>date("Y-m-d H:i:s", time())));
				
			$results = $statement->rowCount();
			
			if($results > 0)
			{
				//TODO: do this with a transaction
				$outfitterID = $pdo->lastInsertId();
				
				//check if email already exsists
				$instance = new User;
				$user = $instance->getUser($this->userEmail);
				$userID = '';
				
				foreach ($user as $row) 
				{
					$userID = $row['user_id'];
				}
				
				if($userID!='')
				{
					$sql = "INSERT INTO users_outfitters (userID,outfitterID) values(:userID,:outfitterID)";
					$statement = $pdo->prepare($sql);
					$statement->execute(array(':userID'=>$userID,
														':outfitterID'=>$outfitterID));
				
					$userOutfitterCount = $statement->rowCount();
					$instance->setUserAsOutfitter();
					
					if($userOutfitterCount>0)
					{
						$success = true;
					}
				}
			}
			
			if($success)
				return true;
			else
				return false;
			
			$pdo = Database::disconnect();
		}
		
		catch (Exception $e) 
		{
			$pdo = Database::disconnect();	
			//echo 'Caught exception: ',  $e->getMessage(), "\n";
			return -1;
		}
	}
	
	public function editOutfitter()
	{
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		
		try 
		{
			$sql = "UPDATE Outfitters set name = :name, userEmail = :email2, email = :email, state_ID = :state_ID, city = :city, address = :address, type = :type, phone = :phone, lodging = :lodging, region_id = :region, lastUpdate = :lastUpdate, description = :description, zip = :zip, descrShort = :descrShort WHERE id = :id";
			$statement = $pdo->prepare($sql);
			$statement->execute(array(':id'=>$this->id,
														':name'=>$this->name,
														':email2'=>$this->email,
														':email'=>$this->email,
														':state_ID'=>$this->state_ID,
														':city'=>$this->city,
														':address'=>$this->address,
														':type'=>$this->type,
														':phone'=>$this->phone,
														':lodging'=>$this->lodging,
														':region'=>$this->region,
														':lastUpdate'=>date("Y-m-d H:i:s", time()),
														':description'=>$this->description,
														':zip'=>$this->zip,
                                                        ':descrShort'=>$this->descrShort,
            ));
	
			$results = $statement->rowCount();
			$pdo = Database::disconnect();
			
			if($results > 0)
			{
				return true;
			}
			else
			{
				echo $this->id .' '.$this->name .' '. $this->email .' '.$this->state_ID .' '.$this->city .' '.$this->address .' '.$this->type .' '.$this->phone .' '.$this->lodging .' '.$this->region,
				print_r($statement->errorInfo());
				return false;	
			}
		}
		
		catch (Exception $e) 
		{
			$pdo = Database::disconnect();	
			echo 'Caught exception: ',  $e->getMessage(), "\n";
			
    echo 'Exception -> ';
    var_dump($e->getMessage());
    return -1;
		}
	}
	
	public function getAllOutfitters($sortValues = null)
	{
		$pdo = Database::connect();
		$statementTxt = "SELECT * FROM Outfitters of left join us_states state on of.state_ID = state.state_id";
        $sortTxt = "";

        if(is_array($sortValues))
        {
            $sortTxt = " ORDER BY";
            $countVal = count($sortValues);
            for($i = 0; $i < $countVal; $i++)
            {
                $sortTxt.=" $sortValues[$i]";

                if($i>0 && $i < $countVal-1)
                {
                    $sortTxt.=",";
                }
            }
        }
        else if($sortValues!="")
        {
            $sortTxt = " ORDER BY $sortValues";
        }

        $statementTxt .= $sortTxt;
		$statement = $pdo->prepare($statementTxt);
		$statement->execute();
		// fetch results as array
		//$results = $statement->fetchAll();
		$results = $statement->fetchAll(PDO::FETCH_CLASS, "Outfitter");

		if(count($results)==0)
		{
			return -1;
		}
		else
		{
			return $results;	
		}
		
		$pdo = Database::disconnect();
	}
	
	public function getAllUsersOutfitters($email)
	{
		$pdo = Database::connect();
		$sql = "SELECT * FROM Outfitters outf INNER JOIN
		users_outfitters uo ON uo.outfitterID = outf.id INNER JOIN
		users usrs ON uo.userID = usrs.user_id LEFT JOIN
		us_states state ON outf.state_ID = state.state_id WHERE usrs.email = :email";
		$statement = $pdo->prepare($sql);
		$statement->execute(array(':email'=>$email));
		
		// fetch results as array
		$results = $statement->fetchAll();
		
		if(count($results)==0)
		{
			return -1;
		}
		else
		{
			return $results;
		}
		
		$pdo = Database::disconnect();
	}
	
	public function addAnimalsByOutfitter($animals)
	{
		$pdo = Database::connect();
		$statement = $pdo->prepare("INSERT INTO animals_outfitters (outfitter_id,animals_id) VALUES (:outfitterID, :animalID)");
		
		foreach($animals as $animalID)
		{
			$statement->execute(array(':outfitterID'=> $this->id,':animalID'=>$animalID));
		}
		
		$resultsOutfitters = $statement->rowCount();
		$pdo = Database::disconnect();
		
		if($resultsOutfitters > 0)
		{
			return true;
		}
		else
		{
			return false;	
		}
	}
	
	
	public function deleteAnimalsByOutfitter($animals)
	{
		$valid = false;
		$pdo = Database::connect();
		$statement = $pdo->prepare("Delete FROM animals_outfitters WHERE outfitter_id = :id AND animals_id = ( :animalIDs )");
		
		foreach($animals as $animalID)
		{
			$statement->execute(array(':id'=> $this->id,':animalIDs'=>$animalID));
		}
		
		
		$resultsOutfitters = $statement->rowCount();
		$pdo = Database::disconnect();

		if($resultsOutfitters > 0)
		{
			return true;
		}
		else
		{
			return false;	
		}
	}


	public function getAnimalsByOutfitter()
	{
		$valid = false;
		$pdo = Database::connect();
		$statement = $pdo->prepare("SELECT * FROM animals_outfitters WHERE outfitter_id = :id");
		$statement->execute(array(':id' => $this->id));
		// fetch results as array
		$results = $statement->fetchAll(PDO::FETCH_ASSOC);
		
		$pdo = Database::disconnect();
		
		if(count($results)==0)
		{
			return -1;
		}
		else
		{
			return $results;	
		}
	}
	
	public function getAnimalsByOutfitterWithDetails()
	{
		$valid = false;
		$pdo = Database::connect();
		$statement = $pdo->prepare("SELECT * FROM animals_outfitters ao inner join animals a on a.id = ao.animals_id WHERE outfitter_id = :id");
		$statement->execute(array(':id' => $this->id));
		// fetch results as array
		$results = $statement->fetchAll(PDO::FETCH_ASSOC);
		
		$pdo = Database::disconnect();
		
		if(count($results)==0)
		{
			return -1;
		}
		else
		{
			return $results;	
		}
	}
}

class User
{
	public $email = "";
	public $firstName = "";
	public $lastName = "";
	public $roles = array();
	public $isOutffiter = false;
	public $id = "";
	
	public static function withEmail($email) {
    	$instance = new User();
    	$instance->email = $email;
    	return $instance;
    }
	
	public function authenticate($username,$password)
	{
		$valid = false;
		$pdo = Database::connect();
		
		//Get the users info 
		$statement = $pdo->prepare("select `user_id`,`email`,`password`,`first_name`, `last_name`, `isOutffiter` FROM users us WHERE us.email = :username");
		$statement->execute(array(':username' => $username));
		$results = $statement->fetchAll();
		
		if(count($results)==0)
		{
			//username doesn't exsist
			return -1;
		}
		else
		{
			$result = $results[0];
			
			$this->email = $result['email'];
			$this->firstName = $result['first_name'];
			$this->lastName = $result['last_name'];
			$this->isOutffiter = $result['isOutffiter'];
            $this->id = $result['user_id'];


			if(password_verify($password,$result['password']))
			{
				//valid user, let's get the roles
				$valid = true;
				$statement = $pdo->prepare("select r.role FROM users us inner join users_roles ur on ur.users_user_id = us.user_id inner join roles r on r.id = ur.roles_id WHERE us.email = :username");
				$statement->execute(array(':username' => $username));
				$results = $statement->fetchAll();	
				
				foreach($results as $result)
				{
					array_push($this->roles, $result['role']);
				}
			}
			else
			{
				$valid = false;
			}
			
			$pdo = Database::disconnect();
			
			if($valid)
			{
				return 1;
			}
			else
			{
				return 0;
			}
		}
	}
	
	public function getUser($email)
	{
		$valid = false;
		$pdo = Database::connect();
		
		$statement = $pdo->prepare("SELECT * FROM users WHERE email = :email	");
			
		// $statement is now a PDOStatement object, with its own methods to use it, e.g.
		// execute the query, passing in the parameters to replace
		$statement->execute(array(':email' => $email));
		
		
		// fetch results as array
		$results = $statement->fetchAll();
		
		$pdo = Database::disconnect();
		
		if(count($results)==0)
		{
			return -1;
		}
		else
		{
			return $results;	
		}
	}
		
	public function editUser($originalEmail, $email, $firstName, $lastName)
	{
		$valid = false;
		$pdo = Database::connect();
		
		try 
		{
			$sql = "UPDATE users set email = :email, first_name = :firstName, last_name = :lastName WHERE email = :originalEmail";
			$statement = $pdo->prepare($sql);
			$statement->execute(array(':originalEmail'=>$originalEmail,
														':firstName'=>$firstName,
														':email'=>$email,
														':lastName'=>$lastName));
				
			$pdo = Database::disconnect();
			return true;
		}
		
		catch (Exception $e) 
		{
			$pdo = Database::disconnect();	
			//echo 'Caught exception: ',  $e->getMessage(), "\n";
			return -1;
		}
	}
	
	
	public function setUserAsOutfitter()
	{
		$valid = false;
		$pdo = Database::connect();
		
		try 
		{
			$sql = "UPDATE users set isOutffiter = 1 WHERE email = :email";
			$statement = $pdo->prepare($sql);
			$statement->execute(array(':email'=> $this->email));
			
			$pdo = Database::disconnect();		
			return true;
		}
		
		catch (Exception $e) 
		{
			$pdo = Database::disconnect();	
			//echo 'Caught exception: ',  $e->getMessage(), "\n";
			return -1;
		}
	}
	
	
	public function editPassword($email, $password)
	{
		$valid = false;
		$pdo = Database::connect();
		
		try 
		{
			$hashAndSalt = password_hash($password, PASSWORD_BCRYPT);
			$sql = "UPDATE users set password = :password WHERE email = :email";
			$statement = $pdo->prepare($sql);
			$statement->execute(array(':password'=>$hashAndSalt,
														':email'=>$email));
				
			$results = $statement->rowCount();
			$pdo = Database::disconnect();
	
			if($results > 0)
			{
				return true;
			}
			else
			{
				return false;	
			}
		}
		
		catch (Exception $e) 
		{
			$pdo = Database::disconnect();	
			//echo 'Caught exception: ',  $e->getMessage(), "\n";
			return -1;
		}
		
		
		
		
		
	}
	
	
	
	//Function used to create a new user
	// Returns false if user already exsists, -1 if error
	// Accepts Username, password, first name, last name (all strings)
	public function createUser($username,$password,$firstName,$lastName)
	{
		$valid = false;
		$pdo = Database::connect();
		
		try 
		{
			$statement = $pdo->prepare("select * FROM users us WHERE us.email = :username");
			$statement->execute(array(':username' => $username));
			$results = $statement->fetchAll();
			
			if(count($results)>0)
			{
				//user already exsists
				return false;
			}
			else
			{
				//No e-mail already in db, so let's hash the password and then create the user				
				$hashAndSalt = password_hash($password, PASSWORD_BCRYPT);
				$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	            $sql = "INSERT INTO users (email,password,first_name,last_name) values(:username,:password,:first_name,:last_name)";
	            $statement = $pdo->prepare($sql);
				$statement->execute(array(':username'=>$username,
														':password'=>$hashAndSalt,
														':first_name'=>$firstName,
														':last_name'=>$firstName));
				return true;
			}
		}
		catch (Exception $e) 
		{
	    	//echo 'Caught exception: ',  $e->getMessage(), "\n";
	    	return -1;
		}
		
		$pdo = Database::disconnect();			
	}
}

class Animals
{
	public $id;
	public $animal;
	public $activity;
	public $type;
	public $freshSalt;
	
	public static function withID( $myID ) {
    	$instance = new Animals();
    	$instance->id = $myID;
    	return $instance;
    }
    
    public static function withAllButID($animal,$activity,$type,$freshSalt) 
    {
    	$instance = new Animals();
    	$instance->animal = $animal;
    	$instance->activity = $activity;
    	$instance->type = $type;
    	$instance->freshSalt = $freshSalt;    	
    	return $instance;
    }
	
	public static function withAll($id,$animal,$activity,$type,$freshSalt) {
    	$instance = new Animals();
    	$instance->id = $id;
    	$instance->animal = $animal;
    	$instance->activity = $activity;
    	$instance->type = $type;
    	$instance->freshSalt = $freshSalt; 
    	return $instance;
    }
    
	
	
	
	public function getAnimal()
	{
		$valid = false;
		$pdo = Database::connect();
		$statement = $pdo->prepare("SELECT * FROM animals WHERE id = :id");
		$statement->execute(array(':id' => $this->id));
		// fetch results as array
		$results = $statement->fetchAll(PDO::FETCH_CLASS, "Animal");
		
		$pdo = Database::disconnect();
		
		if(count($results)==0)
		{
			return -1;
		}
		else
		{
			return $results;	
		}
	}
	
	public function deleteAnimal()
	{
		$valid = false;
		$pdo = Database::connect();
		
		$statement = $pdo->prepare("DELETE FROM Animal WHERE id = :id");
		// $statement is now a PDOStatement object, with its own methods to use it, e.g.
		// execute the query, passing in the parameters to replace
		$statement->execute(array(':id' => $this->id));
		// fetch results as rount
		$resultsOutfitter = $statement->rowCount();
		
		$pdo = Database::disconnect();

		if($resultsOutfitter > 0)
		{
			return true;
		}
		else
		{
			return false;	
		}
	}
        
        public function getAnimals($activity = null)
	{
		$pdo = Database::connect();	
                if(is_null($activity))
                {
                    $statement = $pdo->prepare("SELECT * FROM animals Order by freshSalt, if(type = '' or type is null,1,0),type");
                    $statement->execute();
                }
                else
                {
                    $statement = $pdo->prepare("SELECT * FROM animals WHERE activity = :activity Order by freshSalt, if(type = '' or type is null,1,0),type");
                    $statement->execute(array(':activity' => $activity));
                }
		
                
		$results = $statement->fetchAll(PDO::FETCH_CLASS, "Animals");
		
		if(count($results)==0)
		{
                    return -1;
		}
		else
		{
                    return $results;	
		}
		$pdo = Database::disconnect();
	}
        
	
	/*public function createOutfitter()
	{
		$valid = false;
		$pdo = Database::connect();
		
		try 
		{
			$sql = "INSERT INTO Outfitters (name,email,state_ID,city,address,type,phone,lodging,region_id) values(:name,:email,:state_ID,:city,:address,:type,:phone,:lodging,:region)";
			$statement = $pdo->prepare($sql);
			$statement->execute(array(':name'=>$this->name,
														':email'=>$this->email,
														':state_ID'=>$this->state_ID,
														':city'=>$this->city,
														':address'=>$this->address,
														':type'=>$this->type,
														':phone'=>$this->phone,
														':lodging'=>$this->lodging,
														':region'=>$this->region));
				
			$pdo = Database::disconnect();		
			return true;
		}
		
		catch (Exception $e) 
		{
			$pdo = Database::disconnect();	
			//echo 'Caught exception: ',  $e->getMessage(), "\n";
			return -1;
		}
	}
	
	public function linkOutfitter()
	{
		$success = false;
		$pdo = Database::connect();
		
		try 
		{
			$sql = "INSERT INTO Outfitters (name,email,state_ID,city,address,type,phone,lodging,region_id"
                                . ",userEmail) values(:name,:email,:state_ID,:city,:address,:type,:phone,:lodging,:region,:userEmail)";
			$statement = $pdo->prepare($sql);
			$statement->execute(array(':name'=>$this->name,
														':email'=>$this->email,
														':state_ID'=>$this->state_ID,
														':city'=>$this->city,
														':address'=>$this->address,
														':type'=>$this->type,
														':phone'=>$this->phone,
														':lodging'=>$this->lodging,
														':region'=>$this->region,
														':userEmail'=>$this->userEmail));
				
			$results = $statement->rowCount();
			
			if($results > 0)
			{
				//TODO: do this with a transaction
				$outfitterID = $pdo->lastInsertId();
				
				//check if email already exsists
				$instance = new User;
				$user = $instance->getUser($this->userEmail);
				$userID = '';
				
				foreach ($user as $row) 
				{
					$userID = $row['user_id'];
				}
				
				if($userID!='')
				{
					$sql = "INSERT INTO users_outfitters (userID,outfitterID) values(:userID,:outfitterID)";
					$statement = $pdo->prepare($sql);
					$statement->execute(array(':userID'=>$userID,
														':outfitterID'=>$outfitterID));
				
					$userOutfitterCount = $statement->rowCount();
					
					if($userOutfitterCount>0)
					{
						$success = true;
					}
				}
			}
			
			if($success)
				return true;
			else
				return false;
			
			$pdo = Database::disconnect();
		}
		
		catch (Exception $e) 
		{
			$pdo = Database::disconnect();	
			//echo 'Caught exception: ',  $e->getMessage(), "\n";
			return -1;
		}
	}
	
	public function editOutfitter()
	{
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		
		try 
		{
			$sql = "UPDATE Outfitters set name = :name, userEmail = :email2, email = :email, state_ID = :state_ID, city = :city, address = :address, type = :type, phone = :phone, lodging = :lodging, region_id = :region, lastUpdate = :lastUpdate WHERE id = :id";
			$statement = $pdo->prepare($sql);
			$statement->execute(array(':id'=>$this->id,
														':name'=>$this->name,
														':email2'=>$this->email,
														':email'=>$this->email,
														':state_ID'=>$this->state_ID,
														':city'=>$this->city,
														':address'=>$this->address,
														':type'=>$this->type,
														':phone'=>$this->phone,
														':lodging'=>$this->lodging,
														':region'=>$this->region,
														':lastUpdate'=>date("Y-m-d H:i:s", time())));
	
			$results = $statement->rowCount();
			$pdo = Database::disconnect();
			
			if($results > 0)
			{
				return true;
			}
			else
			{
				echo $this->id .' '.$this->name .' '. $this->email .' '.$this->state_ID .' '.$this->city .' '.$this->address .' '.$this->type .' '.$this->phone .' '.$this->lodging .' '.$this->region,
				print_r($statement->errorInfo());
				return false;	
			}
		}
		
		catch (Exception $e) 
		{
			$pdo = Database::disconnect();	
			echo 'Caught exception: ',  $e->getMessage(), "\n";
			
    echo 'Exception -> ';
    var_dump($e->getMessage());
    return -1;
		}
	}
         public function getAllUsersOutfitters($email)
	{
		$pdo = Database::connect();
		$sql = "SELECT * FROM Outfitters outf INNER JOIN
		users_outfitters uo ON uo.outfitterID = outf.id INNER JOIN
		users usrs ON uo.userID = usrs.user_id LEFT JOIN
		us_states state ON outf.state_ID = state.state_id WHERE usrs.email = :email";
		$statement = $pdo->prepare($sql);
		$statement->execute(array(':email'=>$email));
		
		// fetch results as array
		$results = $statement->fetchAll();
		
		if(count($results)==0)
		{
			return -1;
		}
		else
		{
			return $results;	
		}
		
		$pdo = Database::disconnect();
	}

         *          */	
}




function getAllStates($validOnly = false)
{
	$pdo = Database::connect();

    $sql = "SELECT * FROM us_states";

    if($validOnly)
    {
        $sql .= " WHERE abbreviation in ('CO','TX')";

    }



	$statement = $pdo->prepare($sql);
	$statement->execute();
	// fetch results as array
	$results = $statement->fetchAll();
	$pdo = Database::disconnect();
	
	if(count($results)==0)
	{
		return -1;
	}
	else
	{
		return $results;	
	}
}

function getAllActivities($validOnly = false)
{
    return array(
        array("name" => "Hunting", "id" => "hunt"),
        array("name" => "Fishing", "id" => "fish")
    );
}

function getAllOutfitterActivities($validOnly = false)
{
    return array
    (
        "1" => array(
            "Name" => "FREE HUNTS !!",
            "Description" => "Bring 5 paying friends and hunt free Boar Hunts Year-Round",
            "Animals" => "1 Hog, Deer",
            "Spots" => "1-5",
            "OverNight" => "Yes",
            "Guided" => "Yes",
            "Meals" => "No",
            "Price" => "Hog Hunts - $200.00 per day/2 day min. Deer Hunts - $300.00 per day/2 min.",
        ),
        "2" => array(
            "Name" => "Standard Package",
            "Description" => "Hunts run on weekends & holidays. A two day hog hunt begins Friday Evening and ends on Sunday at noon. Longer hunts can arranged by asking for details. On a combination deer & hog hunt the hunters are allowed one buck, 8 pts. & wider than the ears on inside spread. Minimum 15 outside spread. One doe as long as doe permits are available. Dispensed on a first come first serve basis. Hunters are also allowed one hog. On a hog hunt, the hunter is allowed one hog per day. Hunters are asked to use good judgement by not shooting sows. Hunters are asked to take any size boars or young gilts. Hog hunts are year round and conducted over timered feeders. When hogs become nocturnal, we hunt out of box stands, after dark with spotlights and red lens. ",
            "Animals" => "1 Hog",
            "Spots" => "1-4",
            "OverNight" => "2",
            "Guided" => "Yes",
            "Meals" => "Yes",
            "Price" => "$200"
        )/*,
        "3" => array(
            "Name" => "Comfort Duck, Goose and Crane Package",
            "Description" => "We have one of the best moose hunting areas in Alberta. We have exclusive access to over 70 quarter sections of (deeded) private property.Our hunting area is near the town of Wainwright, Alberta, approximately three hours southeast of Edmonton, Alberta. Surrounded by farmland, rolling hills and the famous Battle River, this area possesses all the natural habitat required to produce quality trophy moose. Limited hunting pressure, a good food source, plenty of cover and exclusive access are all keys to a quality moose hunt! ",
            "Animals" => "Specklebelly geese, Sandhill cranes, Ducks, and if in season doves.",
            "Spots" => "3-7",
            "OverNight" => "3",
            "Guided" => "Yes",
            "Meals" => "Yes",
            "Price" => "550"
        ),
        "4" => array(
            "Name" => "Elk Hunting",
            "Description" => "We have one of the best moose hunting areas in Alberta. We have exclusive access to over 70 quarter sections of (deeded) private property.Our hunting area is near the town of Wainwright, Alberta, approximately three hours southeast of Edmonton, Alberta. Surrounded by farmland, rolling hills and the famous Battle River, this area possesses all the natural habitat required to produce quality trophy moose. Limited hunting pressure, a good food source, plenty of cover and exclusive access are all keys to a quality moose hunt! ",
            "Animals" => "2 Elk",
            "Spots" => "1-2",
            "OverNight" => "5",
            "Guided" => "Yes",
            "Meals" => "Yes",
            "Price" => "550"
        )*/
    );
}

function getOutfitterActivity($activityID, $outfitterID, $validOnly = false)
{

    $activities = getAllOutfitterActivities(true);
    return $activities[$activityID];
}

    function isIPValid($address)
    {
        $pdo = Database::connect();
		
	$statement = $pdo->prepare("SELECT * FROM IPaddress WHERE address = :address	");
			
	// $statement is now a PDOStatement object, with its own methods to use it, e.g.
	// execute the query, passing in the parameters to replace
	$statement->execute(array(':address' => $address));
		
	// fetch results as array
	$results = $statement->fetchAll();
	
	$pdo = Database::disconnect();
	
	if(count($results)>0)
	{
            return true;
	}
	else
	{
            return false;	
	}
    }
    
    function addIP($address)
    {
	$pdo = Database::connect();
		
	try 
	{
            $sql = "INSERT INTO IPaddress (address) values(:address)";
            $statement = $pdo->prepare($sql);
            $statement->execute(array(':address'=>$address));
            $pdo = Database::disconnect();		
            return true;
	}
	catch (Exception $e) 
	{
            $pdo = Database::disconnect();	
            //echo 'Caught exception: ',  $e->getMessage(), "\n";
            return -1;
	}
    }
        
    function getAllOutfittersAJAX()
{
	$pdo = Database::connect();

    $statement = $pdo->prepare("SELECT * FROM Outfitters of left join us_states state on of.state_ID = state.state_id ");
    $statement->execute();

	// fetch results as array
	//$results = $statement->fetchAll();
	$results=$statement->fetchAll(PDO::FETCH_ASSOC);
	//$json=json_encode($results);

	$pdo = Database::disconnect();
	
	if(count($results)==0)
	{
		return -1;
	}
	else
	{
		return $results;	
	}
}

function getRegionByState($stateID)
{
    $pdo = Database::connect();

    $statement = $pdo->prepare("SELECT rg.* FROM regions rg LEFT JOIN us_states us on rg.state_id = us.state_id
	 WHERE us.state_id = :stateID");

    // $statement is now a PDOStatement object, with its own methods to use it, e.g.
    // execute the query, passing in the parameters to replace
    $statement->execute(array(':stateID' => $stateID));

    // fetch results as array
    //$results = $statement->fetchAll();
    $results=$statement->fetchAll(PDO::FETCH_ASSOC);
    //$json=json_encode($results);

    $pdo = Database::disconnect();

    if(count($results)==0)
    {
        return -1;
    }
    else
    {
        return $results;
    }
}

function getAllOutfitterTypes()
{
	$outterArray = [];
	$innerArray = [];
	
	$innerArray['type_id'] = "1";
	$innerArray['kind'] = "Hunting";
	array_push($outterArray, $innerArray);
	
	$innerArray['type_id'] = "2";
	$innerArray['kind'] = "Fishing";
	array_push($outterArray, $innerArray);
	
	$innerArray['type_id'] = "3";
	$innerArray['kind'] = "Both";
	array_push($outterArray, $innerArray);
	
	return $outterArray;	
	
}

function getAllOutfitterLodging()
{
	$outterArray = [];
	$innerArray = [];
	
	$innerArray['type_id'] = "1";
	$innerArray['kind'] = "No";
	array_push($outterArray, $innerArray);
	
	$innerArray['type_id'] = "2";
	$innerArray['kind'] = "Yes";
	array_push($outterArray, $innerArray);
	
	return $outterArray;	
	
}

	
?>
