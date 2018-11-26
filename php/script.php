<?php
      include_once("db.php");
      require_once("nusoap-0.9.5/lib/nusoap.php");

      // =========================================================
      //                    GLOBAL VARIABLE(S)
      // =========================================================      

	$db_name = "ProBook"; //change this if you use a different dbname in your mysql
      $token_interval = "+1 hours";
      $cookie_interval = 6000; //per second; 600 = 10 minutes

      /* SOAP VARIABLES */ 
      $port_soap = "5432"; // port for soap ws
      $wsdl_search = "http://localhost:".$port_soap."/services/search?wsdl";
      $client_search = new nusoap_client($wsdl_search, 'wsdl');

      /* Use Global db_handler so we don't need to declare it in every page */
      $db_handler = new Database("localhost", "root", "", $db_name);
	

      // =========================================================
      //                    USER SESSION HANDLING
      // =========================================================

      /*********************** BOTH **************************/
      // Check both cookies and access token
      function checkActiveUser(){
            return (checkCookie() and checkAccessToken());
      }

      
      /*********************** COOKIES **************************/
      function assignCookies($user_id, $username){
            GLOBAL $db_handler;
            GLOBAL $cookie_interval;
            
            setcookie("user_id", $user_id, time() + $cookie_interval, "/");
            setcookie("username", $username, time() + $cookie_interval, "/");
      }

      function clearAllCookies(){
            GLOBAL $cookie_interval;
            if(isset($_COOKIE["user_id"])){ setcookie("user_id", null, time()-$cookie_interval, "/"); }
            if(isset($_COOKIE["username"])){ setcookie("username", null, time()-$cookie_interval, "/"); }
            if(isset($_COOKIE["token_id"])){ setcookie("token_id", null, time()-$cookie_interval, "/"); }
      }
      
      function checkCookie(){
            GLOBAL $db_handler;

            /* return TRUE if cookies for id and username is assigned */
            if(isset($_COOKIE["user_id"]) != null){

                  /* check if cookie's id is exist inside DB */
                  /* If cookie's id is exist -> return true */
                  /* If cookie's id is not exist -> return false */
                  if(count($db_handler->getUserByID($_COOKIE["user_id"])) == 1){
                        console_log("Cookie valid");
                        console_log($_COOKIE["user_id"]);
                        console_log($_COOKIE["username"]);
                        return true;
                  }
            }

            return false;
      }

      /*********************** ACCESS TOKEN **************************/
      function assignToken($user_id){
            GLOBAL $db_handler;
            GLOBAL $token_interval;
            
            /* If a valid token exist, use it instead */
            if(getToken($user_id) != ""){
                  setcookie("token_id", getToken($user_id), time()+(10*365*24*60*60), "/");
            }
            /* if there is no valid token, create a new one */
            else {
                  /* get Now's date-time and plus ten seconds for access token's expiry time */
                  date_default_timezone_set("Asia/Jakarta");
                  $dt = new DateTime();
                  $dt->modify($token_interval);

                  $token = new stdClass;
                  $token->TokenID = generateToken(10);
                  $token->ExpiryTime = $dt->format("Y-m-d H:i:s");
                  $token->Browser = getBrowser();
                  $token->IpAddress = getIPAddress();
                  $token->UserID = $user_id;
                  $db_handler->addToken($token); // Insert token into database

                  setcookie("token_id", $token->TokenID, time()+(10*365*24*60*60), "/");
            }
      }

      function checkAccessToken(){
            
            /* IF token is assigned, check it's expiry time */
            if(isset($_COOKIE["token_id"])) {
                  return checkTokenExpiryTime($_COOKIE["token_id"]);
            }
            /* IF token is not assigned but cookie's id is assigned, gain token from cookie's id */
            else if(!isset($_COOKIE["token_id"]) and isset($_COOKIE["user_id"])){
                  /* if valid token exist, assign token */
                  /* if not, return false */
                  if(getToken($_COOKIE["user_id"]) != ""){
                        $_COOKIE["token_id"] = getToken($_COOKIE["user_id"]);
                        console_log($_COOKIE["token_id"]);
                        return true;
                  }
            }
            else {
                  return false;
            }
      }


      function checkTokenExpiryTime($token_id){
            GLOBAL $db_handler;

            /* Get token by id */
            $token = $db_handler->getTokenByID($token_id);

            /* If token is not found, return false */
            /* if token found, check expiry time */
            if($token != []) {
                  date_default_timezone_set("Asia/Jakarta");
                  $dt = new DateTime();

                  /* if expiry time > now's time, return true */
                  /* if expiry time < now's time, delete that token & return false */
                  if($token[0]->ExpiryTime > $dt->format("Y-m-d H:i:s")){
                        console_log($token[0]->TokenID);
                        return true;
                  }
                  else {
                        $db_handler->deleteTokenByID($token_id);
                  }
            }

            return false;
      }

      /* get a valid token according to user's environment*/
      /* if found, return token's id */
      /* if not found, return empty string */
      function getToken($user_id){
            GLOBAL $db_handler;

            $tokens = $db_handler->getTokenByUserID($user_id);
            console_log($tokens);
            
            if($tokens != []){
                  date_default_timezone_set("Asia/Jakarta");
                  $dt = new DateTime();

                  foreach($tokens as $token){
                        if($token->Browser == getBrowser() and $token->IpAddress == getIPAddress() and $token->ExpiryTime > $dt->format("Y-m-d H:i:s")) {
                              return $token->TokenID;
                        }      
                  }
                  
            }
            
            return "";
      }


	function generateToken($length, $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'){
		$pieces = [];
		$max = mb_strlen($keyspace, '8bit') - 1;
		for ($i = 0; $i < $length; ++$i) {
			$pieces []= $keyspace[random_int(0, $max)];
		}
		return implode('', $pieces);
	}


      // =========================================================
      //                  ENVIRONMENT HANDLING
      // =========================================================
	function getIPAddress() {
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {   //check ip from share internet
			$ip=$_SERVER['HTTP_CLIENT_IP'];
		}
		elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {   //to check ip is pass from proxy
			$ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		else {
			$ip=$_SERVER['REMOTE_ADDR'];
		}
		return $ip;
	}

	function getBrowser() {
		$u_agent = $_SERVER['HTTP_USER_AGENT']; 
		$bname = 'Unknown';
		$platform = 'Unknown';
		$version = "";
      
      	//First get the platform?
      	if (preg_match('/linux/i', $u_agent)) {
      		$platform = 'linux';
      	}
      	elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
      		$platform = 'mac';
      	}
      	elseif (preg_match('/windows|win32/i', $u_agent)) {
      		$platform = 'windows';
      	}
      	
      	// Next get the name of the useragent yes seperately and for good reason
      	if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent)) {
      		$bname = 'Internet Explorer';
      		$ub = "MSIE";
      	}
      	elseif(preg_match('/Firefox/i',$u_agent)) {
      		$bname = 'Mozilla Firefox';
      		$ub = "Firefox";
      	}
      	elseif(preg_match('/Chrome/i',$u_agent)) {
      		$bname = 'Google Chrome';
      		$ub = "Chrome";
      	}
      	elseif(preg_match('/Safari/i',$u_agent)) {
      		$bname = 'Apple Safari';
      		$ub = "Safari";
      	}
      	elseif(preg_match('/Opera/i',$u_agent)) {
      		$bname = 'Opera';
      		$ub = "Opera";
      	}
      	elseif(preg_match('/Netscape/i',$u_agent)) {
      		$bname = 'Netscape';
      		$ub = "Netscape";
      	}
      
      // finally get the correct version number
      	$known = array('Version', $ub, 'other');
      	$pattern = '#(?<browser>' . join('|', $known) . ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
      
      	if (!preg_match_all($pattern, $u_agent, $matches)) {
         	// we have no matching number just continue
      	}

      	// see how many we have
      	$i = count($matches['browser']);

      	if ($i != 1) {
      		//we will have two since we are not using 'other' argument yet
      		//see if version is before or after the name
      		if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
      			$version= $matches['version'][0];
      		}
      		else {
      			$version= $matches['version'][1];
      		}
      	}
      	else {
      		$version= $matches['version'][0];
      	}

      	// check if we have a number
      	if ($version == null || $version == "") {$version = "?";}
      	/*
      		return array(
      		'userAgent' => $u_agent,
      		'name'      => $bname,
      		'version'   => $version,
      		'platform'  => $platform,
      		'pattern'   => $pattern
      		);
  		*/

      	return $bname;
     }


     // =========================================================
     //                       MISC FUNCTIONS
     // =========================================================
     function console_log( $data ){
            echo '<script>';
            echo 'console.log('. json_encode( $data ) .')';
            echo '</script>';
      }

      function create_alert($data){
            echo '<script>';
            echo 'alert('. json_encode($data) .')';
            echo '</script>';
      }

      function printRating($score){
            if( floor($score) == $score ){
                  echo $score.".0";       
            }
            else {
                  echo $score;      
            }
      }

      function printRecommendationList($rec_list){
            console_log($rec_list);

            if(count($rec_list) > 0){
                  foreach($rec_list as $book){
                        echo "<tr> <td style='vertical-align:top; width:80px;'>";
                        echo "<img src='". $book->volumeInfo->imageLinks->thumbnail. "' class='squareImageSmall' style='border: 1px solid black;'></img>";
                        echo "</td> <td style='vertical-align:top;'>";
                        echo "<span style='padding-left:5px;' class='reviewUsername'>". $book->volumeInfo->title. "</span>" ; echo "<br>";
                        echo "<span style='text-align:justify;padding-left:7px; margin-top:5px'>" .  implode(', ', $book->volumeInfo->authors). "</span>"; echo "<br>";
                        echo "<form action='' method='get'>";
                        echo "<input type='hidden' name='book_id' id='book_id' value='".$book->id."'>";
                        echo "<input type='submit' value='Detail' class='buttonStyleBlueWide'>";
                        echo "</form>";
                        echo "</td></tr>";
                        echo "<tr><td></td></tr>";
                  }
            }
      }
?>