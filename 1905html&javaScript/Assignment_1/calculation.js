	function add(){
		var number1 = document.getElementById("number1").value;
		var number2 = document.getElementById("number2").value;
		var result = Number(number1)+Number(number2);
		document.getElementById("result").innerHTML = result;
	};

	function mul(){
		var number1 = document.getElementById("number1").value;
		var number2 = document.getElementById("number2").value;
		var result = Number(number1)*Number(number2);
		document.getElementById("result").innerHTML = result;
	};

	function sub(){
		var number1 = document.getElementById("number1").value;
		var number2 = document.getElementById("number2").value;
		var result = Number(number1)-Number(number2);
		document.getElementById("result").innerHTML = result;
	};

	function div(){
		var number1 = document.getElementById("number1").value;
		var number2 = document.getElementById("number2").value;
		var result = Number(number1)/Number(number2);
		document.getElementById("result").innerHTML = result;
	};
