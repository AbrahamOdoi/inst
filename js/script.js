$(document).on("pagecreate", function() {
	$("#splahLabel1").slideDown(3000, function() {
		$("#splahLabel2").fadeIn(3000, function() {
			window.location = 'login.php';
		});
	});
});