working = false;
function workOut(skill,times){
	if(working){
		alert("You are still working out. Try again!");
		return false;
	}
	if(times.length == 0){
		alert("You have to train more than "+times+" times");
		return false;
	}
	working = true;
	$(":input").val("Training...");
	$(":input").attr("readonly", true);
	$.ajax({
		type: 'POST',
		url: "ajax.php",
		dataType: 'json',
		data: {do: "gym", skill:skill, times: times},
		cache: false,
		success:function(r){
			working = false;
			if(r.failed){
				$("#gym_container").html("<font color='red'>"+r.failed+"</font>");
				$(":input").attr("readonly", false);
				$(":input").val("0");
				return false;
			}
			$("#gym_container").html(r.message);
			$("#gym_strength").html(r.user.strength);
			$("#gym_strength_rank").html(r.srank);
			$("#gym_agility").html(r.user.agility);
			$("#gym_agility_rank").html(r.arank);
			$("#gym_guard").html(r.user.guard);
			$("#gym_guard_rank").html(r.grank);
			$("#gym_labour").html(r.user.labour);
			$("#gym_labour_rank").html(r.lrank);
			UpdateUserStats(r.user);
			$(":input").attr("readonly", false);
			$(":input").val(""+r.user.energy);
		}
	});
	return false;
}