<?php

/*
	Licence-Terms
	===============
	
	This project is protected by Creative Commons Attribution-NonCommercial-ShareAlike 3.0 Unported licence
	Please read the online version of this licence here:
		http://creativecommons.org/licenses/by-nc-sa/3.0/
	
	An offline copy is in the root folder of this project by the name "licence.pdf"

	This licence is to keep the commercial fishes off the waters. Don't be disheartened. I am always an email away :)
		Mail me at: prashant.dwivedi@outlook.com
*/

?>

<?php


function stringContains($substring, $string) 
{       $pos = strpos($string, $substring);
 
        if($pos === false) {
                // string needle NOT found in haystack
                return false;
        }
        else {
                // string needle found in haystack
                return true;
        }
}

function sanitizeFileName($string, $force_lowercase = true, $anal = false) 
{
    $strip = array("~", "`", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "_", "=", "+", "[", "{", "]",
                   "}", "\\", "|", ";", ":", "\"", "'", "&#8216;", "&#8217;", "&#8220;", "&#8221;", "&#8211;", "&#8212;",
                   "â€”", "â€“", ",", "<", ".", ">", "/", "?");
    $clean = trim(str_replace($strip, "", strip_tags($string)));
    $clean = preg_replace('/\s+/', "-", $clean);
    $clean = ($anal) ? preg_replace("/[^a-zA-Z0-9]/", "", $clean) : $clean ;
    return ($force_lowercase) ?
        (function_exists('mb_strtolower')) ?
            mb_strtolower($clean, 'UTF-8') :
            strtolower($clean) :
        $clean;
}


function highlightCurrentPage($page)
{	if( stringContains($page, $_SERVER['PHP_SELF']))
	{	return 'class="current"';
	}
	/*
	else
	{	echo '<br/><br/>NO!!!!!!!!!!!!!!!!!!!!!!<br/><br/>';
	}
	*/
}


function cleanString($str)
{	return filter_var($str, FILTER_SANITIZE_STRING); 
} 


function validateText($text)
{	return filter_var($text, FILTER_SANITIZE_STRING); 	
}

function validateEmail($email)
{	return filter_var($email, FILTER_SANITIZE_EMAIL);
}

function dbconnect()
{	$dbhost=__DBHOST;	
	$dbuser=__DBUSER;	
	$dbpass=__DBPASS;	
	$database=__DBNAME;	

	$conn= @new mysqli($dbhost, $dbuser, $dbpass, $database);
	if(!$conn)
	{	die('error connecting to database!!');
	}
	return $conn;
}

function loadView($funcName, $params=NULL)
{	try
	{	require_once('views/commons.php');
		require_once('views/'.$funcName.'.php');
		
		if($params!=NULL)
			$output = call_user_func($funcName, $params);
		else
			$output = call_user_func($funcName);
		
		return $output;
	}
	catch(Exception $e)
	{	/*echo '
			<div style="margin-top:10px; z-index:1000000; background:#fff; color:#000; padding:10px; clear: both; border-radius:5px; border:1px solid red;">
			<h1>Unexpected Error Occured:</h1>
			<p>'. $e->getMessage() .' 
			
			</div>';
		//die();
		*/
		return FALSE;
	}
	

}

function loadEvent($funcName, $params=NULL)
{	try
	{	require_once('siteEvents/'.$funcName.'.php');
		
		if($params!=NULL)
			$output = call_user_func($funcName, $params);
		else
			$output = call_user_func($funcName);
		
		return $output;
	}
	catch(Exception $e)
	{	/*echo '
			<div style="margin-top:10px; z-index:1000000; background:#fff; color:#000; padding:10px; clear: both; border-radius:5px; border:1px solid red;">
			<h1>Unexpected Error Occured:</h1>
			<p>'. $e->getMessage() .' 
			
			</div>';
		//die();
		*/
		return FALSE;
	}
	

}


function genPagesListHTML($currentPage, $lastPage, $baseURL)		//requires baseurl with & or ? already added
{
	$HTML=	'<div id="pagination" class="pagination">';
		
	if($currentPage<=1)
		$HTML.=	'<span class="disabled">&#171; Previous</span>
			<span class="current">1</span>
			';
	else
		$HTML.=	'<a href="'.$baseURL.'page='. ($currentPage-1) .'">&#171; Previous</a>
			<a href="'.$baseURL.'page=1">1</a>';

	$pageLimitor = 6;
	$pageLimitorPadding = 2;
	
	if($lastPage > ($pageLimitor*2))
	{	if($currentPage<=$pageLimitor)
		{	for($i = 2; $i<=$pageLimitor+$pageLimitorPadding; $i++)
			{	if($i!=$currentPage)
					$HTML .= '<a href="'. $baseURL .'page='.$i.'">'.$i.'</a>';
				else
					$HTML .= '<span class="current">'.$i.'</span>';
			}
			$printedFlag = TRUE;

			$HTML .= '...';
		}
		
		if($currentPage>=$lastPage-$pageLimitor)
		{	$HTML .= '...';
			for($i=$lastPage-$pageLimitor-$pageLimitorPadding; $i<=$lastPage-1; $i++)
			{	if($i!=$currentPage)
					$HTML .= '<a href="'. $baseURL .'page='.$i.'">'.$i.'</a>';
				else
					$HTML .= '<span class="current">'.$i.'</span>';
			}
			$printedFlag = TRUE;
		}
		//echo $printedFlag;
		if(!$printedFlag)
		{	$mid = $pageLimitor/2;
			$HTML .= '...';
			for($i = $currentPage-$mid; $i<=$currentPage+$mid; $i++ )
			{	if($i!=$currentPage)
					$HTML .= '<a href="'. $baseURL .'page='.$i.'">'.$i.'</a>';
				else
					$HTML .= '<span class="current">'.$i.'</span>'; 
			}
			$HTML .= '...';
		}
	}	
	else
	{	for($i = 2; $i<=$lastPage-1; $i++ )
		{	if($i!=$currentPage)
				$HTML .= '<a href="'. $baseURL .'page='.$i.'">'.$i.'</a>';
			else
				$HTML .= '<span class="current">'.$i.'</span>';
		}
	}
	
	
	{
		if($currentPage>=$lastPage)
		{	if($lastPage!=1)
				$HTML.=	'<span class="current">'. $lastPage .'</span>';
			$HTML.= '<span class="disabled">Next &#187;<span>';
		}
		else
		{	if($lastPage!=1)
				$HTML.=	'<a href="'.$baseURL.'page='. $lastPage .'">'. $lastPage .'</a>';
			$HTML.=	'<a href="'.$baseURL.'page='. ($currentPage+1) .'">Next &#187;</a>';
		}
	}
	$HTML .= '</div>';
		
	return $HTML;
}






?>