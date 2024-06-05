<?php

class Image
{
	public $id;
	public $name;
	public $description;
	public $type;
	public $outfitter_id;
	
	public static function withID( $myID ) {
    	$instance = new Image();
    	$instance->id = $myID;
		$instance->initImage();
    	return $instance;
    }

    public static function withAllButID($name,$description,$type,$outfitter_id)
    {
    	$instance = new Image();
    	$instance->name = $name;
    	$instance->comment = $description;
    	$instance->type = $type;
    	$instance->outfitter_id = $outfitter_id;
    	return $instance;
    }

	public static function withAll($id,$name,$description,$type,$outfitter_id) {
    	$instance = new Image();
    	$instance->id = $id;
    	$instance->name = $name;
    	$instance->comment = $description;
    	$instance->type = $type;
    	$instance->outfitter_id = $outfitter_id;
    	return $instance;
    }
    
	public function printImageInfo()
	{
		//echo 'id: '.$this->id." name ".$this->name." outfitter id".$this->outfitter_id." type ".$this->type;
	}
	public function insertImage()
	{
		$success = false;
		$pdo = Database::connect();

		//Logs errors to screen
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		
		try 
		{
			$sql = "INSERT INTO images (name,type,description,outfitter_id) values(:name,:type,:comment,:outfitter_id)";
			$statement = $pdo->prepare($sql);
			$statement->execute(array(':name'=>$this->name,
														':type'=>$this->type,
														':comment'=>$this->comment,
														':outfitter_id'=>$this->outfitter_id));
			
			$results = $statement->rowCount();
			
			if($results > 0)
			{
				//TODO: do this with a transaction
				$this->id = $pdo->lastInsertId();
				
				$success = true;
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
			echo 'Caught exception: ',  $e->getMessage(), "\n";
			return -1;
		}
	}
	
	
	public function initImage()
	{
		$valid = false;
		$pdo = Database::connect();
		$statement = $pdo->prepare("SELECT * FROM images WHERE id = :id ");
		$statement->execute(array(':id' => $this->id));
		// fetch results as array
		$results = $statement->fetch();
		
		$pdo = Database::disconnect();
		
		$this->outfitter_id = $results["outfitter_id"];
		$this->comment = $results["description"];
		$this->name = $results["name"];
		$this->type = $results["type"];
		
		return $results;

	}

	public function updateImage($description)
	{
		$valid = false;
		$pdo = Database::connect();

		//Logs errors to screen
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);


		try
		{
			$sql = "UPDATE images set description = :description WHERE ID = :imageID";
			$statement = $pdo->prepare($sql);
			$statement->execute(array(':description'=>$description,
				':imageID'=>$this->id));

			$pdo = Database::disconnect();
			return true;
		}
		catch (Exception $e)
		{
			$pdo = Database::disconnect();
			echo 'Caught exception: ',  $e->getMessage(), "\n";
			return -1;
		}
	}


	public function isUserImage($email,$imageId)
	{
		//Returns -1 if image does not belong to the user
		//Returns the image if it does

		$valid = false;
		$pdo = Database::connect();
		$sql = "SELECT * FROM users_outfitters uo INNER JOIN
		users usrs ON uo.userID = usrs.user_id INNER JOIN
		images img ON img.outfitter_id = uo.outfitterID
		WHERE usrs.email = :email
		AND img.id = :img_id";
		$statement = $pdo->prepare($sql);
		$statement->execute(array(':email' => $email, ':img_id' => $imageId));

		// fetch results as array
		$results = $statement->fetch();
		$pdo = Database::disconnect();

		if (count($results) == 0)
		{
			return -1;
		}
		else
		{
			return $results;
		}
	}


    public function getImageExtended($imageId)
    {
        //Returns -1 if image does not belong to the user
        //Returns the image if it does

        $valid = false;
        $pdo = Database::connect();
        $sql = "SELECT * FROM users_outfitters uo INNER JOIN
		users usrs ON uo.userID = usrs.user_id INNER JOIN
		images img ON img.outfitter_id = uo.outfitterID
		WHERE img.id = :img_id";
        $statement = $pdo->prepare($sql);
        $statement->execute(array(':img_id' => $imageId));

        // fetch results as array
        $results = $statement->fetch();
        $pdo = Database::disconnect();

        if (count($results) == 0)
        {
            return -1;
        }
        else
        {
            return $results;
        }
    }
	
	
	public function getImage()
	{
		$valid = false;
		$pdo = Database::connect();
		$statement = $pdo->prepare("SELECT * FROM images WHERE id = :id");
		$statement->execute(array(':id' => $this->id));
		// fetch results as array
        $statement->setFetchMode(PDO::FETCH_CLASS, "Image");

        $results = $statement->fetch();

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
	
	
	
	public function deleteImage()
	{
		$valid = false;
		$pdo = Database::connect();
		$resultsOutfitter = 0;
		
		$FileLocation = $_SERVER['DOCUMENT_ROOT'].'/upload/images/'.$this->outfitter_id.'/' . $this->id.'.'.$this->type;
		
		if(file_exists($FileLocation) && unlink($FileLocation))
		{
		
			$statement = $pdo->prepare("DELETE FROM images WHERE id = :id");
			// $statement is now a PDOStatement object, with its own methods to use it, e.g.
			// execute the query, passing in the parameters to replace
			$statement->execute(array(':id' => $this->id));
			// fetch results as rount
			$resultsOutfitter = $statement->rowCount();
			
			$pdo = Database::disconnect();
		}
		
		if($resultsOutfitter > 0)
		{
			return true;
		}
		else
		{
			return false;	
		}
	}

	public function getAllOutfitterImages($id)
	{
		$pdo = Database::connect();
		$sql = "SELECT * FROM images where outfitter_id = :id";
		$statement = $pdo->prepare($sql);
		$statement->execute(array(':id'=>$id));
		
		// fetch results as array
		$results = $statement->fetchAll();
		
		if(count($results)==0)
		{
			return array();
		}
		else
		{
			return $results;
		}
		
		$pdo = Database::disconnect();
	}

	public function getOutfitterImage($id,$imageID)
	{
		$pdo = Database::connect();
		$sql = "SELECT * FROM images where outfitter_id = :id AND id = :imageID";
		$statement = $pdo->prepare($sql);
		$statement->execute(array(':id'=>$id, ":imageID"=>$imageID));

		// fetch results as array
		$results = $statement->fetchAll();

		if(count($results)==0)
		{
			return array();
		}
		else
		{
			return $results;
		}

		$pdo = Database::disconnect();
	}
}

?>