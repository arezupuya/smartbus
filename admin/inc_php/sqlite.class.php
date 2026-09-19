<?php
	class Database{	
		// sqlite class constants:
		const TYPE_KEY = "INTEGER PRIMARY KEY";
		const TYPE_STRING = "CHAR(256)";
		const TYPE_NUMBER = "INTEGER";
		const TYPE_TEXT = "TEXT";
		const TYPE_BOOLEAN = "BOOLEAN";
		
		//error codes:
		const CODE_ZERO = 0;
		const CODE_TABLE_NOT_EXISTS = 1;
		
		public $pathDatabases = "";
		public $dbFilepath = "";
		public $databaseAbsolutePath = "";
		public $handle = false;
		public $lastRowID = -1;
		public $lastArr = array();
		
		//class constructor set paths and db filename
		function __construct($dbFilename){
			if(function_exists('sqlite_open') == false)
				throw new Exception("You need the php sqlite extension to be available in order to run this application. Please turn it on in php.ini");
			if($dbFilename == "") $this->exitWithMessage("No db file given.");
			$this->setDbFile($dbFilename);
		}
		
		//------------------------------------------------------------
		// class destructor - release handle
		function __destruct(){
			if($this->handle) sqlite_close($this->handle);
		}
		
		//------------------------------------------------------------
		
		public function exitWithMessage($message="",$code=Database::CODE_ZERO){
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
				if($functionName) return($this->exitWithMessage("$functionName error - no open database"));
				else return($this->exitWithMessage("sqlite error - no open database"));
			}
			return($this->confirmOutput());
		}
		
		//------------------------------------------------------------
		// validate table name field if empty or not exists - write error and exit.
		public function validateTableName($tableName,$functionName=""){			
			if(trim($tableName) == ""){
				if($functionName) return($this->exitWithMessage("$functionName error - no table found"));
				else return($this->exitWithMessage("sqlite error - no table found"));
			}
			return($this->confirmOutput());
		}
		
		//------------------------------------------------------------
		// validate if table is created. if not - write error message and exist
		public function validateTable($tableName,$functionName){
			$this->validateTableName($tableName,$functionName);
			if($this->isTableExists($tableName) == false){
				if($functionName) return($this->exitWithMessage("$functionName error - the table $tableName doesn't exists",Database::CODE_TABLE_NOT_EXISTS));
				else return($this->exitWithMessage("sqlite error - the table $tableName doesn't exists",Database::CODE_TABLE_NOT_EXISTS));
			}
			return($this->confirmOutput());
		}
		
		//------------------------------------------------------------
		// valiadte fields array. if empty or the type is not array - write error message and exit.
		public function validateFields($arrFields,$functionName=""){
			if(gettype($arrFields)!="array")  return($this->exitWithMessage("createTable error - the fields array isn't array type."));
			if(count($arrFields) == 0) return($this->exitWithMessage("createTable error - the fields don't given."));
			return($this->confirmOutput());
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
			$this->validateHandle("isTableExists");
			$result = @sqlite_fetch_column_types($tableName,$this->handle);
			if($result) return(true);
			else return(false);
		}

		//------------------------------------------------------------
		// create database. if already created - get database.
		public function getCreateDatabase(){			
			if(trim($this->dbFilepath) == "") $this->exitWithMessage("empty database. can't create.");			
			$this->handle = sqlite_open($this->dbFilepath, 0666, $sqliteError);
			if(!$this->handle) return($this->exitWithMessage("createDatabase error - can't get or create datbase file: ".$this->dbFilepath." error: $sqliteError"));
			return($this->confirmOutput());
		}

		//------------------------------------------------------------
		// delete table
		public function deleteTable($tableName){
			// params validation
			$response = $this->validateTableName($tableName,"deleteTable");
			if($response["success"] == false) return($response);			
			
			$response = $this->validateHandle("deleteTable");
			if($response["success"] == false) return($response);
			
			if(!$this->isTableExists($tableName)) return($this->confirmOutput());
			
			$query = "DROP TABLE $tableName";
			
			@sqlite_exec($this->handle, $query ,$error);
			
			if($error) return($this->exitWithMessage("sqlite deleteTable error - $error"));			
			return($this->confirmOutput());	
		}
		
		//------------------------------------------------------------
		// create table in database from arrFields (array["fieldname","key"])
		public function createTable($tableName,$arrFields){		
			// params validation
			$response = $this->validateTableName($tableName,"createTable");
			if($response["success"] == false) return($response);
			
			$response = $this->validateFields($arrFields,"createTable");
			
			if($response["success"] == false) return($response);
			
			$response = $this->validateHandle("createTable");			
			if($response["success"] == false) return($response);
			
			if($this->isTableExists($tableName)) return($this->confirmOutput());
			
			$strFieldscreate = "";
			foreach($arrFields as $field=>$type){
				if($strFieldscreate != "") $strFieldscreate .= ",";
				$strFieldscreate .= "$field $type";
			}
			
			$query = "CREATE TABLE $tableName($strFieldscreate)";
			
			@sqlite_exec($this->handle, $query ,$error);
			
			if($error) return($this->exitWithMessage("sqlite createTable error - $error"));
			
			return($this->confirmOutput());
		}
		
		
		
		//------------------------------------------------------------
		// insert to table tablename, array([fieldname , data])
		public function insert($tableName,$arrData){		
			$response = $this->validateTable($tableName,"insert");
			
			if($response["success"] == false) return($response);
			
			$response = $this->validateFields($arrData,"insert");
			
			$insertFieldsQuery = "";
			$strFields = "";
			$strValues = "";
			foreach($arrData as $field=>$value){
				$value = sqlite_escape_string($value);
				
				if($field == "id") continue;
				if($strFields != "") $strFields .= ",";
				if($strValues != "") $strValues .= ",";
				$strFields .= $field;
				$strValues .= "'$value'";
			}
			
			$insertQuery = "insert into $tableName($strFields) values($strValues)";
			
			@sqlite_exec($this->handle, $insertQuery ,$error);
			if($error) return($this->exitWithMessage("sqlite insert error - [$error]"));
			$this->lastRowID = sqlite_last_insert_rowid($this->handle);
			
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
			
			$rs = @sqlite_query($this->handle,$query,SQLITE_ASSOC,$error);			
			if(!$rs) return($this->exitWithMessage("sqlite fetch error - [$error]"));
			$this->lastArr = sqlite_fetch_all($rs);
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
			$rs = @sqlite_query($this->handle,$sql,SQLITE_ASSOC,$error);
			if(!$rs) return($this->exitWithMessage("sqlite fetch error - [$error]"));
			$this->lastArr = sqlite_fetch_all($rs);
			return(array("success"=>true,"rows"=>$this->lastArr));		
		}
		
		//--------------------------------------------------------------------------------------------------------------
		// execute sql query
		public function runSql($query){
			@sqlite_exec($this->handle, $query ,$error);
			if($error) return($this->exitWithMessage("sqlite error - [$error]"));
			return($this->confirmOutput());
		}
		
		//--------------------------------------------------------------------------------------------------------------
		//get num rows of the query
		public function getNumRows($tableName,$where=""){
			$response = $this->validateTable($tableName,"fetch");
			if($response["success"] == false) return($response);			
			$query = "select * from $tableName";			
			if($where) $query .= " where $where";
			$rs = @sqlite_query($this->handle,$query,SQLITE_ASSOC,$error);			
			if(!$rs) return($this->exitWithMessage("sqlite getNumRows error - [$error]"));			
			$numRows = sqlite_num_rows($rs);
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
			return(sqlite_escape_string($str));
		}
		
		//------------------------------------------------------------		
		//return if the row with some condition exists		
		public function isRowExists($tableName,$where){
			$response = $this->validateTable($tableName,"isRowExists");
			
			if($response["success"] == false) return($response);
			if(trim($where) == "") $this->exitWithMessage("isRowExists error - empty where stumment"); 
			
			$query = "select * from $tableName where $where";
			
			$rs = @sqlite_query($this->handle,$query,SQLITE_ASSOC,$error);
			if(!$rs) return($this->exitWithMessage("sqlite isRowExists error - [$error]"));
			
			$found = false;
			if(sqlite_num_rows($rs) > 0) $found = true;
			
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
			$this->validateTable($tableName,"update");
			$this->validateFields($arrData,"update");
			if($where == "") return(exitWithMessage("sqlite update error, there must be a where parameter (3-th one)"));
			
			$strFields = "";
			foreach($arrData as $field=>$value){
				$value = sqlite_escape_string($value);
				if($strFields != "") $strFields .= ",";
				$strFields .= "$field='$value'";
			}
			$updateQuery = "update $tableName set $strFields where $where";
			@sqlite_exec($this->handle, $updateQuery ,$error);
			if($error) return($this->exitWithMessage("sqlite upadte error - [$error]"));
			return($this->confirmOutput());
		}
		
		//------------------------------------------------------------
		// delete some row or rows from the table.
		public function delete($tableName,$where){
			$this->validateTable($tableName,"update");
			if($where == "") return(exitWithMessage("sqlite delete error, there must be a where parameter (second one)"));
			$deleteQuery = "delete from $tableName where $where";
			@sqlite_exec($this->handle, $deleteQuery ,$error);
			if($error) return($this->exitWithMessage("sqlite delete error - [$error]"));
			return($this->confirmOutput());
		}
		
		//------------------------------------------------------------
		// delete all rows from the table
		public function clearTable($tableName){
			$this->validateTable($tableName,"update");
			$deleteQuery = "delete from $tableName";
			@sqlite_exec($this->handle, $deleteQuery ,$error);
			if($error) return($this->exitWithMessage("sqlite clearTable error - [$error]"));
			return($this->confirmOutput());
		}
				
		
		//------------------------------------------------------------
		// show table fields
		public function showTable($tableName){
			if($this->isTableExists($tableName) == false){
				dmp("The table: <b>$tableName</b> doesn't exists");
				return(false);
			}
			$list = sqlite_fetch_column_types($tableName,$this->handle);
			dmp($list);
		}		
		
		
	}// Database class end.

?>