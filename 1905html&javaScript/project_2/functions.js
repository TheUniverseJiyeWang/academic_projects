var server_url = "http://dev.cs.smu.ca:8172";

function empty_check(){
	var unv_name = $("#unv_name").val();
	var unv_address = $("#unv_address").val();
	var unv_phone = $("#unv_phone").val();
	var html = $("#unv_save_alert").html();
	var reg = new RegExp("{(message)}","ig");

	if(unv_name == ""){
		html = html.replace(reg,function(text,key){
			return "Please Enter University Name!";
		});
		$("#unv_save_error").html(html);
		$("#unv_name").focus();
		return false;
	}else if(unv_address == ""){
		html = html.replace(reg,function(text,key){
			return "Please Enter Universtiy Address!";
		});
		$("#unv_save_error").html(html);
		$("#unv_address").focus();
		return false;
	}else if(unv_phone == ""){
		html = html.replace(reg,function(text,key){
			return "Please Enter University Phone Number!";
		});
		$("#unv_save_error").html(html);
		$("#unv_phone").focus();
		return false;
	}
	return true;
};

function clean_input(){
	$("#unv_name").val("");
	$("#unv_address").val("");
	$("#unv_phone").val("");
};

function save_unv(){
	if(empty_check()){
		var new_unv = {
			Name:$("#unv_name").val(),
			Address:$("#unv_address").val(),
			Phone:$("#unv_phone").val()
		};
		$.post(server_url + "/saveUniversity", new_unv, function(data){
			alert(data);
			clean_input();
		}).fail(function(error){
			if(error.responseText == ""){
				alert("Please run `node function_server.js`");
			}else{
				alert("ERROR: "+error.responseText);
			}
		});
	}
};

function delete_unv(){
	var html = $("#unv_save_alert").html();
	var reg = new RegExp("{(message)}","ig");
	if($("#unv_name").val()!=""){
		var dlt_unv = {
			Name:$("#unv_name").val()
		};
		$.post(server_url + "/deleteUniversity", dlt_unv, function(data){
			alert(data);
			clean_input();
		}).fail(function(error){
			if(error.responseText == ""){
				alert("Please run `node function_server.js`");
			}else{
				alert("ERROR: "+error.responseText);
			}
		});
	}else{
		html = html.replace(reg,function(text,key){
			return "Please Enter University Name First!";
		});
		$("#unv_save_error").html(html);
		$("#unv_name").focus();
	}
};

function search_record(){
	var html = $("#unv_save_alert").html();
	var reg = new RegExp("{(message)}","ig");
	if($("#search_name").val()!=""){
		var search_unv = {
			Name:$("#search_name").val()
		};
		$.post(server_url + "/searchUniversity", search_unv, function(data){
			unv_record = data;
			if(unv_record==null||unv_record.length==0){
				html = html.replace(reg,function(text,key){
					return "No Record Found.";
				});
				$("#unv_search_error").html(html);
			}else{
				$("#unv_name").val(unv_record[0].Name);
				$("#unv_address").val(unv_record[0].Address);
				$("#unv_phone").val(unv_record[0].Phone);
			}
		}).fail(function(error){
			if(error.responseText == ""){
				alert("Please run `node function_server.js`");
			}else{
				alert("ERROR: "+error.responseText);
			}
		});
	}else{
		html = html.replace(reg,function(text,key){
			return "Please Enter University Name First to Search!";
		});
		$("#unv_search_error").html(html);
		$("#search_name").focus();
	}
};

function display_record(){
	$.post(server_url + "/displayUniversity", function(data){
		unv_records = data;
		if(unv_records==null||unv_records.length==0){
			html = html.replace(reg,function(text,key){
				return "No Record Found.";
			});
			$("#unv_search_error").html(html);
		}else{
			var tbResult = "<tr><th><b>University</b></th><th><b>Address</b></th><th><b>Phone</b></th></tr>";
			for(var i=0; i<unv_records.length;i++){
				var tmpName = unv_records[i].Name;
				var tmpAddress = unv_records[i].Address;
				var tmpPhone = unv_records[i].Phone;
				tbResult += "<tr><th>"+tmpName+"</th><th>"+tmpAddress+"</th><th>"+tmpPhone+"</th></tr>";
			}
			document.getElementById("tbResult").innerHTML = tbResult;			
		}
	}).fail(function(error){
		if(error.responseText == ""){
			alert("Please run `node function_server.js`");
		}else{
			alert("ERROR: "+error.responseText);
		}
	});
};