<?PHP
######################################
# Модуль YandexMoney Скрипт Fruit Farm
# Автор APTEMOH
# E-mail: ArtIncProject@yandex.ru
# Skype: ArtIncProject
######################################

$wallet_yad = 410013965085101;

$_OPTIMIZATION["title"] = "Аккаунт - Пополнение баланса";
$usid = $_SESSION["user_id"];
$usname = $_SESSION["user"];

$db->Query("SELECT * FROM db_config WHERE id = '1' LIMIT 1");
$sonfig_site = $db->FetchArray();


?>

<div class="s-bk-lf">
	<div class="acc-title">Пополнение Яндекс Деньги</div>
</div>

<?PHP

/*
if($_SESSION["user_id"] != 1){
echo "<center><b><font color = red>Технические работы</font></b></center>";
return;
}
*/

?>

<div class="silver-bk">

<?php

if(isset($_POST["sum"])){

$sum = round(floatval($_POST["sum"]),2);


# Заносим в БД
$db->Query("INSERT INTO db_payeer_insert (user_id, user, sum, date_add) VALUES ('".$_SESSION["user_id"]."','".$_SESSION["user"]."','$sum','".time()."')");

$orderid = $db->LastInsert();

?>
	<div align="center">
        <img src="/img/pay/logo_yandexmoney.png" width="250px" height="" />

		<form action="https://money.yandex.ru/quickpay/confirm.xml" method="POST">

		 <table>

		  <tbody>

		<input type="hidden" name="receiver" value="<?=$wallet_yad;?>">
		<input type="hidden" name="label" value="<?=$orderid;?>">
		<input type="hidden" name="formcomment" value="Комментарий">
		<input type="hidden" name="short-dest" value="Описание">
        <input type="hidden" name="quickpay-form" value="donate">
		<input type="hidden" name="targets" value="Помощь проекту!">
		<input type="hidden" name="successURL" value="<?=$_SERVER['SERVER_NAME'];?>/success.html">

		    <tr style="padding-bottom:15px;">

			     <td>Сумма пополнения: <b> <?=$sum;?> <?=$config->VAL; ?> </b> </td>

				 <td><input type="hidden" name="sum" value="<?=number_format($sum, 2, ".", "")?>" placeholder="Введите сумму пополнения"></td>
		    </tr>

			<tr style="padding-left:20px;"><td><label><input type="radio" name="paymentType" value="PC">Яндекс.Деньгами</label></td>
			                               <td><label><input type="radio" name="paymentType" value="AC">Банковской картой</label></td>
			</tr>

			<br>

		   <tr><td></td><td><input type="submit" value="Оплатить и получить серебро"></td></tr>

	      </tbody>

		 </table>

		 </form>

	</div>

<div class="clr"></div>
</div>

<?PHP

return;

}
?>
<script type="text/javascript">
	var min = 0.01;
	var ser_pr = 100;
	function calculate(st_q) {

		var sum_insert = parseFloat(st_q);
		$('#res_sum').html( (sum_insert * ser_pr).toFixed(0) );
}
</script>

<div id="error3"></div>

<div align="center"><img src="/img/pay/logo_yandexmoney.png" width="250px" height="" /></div>

<form method="POST" action="">
    <input type="hidden" name="m" value="<?=$fk_merchant_id?>">
Введите сумму [<?=$config->VAL; ?>]:
<input type="text" value="100" name="sum" size="7" id="psevdo" onchange="calculate(this.value)" onkeyup="calculate(this.value)" onfocusout="calculate(this.value)" onactivate="calculate(this.value)" ondeactivate="calculate(this.value)">

    Вы получите <span id="res_sum">10000</span> серебра
	<BR /><BR />
    <div align="center"><input type="submit" id="submit" value="Пополнить баланс" ></div>
</form>

<script type="text/javascript">
	calculate(100);
</script>

<BR />

<div class="clr"></div>
</div>
