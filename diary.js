$(".toggle").on("click", function() {
	$("#signupform").toggle();
	$("#loginform").toggle();
});


$("#notes").bind('input propertychange', function() {
	$.ajax({
		method: "POST",
		url: "update.php",
		data: { content: $("#notes").val() }
	});
});