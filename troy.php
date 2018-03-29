<?php
if(isset($_GET['submit'])){
	$exp =(int)($_GET['bani']/8);
	print("LEVEL introdus ".$_GET['level']." Bani castigati ".$_GET['bani']." experienta creste cu ".($exp*100/(($_GET['level']+1)*($_GET['level']+1)*($_GET['level']+1)*2.2))."%");
}
?>
<form method="get">
level curent:<input type="text" name="level" value="<?=$_GET['level'];?>"><br />
bani:<input type="text" name="bani" value="<?=$_GET['bani'];?>"><br />
<input type="submit" name="submit">
</form>
