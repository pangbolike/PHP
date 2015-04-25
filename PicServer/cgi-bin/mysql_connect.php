<?php
	 /*
     * @author:pangbolike
     * @date:2015.04.12
     * for pic server utils
     */
	class mysql_data
	{
		private $conn;

		public function __construct($url,$user,$passwd){
			
			$this->conn = mysql_pconnect($url,$user,$passwd);
			if (!$this->conn){
				die('Could not connect: ' . mysql_error());
			}
			mysql_query("set names 'utf8'");
		}
		public function select_db($db_name){
			if (!mysql_select_db($db_name, $this->conn)){
				die("select db error ".mysql_error());
			}
			
		}
		function query($sql)
		{ 
			$result_array=array();  
			$query_result=mysql_query($sql,$this->conn); 
			$i = 0;
			while($row=mysql_fetch_row($query_result)) 
			{
				$result_array[$i++]=$row; 
			}
			return $result_array; 
		}
		function execute($sql)
		{ 
			if (mysql_query($sql,$this->conn)){
				return true;
			}
			else{
				//die('execute mysql error '. mysql_error());
				return false;
			}

		}
		function __destruct(){
			//mysql_close($this->conn);
		}
	}

?>