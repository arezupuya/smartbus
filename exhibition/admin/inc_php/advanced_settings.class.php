<?php

	// advanced settings class. adds some advanced features
	class AdvancedSettings extends Settings{
		
		//------------------------------------------------------------------------------
		//add categories select
		public function addCategoriesSelect($name,$text,$catID=null,$arrParams = array()){
			$response = getCategoriesShort(0,false);
			if($response["success"] == false) throw new Exception($response["message"]);
						
			$arrCats = $response["categories"];			
					
			//get selected category id as selected, or the first item.
			$arrItems = array();
			if(!empty($arrCats)){
				$selectedCatID = $catID;				
				foreach($arrCats as $cat){
					$id = $cat["id"];
					$catTitle = $cat["name"];
					if(isset($arrParams["showids"])){
						$catTitle = $cat["name"] . ' (id='.$cat["id"].')';
					}
					$arrItems[$id] = $catTitle;
				}
				
				if($selectedCatID === null) 
					$selectedCatID = $arrCats[0]["id"];
				else if(!isset($arrItems[$selectedCatID])) 
					$selectedCatID = $arrCats[0]["id"];
			}			
			else{
				$selectedCatID = -1;
				$arrItems[-1] = "Empty gallery";
			}
			
			$this->addSelect($name,$arrItems,$text,$selectedCatID);	
		}
		
		//------------------------------------------------------------------------------
		//add boolean true/false select with custom names
		public function addSelect_boolean($name,$text,$bValue=true,$firstItem="Enabled",$secondItem="Disabled",$arrParams=array()){
			$arrItems = array("true"=>$firstItem,"false"=>$secondItem);
			$defaultText = "true";
			if($bValue == false) $defaultText = "false";
			$this->addSelect($name,$arrItems,$text,$defaultText,$arrParams);
		}

		//------------------------------------------------------------------------------
		//add float select
		public function addSelect_float($name,$defaultValue,$text,$arrParams=array()){
			$this->addSelect($name,array("left"=>"Left","right"=>"Right"),$text,$defaultValue,$arrParams);
		}
		
		//------------------------------------------------------------------------------
		//add align select
		public function addSelect_alignX($name,$defaultValue,$text,$arrParams=array()){
			$this->addSelect($name,array("left"=>"Left","center"=>"Center","right"=>"Right"),$text,$defaultValue,$arrParams);
		}

		//------------------------------------------------------------------------------
		//add align select
		public function addSelect_alignY($name,$defaultValue,$text,$arrParams=array()){
			$this->addSelect($name,array("top"=>"Top","middle"=>"Middle","bottom"=>"Bottom"),$text,$defaultValue,$arrParams);
		}
		
		//------------------------------------------------------------------------------
		//add transitions select
		public function addSelect_border($name,$defaultValue,$text,$arrParams=array()){
			$arrItems = array();
			$arrItems["solid"] = "Solid";
			$arrItems["dashed"] = "Dashed";
			$arrItems["dotted"] = "Dotted";
			$arrItems["double"] = "Double";
			$arrItems["groove"] = "Groove";
			$arrItems["ridge"] = "Ridge";
			$arrItems["inset"] = "Inset";
			$arrItems["outset"] = "Outset";
			$this->addSelect($name,$arrItems,$text,$defaultValue,$arrParams);			
		}
		
		//------------------------------------------------------------------------------
		//add transitions select
		public function addSelect_textDecoration($name,$defaultValue,$text,$arrParams=array()){
			$arrItems = array();
			$arrItems["none"] = "None";
			$arrItems["underline"] = "Underline";
			$arrItems["overline"] = "Overline";
			$arrItems["line-through"] = "Line-through";
			$this->addSelect($name,$arrItems,$text,$defaultValue,$arrParams);			
		}
		
		
		//------------------------------------------------------------------------------
		//add transitions select
		public function addSelect_transitions($name,$defaultValue,$text,$arrParams=array()){
			$arrItems = array();
			$arrItems["linear"] = "Linear";
			$arrItems["easeOutQuint"] = "EaseOut";
			$arrItems["easeInQuint"] = "EaseIn";
			$arrItems["easeInOutQuad"] = "EaseInOut";
			
			$arrItems["easeOutElastic"] = "EaseIn - Elastic";
			$arrItems["easeOutBounce"] = "EaseIn - Bounce";
			$arrItems["easeOutBack"] = "EaseIn - Back";
			$arrItems["easeOutQuart"] = "EaseIn - Quart";
			$arrItems["easeOutExpo"] = "EaseIn - Expo";
			
			$arrItems["easeInElastic"] = "EaseOut - Elastic";
			$arrItems["easeInBounce"] = "EaseOut - Bounce";
			$arrItems["easeInBack"] = "EaseOut - Back";
			$arrItems["easeInQuart"] = "EaseOut - Quart";
			$arrItems["easeInExpo"] = "EaseOut - Expo";
			
			$arrItems["easeInOutElastic"] = "EaseInOut - Elastic";
			$arrItems["easeInOutBounce"] = "EaseInOut - Bounce";
			$arrItems["easeInOutBack"] = "EaseInOut - Back";
			$arrItems["easeInOutQuart"] = "EaseInOut - Quart";
			$arrItems["easeInOutExpo"] = "EaseInOut - Expo";
			
			$this->addSelect($name,$arrItems,$text,$defaultValue,$arrParams);
			
		}
		
	}
	
?>