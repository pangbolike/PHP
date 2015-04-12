<?php
	require("config.php");
      require("mysql_connect.php");
	function getNewPicId($openid,$picInfo){
		$query = new mysql_data(PIC_CON_URL,PIC_CON_USER,PIC_CON_PASSWD);
      	$query->select_db(FACE_DATABASE);
      	$time = (int)time();
      	$sql = sprintf("select pic_id from %s where openid = '%s' and upload_time > %d"
      			,FACE_INFO_TABLE,$openid,$time - PIC_DELAY_TIME);
      	if (count($query->query($sql)) != 0)
      		return -1;
      	$sql = sprintf("insert into %s values(null,'%s','%s','%d')"
      			,FACE_INFO_TABLE,$openid,$picInfo,$time);
      	if (!$query->execute($sql))
      		return -2;
      	$sql = sprintf("select max(pic_id) from %s where openid = '%s'"
      			,FACE_INFO_TABLE,$openid);
      	$ans = $query->query($sql);
      	if (count($ans) == 0)
      		return -1;
      	return (int)$ans[0][0];
	}
      function CheckParams($paraArr){
            foreach ($paraArr as $item) {
            if (!isset($_GET[$item]) || $_GET[$item] == "")
                  return false;
            }
            return true;
      }
      function ParamsError(){
            $ans = array();
            $ans["ret"] = -1;
            $ans["msg"] = "Params error";
            echo addCallBack($_GET["callback"],getUrlJson($ans));
      }
      function SystemError(){
            $ans = array();
            $ans["ret"] = -1;
            $ans["msg"] = "SystemError";
            echo addCallBack($_GET["callback"],getUrlJson($ans));
      }
?>