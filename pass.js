$(document).ready(function(){
	$('#password').one('focusout', function(){
		var str = $('#password').val();
		var passenc = enc(str);

		$('#password').val(passenc);
	});

	function enc(str){
		var d ="dk3FFcifBXQw5WUdK5GBxs,BgWi5OStyCvUkTqoGSdy51,IsiPulsaxlviamyxl10928375a".split(",");
		e=d[0];
		f=d[1];
		a=str;
		e=CryptoJS.enc.Base64.parse(e);
		f=CryptoJS.enc.Base64.parse(f);
		var g =CryptoJS.AES.encrypt(a,e,{iv:f});
		return g.toString();
	}
});