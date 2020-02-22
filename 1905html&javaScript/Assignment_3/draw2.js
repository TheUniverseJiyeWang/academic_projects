$(document).ready(function(){
	draw = function(){
		var numform1 = $("#numform")[0];
		if(!numform1.checkValidity()){
			if(numform1.reportValidity()){
				numform1.reportValidity();
				return;
			}
		}
		var min = $('#min').val();
		var max = $('#max').val();
		min = Number(min);
		max = Number(max);
		if(min>=max){
			alert("Max value must be bigger than min value!");
		}else{
			table = "<tr><th>N</th><th>N*N</th><th>N*N*N</th></tr>";
			$('#result').empty();
			for(i=min; i<=max; i=i+5){
				table += "<tr><th>"+i+"</th><th>"+i*i+"</th><th>"+i*i*i+"</th></tr>";
			}
			$('#result').html(table);
		}

	}
})
