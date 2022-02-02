<?php session_start(); ?>
<?php require '../header.php'; ?>
<?php require 'menu.php'; ?>
<?php require '../chap6/connect.php'; ?>
<?php

if (isset($_SESSION['customer'])) {

	$sql_purchase=$pdo->prepare(
		'SELECT * from purchase 
		 where customer_id=? 
		 order by id desc');
	//購入履歴テーブルから顧客IDで絞り込み,降順で取得
	$sql_purchase->execute([$_SESSION['customer']['id']]);

	foreach ($sql_purchase as $row_purchase) {
		$sql_detail=$pdo->prepare(
			'SELECT * from purchase_detail,product 
			 WHERE purchase_id=? and product_id=id');
	//購入明細と商品一覧を結合
		$sql_detail->execute([$row_purchase['id']]);
?>
		echo '<table>';
		echo '<tr><th>商品番号</th><th>商品名</th>', 
			'<th>価格</th><th>個数</th><th>小計</th></tr>';
<?php			
		$total=0;
		foreach ($sql_detail as $row_detail) {

			echo '<tr>';
			echo '<td>', $row_detail['id'], '</td>';
			echo '<td><a href="detail.php?id=', $row_detail['id'], '">', 
				$row_detail['name'], '</a></td>';
			echo '<td>', $row_detail['price'], '</td>';
			echo '<td>', $row_detail['count'], '</td>';
			$subtotal=$row_detail['price']*$row_detail['count'];
			$total+=$subtotal;
			echo '<td>', $subtotal, '</td>';
			echo '</tr>';
		}
		echo '<tr><td>合計</td><td></td><td></td><td></td><td>', 
			$total, '</td></tr>';
		echo '</table>';
		echo '<hr>';
	}
} else {
	echo '購入履歴を表示するには、ログインしてください。';
}
?>
<?php require '../footer.php'; ?>