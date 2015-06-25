<?php


require("wp-config.php"); 
error_reporting(0);
$DB = mysql_connect(DB_HOST,DB_USER, DB_PASSWORD);
mysql_select_db(DB_NAME);

define('WP_PREFIX', 'wje4yf9mgt_');


class User{
	
	private $miUserID 		=	0;
	private $msName  		=	"";
	private $msPhone			=	"";
	private $msEmail			=	"";
	private $msUsername 		=	"";
	private $msPassword 		=	"";
	private $msBio			=	"";
	private $msDirectDial	=	"";
	
	function User($piUserID, $psName, $psPhone, $psEmail, $psUsername, $psPassword, $psBio, $psDirectDial){
		
		//instantiate	
		$this->miUserID		=	$piUserID;
		$this->msName		=	$psName;
		$this->msPhone 		= 	$psPhone;
		$this->msEmail 		= 	$psEmail;
		$this->msUsername 	=	$psUsername;
		$this->msPassword	=	$psPassword;
		$this->msBio		=	$psBio;
		$this->msDirectDial	=	$psDirectDial;
		
	}
	
	function GetName(){
		
		return $this->msName;	
		
	}
	
	function GetPhone(){
		
		return $this->msPhone;	
		
	}
	
	function GetEmail(){
		
		return $this->msEmail;	
	}
	
	function GetUsername(){
		
		return $this->msUsername;	
	}
	
	function GetPassword(){
		
		return $this->msPassword;	
	}
	
	function GetBio(){
		
		return $this->msBio;	
	}
	
	function GetDirectDial(){
		
		return $this->msDirectDial;	
	}
	
	function GetCount($psWhere){
		
		if(trim($psWhere) == ""){
			$psWhere = " WHERE ".$psWhere;
		}
		$psSQL = "SELECT * FROM ".WP_PREFIX."users ".$psWhere;
		
		return mysql_num_rows(mysql_query($psSQL));
	}
	function GetAll($psWhere, $psLimit = null, $psSort = null){
		
		if(trim($psWhere) == ""){
			$psWhere = " WHERE ".$psWhere;
		}
		$psSQL = "SELECT * FROM ".WP_PREFIX."users ".$psWhere;
		
		return mysql_fetch_assoc(mysql_query($psSQL));
	}
	
	function Load($psUsername){
		
		$piCountUsername = $this->GetCount("user_login = '".$psUsername."'");
		if($piCountUsername == 0){
			return false;
		}
		else{
			//set the user id so that we aren't creating a duplicate 
			$pobjRow = $this->GetAll("user_login = '".$psUsername."'");
			
			return true;
		}
		
	}
	function Save(){
		
		//we only want to insert them if they dont already exist 
		if(!$this->Load($this->msUsername)){
			//do an insert
			$psSQL = "INSERT into ".WP_PREFIX."users values('".$this->miUserID."', '".addslashes($this->msUsername)."', md5('".$this->msPassword."'), '".addslashes($this->msName)."','".addslashes($this->msEmail)."' ,'', NOW(),'',0,  '".addslashes($this->msName)."')";
			
			mysql_query($psSQL);
			$this->miUserID = mysql_insert_id();
			
			//split their name for first name surname 
			$parrName = split(" ", $this->msName); 
			//insert their meta data
			$psSQL = "INSERT INTO ".WP_PREFIX."usermeta values(0, '".$this->miUserID."', '".WP_PREFIX."capabilities','a:1:{s:11:\"contributor\";b:1;}')";
			mysql_query($psSQL);
			$psSQL = "INSERT INTO ".WP_PREFIX."usermeta values(0, '".$this->miUserID."', 'use_ssl', '1')";
			mysql_query($psSQL);
			$psSQL = "INSERT INTO ".WP_PREFIX."usermeta values(0, '".$this->miUserID."', 'rich_editing','false')";
			mysql_query($psSQL);
			$psSQL = "INSERT INTO ".WP_PREFIX."usermeta values(0, '".$this->miUserID."', 'comment_shortcuts','false')";
			mysql_query($psSQL);
			$psSQL = "INSERT INTO ".WP_PREFIX."usermeta values(0, '".$this->miUserID."', 'show_admin_bar_front','false')";
			mysql_query($psSQL);
			$psSQL = "INSERT INTO ".WP_PREFIX."usermeta values(0, '".$this->miUserID."', 'phone-number','".$this->msPhone."')";
			mysql_query($psSQL);
			$psSQL = "INSERT INTO ".WP_PREFIX."usermeta values(0, '".$this->miUserID."', 'description','".$this->msBio."')";
			mysql_query($psSQL);
			$psSQL = "INSERT INTO ".WP_PREFIX."usermeta values(0, '".$this->miUserID."', 'direct-dial','".$this->msDirectDial."')";
			mysql_query($psSQL);
			$psSQL = "INSERT INTO ".WP_PREFIX."usermeta values(0, '".$this->miUserID."', 'nickname','".$parrName[0]."')";
			mysql_query($psSQL);
			$psSQL = "INSERT INTO ".WP_PREFIX."usermeta values(0, '".$this->miUserID."', 'first_name','".$parrName[0]."')";
			mysql_query($psSQL);
			$psSQL = "INSERT INTO ".WP_PREFIX."usermeta values(0, '".$this->miUserID."', 'last_name','".$parrName[count($parrName) -1]."')";
			mysql_query($psSQL);
			return "Added advisor ".$this->msName;
		}
		else{
			
			return $this->msName." exists not added";
		
		}
	}
	
}



$pobjUser = new User(0,'Joanna Fitzpatrick', 	'086-0462709', 	'joanna.fitzpatrick@boi.com', 	'joannafitzpatrick' ,'vEPz4YDcUWMWWsT863Jz','','');
echo $pobjUser->Save() ."<br/>";

$pobjUser = new User(0,'Siobhan McFadden', 	'086-9225528', 	'siobhan.mcfadden@boi.com', 	'siobhanmcfadden', 	'LGCEYXsjSzbRtRYuzpPE','','');
echo $pobjUser->Save() ."<br/>";

$pobjUser = new User(0,'Paul Murphy', 	'087-9326196', 	'paul.murphy@boi.com', 	'paulmurphy', 	'qPcPkzzTqPN3ncU85jpD','','');
echo $pobjUser->Save() ."<br/>";

$pobjUser = new User(0,'Tim O\'Leary', 	'087-7624369', 	'tim.o\'leary@boi.com', 	'timoleary', 	'QC85sPrrEbeP6kwyghLW','','');
echo $pobjUser->Save() ."<br/>";

$pobjUser = new User(0, 'Maria Downes', 	'087-9413466', 	'maria.downes@boi.com', 'mariadownes', 	'ZuSDT9EPfpFLwLLuSPty','','');
echo $pobjUser->Save() ."<br/>";

$pobjUser = new User(0, 'David Reynolds', 	'087-7773314', 	'david.reynolds2@boi.com', 	'davidreynolds2', 	'BXsKd8r5JvMJrmcehdxz','','');
echo $pobjUser->Save() ."<br/>";

$pobjUser = new User(0,'Sara Kelly', 	'086-1005559', 	'sara.kelly@boi.com', 	'sarakelly', 	'4Fxp85uQ5U7hm3j5eDVM','','');
echo $pobjUser->Save() ."<br/>";

$pobjUser = new User(0, 'Siobhan Henry',	'087-9483217', 	'siobhan.henry@boi.com', 	'siobhanhenry', 	'ZFRmmCRtv4sPkJPJTbSp','','');
echo $pobjUser->Save() ."<br/>";

$pobjUser = new User(0, 'Ann Kindregan', 	'086-0431528', 	'ann.kindregan@boi.com', 	'annkindregan', 	'HMrtDdZxcvgqDwp7m7ga','','');
echo $pobjUser->Save() ."<br/>";

$pobjUser = new User(0, 'Diarmuid O\'Riordan', 	'087-6623845', 	'diarmuid.o\'riordan@boi.com', 	'diarmuidoriordan', '	rnRT7Zhk98zS2fc5yca4','','');
echo $pobjUser->Save() ."<br/>";

$pobjUser = new User(0, 'Thomas Allen', 	'087-0928587', 	'thomas.allen@boi.com', 	'thomasallen', 	'wSh2ndqsksEdHgQvjDYG','','');
echo $pobjUser->Save() ."<br/>";

$pobjUser = new User(0, 'Colm Quinn', 	'087-2744706', 	'colm.quinn@boi.com', 	'colmquinn', 	'UzXuDT37KyJUy5WvJUAG','','');
echo $pobjUser->Save() ."<br/>";

$pobjUser = new User(0, 'Maureen Byrne', 	'087-1494482', 	'maureen.byrne@boi.com', 	'maureenbyrne', 	'F5KGL2KMEx4CqLZcxUuJ','','');
echo $pobjUser->Save() ."<br/>";

$pobjUser = new User(0, 'Mark O\'Mahony', 	'087-9224882', 	'mark.o\'mahony@boi.com', 	'markomahony', 	'wAFk2DqPQKqkWehFxaKJ','','');
echo $pobjUser->Save() ."<br/>";

$pobjUser = new User(0, 'Dominic Higgins', 	'087-9075213', 	'dominic.higgins@boi.com', 	'dominichiggins', 	'X83BJuRB9mZkXFaEL29A','','');
echo $pobjUser->Save() ."<br/>";

$pobjUser = new User(0, 'Eilis Hanley', 	'086-0291397', 	'eilis.hanley@boi.com', 	'eilishanley', 	'yzy3PeVJy6JDH6J7Kkvn','','');
echo $pobjUser->Save() ."<br/>";


?>