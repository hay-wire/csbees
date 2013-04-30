<?php

function changeRepo($params)
{
	$csbeesMan = new CSBeesManager();
	$userID = $csbeesMan->getUploaderID($params['fileID']);
	if($userID)
	{	$params['userID'] = $userID;
		$csbeesMan->changeUserRepo($params);
		return TRUE;
	}
	else
	{	return FALSE;	
	}

}


?>
