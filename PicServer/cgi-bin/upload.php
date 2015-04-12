<?php
	require("utils.php");
	if (!CheckParams(array("openid","pic_name")))
	{
		ParamsError();
		return ;
	}
	/*
	 *check right modules here
	 *
	*/

	$tp = array("image/pjpeg","image/jpeg","image/png","image/bmp");
	$extArray = array(".jpg",".jpg",".png",".bmp");

	$isOk = false;
	$arraySize = count($tp);
	for ( $i = 0 ; $i < $arraySize ; $i++)
	{
		if ($_FILES["filename"]["type"] == $tp[$i])
		{
			$picType = $tp[$i];
			$picExt = $extArray[$i];
			$isOk = true;
			break;
		}
	}
	if(!$isOk){
		$ans = array();
      	$ans["ret"] = -1;
      	$ans["msg"] = "File Type is incorrect";
      	echo addCallBack($_GET["callback"],getUrlJson($ans));
		return ;
	}

	$openid = $_GET["openid"];
	$picInfo = array();
	$picInfo["pic_name"] = $_GET["pic_name"];
	$picInfo["pic_type"] = $picType;
	$picInfo["pic_ext"] = $picExt;
	$pic_id = getNewPicId($openid,json_encode($picInfo));

	if(!file_exists(PIC_UPLOAD_DIR))
	{
		SystemError();
		return ;
	}

	if ($pic_id == -2)
	{
		SystemError();
		return ;
	}
	else if ($pic_id == -1)
	{
		$ans = array();
      	$ans["ret"] = -1;
      	$ans["msg"] = "Upload too much";
      	echo addCallBack($_GET["callback"],getUrlJson($ans));
      	return ;
	}
	$filename = PIC_UPLOAD_DIR.FACE_PIC_NAME.$pic_id.$picExt;
	if (!move_uploaded_file($_FILES["filename"]["tmp_name"],$filename))
	{
		SystemError();
		return ;
	}

	$picInfo["pic_id"] =  $pic_id;
	$picInfo["pic_url"] = FACE_PIC_URL.FACE_PIC_NAME.$pic_id.$picExt;
	$picInfo["ret"] = 0;
	$picInfo["msg"] = "success";
	echo addCallBack($_GET["callback"],getUrlJson($picInfo));
?>