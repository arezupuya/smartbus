

//-----------------------------------------------------
//close the color picker
function closeColorPicker(){
	$("#divPickerWrapper").hide();
}

/*
//-----------------------------------------------------
//invoke when click on every setting
function everySettingClick(){
	if(!$(this).hasClass('inputColorPicker')) closeColorPicker();
}
*/

//-----------------------------------------------------

function selectSectionByNum(numSection){	
	var numDivSection = numSection-1; 
	var item = $(".listSections li:nth-child("+numSection+")");
	item.addClass('selected');
	item.siblings().removeClass('selected');
	
	$('.divSections').hide();
	$('#divSection_'+numDivSection).show();
}

//-----------------------------------------------------
// selection click event. update hush, and select proper section.
function onSectionClick(event){
	selectSectionByNum(event.data.num);
	//update hash
	location.hash = event.data.num;
	closeColorPicker();
}


//-----------------------------------------------------
// input color picker event. open the color picker.
function onColorPickerFocus(){
	g_picker.linkTo(this);
	$('#divPickerWrapper').show();
	var serviceID = this.id + "_service";
	var vertGap = -100; 
		
	setDivToDivPos('divPickerWrapper',serviceID,0,vertGap);
}

//-----------------------------------------------------
//event on settings wrapper click. close the color picker.  
function onDivSettingsClick(event){
	//close the color picker
	if(event.target.className != "inputColorPicker") closeColorPicker();
}

//-----------------------------------------------------
//on selects change - impiment the hide/show, enabled/disables functionality
function onSettingsSelectChange(){
	var controlValue = this.value.toLowerCase();
	if(!g_controls[this.name]) return(false);
	$(g_controls[this.name]).each(function(){
		var childInput = document.getElementById(this.name);
		var childRow = document.getElementById(this.name + "_row");
		var value = this.value.toLowerCase();

		switch(this.type){
			case "enable":
			case "disable":
				if(childInput){
					if(this.type == "enable" && controlValue != this.value || this.type == "disable" && controlValue == this.value){
						childRow.className = "disabled";
						childInput.disabled = true;
						childInput.style.color = "";
					}
					else{
						childRow.className = "";
						childInput.disabled = false;
						//color the input again
						if($(childInput).hasClass("inputColorPicker")) g_picker.linkTo(childInput);		
	 				}
				}
			break;
			case "show":
				if(controlValue == this.value) $(childRow).show();									
				else $(childRow).hide();					
			break;
			case "hide":
				if(controlValue == this.value) $(childRow).hide();									
				else $(childRow).show();
			break;
		}
	});
}

//-----------------------------------------------------
//close or open sap control
function toggleSapControl(sapKey,sectionKey){
	var divSapID = "divSap_"+sapKey+"_"+sectionKey;
	var divSapControlID = "divSapControl_"+sapKey+"_"+sectionKey;
	var divSapControl = $("#"+divSapControlID); 
	var divSap = $("#"+divSapID);
	
	if(divSap.is(":visible")){	//hide			
		divSapControl.removeClass("opened");
		divSap.slideUp();
	}
	else {	//show
		divSapControl.addClass("opened");
		divSap.slideDown();
	}
}

//-----------------------------------------------------
//accordion control click. open or close accordion
function sapControlClick(){
	var controlID = this.id;
	var arr = controlID.split("_");
	if(arr.length !=3 ){
		alert("wrong control clicked!!!");
		return(false);
	}
	var sapKey = arr[1];
	var sectionKey = arr[2];
	toggleSapControl(sapKey,sectionKey);
}

//-----------------------------------------------------
//settings init function.
$(document).ready(function(){
	//check hash
	var section = 1;
	if(location.hash) section = location.hash.substring(1,location.hash.length);
	selectSectionByNum(section);
	
	//add sections click event:
	var counter = 1;
	$('.listSections li').each(function(){
		$(this).bind('click',{num:counter},onSectionClick);
		counter++;
	});
	
	$(".inputColorPicker").focus(onColorPickerFocus);
	
	$(".divAllSettings select.control").bind("change",onSettingsSelectChange);
	
	$(".divSettingsPage").click(onDivSettingsClick);
	
	//handle accordion:
	$(".divSapControl").click(sapControlClick);
	
});

