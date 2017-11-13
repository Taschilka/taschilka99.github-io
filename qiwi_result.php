<?php




session_start();
error_reporting (1);
$login = $_SESSION['login'];
$usid = $_SESSION['id'];
header('Content-type: application/json');
Header("Content-Type: text/html;charset=UTF-8");

if($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest' ) { exit();}

#if(!isset($_SESSION['id'])) { echo '<center>Сессия устарела!</center>';} else { $sess = $_SESSION['id']; }

$nameTranz = trim( $_POST['codeqiwi'] );
$token = trim( $_POST['token'] );
$tokenMy = hash('sha256', 'XrenVamVsemVstakanOtAptemona');

if($token !== $tokenMy){
	die('<font style="color: red;"><b>Hacking attempt!</b></font>');
	exit();
}

	if(isset($nameTranz)) {
		if(empty($nameTranz)) { exit(' <center><font color="red"><b>№ транзакции указан не верно. Повторите попытку указав правильный номер.</b></font></center>'); }

	# Автоподгрузка классов
	function __autoload($name){ include("classes/_class.".$name.".php");}

	# Класс конфига
	$config = new config;

	# Функции
	$func = new func;

	# База данных
	$db = new db($config->HostDB, $config->UserDB, $config->PassDB, $config->BaseDB);

	$time = time();






	$myQiwi = new qiwi($config->iQiwiAccount, $config->sPassword, $_SERVER['DOCUMENT_ROOT'].$config->sCookieFile);
//$ass = $myQiwi->getBalances();
//var_dump($ass);

//echo $ass;

	$arHistory = $myQiwi->getHistory( date( 'd.m.Y', strtotime( '-1 day' ) ), date( 'd.m.Y', strtotime( '+1 day' ) ) );
		//print_r($arHistory);

		//	echo $nameTranz;





	$aTransfer = array_shift( $arHistory );
    $idAriID = $aTransfer['iID'];

	    if(isset($idAriID)) {
	    	if($nameTranz == $idAriID){
    			#echo $idAriID;

				$comment = explode("|", $aTransfer['sComment']);
				$idUser = $comment[0];
				$nameUser = $comment[1];

				$db->Query("SELECT `id`, `user` FROM `db_users_a` WHERE id = '$idUser' AND user = '$nameUser' LIMIT 1 ");
				$rowUser = $db->FetchRow();
				$baseIdUser = $rowUser[0];
				$baseUser = $rowUser[1];

				if($aTransfer['sStatus'] == 'SUCCESS' AND $idUser == $baseIdUser AND $nameUser == $baseUser){

					$db->Query("SELECT `batch_num` FROM `db_oplata_pm` WHERE memopay = '$idUser' AND typepayment = 'QiWi' LIMIT 1 ");
					$rowBatch = $db->FetchRow();

echo $rowBatch;
					# Если уже есть такая транзакция
					if($rowBatch == $idAriID){
                    	echo '<center><font color="red"><b>Такой № транзакции уже добавлялся ранее. В случае ошибки напишите в поддержку.</b></font></center>';
					}
					else
					{
						$add_summ = $aTransfer['sWithExpend'];

						$sum = $aTransfer['dAmount'];
	                    $ip = $_SERVER['REMOTE_ADDR'];
	                    $typepayment = "QiWi";
	                    $timedat = $aTransfer['sDate']." ".$aTransfer['sTime'];
	                    $sug_memo = $aTransfer['sComment'];
	                    $noKow = $aTransfer['iOpponentPhone'];

						# Заносим в БД
						$db->Query("INSERT INTO `db_oplata_pm` VALUES(NULL,
																	'".($typepayment)."',
																	'".($ip)."',
																	'".$sug_memo."',
																	'".$idUser."',
																	'1',
																	'".$idAriID."',
																	'".$noKow."',
																	'".$timedat."',
																	'0',
																	'RUB',
																	'".($sum)."') ");

						#Merchant
						$db->Query("INSERT INTO `db_payeer_insert` (user_id, user, sum, date_add, status) VALUES ('".$idUser."','".$nameUser."','$sum','".time()."', '1')");

						$db->Query("SELECT * FROM `db_config` WHERE id = 1 LIMIT 1");
						$sonfig_site = $db->FetchArray();

						$db->Query("SELECT * FROM `db_users_a` WHERE id = '$idUser' LIMIT 1");
						$data = $db->FetchArray();
						$id = $data['id'];
						$login = $data['user'];
						$user_name = $data['user'];
						$refid =  $data['referer_id'];
						$ref2 =  $data['referer_id2'];
						$ref3 =  $data['referer_id3'];
						
						
						   
                           
                        						
						

						$serebro = $sonfig_site['ser_per_wmr'] * $sum;
					    $db->Query("SELECT `insert_sum` FROM `db_users_b` WHERE id = '$idUser' LIMIT 1");
			            $ins_sum = $db->FetchRow();

					   // $serebro = intval($ins_sum <= 0.01) ? ($serebro + ($serebro * 0.2) ) : $serebro + ($serebro * 0.2); # Зачисляем бонус при первом пополнении 50 процентов - 0.5 серебро
                          $serebro = intval($ins_sum <= 0.01) ? ($serebro + ($serebro * 0.2) ) : $serebro;
                          
						$lsb = time();
						   $to_referer = ($serebro * 0.05); // Первый уровень - 10 процентов
                           $to_referer2 = ($serebro * 0.02); // Второй уровень - 10 процентов
                           $to_referer3 = ($serebro * 0.01); // Третий уровень - 10 процентов

						$db->Query("UPDATE `db_users_b` SET money_b = money_b + '$serebro', to_referer = to_referer + '$to_referer', last_sbor = '$lsb', insert_sum = insert_sum + '$sum' WHERE id = '$id'");
						
						

                       
                        $db->Query("UPDATE `db_users_a` SET doxod = doxod + '$to_referer' WHERE id = '$id'");
                        $db->Query("UPDATE `db_users_a` SET doxod2 = doxod2 + '$to_referer2' WHERE id = '$id'");
                        $db->Query("UPDATE `db_users_a` SET doxod3 = doxod3 + '$to_referer3' WHERE id = '$id'");
                                                
    //						echo $refid2;


# Зачисляем средства рефереру и дерево						
  $db->Query("UPDATE `db_users_b` SET money_p = money_p + '$to_referer', from_referals = from_referals + '$to_referer' WHERE id = '$refid'");
  $db->Query("UPDATE `db_users_b` SET money_p = money_p + '$to_referer2', from_referals = from_referals + '$to_referer' WHERE id = '$ref2'");						
  $db->Query("UPDATE `db_users_b` SET money_p = money_p + '$to_referer3', from_referals = from_referals + '$to_referer' WHERE id = '$ref3'");	
   

						# Статистика пополнений
					   	$da = time();
					   	$dd = $da + 60*60*24*15;
					   	$db->Query("INSERT INTO `db_insert_money` (user, user_id, money, serebro, date_add, date_del) VALUES ('$login','$id','$sum','$serebro','$da','$dd')");

					   	# Конкурс
					   	$competition = new competition($db);
					   	$competition->UpdatePoints($id, $add_summ);

					   	# Обновление статистики сайта
						$db->Query("UPDATE `db_stats` SET all_insert = all_insert + '$sum' WHERE id = '1'");

						# Конец Merchant

						echo '<center><font color="green"><b>Ваш баланс пополнен на сумму '.$add_summ.'!</b></font></center>';

                    }

				}


    		} else echo '<center><font color="red"><b>Перевод не найден либо не подтвержден КИВИ, проверьте указанный № транзакции и его статус и повторите попытку через 30 сек.</b></font></center>';
	    } else echo '<center><font color="red"><b>Системная ошибка, сообщите Тех. Поддержке!</b></font></center>';

	} else echo '<center><font color="red"><b>Системная ошибка, сообщите Тех. Поддержке!</b></font></center>';


?>