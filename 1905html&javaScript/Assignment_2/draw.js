function draw(){
	var min = document.getElementById("min").value;
	var max = document.getElementById("max").value;
	min = Number(min);
	max = Number(max);
	if(min>=max){
		alert("Max value must be bigger than min value!");
	}else{
		
		table = "<tr><th>N</th><th>N*N</th><th>N*N*N</th></tr>";
		for(i=min; i<=max; i=i+5){
			table += "<tr><th>"+i+"</th><th>"+i*i+"</th><th>"+i*i*i+"</th></tr>";
		}
		document.getElementById("result").innerHTML = table;
	}
};
