<?php require '../header.php';?>
<table>
<tr><th>商品番号</th><th>商品名</th><th>価格</th></tr>
<?php
require 'connect.php';
foreach ($pdo->query('select * from product ') as $row){
  echo '<tr>';
  echo '<td>',$row['id'],'</td>';
  echo '<td>',$row['name'],'</td>';
  echo '<td>',$row['price'],'</td>';
  echo '</tr>';
}
?>
</table>
<?php require '../footer.php';?>