<?PHP


# ������������� �������
function __autoload($name){ include("classes/_class.".$name.".php");}

# ����� �������
$config = new config;

# �������
$func = new func;

# ���� ������
$db = new db($config->HostDB, $config->UserDB, $config->PassDB, $config->BaseDB);

# ���������� ����
$secret_key = '5XEb/hlgQ+KaxuXx8SXETwK7';


$wallet = $_POST['sender'];

$ik_payment_amount = $_POST['amount'];

$operation_id = $_POST['operation_id'];

$secret_hashy = $_POST['notification_type'];

$id_insert = $_POST['label'];

// �������� ��������� �� ����������������� ���������� ��� ����������
// $_POST['operation_id'] - ����� ��������
// $_POST['amount'] - ���������� �����, ������� �������� �� ���� ����������
// $_POST['withdraw_amount'] - ���������� �����, ������� ����� ������� �� ����� ����������
// $_POST['datetime'] - ��� �������, ���� � ����� ������
// $_POST['sender'] - ���� ������ ������������ ����� ������ ������, �� ���� �������� �������� ����� �������� ����������
// $_POST['label'] - �����, ������� �� ��������� � ����� ������
// $_POST['email'] - email ���������� (�������� ������ ��� ������������� https://)

$sha1 = sha1( $_POST['notification_type'] . '&'. $_POST['operation_id']. '&' . $_POST['amount'] . '&643&' . $_POST['datetime'] . '&'. $_POST['sender'] . '&' . $_POST['codepro'] . '&' . $secret_key. '&' . $_POST['label'] );

if ($sha1 != $_POST['sha1_hash'] ) {
	// ��� ���������� ��� �� ������, ���� ����������� �� ��������
	exit();
}

	// ��� ��� �� ������, ���� �������� ������ �������
	//exit();

	$db->Query("SELECT * FROM `db_payeer_insert` WHERE id = '".intval($_POST['label'])."'");
	if($db->NumRows() == 0){ echo $_POST['label']."|error"; exit;}

	$payeer_row = $db->FetchArray();

	if($payeer_row["status"] > 0){ echo $_POST['label']."|success"; exit;}

	$db->Query("UPDATE db_payeer_insert SET status = '1' WHERE id = '".intval($_POST['label'])."'");

	$ik_payment_amount = $_POST['amount']; #$payeer_row["sum"];
	$user_id = $payeer_row["user_id"];


	# ���������
	$db->Query("SELECT * FROM db_config WHERE id = '1' LIMIT 1");
	$sonfig_site = $db->FetchArray();

   
     $db->Query("SELECT user, referer_id, referer_id2, referer_id3 FROM db_users_a WHERE id = '{$user_id}' LIMIT 1");
   $user_ardata = $db->FetchArray();
   $user_name = $user_ardata["user"];
   $refid = $user_ardata["referer_id"];
   $ref2 = $user_ardata["referer_id2"];
   $ref3 = $user_ardata["referer_id3"];
    

    # ��������� ������
    $serebro = sprintf("%.4f", floatval($sonfig_site["ser_per_wmr"] * $ik_payment_amount) );
    

    $db->Query("SELECT insert_sum FROM db_users_b WHERE id = '{$user_id}' LIMIT 1");
    $ins_sum = $db->FetchRow();

    $serebro = intval($ins_sum <= 0.01) ? ($serebro + ($serebro * 0.2) ) : $serebro;
    //$serebro = intval($ins_sum <= 0.01) ? ($serebro + ($serebro * 0.2) ) : ($serebro + ($serebro * 0) ) ; //��� ������ ���������� +50% � �� ��������� 0% !
    
    $lsb = time();
    
    
     $to_referer = ($serebro * 0.05); // ������ ������� - 10 ���������
   $to_referer2 = ($serebro * 0.02); // ������ ������� - 10 ���������
   $to_referer3 = ($serebro * 0.01); // ������ ������� - 10 ���������



	# ��������� �������� ��� )
	$db->Query("UPDATE db_users_b
    			SET money_b = money_b + '$serebro',
    			    to_referer = to_referer + '$to_referer',
    			    last_sbor = '$lsb',
    			    insert_sum = insert_sum + '$ik_payment_amount'
    			WHERE id = '{$user_id}'");


 $db->Query("UPDATE db_users_b SET money_p = money_p + $to_referer, from_referals = from_referals + '$to_referer'  WHERE id = '$refid'");
   $db->Query("UPDATE db_users_b SET money_p = money_p + $to_referer2, from_referals = from_referals + '$to_referer2' WHERE id = '$ref2'");
   $db->Query("UPDATE db_users_b SET money_p = money_p + $to_referer3, from_referals = from_referals + '$to_referer3' WHERE id = '$ref3'");
   
   $db->Query("UPDATE db_users_a SET doxod = doxod + $to_referer WHERE id = '{$user_id}'");
$db->Query("UPDATE db_users_a SET doxod2 = doxod2 + $to_referer2 WHERE id = '{$user_id}'");
$db->Query("UPDATE db_users_a SET doxod3 = doxod3 + $to_referer3 WHERE id = '{$user_id}'");

   

    # ���������� ����������
    $da = time();
    $dd = $da + 60*60*24*15;
   	$db->Query("INSERT INTO db_insert_money (user, user_id, money, serebro, date_add, date_del)
  	 VALUES ('$user_name','$user_id','$ik_payment_amount','$serebro','$da','$dd')");


	# ���������� ���������� �����
	$db->Query("UPDATE db_stats SET all_insert = all_insert + '$ik_payment_amount' WHERE id = '1'");

?>