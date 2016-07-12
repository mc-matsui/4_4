<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>● 課題4_4, レコードを削除するページを作成する(DELETE)</title>
</head>
<body>

<h1>● 課題4_4, レコードを削除するページを作成する(DELETE)</h1>
<br>
<?php
//DB接続
$link = mysql_connect("localhost","root","3212");
mysql_query("SET NAMES utf8",$link);
if (!$link)
{
	die("接続できませんでした" .mysql_error());
}
$db = mysql_select_db("test" , $link);
if (!$db)
{
	die("データベース接続エラーです。" .mysql_error());
}


if (isset($_POST["sakujo"]))
{
	//DB削除(郵便番号の値を取得してループ)
	foreach ($_POST["sakujo"] as $zip_code)
	{
		$sql = "DELETE FROM  `kadai_matsui_ziplist` WHERE  `zip_code` =  '$zip_code'";
		mysql_query("$sql");
	}

	$rst = mysql_query($sql, $link);

	//DB削除チェック
	if ($rst)
	{
		print "削除しました。<br><br>";
	}
	else
	{
		print "削除できませんでした。<br><br>";
	}
}
else
{
	print "削除するリストを選択してください!!<br><br>";
	print "削除できませんでした。<br><br>";
}


print "<a href = \"kadai4_4.php\">リストページに戻る</a>";


mysql_close($link);
?>


</body>
</html>
