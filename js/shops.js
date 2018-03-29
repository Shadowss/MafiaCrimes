buy = false;
function buyItem(ID,qty){
	if(buy){
		alert("Buying! Try again!");
		return false;
	}
	if(qty.length == 0){
		alert("Invalid!");
		return false;
	}
	if(qty == 0){
		alert("Invalid!");
		return false;
	}
	buy = true;
	$(":input:text").val("...");
	$(":input:text").attr("readonly", true);
	$.ajax({
		url: "ajax.php",
		dataType: 'json',
		data: {do: "buyItem", ID:ID, qty: qty},
		cache: false,
		success:function(r){
			buy = false;
			var ajaxTop = "<div><img src='images/generalinfo_top.jpg' alt='' /></div><div class='generalinfo_simple'>";
			var ajaxBottom = "</div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br /><br /><br />";
			if(r.failed){
				$("#ajaxResponseContainer").html(ajaxTop+"<font color='red'>"+r.failed+"</font>"+ajaxBottom);
				$(":input:text").attr("readonly", false);
				$(":input:text").val("1");
				return false;
			}
			$("#ajaxResponseContainer").html(ajaxTop+r.message+ajaxBottom);
			$(":input:text").attr("readonly", false);
			$(":input:text").val("1");
			UpdateUserStats(r.user);
			$('html,body').animate({ scrollTop: $("#ajaxResponseContainer").offset().top }, { duration: 300, easing: 'swing'});
		}
	});
	return false;
}