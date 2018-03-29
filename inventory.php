<?php
$special_page = '<link rel="stylesheet" href="css/inventory.css" type="text/css" />
		        <script src="js/ui_002.js" type="text/javascript"></script>
		        <script src="js/ui.js" type="text/javascript"></script>
		        <script type="text/javascript">
		            $(function() {
		                $("#rotate > ul").tabs({ fx: { opacity: "toggle" } }).tabs("rotate", 0);
		            });
		        </script>
';
include "globals.php";
print pageHelp(_HELP_INVENTORY_HEADER, _HELP_INVENTORY);

$q=$db->query("SELECT * FROM items WHERE itmid IN({$ir['equip_primary']}, {$ir['equip_secondary']}, {$ir['equip_armor']})");
$primary=$secondary=$armor=false;
while($arr=$db->fetch_row($q)){
	if($arr['itmid'] == $ir['equip_primary']){
		$primary = true;
		$pic_primary = $arr['itmpic'];
		$name_primary=$arr['itmname'];
	}if($arr['itmid'] == $ir['equip_secondary']){
		$secondary = true;
		$pic_secondary = $arr['itmpic'];
		$name_secondary=$arr['itmname'];
	}if($arr['itmid'] == $ir['equip_armor']){
		$armor = true;
		$pic_armor = $arr['itmpic'];
		$name_armor=$arr['itmname'];
	}
}
$inv=$db->query("SELECT iv.*,i.*,it.* FROM inventory iv LEFT JOIN items i ON iv.inv_itemid=i.itmid LEFT JOIN itemtypes it ON i.itmtype=it.itmtypeid WHERE iv.inv_userid={$userid} ORDER BY i.itmtype ASC, i.itmname ASC");

?>

<style>
.match_imgbg {
}
.match_imgbg#body1 {
	background-position: 0 0;
}
.match_imgbg#body2 {
	background-position: -82px 0;
}
.match_imgbg#body3 {
	background-position: 0 -81px;
}
.match_imgbg#body4 {
	background-position: -82px -81px;
}
.match_imgbg#body5 {
	background-position: 0 -162px;
}
.match_imgbg#body6 {
	background-position: -82px -162px;
}
</style>
				<div id="invimgtemp" style="display:none;position:absolute;top:0px;left:0px;z-index:5000;height:81px;width:82px;margin:0;padding-top:6px;">&nbsp;</div>
					<div id="invactions" style="display:none;position:absolute;top:0px;left:0px;z-index:3000;height:50px;width:250px;background:#000;border:1px solid #F7C942;padding:10px;">&nbsp;</div>
						<div class="inventory_container">
							<div class="inventory_topbg">
								<div class="inven_toptxt1"><img src="images/inven_toptxt1.jpg" align=left alt="" /></div>
								<div class="inven_toptxt2"></div>
							</div>
							<div class="inventory_conpart">
								<div class="inven_col1 inven_col1bg<?=$ir['class']?>">
									<div class="matchimgpart">
										<!---<div class="match_imgbg" id="body1"></div> --->
										<div class="match_imgbg" style="margin-top:22px;" id="body3"><?=($primary ? "<img src=\"./images/weapons/".$pic_primary."\" title=\"".$name_primary."\">" : "")?></div>
										<!---<div class="match_imgbg" style="margin-top:35px;" id="body5"></div>--->									
									</div>

									<div class="matchimgpart" style="margin-left:210px;">
										<div class="match_imgbg" id="body2"><?=($armor ? "<img src=\"./images/weapons/".$pic_armor."\" title=\"".$name_armor."\">" : "")?></div>
										<div class="match_imgbg" style="margin-top:22px;" id="body4"><?=($secondary ? "<img src=\"./images/weapons/".$pic_secondary."\" title=\"".$name_secondary."\">" :"")?></div>
										<!---<div class="match_imgbg" style="margin-top:35px;" id="body6"></div>--->							
									</div>
								</div>
								<div class="inven_col2">
									<div class="inven_tabpart">
										<div id="rotate">

											<ul class="ui-tabs-nav">
												<li><a href="#fragment-1"><span>Weapons</span></a></li>
												<li><a href="#fragment-2"><span>Armor</span></a></li>
												<li><a href="#fragment-3"><span>Potions</span></a></li>
											</ul>
				
										<?
										$tarr = array();
										while($i=$db->fetch_row($inv)){
											$tarr[] = $i['inv_id'];
											if($i['weapon'])
												$compart1= $compart1.'
												<div class="inven_con" id="invlist'.$i['inv_id'].'" >												
													<div class="inven_maincon">
														<div class="inven_txtpart">
															<div class="inven_con_txt1" style="font-size:12px;cursor:pointer;">'.$i['itmname'].' &nbsp;<small></small></div>
															<div class="inven_con_txt2"><span>Item Type:</span>'.$i['itmtypename'].'</div>
															<div class="inven_con_txt3"><span>Item Des.:</span>'.$i['itmdesc'].'<a href="iteminfo.php?ID='.$i['itmid'].'" title="More">More</a></div>
															<div class="inven_con_txt3" id="inv_qty'.$i['inv_id'].'"><small><span>Equip:</span> [<a href="javascript:void(0);" onclick="equipitem('.$i['inv_id'].',\'equip_primary\',1,'.$i['inv_qty'].')"><font color="#FF0000">Primary</font></a>] [<a href="javascript:void(0);"  onclick="equipitem('.$i['inv_id'].',\'equip_secondary\',1,'.$i['inv_qty'].')"><font color="#FF0000">Secondary</font></a>]</small>
																			            <br /><small><span>Shop:</span> [<a href="itemsend.php?ID='.$i['inv_id'].'"><font color="#FF0000">Send</font></a>] [<a href="itemsell.php?ID='.$i['inv_id'].'"><font color="#FF0000">Sell</font></a>] [<a href="imadd.php?ID='.$i['inv_id'].'"><font color="#FF0000">Add To Market</font></a>]</small>
															</div>
														</div>
														<div class="inven_imgpart" id="invimg'.$i['inv_id'].'"><img src="./images/weapons/'.$i['itmpic'].'" /></div>
													</div>												
													<div class="inven_tabline"><img src="images/inven_tabline.jpg" alt="" /></div>
												</div>';
											elseif($i['armor'])
												$compart2= $compart2.'
												<div class="inven_con" id="invlist'.$i['inv_id'].'" >												
													<div class="inven_maincon">
														<div class="inven_txtpart">
															<div class="inven_con_txt1" style="font-size:12px;cursor:pointer;">'.$i['itmname'].' &nbsp;<small></small></div>
															<div class="inven_con_txt2"><span>Item Type:</span>'.$i['itmtypename'].'</div>
															<div class="inven_con_txt3"><span>Item Des.:</span>'.$i['itmdesc'].'<a href="iteminfo.php?ID='.$i['itmid'].'" title="More">More</a></div>
															<div class="inven_con_txt3"><small><span>Equip:</span> [<a href="javascript:void(0);"  onclick="equipitem('.$i['inv_id'].',\'equip_armor\',2,'.$i['inv_qty'].')"><font color="#FF0000">Armor</font></a>]</small>
																	      <br /><small><span>Shop:</span> [<a href="itemsend.php?ID='.$i['inv_id'].'"><font color="#FF0000">Send</font></a>] [<a href="itemsell.php?ID='.$i['inv_id'].'"><font color="#FF0000">Sell</font></a>] [<a href="imadd.php?ID='.$i['inv_id'].'"><font color="#FF0000">Add To Market</font></a>]</small>
															</div>
														</div>
														<div class="inven_imgpart" id="invimg'.$i['inv_id'].'"><img src="./images/weapons/'.$i['itmpic'].'" /></div>
													</div>												
													<div class="inven_tabline"><img src="images/inven_tabline.jpg" alt="" /></div>
												</div>';
											else
												$compart3= $compart3.'
												<div class="inven_con" id="invlist'.$i['inv_id'].'" >												
													<div class="inven_maincon">
														<div class="inven_txtpart">
															<div class="inven_con_txt1" style="font-size:12px;cursor:pointer;" >'.$i['itmname'].' &nbsp;<small></small></div>
															<div class="inven_con_txt2"><span>Item Type:</span>'.$i['itmtypename'].'</div>
															<div class="inven_con_txt3"><span>Item Des.:</span>'.$i['itmdesc'].'<a href="iteminfo.php?ID='.$i['itmid'].'" title="More">More</a></div>
															<div class="inven_con_txt3"><small> [<a href="javascript:void(0);"  onclick="useitem('.$i['inv_id'].')"><font color="#FF0000">Use</font></a> <span id="qty'.$i['inv_id'].'">x'.$i['inv_qty'].'</span>]</small>
																	      <br /><small><span>Shop:</span> [<a href="itemsend.php?ID='.$i['inv_id'].'"><font color="#FF0000">Send</font></a>] [<a href="itemsell.php?ID='.$i['inv_id'].'"><font color="#FF0000">Sell</font></a>] [<a href="imadd.php?ID='.$i['inv_id'].'"><font color="#FF0000">Add To Market</font></a>]</small>
															</div>
														</div>
														<div class="inven_imgpart" id="invimg'.$i['inv_id'].'"><img src="./images/weapons/'.$i['itmpic'].'" /></div>
													</div>												
													<div class="inven_tabline"><img src="images/inven_tabline.jpg" alt="" /></div>
												</div>';
										}
										?>
						
										
										<div id="fragment-1" style="width:290px;max-height:600px;overflow-y:auto;overflow-x:hidden;">
											<div class="inven_conpart" id="inven_conpart1">
												<?=$compart1?>	
											</div>
										</div>
										
										
										<div id="fragment-2" style="width:290px;max-height:600px;overflow-y:auto;overflow-x:hidden;">
											<div class="inven_conpart" id="inven_conpart2">
												<?=$compart2?>
											</div>
										</div>
										<div id="fragment-3" style="width:290px;max-height:600px;overflow-y:auto;overflow-x:hidden;">
											<div class="inven_conpart" id="inven_conpart3">
												<?=$compart3?>
											</div>
										</div>
										<div class="inven_btm">&nbsp;</div>
									</div>

								</div>
							</div>
						</div>
<script type="text/javascript">
$('#body2').mouseover(function(){
	if($('#body2 > img').length){
		if(!$('#msg2').length)
			$('#body2').append('<div id="msg2"><a href="javascript:void(0)" onclick="unequipitem(\'equip_armor\',2,2)">Unequip</div>');
		else
			$('#msg2').show();
	}
});
$('#body2').mouseout(function(){
	$('#msg2').hide();
});

$('#body3').mouseover(function(){
	if($('#body3 > img').length){
		if(!$('#msg3').length)
			$('#body3').append('<div id="msg3"><a href="javascript:void(0)" onclick="unequipitem(\'equip_primary\',1,3)">Unequip</div>');
		else
			$('#msg3').show();
	}
});
$('#body3').mouseout(function(){
	$('#msg3').hide();
});

$('#body4').mouseover(function(){
	if($('#body4 > img').length){
		if(!$('#msg4').length)
			$('#body4').append('<div id="msg4"><a href="javascript:void(0)" onclick="unequipitem(\'equip_secondary\',1,4)">Unequip</div>');
		else
			$('#msg4').show();
	}
});
$('#body4').mouseout(function(){
	$('#msg4').hide();
});

function unequipitem(position,container,body){
	$.ajax({
		url: "ajax.php",
		data: {do: "unequipitem", position:position},
		async: false,
		cache: false,
		success:function(r){
			//alert(r);
			eval("var resp = "+r);
			if(resp.failed){
				alert(resp.failed);
				return false;
			}
			displayunequiped(resp.item,container);
			$('#body'+body).children().remove();
		}
	}); 
}
var error = false;
function equipitem(id,position,container,quantity){
	if(error){
		alert("There was an error! Please reload the page!");
		return false;
	}
	error=true;
	$.ajax({
		url: "ajax.php",
		data: { position:position, do: "equipitem",ID:id },
		async: false,
		cache: false,
		success:function(r){
			//alert(r);
			eval("var resp = "+r);
			if(resp.failed){
				alert(resp.failed);
				return false;
			}
			if(quantity == 1 || resp.equiped.inv_qty == 0)
				$('#invlist'+id).remove();
			else
				$('#inv_qty'+id).html('<small><span>Equip:</span> [<a href="javascript:void(0);"  onclick="equipitem('+id+',\'equip_primary\','+container+','+(quantity-1)+')"><font color="#FF0000">Primary</font></a>] [<a href="javascript:void(0);"  onclick="equipitem('+id+',\'equip_secondary\','+container+','+(quantity-1)+')"><font color="#FF0000">Secondary</font></a>]</small><br /><small><span>Shop:</span> [<a href="itemsend.php?ID='+id+'"><font color="#FF0000">Send</font></a>] [<a href="itemsell.php?ID='+id+'"><font color="#FF0000">Sell</font></a>] [<a href="imadd.php?ID='+id+'"><font color="#FF0000">Add To Market</font></a>]</small>');
			if(resp.change)
				displayunequiped(resp.change,container);
			displayequiped(resp.equiped,position,container);
			error=false;
		}
	}); 
}
function displayunequiped(obj,container){
	if($('#invlist'+obj.inv_id).length){
		var invhtml = '<div class="inven_maincon"><div class="inven_txtpart">' +
			'<div class="inven_con_txt1" style="font-size:12px;cursor:pointer;"' +
			' >'+obj.itmname+'&nbsp;</div><div class="inven_con_txt2"><span>Item Type:</span>'+obj.itmtypename+'</div>';
		invhtml +='<div class="inven_con_txt3"><span>Item Des.:</span>'+obj.itmdesc+'<a href="iteminfo.php?ID='+obj.itmid+'" title="More">More</a></div>';
		if((obj.itmtype == 3)||(obj.itmtype == 4))
			invhtml +='<div class="inven_con_txt3"><small><span>Equip:</span> [<a href="javascript:void(0);"  onclick="equipitem('+obj.inv_id+',\'equip_primary\','+container+','+obj.inv_qty+')"><font color="#FF0000">Primary</font></a>] [<a href="javascript:void(0);"  onclick="equipitem('+obj.inv_id+',\'equip_secondary\','+container+','+obj.inv_qty+')"><font color="#FF0000">Secondary</font></a>]</small><br /><small><span>Shop:</span> [<a href="itemsend.php?ID='+obj.inv_id+'"><font color="#FF0000">Send</font></a>] [<a href="itemsell.php?ID='+obj.inv_id+'"><font color="#FF0000">Sell</font></a>] [<a href="imadd.php?ID='+obj.inv_id+'"><font color="#FF0000">Add To Market</font></a>]</small></div></div>';
		if(obj.itmtype == 7)
			invhtml +='<div class="inven_con_txt3" id="inv_qty'+obj.inv_id+'"><small><span>Equip:</span> [<a href="javascript:void(0);"  onclick="equipitem('+obj.inv_id+',\'equip_armor\','+container+','+obj.inv_qty+')"><font color="#FF0000">Armor</font></a>]</small><br /><small><span>Shop:</span> [<a href="itemsend.php?ID='+obj.inv_id+'"><font color="#FF0000">Send</font></a>] [<a href="itemsell.php?ID='+obj.inv_id+'"><font color="#FF0000">Sell</font></a>] [<a href="imadd.php?ID='+obj.inv_id+'"><font color="#FF0000">Add To Market</font></a>]</small></div></div>';
		invhtml +='<div class="inven_imgpart" id="invimg'+obj.inv_id+'"><img src="./images/weapons/'+obj.itmpic+'" title="'+obj.itmname+'"/></div></div><div class="inven_tabline"><img src="images/inven_tabline.jpg" alt="" /></div>';
		$('#invlist'+obj.inv_id).html(invhtml);
	}else{
		var invhtml = '<div class="inven_con" id="invlist'+obj.inv_id+'" >' +
			'<div class="inven_maincon"><div class="inven_txtpart">' +
			'<div class="inven_con_txt1" style="font-size:12px;cursor:pointer;"' +
			' >'+obj.itmname+'&nbsp;</div><div class="inven_con_txt2"><span>Item Type:</span>'+obj.itmtypename+'</div>';
		invhtml +='<div class="inven_con_txt3"><span>Item Des.:</span>'+obj.itmdesc+'<a href="iteminfo.php?ID='+obj.itmid+'" title="More">More</a></div>';
		if((obj.itmtype == 3)||(obj.itmtype == 4))
			invhtml +='<div class="inven_con_txt3"><small><span>Equip:</span> [<a href="javascript:void(0);"  onclick="equipitem('+obj.inv_id+',\'equip_primary\',1,'+obj.inv_qty+')"><font color="#FF0000">Primary</font></a>] [<a href="javascript:void(0);"  onclick="equipitem('+obj.inv_id+',\'equip_secondary\',1,'+obj.inv_qty+')"><font color="#FF0000">Secondary</font></a>]</small><br /><small><span>Shop:</span> [<a href="itemsend.php?ID='+obj.inv_id+'"><font color="#FF0000">Send</font></a>] [<a href="itemsell.php?ID='+obj.inv_id+'"><font color="#FF0000">Sell</font></a>] [<a href="imadd.php?ID='+obj.inv_id+'"><font color="#FF0000">Add To Market</font></a>]</small></div></div>';
		if(obj.itmtype == 7)
			invhtml +='<div class="inven_con_txt3" id="inv_qty'+obj.inv_id+'"><small><span>Equip:</span> [<a href="javascript:void(0);"  onclick="equipitem('+obj.inv_id+',\'equip_armor\',2,'+obj.inv_qty+')"><font color="#FF0000">Armor</font></a>]</small><br /><small><span>Shop:</span> [<a href="itemsend.php?ID='+obj.inv_id+'"><font color="#FF0000">Send</font></a>] [<a href="itemsell.php?ID='+obj.inv_id+'"><font color="#FF0000">Sell</font></a>] [<a href="imadd.php?ID='+obj.inv_id+'"><font color="#FF0000">Add To Market</font></a>]</small></div></div>';
		invhtml +='<div class="inven_imgpart" id="invimg'+obj.inv_id+'"><img src="./images/weapons/'+obj.itmpic+'"  title="'+obj.itmname+'"/></div></div><div class="inven_tabline"><img src="images/inven_tabline.jpg" alt="" /></div>';
		$('#inven_conpart'+container).append(invhtml);
	}
}
function displayequiped(obj,position,container){
	var body_id=-1;
	if(position == "equip_primary")
		body_id=3;
	else if(position == "equip_secondary")
		body_id=4;
	else if(position == "equip_armor")
		body_id=2;
	$('#body'+body_id).html('<img src="./images/weapons/'+obj.itmpic+'"   title="'+obj.itmname+'" border="0" style="" alt="" />');
	$('#body'+body_id+'>img').show();
}
function useitem(id){
	$.ajax({
		url: "ajax.php",
		data: { do:"useitem", ID:id },
		async: false,
		cache: false,
		success:function(r){
			eval("var resp = "+r);
			if(resp.failed){
				alert(resp.failed);
				return false;
			}
			if(resp.item.inv_qty == 0)
				$('#invlist'+id).remove();
			else
				$('#qty'+id).html("x"+resp.item.inv_qty);
				AjaxUpdateUserStats();
		}
	}); 
}
</script>			
<?
$h->endpage();
?>