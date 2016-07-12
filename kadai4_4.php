<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>● 課題4_4, レコードを削除するページを作成する(DELETE)</title>
<script type="text/javascript"><!--
	//一斉削除・削除解除
	function allcheck( tf ) {
		// チェックボックスの数
		var ElementsCount = document.sakujoform.elements.length;
		for( i=0 ; i<ElementsCount ; i++ )
		{
			// ON・OFFを切り替え
			document.sakujoform.elements[i].checked = tf;
		}
	}

	//削除コーション表示
	function disp(){
		// 削除確認
		if(window.confirm('本当に削除しますか？'))
		{
			//「はい」選択で削除処理
			document.sakujoform.submit();
		}
		else
		{
			//「いいえ」選択で削除せず警告ダイアログを表示
			window.alert('キャンセルされました');
			return false;
		}
	}
// --></script>
</head>
<body>
<h1>● 課題4_4, レコードを削除するページを作成する(DELETE)</h1>
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

print  <<<EOM
		<table border = "1">
		<form name="sakujoform" method="post" action="kadai4_4_delete.php">
				<input type="button" value="一斉チェック" onclick="allcheck(true);" />
				<input type="button" value="一斉解除" onclick="allcheck(false);" />
	      		<input type="button" value="削除" onclick="disp()">
	      		<br>
	      		<br>
			<tr>
				<th>削除</th>
				<th>全国地方公共団体コード</th>
				<th>旧郵便番号</th>
				<th>郵便番号</th>
				<th>都道府県名(半角カタカナ)</th>
				<th>市区町村名(半角カタカナ)  </th>
				<th>町域名(半角カタカナ)</th>
				<th>都道府県名(漢字)</th>
				<th>市区町村名(漢字)</th>
				<th>町域名(漢字)</th>
				<th>一町域で複数の郵便番号か</th>
				<th>小字毎に番地が起番されている町域か</th>
				<th>丁目を有する町域名か</th>
				<th>一郵便番号で複数の町域か</th>
				<th>更新確認</th>
				<th>更新理由</th>
			</tr>


EOM;

//DBデータ全件表示
$result = mysql_query("SELECT * FROM `kadai_matsui_ziplist` WHERE 1");
while ($row = mysql_fetch_array($result))
 {
	//town_double_zip_code    (1=該当、0=該当せず)
	if ($row['town_double_zip_code'] == 1)
	{
		$row['town_double_zip_code'] = "該当";
	}
	else
	{
		$row['town_double_zip_code'] = "該当せず";
	}

	//town_multi_address      (1=該当、0=該当せず)
	if ($row['town_multi_address'] == 1)
	{
		$row['town_multi_address'] = "該当";
	}
	else
	{
		$row['town_multi_address'] = "該当せず";
	}

	//town_attach_district    (1=該当、0=該当せず)
	if ($row['town_attach_district'] == 1)
	{
		$row['town_attach_district'] = "該当";
	}
	else
	{
		$row['town_attach_district'] = "該当せず";
	}

	//zip_code_multi_town     (1=該当、0=該当せず)
	if ($row['zip_code_multi_town'] == 1)
	{
		$row['zip_code_multi_town'] = "該当";
	}
	else
	{
		$row['zip_code_multi_town'] = "該当せず";
	}

	//update_check            (0=変更なし、1=変更あり、2=廃止(廃止データのみ使用))
	if ($row['update_check'] == 0)
	{
		$row['update_check'] = "変更なし";
	}
	elseif($row['update_check'] == 1)
	{
		$row['update_check'] = "変更あり";
	}
	else
	{
		$row['update_check'] = "廃止(廃止データのみ使用)";
	}

	//update_reason           (0=変更なし、1=市政・区政・町政・分区・政令指定都市施行、2=住居表示の実施、
	//3=区画整理、4=郵便区調整等、5=訂正、6=廃止(廃止データのみ使用))
	if ($row['update_reason'] == 0)
	{
		$row['update_reason'] = "変更なし";
	}
	elseif($row['update_reason'] == 1)
	{
		$row['update_reason'] = "市政・区政・町政・分区・政令指定都市施行";
	}
	elseif($row['update_reason'] == 2)
	{
		$row['update_reason'] = "住居表示の実施";
	}
	elseif($row['update_reason'] == 3)
	{
		$row['update_reason'] = "区画整理";
	}
	elseif($row['update_reason'] == 4)
	{
		$row['update_reason'] = "郵便区調整等";
	}
	elseif($row['update_reason'] == 5)
	{
		$row['update_reason'] = "訂正";
	}
	else
	{
		$row['update_reason'] = "廃止(廃止データのみ使用)";
	}

	print <<<EOM
		<tr>
			<td><input type="checkbox" name="sakujo[]" value="{$row['zip_code']}"></td>
			<td>{$row['public_group_code']}</td>
			<td>{$row['zip_code_old']}</td>
			<td>{$row['zip_code']}</td>
			<td>{$row['prefecture_kana']}</td>
			<td>{$row['city_kana']}</td>
			<td>{$row['town_kana']}</td>
			<td>{$row['prefecture']}</td>
			<td>{$row['city']}</td>
			<td>{$row['town']}</td>
			<td>{$row['town_double_zip_code']}</td>
			<td>{$row['town_multi_address']}</td>
			<td>{$row['town_attach_district']}</td>
			<td>{$row['zip_code_multi_town']}</td>
			<td>{$row['update_check']}</td>
			<td>{$row['update_reason']}</td>
		</tr>
EOM;

	//mb_convert_variables("UTF-8", "SJIS", $row[]);

}

print "</form></table>";

mysql_close($link);
?>


</body>
</html>
