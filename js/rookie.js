// Most of this grabbed from StackExchange

// Show/mask text in password field
function FormShowPassword() {
	var x = document.getElementById("password");
	if (x.type === "password") {
		x.type = "text";
	} else {
		x.type = "password";
	}
}

// Force toggle input field from 'text' to 'password'
function ToggleText2Pass() {
	var x = document.getElementById("password");
	x.type = "password";
}

// Open window to choose file
function ChooseFile() {
	document.getElementById("file2Upload").click();
}

// Preview selected image before it is submitted
function PreviewImage(event) {
	var input = event.target;
	var reader = new FileReader();
	reader.onload = function() {
		var dataURL = reader.result;
		var output = document.getElementById('profileimage');
		output.src = dataURL;
	};
	reader.readAsDataURL(input.files[0]);
}