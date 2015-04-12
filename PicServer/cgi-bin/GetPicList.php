<?php
    /*
    * @author:pangbolike
    * @date:2015.04.12
    * cgi for get user's pic info list
    */
	require("utils.php");
	if (!CheckParams(array("openid")))
	{
		ParamsError();
		return ;
	}
	/*
    *check right modules here
    *
    */

	$query = new mysql_data(PIC_CON_URL,PIC_CON_USER,PIC_CON_PASSWD);
    $query->select_db(FACE_DATABASE);
    $sql = sprintf("select pic_id,pic_info from %s where openid = '%s'",FACE_INFO_TABLE,$_GET["openid"]);
    $ans = $query->query($sql);
    $count = count($ans);
    $ret["ret"] = 0;
    $ret["msg"] = "success";
    $pic_list = array();
    for ($i = 0;$i < $count ;$i++)
    {
    	$picInfo = json_decode($ans[$i][1],true);
    	$picInfo["pic_url"] = FACE_PIC_URL.FACE_PIC_NAME.$ans[$i][0].$picInfo["pic_ext"];
    	array_push($pic_list, $picInfo);
    }
    $ret["pic_list"] = $pic_list;
    echo addCallBack($_GET["callback"],getUrlJson($ret));
?>