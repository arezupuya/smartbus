<?php
	class Settings{
		const RELATED_NONE = "";
		const TYPE_TEXT = "text";
		const TYPE_COLOR = "color";
		const TYPE_SELECT = "select";
		const TYPE_CHECKBOX = "checkbox";
		const TYPE_RADIO = "radio";
		const TYPE_TEXTAREA = "textarea";
		const TYPE_STATIC_TEXT = "statictext";
		const TYPE_HR = "hr";
		
		//------------------------------------------------------------
		//set data types  
		const DATATYPE_NUMBER = "number";
		const DATATYPE_STRING = "string";
		const DATATYPE_BOOLEAN = "boolean";
		
		const CONTROL_TYPE_ENABLE = "enable";
		const CONTROL_TYPE_DISABLE = "disable";
		const CONTROL_TYPE_SHOW = "show";
		const CONTROL_TYPE_HIDE = "hide";
		
		//additional parameters that can be added to settings.
		const PARAM_TEXTSTYLE = "textStyle";
		const PARAM_ADDTEXT = "addtext";	//additional text after the field
		const PARAM_CELLSTYLE = "cellStyle";	//additional text after the field
		
		//view defaults:
		private $defaultText = "Enter value";
		private $sap_size = 5;
		private $dbtable = TABLE_SETTINGS;
		
		//other variables:
		private $database = null;
		private $relatedTo = Settings::RELATED_NONE;
		private $relatedID = -1;
		private $HRIdCounter = 0;	//counter of hr id
		
		private $arrSettings = array();
		private $arrSections = array();
		private $arrIndex = array();	//index of name->index of the settings.
		private $arrSaps = array();
		
		//controls:
		private $arrControls = array();		//array of items that controlling others (hide/show or enabled/disabled) 
		private $arrBulkControl = array();	//bulk cotnrol array. if not empty, every settings will be connected with control.
		 
		//custom functions:
		private $customFunction_afterSections = null;
		
		
		//-----------------------------------------------------------------------------------------------
		// constructor
	    public function __construct(&$database){	    	
			$this->database = $database;
			if(empty($this->database)) throw new Exception("No database given!");	    			
	    }
		
		//-----------------------------------------------------------------------------------------------
		//creates settings table
		private function create_table(){			
			$arrCreate = array();
			$arrCreate["id"] = Database::TYPE_KEY;
			$arrCreate["relatedTo"] = Database::TYPE_STRING;
			$arrCreate["relatedID"] = Database::TYPE_STRING;
			$arrCreate["data"] = Database::TYPE_TEXT;
			$response = $this->database->createTable(TABLE_SETTINGS,$arrCreate);
			return($response);
		}
		
		//-----------------------------------------------------------------------------------------------
		// validate the data for basic types before saving
		private function validateDataBeforeSave($types,$data){
			return(array("success"=>true));
		}				
		
		//-----------------------------------------------------------------------------------------------
		// get where query according relatedTo and relatedID. 
		private function getWhereQuery(){
			$where = "relatedTo='".$this->relatedTo."' and relatedID='".$this->relatedID."'";
			return($where);
		}

		//-----------------------------------------------------------------------------------------------
		//set the related to/id for saving/restoring settings.
		public function setRelated($relatedTo,$relatedID){
			$this->relatedTo = $relatedTo;
			$this->relatedID = $relatedID;
		}
		
		//-----------------------------------------------------------------------------------------------
		//modify the data before save
		private function modifySettingsData($arrSettings){
			foreach($arrSettings as $key=>$content){
				//replace the unicode line break (sometimes left after json)
				$content = str_replace("u000a","\n",$content);
				$content = str_replace("u000d","",$content);
				$arrSettings[$key] = $content;
			}
			return($arrSettings);
		}
		
		//-----------------------------------------------------------------------------------------------
		//save settings from post
		public function saveSettings(){
			$jsonData = $_POST["data"];
						
			$arrData = (array)getJsonObj($jsonData);
						
			$types = (array)$arrData["settingsTypes"];
			$data = (array)$arrData["settingsData"];
			$data = $this->modifySettingsData($data);
			
			//validation		
			$response = $this->validateDataBeforeSave($types,$data);
			if($response["success"] == false) outputJson($response);
			
			$serialData = serialize($data);
									
			$this->create_table();
			$arrFields = array();
			$arrFields["data"] = $serialData;
			$arrFields["relatedTo"] = $this->relatedTo;
			$arrFields["relatedID"] = $this->relatedID;
			$where = $this->getWhereQuery();
			$this->database->replace($this->dbtable,$arrFields,$where);
			return(array("success"=>true));
		}
		
		//-----------------------------------------------------------------------------------------------
		//restore settings.
		public function restoreSettings(){
			$where = $this->getWhereQuery();
			if($this->database->isTableExists($this->dbtable) == false)
				return(array("success"=>true));
			$response = $this->database->delete($this->dbtable,$where);
			return($response);
		}
		
		//-----------------------------------------------------------------------------------------------
		// validate items parameter. throw exception on error
		private function validateParamItems($arrParams){
			if(!isset($arrParams["items"])) throw new Exception("no select items presented");
			if(!is_array($arrParams["items"])) throw new Exception("the items parameter should be array");
			if(empty($arrParams["items"])) throw new Exception("the items array should not be empty");			
		}
		
		//-----------------------------------------------------------------------------------------------
		// add the section value to the setting
		private function checkAndAddSectionAndSap($setting){
			//add section
			if(!empty($this->arrSections)){
				$sectionKey = count($this->arrSections)-1;
				$setting["section"] = $sectionKey;
				$section = $this->arrSections[$sectionKey];
				$sapKey = count($section["arrSaps"])-1;
				$setting["sap"] = $sapKey;
			}
			else{
				//please impliment add sap normal!!! - without sections
			}
			return($setting);
		}
		
		//-----------------------------------------------------------------------------------------------
		//add setting, may be in different type, of values
		protected function add($name,$defaultValue = "",$text = "",$type = self::TYPE_TEXT,$arrParams = array()){
			
			//validation:
			if(empty($name)) throw new Exception("Every setting should have a name!");
			
			switch($type){
				case self::TYPE_RADIO:
					$this->validateParamItems($arrParams);
				break;
				case self::TYPE_SELECT:
					$this->validateParamItems($arrParams);
				break;
				case self::TYPE_CHECKBOX:
					if(!is_bool($defaultValue)) throw new Exception("The checkbox value should be boolean");
				break;
			}
			
			//validate name:
			if(isset($this->arrIndex[$name])) throw new Exception("Duplicate setting name:".$name);
			
			$this->checkAddBulkControl($name);
						
			//set defaults:
			if($text == "") $text = $this->defaultText;
			
			$setting = array();
			$setting["name"] = $name;
			$setting["id"] = $name;
			$setting["id_service"] = $setting["id"]."_service";
			$setting["id_row"] = $setting["id"]."_row";
			$setting["type"] = $type;
			$setting["text"] = $text;
			$setting["value"] = $defaultValue;

			//set data type:
			switch($setting["type"]){
				case self::TYPE_COLOR:
					$dataType = self::DATATYPE_STRING;
				break;
				default:
					switch(getType($defaultValue)){
						case "integer":							
						case "double":
							$dataType = self::DATATYPE_NUMBER;
						break;
						case "boolean":
							$dataType = self::DATATYPE_BOOLEAN;
						break;
						case "string":							
						default:
							$dataType = self::DATATYPE_STRING;
						break;
					}
				break;
			} 			
			$setting["datatype"] = $dataType;
			
			$setting = array_merge($setting,$arrParams);
			
			//addsection and sap keys
			$setting = $this->checkAndAddSectionAndSap($setting);
			
			$this->arrSettings[] = $setting;
			
			//add to settings index
			$this->addSettingToIndex($name);
		}

		//-----------------------------------------------------------------------------------------------
		//add this setting to index
		private function addSettingToIndex($name){
			$this->arrIndex[$name] = count($this->arrSettings)-1;
		}
		
		//-----------------------------------------------------------------------------------------------
		//get types array from all the settings:
		private function getArrTypes(){
			$arrTypesAssoc = array();
			$arrTypes = array();
			foreach($this->arrSettings as $setting){	
				$type = $setting["type"];
				if(!isset($arrTypesAssoc[$type])) $arrTypes[] = $type;
				$arrTypesAssoc[$type] = "";				
			}			
			return($arrTypes);
		}
		
		//-----------------------------------------------------------------------------------------------
		//draw text as input
		private function drawTextInput($setting) {
			$disabled = "";
			$style="";
			if(isset($setting["inputStyle"])) $style = "style='".$setting["inputStyle"]."'";
			if(isset($setting["disabled"])) $disabled = " disabled ";
			?>
				<input type="text" <?php echo $style?> <?php echo $disabled?> id="<?php echo $setting["id"]?>" name="<?php echo $setting["name"]?>" value="<?php echo $setting["value"]?>" />
			<?php
		}
		//-----------------------------------------------------------------------------------------------
		//draw a color picker
		private function drawColorPickerInput($setting){			
			$bgcolor = $setting["value"];
			$bgcolor = str_replace("0x","#",$bgcolor);
			// set the forent color (by black and white value)
			$rgb = html2rgb($bgcolor);
			$bw = yiq($rgb[0],$rgb[1],$rgb[2]);
			$color = "#000000";
			if($bw<128) $color = "#ffffff";
			
			
			$disabled = "";
			if(isset($setting["disabled"])){
				$color = "";
				$disabled = " disabled ";
			}
			
			$style="style='background-color:$bgcolor;color:$color'";
			
			?>
				<input type="text" class="inputColorPicker" id="<?php echo $setting["id"]?>" <?php echo $style?> name="<?php echo $setting["name"]?>" value="<?php echo $bgcolor?>" <?php echo $disabled?>></input>
			<?php
		}
		
		//-----------------------------------------------------------------------------------------------
		//draw select input
		private function drawSelectInput($setting){
			$className = "";
			if(isset($this->arrControls[$setting["name"]])) $className = "control";
			$class = "";
			if($className != "") $class = "class='".$className."'";
			
			$disabled = "";
			if(isset($setting["disabled"])) $disabled = " disabled ";
			
			?>
			<select id="<?php echo $setting["id"]?>" name="<?php echo $setting["name"]?>" <?php echo $disabled?> <?php echo $class?>>
			<?php			
			foreach($setting["items"] as $value=>$text):
				$selected = "";
				if($value == $setting["value"]) $selected = "selected=true";
				?>
					<option value="<?php echo $value?>" <?php echo $selected?>><?php echo $text?></option>
				<?php
			endforeach
			?>
			</select>
			<?php
		}
		
		//-----------------------------------------------------------------------------------------------
		// draw checkbox
		private function drawCheckboxInput($setting){
			$checked = "";
			if($setting["value"] == true) $checked = "checked";
			?>
				<input type="checkbox" id="<?php echo $setting["id"]?>" class="inputCheckbox" name="<?php echo $setting["name"]?>" <?php echo $checked?>/>
			<?php
		}
		
		//-----------------------------------------------------------------------------------------------
		// draw radio input
		private function drawRadioInput($setting){
			$items = $setting["items"];
			$counter = 0;
			foreach($items as $value=>$text):
				$counter++;
				$radioID = $setting["id"]."_".$counter;
				$checked = "";
				if($value == $setting["value"]) $checked = " checked"; 
				?>
					<input type="radio" id="<?php echo $radioID?>" value="<?php echo $setting["value"]?>" name="<?php echo $setting["name"]?>" <?php echo $checked?>/>
					<label for="<?php echo $radioID?>" style="cursor:pointer;"><?php echo $text?></label> 
					<br>
				<?php				
			endforeach;
		}
		
		//-----------------------------------------------------------------------------------------------
		// draw text area input
		private function drawTextAreaInput($setting){
			$disabled = "";
			if(isset($setting["disabled"])) $disabled = " disabled ";
			$width = getArrValue($setting,"width","250px");
			$height = getArrValue($setting,"height","");
			$styleContent="";
			if($width != "") $styleContent .= 'width:'.$width.";";
			if($height != "") $styleContent .= 'height:'.$height.";";
			$style = "";
			if(!empty($styleContent)) $style = "style='$styleContent'";			 
			?>
				<textarea id="<?php echo $setting["id"]?>" name="<?php echo $setting["name"]?>" <?php echo $style?> <?php echo $disabled?>><?php echo $setting["value"]?></textarea>				
			<?php
		}
				
		//-----------------------------------------------------------------------------------------------
		// draw setting input by type
		private function drawInputs($setting){
			switch($setting["type"]){
				case self::TYPE_TEXT:
					$this->drawTextInput($setting);
				break;
				case self::TYPE_COLOR:
					$this->drawColorPickerInput($setting);
				break;
				case self::TYPE_SELECT:
					$this->drawSelectInput($setting);
				break;
				case self::TYPE_CHECKBOX:
					$this->drawCheckboxInput($setting);
				break;
				case self::TYPE_RADIO:
					$this->drawRadioInput($setting);
				break;
				case self::TYPE_TEXTAREA:
					$this->drawTextAreaInput($setting);
				break;
				default:
					throw new Exception("wrong setting type - ".$setting["type"]);
				break;
			}
			
		}

		//-----------------------------------------------------------------------------------------------
		// get json client object for javascript
		private function getJsonClientString(){
			$arrSettingTypes = array();
			foreach($this->arrSettings as $setting){
				if(isset($setting["name"]))
					$arrSettingTypes[$setting["name"]] = $setting["datatype"]; 
			}
			$strJson = json_encode($arrSettingTypes);
			return($strJson);
		}		
		
		//-----------------------------------------------------------------------------------------------
		//get number of settings
		public function getNumSettings(){
			$counter = 0;
			foreach($this->arrSettings as $setting){
				switch($setting["type"]){
					case self::TYPE_HR:
					case self::TYPE_STATIC_TEXT:
					break;
					default:
						$counter++;
					break;
				}
			}
			return($counter);
		}
		
		//private function 
		//-----------------------------------------------------------------------------------------------
		// add radio group
		public function addRadio($name,$arrItems,$text = "",$defaultItem="",$arrParams = array()){
			$params = array("items"=>$arrItems);
			$params = array_merge($params,$arrParams);
			$this->add($name,$defaultItem,$text,self::TYPE_RADIO,$params);
		}
		
		//-----------------------------------------------------------------------------------------------
		//add text area control
		public function addTextArea($name,$defaultValue,$text,$arrParams = array()){
			$this->add($name,$defaultValue,$text,self::TYPE_TEXTAREA,$arrParams);
		}
		
		//-----------------------------------------------------------------------------------------------
		// add checkbox element
		public function addCheckbox($name,$defaultValue = false,$text = "",$arrParams = array()){
			$this->add($name,$defaultValue,$text,self::TYPE_CHECKBOX,$arrParams);
		}
		
		//-----------------------------------------------------------------------------------------------
		//add text box element
		public function addTextBox($name,$defaultValue = "",$text = "",$arrParams = array()){
			$this->add($name,$defaultValue,$text,self::TYPE_TEXT,$arrParams);
		}
		
		//-----------------------------------------------------------------------------------------------
		//add color picker setting
		public function addColorPicker($name,$defaultValue = "",$text = "",$arrParams = array()){
			$this->add($name,$defaultValue,$text,self::TYPE_COLOR,$arrParams);
		}
		
		//-----------------------------------------------------------------------------------------------
		//check that bulk control is available , and add some element to it. 
		private function checkAddBulkControl($name){
			//add control
			if(!empty($this->arrBulkControl)) 
				$this->addControl($this->arrBulkControl["control_name"],$name,$this->arrBulkControl["type"],$this->arrBulkControl["value"]);			
		}
		
		//-----------------------------------------------------------------------------------------------
		//add horezontal sap
		public function addHr($name="",$params=array()){
			$setting = array();
			$setting["type"] = self::TYPE_HR;
			
			//set item name
			$itemName = "";
			if($name != "") $itemName = $name;
			else{	//generate hr id
			  $this->HRIdCounter++;
			  $itemName = "hr".$this->HRIdCounter;
			}
			
			$setting["id"] = $itemName;
			$setting["id_row"] = $setting["id"]."_row";
			
			$this->checkAddBulkControl($itemName);
			
			$params = array_merge($params,$setting);
			$this->arrSettings[] = $setting;
			
			//add to settings index
			$this->addSettingToIndex($itemName);
		}
		
		//-----------------------------------------------------------------------------------------------
		//add static text
		public function addStaticText($text,$name="",$params=array()){
			$setting = array();
			$setting["type"] = self::TYPE_STATIC_TEXT;
			
			//set item name
			$itemName = "";
			if($name != "") $itemName = $name;
			else{	//generate hr id
			  $this->HRIdCounter++;
			  $itemName = "textitem".$this->HRIdCounter;
			}
			
			$setting["id"] = $itemName;
			$setting["id_row"] = $setting["id"]."_row";
			$setting["text"] = $text;
			
			$this->checkAddBulkControl($itemName);
			
			$params = array_merge($params,$setting);
			
			//addsection and sap keys
			$setting = $this->checkAndAddSectionAndSap($setting);
			
			$this->arrSettings[] = $setting;
			
			//add to settings index
			$this->addSettingToIndex($itemName);
		}
		
		//-----------------------------------------------------------------------------------------------
		// add select setting
		public function addSelect($name,$arrItems,$text,$defaultItem="",$arrParams=array()){
			$params = array("items"=>$arrItems);
			$params = array_merge($params,$arrParams);
			$this->add($name,$defaultItem,$text,self::TYPE_SELECT,$params);
		}
		
		//-----------------------------------------------------------------------------------------------
		//add saporater
		public function addSap($text = "",$opened = false){
			$sap = array();
			$sap["text"] = $text; 
			if($opened == true) $sap["opened"] = true;
			
			//add sap to current section
			if(!empty($this->arrSections)){
				$lastSection = end($this->arrSections);
				$lastSectionKey = end(array_keys($this->arrSections));
				$arrSaps = $lastSection["arrSaps"];
				$arrSaps[] = $sap;
				$this->arrSections[$lastSectionKey]["arrSaps"] = $arrSaps; 				
				$sapKey = end(array_keys($arrSaps));
			}
			else{
				$this->arrSaps[] = $sap;
				dmp("implement saps without sections");
				exit();
			}
		}
		
		//-----------------------------------------------------------------------------------------------
		//get sap data:
		public function getSap($sapKey,$sectionKey=-1){
			//get sap without sections:
			if($sectionKey == -1) return($this->arrSaps[$sapKey]);
			if(!isset($this->arrSections[$sectionKey])) throw new Exception("Sap on section:".$sectionKey." doesn't exists");
			$arrSaps = $this->arrSections[$sectionKey]["arrSaps"];
			if(!isset($arrSaps[$sapKey])) throw new Exception("Sap with key:".$sapKey." doesn't exists");
			$sap = $arrSaps[$sapKey];
			return($sap);
		}
		
		//-----------------------------------------------------------------------------------------------
		// add a new section. Every settings from now on will be related to this section
		public function addSection($text){
			if(!empty($this->arrSettings) && empty($this->arrSections)) throw new Exception("You should add first section before begin to add settings.");
			if(empty($text)) throw new Exception("Every section should have a text");
			$arrSection = array("text"=>$text,"arrSaps"=>array());
			$this->arrSections[] = $arrSection;
		}
		
		//-----------------------------------------------------------------------------------------------
		//add a item that controlling visibility of enabled/disabled of other.
		public function addControl($control_item_name,$controlled_item_name,$control_type,$value){
			$arrControl = array();
			if(isset($this->arrControls[$control_item_name])) $arrControl = $this->arrControls[$control_item_name];
			$arrControl[] = array("name"=>$controlled_item_name,"type"=>$control_type,"value"=>$value);
			$this->arrControls[$control_item_name] = $arrControl;
		}
		
		//-----------------------------------------------------------------------------------------------
		//start control of all settings that comes after this function (between startBulkControl and endBulkControl)
		public function startBulkControl($control_item_name,$control_type,$value){
			$this->arrBulkControl = array("control_name"=>$control_item_name,"type"=>$control_type,"value"=>$value);
		}	
			
		//-----------------------------------------------------------------------------------------------
		//end bulk control
		public function endBulkControl(){
			$this->arrBulkControl = array();
		}
		
		//-----------------------------------------------------------------------------------------------
		//build name->(array index) of the settings. 
		private function buildArrSettingsIndex(){
			$this->arrIndex = array();
			foreach($this->arrSettings as $key=>$value)
				if(isset($value["name"])) $this->arrIndex[$value["name"]] = $key;
		}
		
		//-----------------------------------------------------------------------------------------------
		// set sattes of the settings (enabled/disabled, visible/invisible) by controls
		private function setSettingsStateByControls(){
			
			foreach($this->arrControls as $control_name => $arrControlled){
				//take the control value
				if(!isset($this->arrIndex[$control_name])) throw new Exception("There is not sutch control setting: '$control_name'");
				$index = $this->arrIndex[$control_name];
				$parentValue = strtolower($this->arrSettings[$index]["value"]);
				
				//set child (controlled) attributes
				foreach($arrControlled as $controlled){
					if(!isset($this->arrIndex[$controlled["name"]])) throw new Exception("There is not sutch controlled setting: '".$controlled["name"]."'");
					$indexChild = $this->arrIndex[$controlled["name"]];
					$child = $this->arrSettings[$indexChild];					
					$value = strtolower($controlled["value"]);
					switch($controlled["type"]){
						case self::CONTROL_TYPE_ENABLE:
							if($value != $parentValue) $child["disabled"] = true;
						break;
						case self::CONTROL_TYPE_DISABLE:
							if($value == $parentValue) $child["disabled"] = true;
						break;
						case self::CONTROL_TYPE_SHOW:
							if($value != $parentValue) $child["hidden"] = true;
						break;
						case self::CONTROL_TYPE_HIDE:
							if($value == $parentValue) $child["hidden"] = true;
						break;
					}
					$this->arrSettings[$indexChild] = $child;					
				}								
			}//end foreach
		}
		
		//-----------------------------------------------------------------------------------------------
		//draw all settings
		private function drawSettings(){
			//draw main div
			?><div class="divAllSettings">
			  <form name="frmSettings" id="frmSettings">
			<?php
						
			$lastSectionKey = -1;
			$visibleSectionKey = 0;
			$arrSaps = $this->arrSaps;
			$lastSapKey = -1;
						
			foreach($this->arrSettings as $key=>$setting):								
			
				//operate sections:
				if(!empty($this->arrSections) && isset($setting["section"])){										
					$sectionKey = $setting["section"];
					
					if($sectionKey != $lastSectionKey):	//new section					
						$arrSaps = $this->arrSections[$sectionKey];
						
						//close sap
						if($lastSapKey != -1):
						?>
							</table>
							</div>
						<?php						
						endif;
						
						$lastSapKey = -1;										
				 		$style = ($visibleSectionKey == $sectionKey)?"":"style='display:none'";
				 		
				 		//close section
				 		if($sectionKey != 0): 
				 		?>
				 		</div>
				 		<?php endif;
				 		
					?>	<div class="divSections" id="divSection_<?php echo $sectionKey?>" <?php echo $style ?>> <?php																												
					endif;
					$lastSectionKey = $sectionKey;
				}
				
				
				if(isset($setting["sap"])):
					//operate saps
					$sapKey = $setting["sap"];
					if($sapKey != $lastSapKey){
						$sap = $this->getSap($sapKey,$sectionKey);
						
						//draw sap end					
						if($sapKey != 0): ?>
						</table>
						</div>
						<?php endif;
						
						//set opened/closed states:
						$style = "style='display:none;'";
						$class = "divSapControl";
						
						if($sapKey == 0 || isset($sap["opened"]) && $sap["opened"] == true){
							$style = "";
							$class = "divSapControl opened";						
						}
						
						?>
							<div id="divSapControl_<?php echo $sectionKey."_".$sapKey?>" class="<?php echo $class?>">
								<div class="divSapControlIcon pngfix"></div>
								<div class="divSapControlText"><?php echo $sap["text"]?></div>
							</div>
							<div id="divSap_<?php echo $sectionKey."_".$sapKey?>" class="divSap" <?php echo $style ?>>				
							<table class="tableSettings">
						<?php 
						$lastSapKey = $sapKey;
					}
				endif;	//saps manage
				
				//draw row:
				switch($setting["type"]){
					case self::TYPE_HR:
						$this->drawHrRow($setting);
					break;
					case self::TYPE_STATIC_TEXT:
						$this->drawTextRow($setting);
					break;
					default:
						$this->drawSettingRow($setting);
					break;
				}
				
			endforeach ?>
			</table>
			
			<?php
			if(!empty($this->arrSections)):
				echo "</div>\n";
			endif;	
			?>
				</form>
				</div>
			<?php		
		}
		

		//-----------------------------------------------------------------------------------------------
		//draw hr row
		private function drawTextRow($setting){
			//set style
			$padding = "";
			if(isset($setting["padding"])) $padding = "padding-left:".$setting["padding"].";";
			
			$hidden = "";
			if(isset($setting["hidden"])) $hidden = "display:none;";
			$rowStyle = "style='$hidden'";
			
			$cellStyle="style='$padding'";
			
			?>
				<tr id="<?php echo $setting["id_row"]?>" <?php echo $rowStyle ?>>
					<td colspan="4" align="right" <?php echo $cellStyle?>>
						<span class="spanSettingsStaticText"><?php echo $setting["text"]?></span><span>
					</td>
				</tr>
			<?php 
		}
		
		//-----------------------------------------------------------------------------------------------
		//draw hr row
		private function drawHrRow($setting){
			//set hidden
			$rowStyle = "";
			if(isset($setting["hidden"])) $rowStyle = "style='display:none;'";
			?>
			<tr id="<?php echo $setting["id_row"]?>" <?php echo $rowStyle ?>>
				<td colspan="4" style="border-top:1px dashed black;"></td>
			</tr>
			<?php 
		}
		
		//-----------------------------------------------------------------------------------------------
		//draw settings row
		private function drawSettingRow($setting){
		
			//set cellstyle:
			$cellStyle = "";
			if(isset($setting[self::PARAM_CELLSTYLE])){
				$cellStyle .= $setting[self::PARAM_CELLSTYLE];
			}
			
			//set text style:
			$textStyle = $cellStyle;
			if(isset($setting[self::PARAM_TEXTSTYLE])){
				$textStyle .= $setting[self::PARAM_TEXTSTYLE];
			}
			
			if($textStyle != "") $textStyle = "style='".$textStyle."'";
			if($cellStyle != "") $cellStyle = "style='".$cellStyle."'";
			
			//set hidden
			$rowStyle = "";
			if(isset($setting["hidden"])) $rowStyle = "display:none;";
			if(!empty($rowStyle)) $rowStyle = "style='$rowStyle'";
			
			//set text class:
			$class = "";
			if(isset($setting["disabled"])) $class = "class='disabled'";
			
			//modify text:
			$text = getArrValue($setting,"text","");				
			// prevent line break (convert spaces to nbsp)
			$text = str_replace(" ","&nbsp;",$text);
			switch($setting["type"]){					
				case self::TYPE_CHECKBOX:
					$text = "<label for='".$setting["id"]."' style='cursor:pointer;'>$text</label>";
				break;
			}			
			
			//set settings text width:
			$textWidth = "";
			if(isset($setting["textWidth"])) $textWidth = 'width="'.$setting["textWidth"].'"';
			
			?>
				<tr id="<?php echo $setting["id_row"]?>" <?php echo $rowStyle ?> <?php echo $class?>>
					<td <?php echo $textStyle?> class="cellText" <?php echo $textWidth ?>>
						<?php echo $text?>:
					</td>
					<td <?php echo $cellStyle?> width="<?php echo $this->sap_size?>"></td>
					<td <?php echo $cellStyle?>>
						<?php 
							$this->drawInputs($setting);
							//check additional settings:
							if(isset($setting[self::PARAM_ADDTEXT])):?>
								<span class="spanSettingsAddtext"><?php echo $setting[self::PARAM_ADDTEXT]?></span>
							<?php
							endif
						?>												
					</td>
					<td width="<?php echo $this->sap_size?>"></td>
					<td <?php echo $cellStyle?>>
						<div id="<?php echo $setting["id_service"] ?>"></div>
					</td>
				</tr>								
			<?php 
		}
		
		//-----------------------------------------------------------------------------------------------
		// draw sections menu
		private function drawSections($activeSection=0){			
			echo "<ul class='listSections' >";
			for($i=0;$i<count($this->arrSections);$i++):
				$class = "";
				if($activeSection == $i) $class="class='selected'";
				$text = $this->arrSections[$i]["text"];
				echo '<li '.$class.'><a onfocus="this.blur()" href="#'.($i+1).'"><div>'.$text.'</div></a></li>';
			endfor;
			echo "</ul>";
			
			//call custom draw function:
			if($this->customFunction_afterSections) call_user_func($this->customFunction_afterSections);
						
		}				
		
		//-----------------------------------------------------------------------------------------------
		//get saved settings from database and replace values
		private function replaceSavedSettingsValues(){
			//validate table
			
			if($this->database->isTableExists($this->dbtable) == false) return(false);
						
			//get data 
			$errorText = "Something wrong with saved settings.";
			$where = $this->getWhereQuery();
			$response = $this->database->fetch($this->dbtable,$where);
			
			if($response["success"] == false) throw new Exception($errorText);
			$rows = $response["rows"];
									
			if(count($rows) == 0) return(false);
			if(count($rows)>1) throw new Exception($errorText);
			$dataSerial = $rows[0]["data"];
			$data = unserialize($dataSerial);
			
			//replace settings
			foreach($this->arrSettings as $key=>$setting){
				if(!isset($setting["name"])) continue;
				$name = $setting["name"];
				if(isset($data[$name])) $this->arrSettings[$key]["value"] = $data[$name];
			}
		}
		
		//-----------------------------------------------------------------------------------------------
		//set custom function that will be run after sections will be drawen
		public function setCustomDrawFunction_afterSections($func){
			$this->customFunction_afterSections = $func;
		}
		
		//-----------------------------------------------------------------------------------------------
		// draw settings for input
		public function draw(){
			$this->replaceSavedSettingsValues();
			$this->setSettingsStateByControls();
			
			?>
			<div class="divSettingsPage">
			<?php 
			if(!empty($this->arrSections)):
			?>
				<table cellpadding="0" cellspacing="0" width="100%">
					<tr>
						<td valign="top" class="cellSections">
							<?php $this->drawSections(); ?>
						</td>
						<td valign="top">
							<?php $this->drawSettings(); ?>
						</td>						
					</tr>
				</table>
			<?php
			else:
				$this->drawSettings();
			endif;
			?>
			</div>
			<?php
		}
		
		//-----------------------------------------------------------------------------------------------
		// put header includes:
		public function drawHeaderIncludes(){
			$arrOnReady = array();
			$arrJs = array();
			
			//put json string types
			$jsonString = $this->getJsonClientString();
			$arrJs[] = "var g_jsonSettingTypes = '$jsonString'";
			$arrJs[] = "var objSettingTypes = JSON.parse(g_jsonSettingTypes);";
			
			//put sections vars
			if(!empty($this->arrSections)){
				$arrJs[] = "var g_sectionsEnabled = true;";
				$arrJs[] = "var g_numSections = ".count($this->arrSections).";";
			}
			else 
				$arrJs[] = "var g_sectionsEnabled = false;";
			
			//put controls json object:
			if(!empty($this->arrControls)){
				$strControls = json_encode($this->arrControls);
				$arrJs[] = "var g_jsonControls = '".$strControls."'";
				$arrJs[] = "var g_controls = JSON.parse(g_jsonControls)";
			}
						
			//put types onready function
			$arrTypes = $this->getArrTypes();
			//put script includes:
			foreach($arrTypes as $type){
				switch($type){
					case self::TYPE_COLOR:
						?>
							<script type="text/javascript" src="inc_js/farbtastic.js"></script>
							<link rel="stylesheet" href="inc_css/farbtastic.css" type="text/css" />
						<?php
						$arrJs[] = "var g_picker;";						
						$arrOnReady[] = "g_picker = $.farbtastic('#divColorPicker');";
					break;
				}
			}
						
			//put js vars and onready func.
			
			echo "<script language='javascript'>\n";
				
			//put js 
			foreach($arrJs as $line){
				echo $line."\n";
			}
				
			if(!empty($arrOnReady)):
				//put onready
				echo "$(document).ready(function(){\n";
				foreach($arrOnReady as $line){
					echo $line."\n";
				}				
				echo "});";
			endif;
			echo "\n</script>\n";
		}
		
		//-----------------------------------------------------------------------------------------------
		// put header includes:
		public function drawAfterBody(){
			$arrTypes = $this->getArrTypes();
			foreach($arrTypes as $type){
				switch($type){
					case self::TYPE_COLOR:
						?>
							<div id='divPickerWrapper' style='position:absolute;display:none;'><div id='divColorPicker'></div></div>
						<?php
					break;
				}
			}
		}
		
		//-----------------------------------------------------------------------------------------------
		// get settings array
		public function getArrSavedSettings(){
			$this->replaceSavedSettingsValues();
			$arrSettingsOutput = array();
			
			foreach($this->arrSettings as $setting){
				if($setting["type"] == self::TYPE_HR 
				  ||$setting["type"] == self::TYPE_STATIC_TEXT)
					continue;
					
				$value = $setting["value"];
				
				//modify value by type
				switch($setting["type"]){
					case self::TYPE_COLOR:
							$value = strtolower($value);
							//$value = str_replace("#","0x",$value);
					break;
					case self::TYPE_CHECKBOX:
						if($value == true) $value = "true";
						else $value = "false";
					break;
				}
				
				//remove lf
				if(isset($setting["remove_lf"])){
					$value = str_replace("\n","",$value);
					$value = str_replace("\r\n","",$value);
				}
								
				$arrSettingsOutput[$setting["name"]] = $value;
			}
			
			return($arrSettingsOutput);
		}
	}
	
?>