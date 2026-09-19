<?php
	//sqlite class that using pdo!, can be used with mysql eather.
	class Database{
		
		const DBTYPE_SQLITE = "sqlite";
		const DBTYPE_MYSQL = "mysql";
		
		// sqlite class constants:
		const TYPE_KEY = "INTEGER PRIMARY KEY NOT NULL AUTO_INCREMENT";
		const TYPE_STRING = "VARCHAR(90)";
		const TYPE_NUMBER = "INTEGER";
		const TYPE_TEXT = "TEXT";
		const TYPE_BOOLEAN = "BOOLEAN";
		
		//error codes:
		const CODE_ZERO = 0;
		const CODE_TABLE_NOT_EXISTS = 1;
		
		private $dbtype = "";
		private $mysql_host = "";
		private $mysql_user = ""; 
		private $mysql_pass = "";
		private $mysql_database = "";
		
		public $pathDatabases = "";
		public $dbFilepath = "";
		public $databaseAbsolutePath = "";
		public $handle = false;
		public $lastRowID = -1;
		public $lastArr = array();
		
		
		//class constructor set paths and db filename
		function __construct($dbtype,$dbFilename=""){
			//validate type:
			switch($dbtype){
				case self::DBTYPE_SQLITE:
				case self::DBTYPE_MYSQL:
					$this->dbtype = $dbtype;
				break;
				default:
					throw new Exception("Wrong dbtype:$dbtype, please give a proper type(".self::DBTYPE_SQLITE." or ".self::DBTYPE_MYSQL.").");
				break;
			}
			
			if(!class_exists("PDO")) throw new Exception("PDO php extension doesn't activated, please activate it in php.ini");
			
			if($dbtype == self::DBTYPE_SQLITE){
				if($dbFilename == "") throw new Exception("No db file given."); 
				$this->setDbFile($dbFilename);
			}
		}
		
		//------------------------------------------------------------
		// class destructor - release handle
		function __destruct(){
			$this->handle = null;
		}
		
		//------------------------------------------------------------
		//set mysql properties
		public function setMysqlData($host,$user,$pass,$database){
			$this->mysql_host = $host;
			$this->mysql_user = $user;
			$this->mysql_pass = $pass;
			$this->mysql_database = $database;
			$this->getCreateDatabase();
		}
		
		//------------------------------------------------------------
		
		public function exitWithMessage($message="",$code=self::CODE_ZERO){
			//throw exception if no code.
			if($code == self::CODE_ZERO) throw new Exception($message);
			
			//if there is a code - return error.
			return(array("success"=>false,"message"=>$message,"code"=>$code));
		}
		
		//------------------------------------------------------------
		
		public function confirmOutput($message=""){
			return(array("success"=>true,"message"=>$message));
		}
		
		//------------------------------------------------------------
		// validates if handle exists. if not - exit with error message
		public function validateHandle($functionName = ""){
			if($this->handle == false){
				if($functionName) $this->exitWithMessage("$functionName error - no open database");
				else $this->exitWithMessage("sqlite error - no open database");
			}
			return($this->confirmOutput());
		}
		
		//------------------------------------------------------------
		// validate table name field if empty or not exists - write error and exit.
		public function validateTableName($tableName,$functionName=""){			
			if(trim($tableName) == ""){
				if($functionName) $this->exitWithMessage("$functionName error - no table found");
				else $this->exitWithMessage("sqlite error - no table found");
			}
		}
		
		//------------------------------------------------------------
		// validate if table is created. if not - write error message and exist
		public function validateTable($tableName,$functionName){
			$this->validateTableName($tableName,$functionName);
			if($this->isTableExists($tableName) == false){
				if($functionName) return($this->exitWithMessage("$functionName error - the table $tableName doesn't exists",self::CODE_TABLE_NOT_EXISTS));
				else return($this->exitWithMessage("sqlite error - the table $tableName doesn't exists",self::CODE_TABLE_NOT_EXISTS));
			}
			return($this->confirmOutput());
		}
		
		//------------------------------------------------------------
		// valiadte fields array. if empty or the type is not array - write error message and exit.
		public function validateFields($arrFields,$functionName=""){
			if(gettype($arrFields)!="array") $this->exitWithMessage("createTable error - the fields array isn't array type.");
			if(count($arrFields) == 0) $this->exitWithMessage("createTable error - the fields don't given.");
		}
		
		//------------------------------------------------------------
		// set database file (without path)
		public function setDbFile($dbFilepath){
			$this->dbFilepath = $dbFilepath;
			$response = $this->getCreateDatabase();
			return($response);
		}

		//------------------------------------------------------------
		
		public function setAbsolutePath($path){
			$this->databaseAbsolutePath = $path;
			$this->dbFilepath = "";
		}
		
		//------------------------------------------------------------
		
		public function getLastRowID(){
			return($this->lastRowID);
		}
		
		//------------------------------------------------------------
		// return if table exists or not.
		public function isTableExists($tableName){
			$sql = 'select * from '.$tableName;
			try {			
				$result = $this->handle->query($sql);
			}catch(PDOException $e){
				return(false);
			}
			
			if($this->handle->errorCode() == "00000") return(true);
			return(false);
		}

		//------------------------------------------------------------
		// create database. if already created - get database.
		public function getCreateDatabase(){
			
			try {
				if($this->dbtype == self::DBTYPE_MYSQL){
					$dsn = 'mysql:dbname='.$this->mysql_database.';host='.$this->mysql_host;
					$user = $this->mysql_user;
					$password = $this->mysql_pass;
					$this->handle = new PDO($dsn, $user, $password);
				}
				else{	//sqlite
					if(trim($this->dbFilepath) == "") $this->exitWithMessage("No database file given. can't create handle.");
					$this->handle = new PDO("sqlite:".$this->dbFilepath);				
				}
				
			} catch (PDOException $e) {
				$message = "PDO error: can't connect to database. ".$e->getMessage();
				//$message .= "<br>Please activate the driver for PDO with ".$this->dbtype . " in your php.ini";
				//phpinfo();
				throw new Exception($message);
			}
			
			return($this->confirmOutput());
		}

		//------------------------------------------------------------
		// delete table
		public function deleteTable($tableName){
			// params validation
			$this->validateTableName($tableName,"deleteTable");
			
			$this->validateHandle("deleteTable");
			
			if(!$this->isTableExists($tableName)) return($this->confirmOutput());
			
			$query = "DROP TABLE $tableName";
			
			try{
				$count = $this->handle->exec($query);
			}catch(PDOException $e){
				$this->exitWithMessage($e->getMessage());
			}
			
			$this->checkForErrors("delete table error",$query);
			
			return($this->confirmOutput());
		}
		
		//------------------------------------------------------------
		// validate for errors
		private function checkForErrors($prefix = "",$query=""){
			if($this->handle->errorCode() == "00000") return(false);
			else{
				$arrInfo = $this->handle->errorInfo();
				$message = $arrInfo[2];
				if($prefix) $message = $prefix.' - '.$message;
				if($query) $message .=  ' query: ' . $query;
				$this->exitWithMessage($message);
			}
		}
		
		//------------------------------------------------------------
		// create table in database from arrFields (array["fieldname","key"])
		public function createTable($tableName,$arrFields){
		
			// params validation
			$this->validateTableName($tableName,"createTable");
			
			$this->validateFields($arrFields,"createTable");
						
			$this->validateHandle("createTable");
			
			if($this->isTableExists($tableName)) return($this->confirmOutput());
			
			$strFieldscreate = "";
			foreach($arrFields as $field=>$type){
				if($strFieldscreate != "") $strFieldscreate .= ",";
				$strFieldscreate .= "$field $type";
			}
			
			$query = "CREATE TABLE $tableName($strFieldscreate)";
			
			//dmp($query);
			//exit();
			
			try{
				$count = $this->handle->exec($query);				
				
			}catch(PDOException $e){
				$this->exitWithMessage($e->getMessage());
			}
			
			$this->checkForErrors("create",$query);
			
			return($this->confirmOutput());
		}
		
		
		//------------------------------------------------------------
		// insert to table tablename, array([fieldname , data])
		public function insert($tableName,$arrData){
			$response = $this->validateTable($tableName,"insert");
			if($response["success"] == false) return($response);
			
			$this->validateFields($arrData,"insert");
			
			$insertFieldsQuery = "";
			$strFields = "";
			$strValues = "";
			foreach($arrData as $field=>$value){
				$value = $this->escape($value);
				
				if($field == "id") continue;
				if($strFields != "") $strFields .= ",";
				if($strValues != "") $strValues .= ",";
				$strFields .= $field;
				$strValues .= $value;
			}
			
			$insertQuery = "insert into $tableName($strFields) values($strValues)";						
			
			try{
				$count = $this->handle->exec($insertQuery);
			}catch(PDOException $e){
				$this->exitWithMessage($e->getMessage());
			}
			
			$this->checkForErrors("insert error",$insertQuery);
			
			if($count == 0) $this->exitWithMessage("sqlite insert error - no rows affected");

			$this->lastRowID = $this->handle->lastInsertId();
			
			return(array("success"=>true,"lastID"=>$this->lastRowID));
		}
		
		//------------------------------------------------------------
		// fetch all rows in array from table
		public function fetch($tableName,$where="",$orderField="",$groupByField=""){
			$response = $this->validateTable($tableName,"fetch");
			if($response["success"] == false) return($response);
			
			$query = "select * from $tableName";
			if($where) $query .= " where $where";
			if($groupByField) $query .= " group by $groupByField";
			if($orderField) $query .= " order by $orderField";
			
			$stat = $this->handle->prepare($query);
			$this->checkForErrors("fetch error",$query);
			$stat->execute();
			
			$this->lastArr = $stat->fetchAll(PDO::FETCH_ASSOC);
			return(array("success"=>true,"rows"=>$this->lastArr));
		}
		
		//------------------------------------------------------------
		// fetch rows with paging
		public function fetchPage($page,$inpage,$tableName,$where="",$orderField="",$groupByField=""){
			$response = $this->validateTable($tableName,"fetchPage");
			if($response["success"] == false) return($response);
			
			$query = "select * from $tableName";
			if($where) $query .= " where $where";
			if($groupByField) $query .= " group by $groupByField";
			if($orderField) $query .= " order by $orderField";
			
			//get num rows:
			$response = $this->getNumRows($tableName,$where);
			if($response["success"] == false) return($response);
			
			$totalRows = $response["numRows"];
			if($totalRows == 0) return($this->fetchSql($query));
			
			$numPages = ceil($totalRows / $inpage);
			if($page>$numPages) $page = $numPages;
			if($page<1) $page = 1;
			
			$offset = ($page-1)*$inpage;
			$nextPage = $page+1;
			if($nextPage > $numPages) $nextPage = 0;
			$prevPage = $page-1;
			
			$query .= " limit $offset,$inpage";
			
			$response = $this->fetchSql($query);
			if($response["success"] == false) return($response);
			
			$response["page"] = $page;
			$response["numPages"] = $numPages;
			$response["nextPage"] = $nextPage;
			$response["prevPage"] = $prevPage;
			
			return($response);
		}
		
		//------------------------------------------------------------
		// fetch all rows in array from table
		public function fetchSql($sql){
			$stat = $this->handle->prepare($sql);
			$this->checkForErrors("fetch sql",$sql);
			$rows = $stat->execute();			
			$this->lastArr = $stat->fetchAll(PDO::FETCH_ASSOC);
			return(array("success"=>true,"rows"=>$this->lastArr));		
		}
		
		//--------------------------------------------------------------------------------------------------------------
		// execute sql query
		public function runSql($query){
		
			try{
				$count = $this->handle->exec($query);
			}catch(PDOException $e){
				$this->exitWithMessage($e->getMessage());
			}
			$this->checkForErrors("run sql error",$query);
			
			return($this->confirmOutput());
		}
		
		//--------------------------------------------------------------------------------------------------------------
		//get num rows of the query
		public function getNumRows($tableName,$where=""){
			$response = $this->validateTable($tableName,"get num rows");
			if($response["success"] == false) return($response);
			
			$query = "select count(*) as count from $tableName";
			if($where) $query .= " where $where";
			
			$stat = $this->handle->prepare($query);	
			$this->checkForErrors("get num rows error",$query);			
			$rows = $stat->execute();
			
			$row = $stat->fetch(PDO::FETCH_ASSOC);
			
			$numRows = $row["count"];
			
			return(array("success"=>true,"numRows"=>$numRows));
		}
		
		//--------------------------------------------------------------------------------------------------------------
		// get max field value
		public function getMaxValue($tableName,$field,$where=""){
			$response = $this->validateTable($tableName,"getMaxValue");
			if($response["success"] == false) return($response);
			
			$query = "select MAX($field) as maxValue from $tableName";
			if($where) $query .= " where $where";
			
			$response = $this->fetchSql($query);
			if($response["success"] == false) return($response);
			$maxValue = 0;
			$rows = $response["rows"];
			if(count($rows)>0) $maxValue = $rows[0]["maxValue"];
			if($maxValue == "") $maxValue = 0;
			return(array("success"=>true,"maxValue"=>$maxValue));
		}		
		
		//------------------------------------------------------------		
		//return escape database parameter string.
		public function escape($str){
			$str = $this->handle->quote($str);
			return($str);
		}
		
		//------------------------------------------------------------		
		//return if the row with some condition exists		
		public function isRowExists($tableName,$where=""){
			$response = $this->validateTable($tableName,"isRowExists");
			if($response["success"] == false) return($response);
			
			$response = $this->getNumRows($tableName,$where);
			$found = false;
			if($response["numRows"] > 0) $found = true;
			
			return(array("success"=>true,"exists"=>$found));
		}
		
		//------------------------------------------------------------
		//replace some row in the table (insert, and then delete)
		public function replace($tableName,$arrData,$where=""){
			$response = $this->delete($tableName,$where);
			if($response["success"] == true) $response = $this->insert($tableName,$arrData,$where="");
			return($response);
		}
		
		//------------------------------------------------------------
		// update some row in the table.
		public function update($tableName,$arrData,$where=""){
			$response = $this->validateTable($tableName,"update");
			if($response["success"] == false) return($response);
			
			$this->validateFields($arrData,"update");
			if($where == "") $this->exitWithMessage("update error, there must be a where parameter (3-th one)");
			
			$strFields = "";
			foreach($arrData as $field=>$value){
				$value = $this->escape($value);
				if($strFields != "") $strFields .= ",";
				$strFields .= "$field=$value";
			}
			$updateQuery = "update $tableName set $strFields where $where";

			try{
				$count = $this->handle->exec($updateQuery);
			}catch(PDOException $e){
				$this->exitWithMessage($e->getMessage());
			}
			
			$this->checkForErrors("update error",$updateQuery);
			
			return($this->confirmOutput());
		}
		
		//------------------------------------------------------------
		// delete some row or rows from the table.
		public function delete($tableName,$where){
			$response = $this->validateTable($tableName,"delete");
			if($response["success"] == false) return($response);
			
			if($where == "") $this->exitWithMessage("delete error, there must be a where parameter (second one)");
			$deleteQuery = "delete from $tableName where $where";
			
			try{
				$count = $this->handle->exec($deleteQuery);
			}catch(PDOException $e){
				$this->exitWithMessage($e->getMessage());
			}
			
			$this->checkForErrors("delete error",$deleteQuery);
			
			return($this->confirmOutput());
		}
		
		//------------------------------------------------------------
		// delete all rows from the table
		public function clearTable($tableName){
			$response = $this->validateTable($tableName,"clear table");
			if($response["success"] == false) return($response);
			
			$response = $this->runSql("delete from ".$tableName);
			return($response);
		}
		
	}// Database class end.

?>