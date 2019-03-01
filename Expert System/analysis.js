

function generateRandomString(){

	var possChars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

	for (var i = 0; i < 8; i++){

		id = id + possChars.charAt(Math.floor(Math.random() * possChars.length));

	}
}
