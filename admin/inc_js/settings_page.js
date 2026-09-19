//-----------------------------------------------------
//restore save button
function restoreSaveButton(){	
	$("#spanLoaderSave").hide();
	$("#spanErrorText").hide();
	$("#spanSavedText").hide();
	$("#butSaveSettings").show();
}

//-----------------------------------------------------
//show saving error text
function showSavingErrorText(){
   $("#butSaveSettings").show();
   $("#spanErrorText").show();
   setTimeout("restoreSaveButton()",5000);
}

//-----------------------------------------------------
//show restoring error text
function showRestoreErrorText(){
	$("#spanRestoreErrorText").show();
	$("#butRestoreSettings").show();
	$("#spanLoaderRestore").hide();
}

//-----------------------------------------------------
//save the settings
function saveSettingsClick(formID){
	if(!formID) formID = "frmSettings";
	
	var objForm = getObjFormElements(formID);
	var obj = new Object();
	obj.settingsData = objForm;
	obj.settingsTypes = objSettingTypes; 
	var data = JSON.stringify(obj);
	
	var postData = {};
	postData.action = "saveSettings";
	postData.data = data;
	
	//add preset (if exists)
	if($("#selectPresets").length)
		postData.preset = $("#selectPresets").val();
	
	$("#spanLoaderSave").show();
	$("#butSaveSettings").hide();
	
	//send request to save settings by ajax
	jQuery.ajax({
		   type: "POST",
		   url: g_self,
		   data: postData,
		   success: function(response){
				$("#spanLoaderSave").hide();
				if(!isJSON(response)){
					debug(response);
					showSavingErrorText();
					return(false);
				}
				var objResponse = JSON.parse(response);
				if(objResponse.success == true){	//show success text
					$("#spanSavedText").show();
					setTimeout("restoreSaveButton()",750);
				}
				else showSavingErrorText();
		   },
		   error: function(){
			   $("#spanLoaderSave").hide();
			   showSavingErrorText();
		   }		
		});	
	
}

//-----------------------------------------------------
// restore settings
function restoreSettingsClick(){
	if(confirm("The settings will be restored to their defaults. Do you sure?") == false) return(false);
	
	$("#butRestoreSettings").hide();	
	$("#spanLoaderRestore").show();
	
	var data = {}; 
	data.action = "restoreSettings";
	
	//add preset to the request data and set relocate querystring
	var querystring = "";
	if($("#selectPresets").length){
		data.preset = $("#selectPresets").val();
		querystring = "?preset="+data.preset;
	}
	
	//send request to restore settings by ajax
	jQuery.ajax({
		   type: "POST",
		   url: g_self,
		   data: data,
		   success: function(response){
				if(!isJSON(response)){
					debug(response);
					showRestoreErrorText();
					return(false);
				}				
				var objResponse = JSON.parse(response);
				
				if(objResponse.success == true){	//show success text					
					$("#spanLoaderRestore").hide();
					$("#spanRestoredText").show();
					setTimeout("location.href='"+g_self+querystring+"'",500);
				}
				else showRestoreErrorText();				
		   },
		   error: function(){
			   showRestoreErrorText();
		   }		
		});
}
