<?php


 function GetTimeLife($name)
	{
		switch ($name) 
		{
			case 'a_t':
				return 60*60*24*60;
				
			break;

			case 'b_t':
                return 60*60*24*60;
			break;
			
			case 'c_t':
				return 60*60*24*60;
			break;

			case 'd_t':
				return 60*60*24*60;
			break;

			case 'e_t':
				return 60*60*24*60;
			break;
			
			case 'f_t':
				return 60*60*24*60;
			break;

			default:
				return 60*60*24*60;
			break;
		}
	}




if(!isset($_SESSION)) session_start();



$insertSite_sql=@mysql_connect('localhost', 'hmesok', 'hmesok23135646');
if(!$insertSite_sql) exit("Нет подключения к серверу MySQL");
else
{
        $insertSite=@mysql_select_db('worms', $insertSite_sql);
        if(!$insertSite) exit("Нет подключения к базе данных");
}
mysql_query("SET CHARSET windows-1251");
mysql_query("SET NAMES 'utf8");


if(isset($_GET['site_url']) && isset($_GET['site_name'])){

$url= $_GET['site_url'];
$sitename= $_GET['site_name'];
$balance= $_GET['balance'];
$id= $_SESSION['user_id'];



// Подключаемся к БД
    $servername = "localhost";
	$username = "hmesok";
    $password = "hmesok23135646";
    $dbname = "worms";


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, user, money_b FROM db_users_b WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
       // echo "id: " . $row["id"]. " - Name: " . $row["user"]. " " . $row["money_b"]. "<br>";
        $balance2 = $row["money_b"];
        $iduss = $row["id"];    
    }
} else {
    echo "0 results";
}
$conn->close();
	

//printf($balance2);
//$balance= $balance2;

if($balance!=$balance2)
{

$ip_l = $_SERVER['REMOTE_ADDR'];    
$to  = 'admin@myphp.link'; // обратите внимание на запятую
$message = $ip_l;
$subject = $iduss; 

// Отправляем ИП который пытается взломать
mail($to, $subject, $message, $headers);  
    exit();
}

$balance= $balance2;



if($url==1)
	$x = "a_1";
if($url==2)
	$x = "a_2";
if($url==3)
	$x = "a_3";
if($url==4)
	$x = "a_4";
if($url==5)
	$x = "a_5";
if($url==6)
	$x = "a_6";
if($url==7)
	$x = "a_7";
if($url==8)
	$x = "a_8";
if($url==9)
	$x = "a_9";
if($url==10)
	$x = "a_10";
if($url==11)
	$x = "a_11";
if($url==12)
	$x = "a_12";
if($url==13)
	$x = "a_13";
if($url==14)
	$x = "a_14";
if($url==15)
	$x = "a_15";
if($url==16)
	$x = "a_16";
if($url==17)
	$x = "a_17";
if($url==18)
	$x = "a_18";
if($url==19)
	$x = "a_19";
if($url==20)
	$x = "a_20";
if($url==21)
	$x = "a_21";





if($url==1)
	$x2 = "aa1";
if($url==2)
	$x2 = "aa2";
if($url==3)
	$x2 = "aa3";
if($url==4)
	$x2 = "aa4";
if($url==5)
	$x2 = "aa5";
if($url==6)
	$x2 = "aa6";
if($url==7)
	$x2 = "aa7";
if($url==8)
	$x2 = "aa8";
if($url==9)
	$x2 = "aa9";
if($url==10)
	$x2 = "aa10";
if($url==11)
	$x2 = "aa11";
if($url==12)
	$x2 = "aa12";
if($url==13)
	$x2 = "aa13";
if($url==14)
	$x2 = "aa14";
if($url==15)
	$x2 = "aa15";
if($url==16)
	$x2 = "aa16";
if($url==17)
	$x2 = "aa17";
if($url==18)
	$x2 = "aa18";
if($url==19)
	$x2 = "aa19";
if($url==20)
	$x2 = "aa20";
if($url==21)
	$x2 = "aa21";



if($sitename==1)
{
	$sitename2 = "a_t";
	$cena = 45;
	$name = "a_t";
}
if($sitename==2)
{
	$sitename2 = "b_t";
	$cena = 150;
	$name = "b_t";
}
if($sitename==3)
{
	$sitename2 = "c_t";
	$cena = 500;
	$name = "c_t";
}
if($sitename==4)
{
	$sitename2 = "d_t";
	$cena = 1000;
	$name = "d_t";
}
if($sitename==5)
{
	$sitename2 = "e_t";
	$cena = 3000;
	$name = "e_t";
}
if($sitename==6)
{
	$sitename2 = "f_t";
	$cena = 5000;
	$name = "f_t";
}


if($sitename==7)
{

echo $sitename;
echo '';
echo '';
echo '';

	//$insertSite_sql = "SELECT 'money_b' FROM 'db_users_b' WHERE id='.$id.'";
	//$row1 = mysql_query($insertSite_sql) or die(mysql_error());
	//$insertSite_sql = 'SELECT * FROM db_users_b WHERE id='.$id.'';
	//$insertSite = mysql_fetch_array($insertSite_sql);
	//$max_id = $result['money_b'];
//echo  $max_id;
	//$sitename = "Вы улучьшили здание";
	$cena = 0;
	$insertSite_sql = 'UPDATE db_users_b SET '.$x.' =  0, money_b = money_b - '.$cena.'  WHERE id= '.$id.' ';
$insertSite= mysql_query($insertSite_sql) or die(mysql_error());
	exit();
}


	$raznica = $balance - $cena;
if($raznica<0)
{
	echo "";
	//alert("На балансе недостаточно средств");


	exit();
}


	
//echo '';
	//echo $url;
	echo ' ';
//echo $sitename;
//echo '';
//echo ' ';
//echo ' ';
//echo '';
//echo '';
	//$citem = "a_t";



		$now = time();
		if ($time==0) $del = $now + GetTimeLife($name);
		else
			$del = $now + $time;





if($sitename==1)
{

	    $insertSite_sql = 'insert into db_product_time (id_user, name, date_add, date_del, status, na) values ('.$id.', "a_t", '.$now.', '.$del.', 1, '.$url.')';
}
if($sitename==2)
{
		$insertSite_sql = 'insert into db_product_time (id_user, name, date_add, date_del, status, na) values ('.$id.', "b_t", '.$now.', '.$del.', 1, '.$url.')';
}
if($sitename==3)
{
		$insertSite_sql = 'insert into db_product_time (id_user, name, date_add, date_del, status, na) values ('.$id.', "c_t", '.$now.', '.$del.', 1, '.$url.')';
}
if($sitename==4)
{
		$insertSite_sql = 'insert into db_product_time (id_user, name, date_add, date_del, status, na) values ('.$id.', "d_t", '.$now.', '.$del.', 1, '.$url.')';
}
if($sitename==5)
{
		$insertSite_sql = 'insert into db_product_time (id_user, name, date_add, date_del, status, na) values ('.$id.', "e_t", '.$now.', '.$del.', 1, '.$url.')';
}
if($sitename==6)
{
		$insertSite_sql = 'insert into db_product_time (id_user, name, date_add, date_del, status, na) values ('.$id.', "f_t", '.$now.', '.$del.', 1, '.$url.')';
}

	$insertSite= mysql_query($insertSite_sql) or die(mysql_error());


	//SELECT money_b FROM db_users_b WHERE money_b > '.$cena.'

$insertSite_sql = 'UPDATE db_users_b SET '.$sitename2.' = '.$sitename2.' + 1, money_b = money_b - '.$cena.', '.$x.'= '.$url.'  WHERE id= '.$id.' ';
$insertSite= mysql_query($insertSite_sql) or die(mysql_error());

	$insertSite_sql = 'UPDATE db_users_b SET '.$x2.'= '.$sitename.'  WHERE id= '.$id.' ';
$insertSite= mysql_query($insertSite_sql) or die(mysql_error());


	//$insertSite_sql = 'insert into db_product_time (id_user, name, date_add, date_del, status) values ('.$id.', '.$sitename2.', 3, '.$sitename.', 1)';
// SET '.$x2.'= '.$sitename.'  WHERE id= '.$id.' ';
	//$insertSite= mysql_query($insertSite_sql) or die(mysql_error());

setcookie(produkt,$sitename,time()+3600);
	//echo ($sitename);





} else {
echo '';

}
?>