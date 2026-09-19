<?php
	$g_activePresetID = getActivePreset();
	
	function setAllSettings(){
		global $g_settings,$g_activePresetID;
		global $database;
		
		$g_settings = new AdvancedSettings($database);
		
		//set the settings related to active preset
		if(!empty($g_activePresetID))
			$g_settings->setRelated("preset",$g_activePresetID);
				
		$g_settings->addSection("General settings");
		$g_settings->addSap("General");
		$g_settings->addCategoriesSelect("category","Default category");
		$g_settings->addSelect_boolean("navigation_deeplink","JS navigation deep linking",true);
		$g_settings->addSelect_boolean("enable_caching","Enable javascript data caching",true);
		$g_settings->addSap("Links Handle",true);
		$g_settings->addSelect_boolean("enable_links","Enable links handling",false,"Enable","Disable",array("textStyle"=>"font-weight:bold"));
		$g_settings->addControl("enable_links","links_target_self",Settings::CONTROL_TYPE_ENABLE,"true");
		$g_settings->addSelect_boolean("links_target_self","Links target",true,"Current window (self)","New window (blank)");
		$g_settings->addStaticText("Enable links means that item click will follow the link instead of the lightbox when the item link exists");
		$g_settings->addSap("Empty category",false);
		$g_settings->addSelect_boolean("empty_category_display_text","Display text on emtpy category",true,"Display","Don't display",array("textStyle"=>"font-weight:bold"));
		$g_settings->startBulkControl("empty_category_display_text",Settings::CONTROL_TYPE_ENABLE,"true");			
			$g_settings->addTextBox("empty_category_text","Emtpy category","Empty category text");
			$g_settings->addHr();
			$g_settings->addSelect_boolean("empty_category_use_custom_class","Use custom CSS class",false,"Use custom class","Use default class",array("textStyle"=>"font-weight:bold"));
			$g_settings->addTextBox("empty_category_class","my_empty_category","Emtpy category custom class");			
				$g_settings->addControl("empty_category_use_custom_class","empty_category_class",Settings::CONTROL_TYPE_SHOW,"true");
			$g_settings->addTextBox("empty_category_font_family","Times New Roman","Empty category text font family");
				$g_settings->addControl("empty_category_use_custom_class","empty_category_font_family",Settings::CONTROL_TYPE_SHOW,"false");
			$g_settings->addTextBox("empty_category_size","14","Empty category text size");
				$g_settings->addControl("empty_category_use_custom_class","empty_category_size",Settings::CONTROL_TYPE_SHOW,"false");
			$g_settings->addColorPicker("empty_category_color","#000000","Empty category text color");
				$g_settings->addControl("empty_category_use_custom_class","empty_category_color",Settings::CONTROL_TYPE_SHOW,"false");
			$g_settings->addCheckbox("empty_category_bold",false,"Empty category text bold");
				$g_settings->addControl("empty_category_use_custom_class","empty_category_bold",Settings::CONTROL_TYPE_SHOW,"false");
		$g_settings->endBulkControl();
		
		//------ Thumbs panel settings
		$g_settings->addSection("Thumb panel settings");
		$g_settings->addSap("Thumb panel settings");
			$g_settings->addSelect_boolean("thumbs_columns_enable","Set number of columns",false,"Set","Don't set (dynamic)");
			$g_settings->addTextBox("thumbs_num_cols",6,"Number of columns in row");
			$g_settings->addControl("thumbs_columns_enable","thumbs_num_cols",Settings::CONTROL_TYPE_ENABLE,"true");
			$g_settings->addSelect_float("thumbs_float","left","Thumbs align to");
			$g_settings->addTextBox("thumbs_margin_x",8,"Space between thumbs - horizontal");
			$g_settings->addTextBox("thumbs_margin_y",8,"Space between thumbs - vertical");
		
		//------ Thumbs panel settings
		$g_settings->addSection("Thumbs settings");
		
		$g_settings->addSap("Thumbs Size and Padding");
		//hor. width and padding
		$g_settings->addSelect_boolean("thumb_exact_width","Thumb width type",true,"Exact","Dynamic");
			$g_settings->addTextBox("thumb_width","130","Thumb width");
		$g_settings->addControl("thumb_exact_width","thumb_width",Settings::CONTROL_TYPE_ENABLE,"true");
		
		$g_settings->startBulkControl("thumb_exact_width",Settings::CONTROL_TYPE_DISABLE,"true");		
			$g_settings->addTextBox("thumb_padding_left","8","Thumb padding left");
			$g_settings->addTextBox("thumb_padding_right","8","Thumb padding right");
		$g_settings->endBulkControl();		
		$g_settings->addTextBox("thumb_padding_top","10","Thumb padding top");
		$g_settings->addTextBox("thumb_padding_bottom","10","Thumb padding bottom");
		$g_settings->addHr();
		$g_settings->addTextBox("thumb_image_width","80","Thumb image width");
		$g_settings->addTextBox("thumb_image_height","80","Thumb image height");
		
		$g_settings->addSap("Thumbs Border and Background");
		$g_settings->addSelect_boolean("thumb_border","Thumb border",true);		
		$g_settings->startBulkControl("thumb_border",Settings::CONTROL_TYPE_ENABLE,"true");
			$g_settings->addColorPicker("thumb_border_color","#ffffff","Thumb border color");
			$g_settings->addColorPicker("thumb_border_color_over","#ebebeb","Thumb border color - mouseover");
			$g_settings->addTextBox("thumb_border_size","1","Thumb border size");
			$g_settings->addSelect_border("thumb_border_style","solid","Thumb border style");
		$g_settings->endBulkControl();		
		
		$g_settings->addHr();
		
		$g_settings->addSelect_boolean("thumb_image_border","Thumb image border",true);		
		$g_settings->startBulkControl("thumb_image_border",Settings::CONTROL_TYPE_ENABLE,"true");
			$g_settings->addColorPicker("thumb_image_border_color","#757575","Thumb image border color");
			$g_settings->addColorPicker("thumb_image_border_color_over","#757575","Thumb image border color - mouseover");
			$g_settings->addTextBox("thumb_image_border_size","1","Thumb image border size");
			$g_settings->addSelect_border("thumb_image_border_style","solid","Thumb image border style");
		$g_settings->endBulkControl();		
		
		$g_settings->addHr();
		
		$g_settings->addColorPicker("thumb_background_color","#ffffff","Background color");
		$g_settings->addColorPicker("thumb_background_color_over","#f2f2f2","Background color - mouseover");
		
		//Thumb text
		$g_settings->addSap("Thumbs Title Text");
		
		$g_settings->addSelect_boolean("thumb_text","Enable thumb text",true);		
		$g_settings->startBulkControl("thumb_text",Settings::CONTROL_TYPE_SHOW,"true");
			$g_settings->addTextBox("thumb_text_fontfamily","sans-serif","Thumb text font family");
			$g_settings->addTextBox("thumb_text_size","14","Thumb text size");
			$g_settings->addCheckbox("thumb_text_bold",false,"Thumb text bold");
			$g_settings->addColorPicker("thumb_text_color","#666666","Text color");
			$g_settings->addColorPicker("thumb_text_color_over","#000000","Text color - mouseover");
			$g_settings->addSelect("thumb_text_vert_pos",array("top"=>"Top","bottom"=>"Bottom"),"Text vertical position","bottom");
			$g_settings->addTextBox("thumb_text_image_space","3","Space between text and image");
			$g_settings->addSelect_textDecoration("thumb_text_decoration","none","Thumb text decoration");
			$g_settings->addSelect_textDecoration("thumb_text_decoration_over","none","Thumb text decoration - mouseover");
			$g_settings->addSelect_alignX("thumb_text_align","center","Thumb text align");
			$g_settings->addTextBox("thumb_text_padding_left","3","Thumb text padding left");			
			$g_settings->addTextBox("thumb_text_padding_right","3","Thumb text padding right");
				$g_settings->addControl("thumb_text_align","thumb_text_padding_left",Settings::CONTROL_TYPE_DISABLE,"center");
				$g_settings->addControl("thumb_text_align","thumb_text_padding_right",Settings::CONTROL_TYPE_DISABLE,"center");
		$g_settings->endBulkControl();
		
		//--- View settings
		$g_settings->addSection("Lightbox");
		$g_settings->addSap("Lightbox settings");
		$g_settings->addSelect_boolean("view_image_resize","View image resize",true,"Resize image","Leave original size");
		$g_settings->startBulkControl("view_image_resize",Settings::CONTROL_TYPE_ENABLE,"true");
			$g_settings->addTextBox("view_image_width","800","View image max width");
			$g_settings->addTextBox("view_image_height","600","View image max height");			
		$g_settings->endBulkControl();
		$g_settings->addHr();
		$g_settings->addTextBox("view_overlay_opacity","0.8","Background overlay opacity");		
		$g_settings->addColorPicker("view_overlay_color","#000000","Background overlay color");
		$g_settings->addHr();
		$g_settings->addCheckbox("view_fixed_navigation",false,"Fixed navigation buttons");
		$g_settings->addColorPicker("view_frame_color","#ffffff","Frame color");
		$g_settings->addTextBox("view_resize_speed","400","Frame resize speed");
		
		
		$g_settings->addSap("Lightbox Keys");
		$g_settings->addTextBox("view_key_close","c","Key - Close");
		$g_settings->addTextBox("view_key_prev","p","Key - Prev");
		$g_settings->addTextBox("view_key_next","n","Key - Next");
		
		$g_settings->addSap("Lightbox Images");
		$g_settings->addSelect_boolean("view_use_images_default_url","Use custom images url's",true,"Use default","Use custom");
		$g_settings->startBulkControl("view_use_images_default_url",Settings::CONTROL_TYPE_ENABLE,"false");
		$g_settings->addTextBox("view_image_loading","images/lightbox-ico-loading.gif","Image - Loading");
		$g_settings->addTextBox("view_image_prev","images/lightbox-btn-prev.gif","Image - Prev");
		$g_settings->addTextBox("view_image_next","images/lightbox-btn-next.gif","Image - Next");
		$g_settings->addTextBox("view_image_close","images/lightbox-btn-close.gif","Image - Close");
		$g_settings->addTextBox("view_image_blank","images/lightbox-blank.gif","Image - Blank");
		$g_settings->endBulkControl();
		
		$g_settings->addSection("Lightbox text");
		$g_settings->addSap("General text settings");
		$g_settings->addTextBox("view_text_font_family","times new roman","Text font family");
		$g_settings->addTextBox("view_text_padding_left","10","Text space from left");
		$g_settings->addTextBox("view_text_padding_bottom","10","Bottom space");
		
		$g_settings->addSap("Caption and description",true);
		
		$g_settings->addSelect("view_text_fields",array("caption"=>"Caption only","desc"=>"Description only","both"=>"Caption and description"),"Text fields present","both",array("textStyle"=>"font-weight:bold"));
		$g_settings->addColorPicker("view_text_caption_color","#666666","Caption color");
			$g_settings->addControl("view_text_fields","view_text_caption_color",Settings::CONTROL_TYPE_DISABLE,"desc");
		$g_settings->addTextBox("view_text_caption_size",14,"Caption text size");
			$g_settings->addControl("view_text_fields","view_text_caption_size",Settings::CONTROL_TYPE_DISABLE,"desc");
		$g_settings->addCheckbox("view_text_caption_bold",true,"Caption bold");
			$g_settings->addControl("view_text_fields","view_text_caption_bold",Settings::CONTROL_TYPE_DISABLE,"desc");
			
		$g_settings->addColorPicker("view_text_desc_color","#666666","Description color");
			$g_settings->addControl("view_text_fields","view_text_desc_color",Settings::CONTROL_TYPE_DISABLE,"caption");
		$g_settings->addTextBox("view_text_desc_size",12,"Description text size");
			$g_settings->addControl("view_text_fields","view_text_desc_size",Settings::CONTROL_TYPE_DISABLE,"caption");
		$g_settings->addCheckbox("view_text_desc_bold",false,"Description bold");
			$g_settings->addControl("view_text_fields","view_text_desc_bold",Settings::CONTROL_TYPE_DISABLE,"caption");
		$g_settings->addTextBox("view_text_space_between",3,"Space between caption and description");
		$g_settings->endBulkControl();
		
		$g_settings->addSap("Text of image numbers");
		$g_settings->addSelect_boolean("view_show_text_numbers","Show image number text",true,"Show","Don't show",array("textStyle"=>"font-weight:bold"));
		$g_settings->startBulkControl("view_show_text_numbers",Settings::CONTROL_TYPE_SHOW,"true");
			$g_settings->addColorPicker("view_text_numbers_color","#666666","Numbers text color");
			$g_settings->addTextBox("view_text_numbers_size",12,"Numbers text size");
			$g_settings->addCheckbox("view_text_numbers_bold",false,"Numbers text bold");
			$g_settings->addHr();
			$g_settings->addTextBox("view_text_numbers_padding_top","2","Space between caption and numbers text");
			$g_settings->addTextBox("view_txt_image","Image","Text - 'Image'");
			$g_settings->addTextBox("view_txt_of","Of","Text - 'Of'");
		$g_settings->endBulkControl();
		
		$g_settings->addSection("Navigation - Horizontal");
		$g_settings->addSap("Navigation Layout");
		$g_settings->addTextBox("navhor_space_between_items","10","Space between items");
		$g_settings->addHr();
		$g_settings->addSelect_boolean("navhor_width_dynamic","Width type",false,"Dynamic","Fixed");
		$g_settings->addTextBox("navhor_width","140","Items width");
		$g_settings->addControl("navhor_width_dynamic","navhor_width",Settings::CONTROL_TYPE_ENABLE,"false");
		$g_settings->addTextBox("navhor_text_padding_right","3","Items text padding right");
		$g_settings->addControl("navhor_width_dynamic","navhor_text_padding_right",Settings::CONTROL_TYPE_ENABLE,"true");
		$g_settings->addHr();
		$g_settings->addTextBox("navhor_text_padding_left","3","Items text padding left");
		$g_settings->addTextBox("navhor_text_padding_top","3","Items text padding top");
		$g_settings->addHr();
		$g_settings->addSelect_boolean("navhor_height_dynamic","Height type",false,"Dynamic","Fixed");
		$g_settings->addTextBox("navhor_height","24","Items height");		
		$g_settings->addControl("navhor_height_dynamic","navhor_height",Settings::CONTROL_TYPE_ENABLE,"false");
		$g_settings->addTextBox("navhor_text_padding_bottom","4","Items text padding bottom");		
		$g_settings->addControl("navhor_height_dynamic","navhor_text_padding_bottom",Settings::CONTROL_TYPE_ENABLE,"true");
		
		$g_settings->addSap("Navigation Items Style");
		$g_settings->addSelect_boolean("navhor_enable_background","Background enabled",true);
		$g_settings->addColorPicker("navhor_back_color","#ebebeb","Items background color");
		$g_settings->addControl("navhor_enable_background","navhor_back_color",Settings::CONTROL_TYPE_ENABLE,"true");
		$g_settings->addHr();
		$g_settings->addSelect_alignX("navhor_text_align","center","Items text align");
		$g_settings->addColorPicker("navhor_text_color","#595959","Items text color");		
		$g_settings->addTextBox("navhor_text_font_family","Times New Roman","Items Text font family");
		$g_settings->addTextBox("navhor_text_size",14,"Items text size");
		$g_settings->addCheckbox("navhor_text_bold",true,"Items text bold");
		$g_settings->addCheckbox("navhor_text_underline",false,"Items text underline");
		$g_settings->addHr();
		$g_settings->addSelect_boolean("navhor_border","Items border",true);		
		$g_settings->startBulkControl("navhor_border",Settings::CONTROL_TYPE_ENABLE,"true");
			$g_settings->addColorPicker("navhor_border_color","#c4c4c4","Items border color");
			$g_settings->addTextBox("navhor_border_size","1","Items border size");
			$g_settings->addSelect_border("navhor_border_style","solid","Items border style");
		$g_settings->endBulkControl();
		
		$g_settings->addSap("Navigation Items - Mouse Over");
		$g_settings->addSelect_boolean("navhor_mouseover","Enable mouseover",true,"Enable","Disable",array("textStyle"=>"font-weight:bold"));
		$g_settings->startBulkControl("navhor_mouseover",Settings::CONTROL_TYPE_SHOW,"true");
			$g_settings->addColorPicker("navhor_back_color_over","#ebebeb","Items background color");
			$g_settings->addControl("navhor_enable_background","navhor_back_color_over",Settings::CONTROL_TYPE_ENABLE,"true");
			$g_settings->addColorPicker("navhor_border_color_over","#c4c4c4","Items border color");
			$g_settings->addControl("navhor_border","navhor_border_color_over",Settings::CONTROL_TYPE_ENABLE,"true");
			$g_settings->addCheckbox("navhor_text_underline_over",true,"Items text underline");
			$g_settings->addColorPicker("navhor_text_color_over","#595959","Items text color");
			$g_settings->addCheckbox("navhor_text_bold_over",true,"Items text bold");
		$g_settings->endBulkControl();
		
		$g_settings->addSap("Navigation Items - Selected");
		$g_settings->addSelect_boolean("navhor_selected","Enable selected",true,"Enable","Disable",array("textStyle"=>"font-weight:bold"));
		$g_settings->startBulkControl("navhor_selected",Settings::CONTROL_TYPE_SHOW,"true");
			$g_settings->addColorPicker("navhor_back_color_selected","#bcceeb","Items background color");			
			$g_settings->addControl("navhor_enable_background","navhor_back_color_selected",Settings::CONTROL_TYPE_ENABLE,"true");
			$g_settings->addColorPicker("navhor_border_color_selected","#c4c4c4","Items border color");
			$g_settings->addControl("navhor_border","navhor_border_color_selected",Settings::CONTROL_TYPE_ENABLE,"true");
			$g_settings->addCheckbox("navhor_text_underline_selected",false,"Items text underline");
			$g_settings->addColorPicker("navhor_text_color_selected","#2e2e2e","Items text color");
			$g_settings->addCheckbox("navhor_text_bold_selected",true,"Items text bold");
		$g_settings->endBulkControl();
		
		//---- Vertical Navigation -----
		
		$g_settings->addSection("Navigation - Vertical");
		$g_settings->addSap("Navigation Layout");
		$g_settings->addTextBox("navvert_space_between_items","10","Space between items");
		$g_settings->addHr();
		$g_settings->addSelect_boolean("navvert_height_dynamic","Height type",false,"Dynamic","Fixed");
		$g_settings->addTextBox("navvert_height","24","Items height");		
		$g_settings->addControl("navvert_height_dynamic","navvert_height",Settings::CONTROL_TYPE_ENABLE,"false");
		$g_settings->addTextBox("navvert_text_padding_bottom","4","Items text padding bottom");		
		$g_settings->addControl("navvert_height_dynamic","navvert_text_padding_bottom",Settings::CONTROL_TYPE_ENABLE,"true");
		$g_settings->addHr();
		$g_settings->addSelect_boolean("navvert_width_dynamic","Width type",false,"Dynamic","Fixed");
		$g_settings->addTextBox("navvert_width","100","Items width");
		$g_settings->addControl("navvert_width_dynamic","navvert_width",Settings::CONTROL_TYPE_ENABLE,"false");
		$g_settings->addTextBox("navvert_text_padding_right","5","Items text padding right");
		$g_settings->addControl("navvert_width_dynamic","navvert_text_padding_right",Settings::CONTROL_TYPE_ENABLE,"true");
		$g_settings->addHr();
		$g_settings->addTextBox("navvert_text_padding_top","4","Items text padding top");
		$g_settings->addTextBox("navvert_text_padding_left","5","Items text padding left");
		
		$g_settings->addSap("Navigation Items Style");
		$g_settings->addSelect_boolean("navvert_enable_background","Background enabled",true);
		$g_settings->addColorPicker("navvert_back_color","#ebebeb","Items background color");		
		$g_settings->addControl("navvert_enable_background","navvert_back_color",Settings::CONTROL_TYPE_ENABLE,"true");
		$g_settings->addHr();
		$g_settings->addSelect_alignX("navvert_text_align","left","Items text align");
		$g_settings->addColorPicker("navvert_text_color","#595959","Items text color");		
		$g_settings->addTextBox("navvert_text_font_family","Times New Roman","Items Text font family");
		$g_settings->addTextBox("navvert_text_size",14,"Items text size");
		$g_settings->addCheckbox("navvert_text_bold",true,"Items text bold");
		$g_settings->addCheckbox("navvert_text_underline",false,"Items text underline");
		$g_settings->addHr();
		$g_settings->addSelect_boolean("navvert_border","Items border",true);		
		$g_settings->startBulkControl("navvert_border",Settings::CONTROL_TYPE_ENABLE,"true");
			$g_settings->addColorPicker("navvert_border_color","#c4c4c4","Items border color");
			$g_settings->addTextBox("navvert_border_size","1","Items border size");
			$g_settings->addSelect_border("navvert_border_style","solid","Items border style");
		$g_settings->endBulkControl();
		
		$g_settings->addSap("Navigation Items - Mouse Over");
		$g_settings->addSelect_boolean("navvert_mouseover","Enable mouseover",true,"Enable","Disable",array("textStyle"=>"font-weight:bold"));
		$g_settings->startBulkControl("navvert_mouseover",Settings::CONTROL_TYPE_SHOW,"true");
			$g_settings->addColorPicker("navvert_back_color_over","#ebebeb","Items background color");
			$g_settings->addControl("navvert_enable_background","navvert_back_color_over",Settings::CONTROL_TYPE_ENABLE,"true");
			$g_settings->addColorPicker("navvert_border_color_over","#c4c4c4","Items border color");
			$g_settings->addCheckbox("navvert_text_underline_over",true,"Items text underline");
			$g_settings->addColorPicker("navvert_text_color_over","#595959","Items text color");
			$g_settings->addCheckbox("navvert_text_bold_over",true,"Items text bold");
		$g_settings->endBulkControl();
		
		$g_settings->addSap("Navigation Items - Selected");
		$g_settings->addSelect_boolean("navvert_selected","Enable selected",true,"Enable","Disable",array("textStyle"=>"font-weight:bold"));
		$g_settings->startBulkControl("navvert_selected",Settings::CONTROL_TYPE_SHOW,"true");
			$g_settings->addColorPicker("navvert_back_color_selected","#bcceeb","Items background color");
			$g_settings->addControl("navvert_enable_background","navvert_back_color_selected",Settings::CONTROL_TYPE_ENABLE,"true");
			$g_settings->addColorPicker("navvert_border_color_selected","#c4c4c4","Items border color");
			$g_settings->addCheckbox("navvert_text_underline_selected",false,"Items text underline");
			$g_settings->addColorPicker("navvert_text_color_selected","#2e2e2e","Items text color");
			$g_settings->addCheckbox("navvert_text_bold_selected",true,"Items text bold");
		$g_settings->endBulkControl();
		
	}
	
	//write a head section of a gallery page
	function writeHeadSection(){
		global $g_settings;
		
		if(Functions::isJsonActivated())
			$g_settings->drawHeaderIncludes();
		
		?>
			<script type="text/javascript" src="inc_js/settings.js"></script>			
			<script type="text/javascript" src="inc_js/settings_page.js"></script>
			
			<link rel="stylesheet" href="<?php echo URL_THEME?>settings.css" type="text/css" />			
		<?php 
	}
	
	//--------------------------------------------------------------------------------------------------
	//draw all control buttons. (save, restore default etc...)
	function drawControlButtons(){		
		?>
		<div class="divVerticalButtonWrapper" style="margin-top:25px;">
			<?php Utils::putButton("Save Settings","saveSettingsClick()","butSaveSettings")?>
			<span id="spanLoaderSave" style="display:none;"><img src="images/cms/loader1.gif"></img> Saving settings...</span>
			<span id="spanSavedText" class="confirmText" style="display:none;">Settings saved!!!</span>
			<span id="spanErrorText" class="errorText" style="display:none;">Error saving settings!!!</span>
		</div>
		
		<div class="divVerticalButtonWrapper">
			<?php Utils::putButton("Restore defaults","restoreSettingsClick()","butRestoreSettings")?>
			<span id="spanLoaderRestore" style="display:none;"><img src="images/cms/loader1.gif"></img> Restoring defaults...</span>
			<span id="spanRestoredText" class="confirmText" style="display:none;"><img src="images/cms/loader1.gif"></img> Settings restored to defaults, reloading...</span>
			<span id="spanRestoreErrorText" class="errorText" style="display:none;">Error restoring settings!!!</span>				
		</div>
		
		<?php putSelectPresets(); ?>
		
		<?php 
	}
	
	//--------------------------------------------------------------------------------------------------
	//put presets select
	function putSelectPresets(){
		global $g_presets,$g_activePresetID;
		
		if(!isset($g_presets) || empty($g_presets)) return(false);
		?>
		<div style="font-weight:bold;padding-top:20px;padding-left:30px;">
		
		<div style="padding-bottom:7px;">
		Choose Preset:
		</div>
		
		<select style="width:140px;" id="selectPresets" onchange="onSelectPresetsChange(this)">
		<?php
			foreach($g_presets as $preset){
				$id = $preset["id"];				
				$selected = "";
				if($id == $g_activePresetID) $selected = " selected ";
				
				?>
					<option value="<?php echo $id?>" <?php echo $selected?>><?php echo $preset["title"];?></option>
				<?php				
			}			
		?>
		</select>
		
		<script language="javascript">
			
			function onSelectPresetsChange(select){
				var presetID = select.value;
				var url = g_self + "?preset="+presetID+location.hash;
				location.href = url;
			}
			
		</script>
						
		</div>		
		<?php 
	}
	
	//--------------------------------------------------------------------------------------------------
	// write a body section of a gallery page.
	function writeBodySection(){
		if(Functions::isJsonActivated() == false){
			echo "The php JSON library is not activated. You can't set up settings with this screen. Please activate it via php.ini";
			return(false);
		}
				
		global $g_settings;
		$g_settings->setCustomDrawFunction_afterSections("drawControlButtons");
		$g_settings->draw();
		$g_settings->drawAfterBody();	//draw the color picker div etc...
	}
	
	setAllSettings();
	
?>