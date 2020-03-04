<?php
include "db_config.php";

	class User{
	
		public $db;

		public function __construct(){
			$this->db = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABSE);

			if(mysqli_connect_errno()) {
				echo "Error: Could not connect to database.";
			        exit;
			}
		}

		//get Model Details by Detail ID
		public function get_model_details($model_id)
		{

		$stmt = $this->db->prepare("SELECT model_id,model_name,model_color,model_manufacturer_year,table1.manufacturer_id,manufacturer_name FROM model_tb as table1 INNER JOIN manufacturer_tb as table2 ON table1.manufacturer_id = table2.manufacturer_id where  model_id=?");
        $stmt->bind_param("s", $model_id);
        $stmt->execute();
        $stmt->bind_result($model_id,$model_name,$model_color,$model_manufacturer_year,$manufacturer_id,$manufacturer_name);
        $stmt->fetch();
		$result = array();

        $result['model_id'] = $model_id;
        $result['model_name'] = $model_name;
        $result['model_color'] = $model_color;
        $result['model_manufacturer_year'] = $model_manufacturer_year;
		$result['manufacturer_id'] = $manufacturer_id;
		$result['manufacturer_name'] = $manufacturer_name;
		return $result;
			
		}
		
		// get manufacturer lists
		public function get_manufacturer_lists(){

			$sql="SELECT * FROM manufacturer_tb order by manufacturer_id DESC ";	
        	$result = mysqli_query($this->db,$sql);

        	return $result;
			
		}


		//get Inventory Lists
		public function get_model_lists(){

			$sql="SELECT * FROM model_tb as table1 INNER JOIN manufacturer_tb as table2 ON table1.manufacturer_id = table2.manufacturer_id order by model_id DESC";

        	$result = mysqli_query($this->db,$sql);
        
        	return $result;
			
		}

		//Add New Manufaturer
		public function add_new_manufaturer($manufaturer_name)
		{
		
			$sql="INSERT INTO manufacturer_tb (manufacturer_name) VALUES ('$manufaturer_name')";
			$result = mysqli_query($this->db,$sql);
			return $result;

		}

		// Upload Model Images
		public function add_images($model_id,$image_name)
		{
		
			$sql="INSERT INTO model_images (model_id,image_path) VALUES ('$model_id','$image_name')";
			$result = mysqli_query($this->db,$sql);
			return $result;

		}


		// add new Inventory
		public function add_new_model($model_id,$model_name, $model_color,$model_manufacturer_year,$manufacturer_id,$count,$registration_number,$note)
		{
				
			$sql="INSERT INTO model_tb (model_id,model_name, model_color,model_manufacturer_year,registration_number,Note,inventory,manufacturer_id)
			VALUES ('$model_id','$model_name', '$model_color', '$model_manufacturer_year', '$registration_number', '$note', '$count', '$manufacturer_id')";
			
        	$result = mysqli_query($this->db,$sql);
        	
        	return $result;
		}

		//delete inventory

		public function delete_model($model_id){
			
			$sql="delete from model_tb where model_id=$model_id";
		
			$result = mysqli_query($this->db,$sql);
			
			return $result;
		}

		// get row count from custom table
		public function get_row_count($table,$cond){

			$sql2="SELECT COUNT(*) FROM $table where 1 $cond";
			
			$result = mysqli_query($this->db,$sql2);
			$row = mysqli_fetch_row($result);   
        
        	return $row[0];
			
		}
	
	}
?>