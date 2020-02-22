function addValueToPassword(button){
	var currVal = $("#passcode").val();
	if (button ==="bksp"){
		$("#passcode").val(currVal.substring(0,currVal.length -1));
	}else{
		$("#passcode").val(currVal.concat(button));
	}
};

function saveSignupForm(){
	var user ={
		"FirstName":$("#singupFirstName").val(),
		"LastName":$("#signupLastName").val(),
		"DateofBirth":$("#dateOfBirth").val(),
		"SINNumber":$("#signupSinNumber"),
		"NewPassword":$("#confirmPassword").val(),
		"Gender":$("#signupGenderType option:selected").val()
	};
	try{
		localStorage.setItem("user",JSON.stringify(user));
		alert("Saving Information");
		$.mobile.changePage("#legalNotice");
		window.location.reload();
	}catch(e){
		if(window.navigator.vendor === "Google Inc."){
			if(e == DOMException.QUOTA_EXCEEDED_ERR){
				alert("Error: Local Storage limit Exceeds.");
			}else if(e == QUOTA_EXCEEDED_ERR){
				alert("Error: Saving to local storage.");
			}
		}
		console.log(e);
	}
};

function saveDisclaimer(){
	localStorage.setItem("agreedToLegal","true");
	$.mobile.changePage("#pageMenu");
	window.location.reload();
};

function redirectPage(){
	if(document.getElementById("passcode").value == password && document.getElementById("username").value === userName){
		if(localStorage.getItem("agreedToLegal") === null){
			alert("You need to sign the Legal Notice first.");
			$("#btnEnter").attr("href","#legalNotice").button();
		}else if(localStorage.getItem("agreedToLegal") === "true"){
			$("#btnEnter").attr("href","#pageMenu").button();
		}
	}else{
		alert("Incorrect username/password, please try agian.");
	}
};

$("#btnClearHistory").click(function(){
	localStorage.removeItem("tbRecords");
	listRecords();
	alert("All records have been deleted.");
});

$("#btnAddRecord").click(function(){
	$("#btnSubmitRecord").val("Add").button("refresh");
});

function checkAddOrEditRecord(){
	var formOperation = $("#btnSubmitRecord").val();
	if(formOperation == "Add Expense"){
		addRecord();
		$.mobile.changePage("#pageRecords");
	}else if(formOperation == "Update Expense"){
		editRecord($("btnSubmitRecord").attr("indexToEdit"));
	}
	return false;
};

