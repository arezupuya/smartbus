<?php
	
	class GalleryCssOutput{
		private $mainClass = ".gallery";
		private $settings;
		
		//------------------------------------------------------
		//set the settings variable
		public function setSettings($settings){
			$this->settings = $settings;
		}
		
		//------------------------------------------------------
		//put thumbnails css
		private function putListCss(){
			$s = $this->settings;
			
			$margin_hor = "";
			//set horizontal deilmiter - if dynamic
			if($s["thumbs_columns_enable"] == "false"){
				if($s["thumbs_float"] == "left")
					$margin_hor = "margin-right:".$s["thumbs_margin_x"]."px;";
				else 
					$margin_hor = "margin-left:".$s["thumbs_margin_x"]."px;";
			}
			
			$div_width = $s["thumb_image_width"]; 
			$div_height = $s["thumb_image_height"]; 
			if($s["thumb_image_border"] == "true"){
				$div_width += $s["thumb_image_border_size"]*2;
				$div_height += $s["thumb_image_border_size"]*2;
			}
			
			?>
				
				.gallery_empty_category{
					font-family:<?php echo $s["empty_category_font_family"]?>;
					font-size:<?php echo $s["empty_category_size"]?>px;
					color:<?php echo $s["empty_category_color"]?>;
					<?php if($s["empty_category_bold"] == "true"):?>
					font-weight:bold;
					<?php else: ?>
					font-weight:normal;
					<?php endif ?>					
				}
				
				table.table_gallery{
					<?php if($s["thumbs_float"] == "right"):?>
					direction:rtl;
					<?php endif ?>
				}
				
				table.table_gallery tr td.sap_vert{
					height:<?php echo $s["thumbs_margin_y"]?>px;
				}
				
				table.table_gallery tr td.sap_hor{
					width:<?php echo $s["thumbs_margin_x"]?>px;
				}
				
				ul.list_gallery{
					list-style:none;
					padding:0px;
					margin:0px;
				}
				
				ul.list_gallery li{
					padding:0px;
					margin:0px;
					float:<?php echo $s["thumbs_float"]?>;
					
					<?php if($s["thumbs_columns_enable"] == "false"):?>
					margin-bottom:<?php echo $s["thumbs_margin_y"]?>px;
					<?php endif?>
					
					<?php echo $margin_hor."\n"?>
				}
				
				ul.list_gallery li a{
					padding:0px;
					margin:0px;
					display:block;
					<?php if($s["thumb_border"] == "true"):?>
					border-style:<?php echo $s["thumb_border_style"]?>;
					border-width:<?php echo $s["thumb_border_size"]?>px;
					border-color:<?php echo $s["thumb_border_color"]?>;
					<?php else: ?>
					border:0px;
					<?php endif;?>
					text-decoration:<?php echo $s["thumb_text_decoration"]?>;
					color:<?php echo $s["thumb_text_color"]?>;
					
					<?php if($s["thumb_text_bold"] == "true"):?>
					font-weight:bold;
					<?php else: ?>
					font-weight:normal;					
					<?php endif ?>
					
					font-family:<?php echo $s["thumb_text_fontfamily"]?>;
					font-size:<?php echo $s["thumb_text_size"]?>px;
					text-align:center;					
					background-color:<?php echo $s["thumb_background_color"]?>;
					padding-top:<?php echo $s["thumb_padding_top"]?>px;
					padding-bottom:<?php echo $s["thumb_padding_bottom"]?>px;
					<?php if($s["thumb_exact_width"] == "true"):?>
					width:<?php echo $s["thumb_width"]?>px;
					overflow:hidden;
					<?php else:?>
					padding-left:<?php echo $s["thumb_padding_left"]?>px;
					padding-right:<?php echo $s["thumb_padding_right"]?>px;
					<?php endif ?>
				}
				
				ul.list_gallery li a:hover{
					<?php if($s["thumb_border"] == "true"):?>
					border-color:<?php echo $s["thumb_border_color_over"]?>;
					<?php endif;?>					
					background-color:<?php echo $s["thumb_background_color_over"]?>;					
					text-decoration:<?php echo $s["thumb_text_decoration_over"]?>;										
					color:<?php echo $s["thumb_text_color_over"]?>;					
				}
				
				ul.list_gallery li a div{
					text-align:center;
					width:<?php echo $div_width?>px;
					height:<?php echo $div_height?>px;
					margin:0 auto;
				}					
				
				ul.list_gallery li a img{
					display:block;
					padding:0px;
					margin:0px;
					<?php if($s["thumb_image_border"] == "true"):?>
					border-style:<?php echo $s["thumb_image_border_style"]?>;
					border-width:<?php echo $s["thumb_image_border_size"]?>px;
					border-color:<?php echo $s["thumb_image_border_color"]?>;
					<?php else: ?>
					border:0px;
					<?php endif ?>
					margin:0 auto;
					cursor:pointer;
				}
				
				ul.list_gallery li a:hover img{
					<?php if($s["thumb_image_border"] == "true"):?>
					border-color:<?php echo $s["thumb_image_border_color_over"]?>;
					<?php else: ?>
					border:0px;
					<?php endif ?>				
				}
				
				ul.list_gallery li a span{
					display:block;
					direction:ltr;					
					text-align:<?php echo $s["thumb_text_align"]?>;
					<?php if($s["thumb_text_vert_pos"] == "top"):?>
					padding-bottom:<?php echo $s["thumb_text_image_space"]?>px;
					<?php else: ?>
					padding-top:<?php echo $s["thumb_text_image_space"]?>px;
					<?php endif ?>
					<?php if($s["thumb_text_align"] != "center"):?>
					padding-left:<?php echo $s["thumb_text_padding_left"]?>px;
					padding-right:<?php echo $s["thumb_text_padding_right"]?>px;
					<?php endif ?>
				}
				
			<?php
		}
		
		//------------------------------------------------------
		// put some styles for the lightbox
		private function putLightboxStyles(){
			$s = $this->settings;
			?>
				#jquery-overlay {
					position: absolute;
					top: 0;
					left: 0;
					z-index: 90;
					width: 100%;
					height: 500px;
				}
				
				#jquery-lightbox {
					position: absolute;
					top: 0;
					left: 0;
					width: 100%;
					z-index: 100;
					text-align: center;
					line-height: 0;
				}
				
				#jquery-lightbox a img { border: none; }
				#lightbox-container-image-box {
					position: relative;
					background-color: <?php echo $s["view_frame_color"]?>;
					width: 250px;
					height: 250px;
					margin: 0 auto;
				}
				
				#lightbox-container-image { padding: 10px; }
				#lightbox-loading {
					position: absolute;
					top: 40%;
					left: 0%;
					height: 25%;
					width: 100%;
					text-align: center;
					line-height: 0;
				}
				#lightbox-nav {
					position: absolute;
					top: 0;
					left: 0;
					height: 100%;
					width: 100%;
					z-index: 10;
				}
				#lightbox-container-image-box > #lightbox-nav { left: 0; }
				#lightbox-nav a { outline: none;}
				#lightbox-nav-btnPrev, #lightbox-nav-btnNext {
					width: 49%;
					height: 100%;
					zoom: 1;
					display: block;
				}
				#lightbox-nav-btnPrev { 
					left: 0; 
					float: left;
				}
				#lightbox-nav-btnNext { 
					right: 0; 
					float: right;
				}
				#lightbox-container-image-data-box {
					font: 10px Verdana, Helvetica, sans-serif;
					background-color: <?php echo $s["view_frame_color"]?>;
					margin: 0 auto;
					line-height: 1.4em;
					overflow: auto;
					width: 100%;
					padding: 0 10px 0;
				}
				#lightbox-container-image-data {
					padding-left:<?php echo $s["view_text_padding_left"]?>px;
					padding-top:0px;
				}
				
				#lightbox-container-image-data #lightbox-image-details{
					width: 70%; 
					float: left; 
					text-align: left; 
				}	
				
				#lightbox-image-details-caption { 
					display:block;
					<?php if($s["view_show_text_numbers"] == "false"):?>
					padding-bottom: <?php echo $s["view_text_padding_bottom"]?>px;
					<?php endif ?>					
				}
				
				.lightbox_text_sap{
					display:block;
					margin-bottom:<?php echo $s["view_text_space_between"]?>px;
					padding:0px;
				}
				
				.lightbox_text_title{
					display:block;
					font-family:<?php echo $s["view_text_font_family"]?>;
					font-size:<?php echo $s["view_text_caption_size"]?>px;
					color:<?php echo $s["view_text_caption_color"]?>;
					<?php if($s["view_text_caption_bold"] == "true"):?>;
					font-weight:bold;
					<?php else: ?>
					font-weight:normal;					
					<?php endif ?>
				}
				
				.lightbox_text_desc{
					display:block;
					font-family:<?php echo $s["view_text_font_family"]?>;
					font-size:<?php echo $s["view_text_desc_size"]?>px;
					color:<?php echo $s["view_text_desc_color"]?>;
					<?php if($s["view_text_desc_bold"] == "true"):?>;
					font-weight:bold;
					<?php else: ?>
					font-weight:normal;					
					<?php endif ?>					
				}
				
				#lightbox-image-details-currentNumber {
					display: block; 
					clear: left;
					font-family:<?php echo $s["view_text_font_family"]?>;
					font-size:<?php echo $s["view_text_numbers_size"]?>px;
					color:<?php echo $s["view_text_numbers_color"]?>;
					<?php if($s["view_text_numbers_bold"] == "true"):?>;
					font-weight:bold;
					<?php else: ?>
					font-weight:normal;					
					<?php endif ?>
					padding-top:<?php echo $s["view_text_numbers_padding_top"]?>px;					
					<?php if($s["view_show_text_numbers"] == "true"):?>
					padding-bottom: <?php echo $s["view_text_padding_bottom"]?>px;
					<?php endif ?>
				}			
				#lightbox-secNav-btnClose {
					width: 66px; 
					float: right;
					padding-bottom: 0.7em;	
				}
				
			<?php
		}
		
		//------------------------------------------------------
		//put navigation horezontal styles
		private function putNavigation_hor_Styles(){
			$s = $this->settings;
			
			?>				
				/* Horezontal Navigation */
				
				ul.gallery_navigation_hor{
					list-style:none;
					margin:0px;
					padding:0px;					
				}
				
				ul.gallery_navigation_hor li{
					display:block;
					float:left;
					padding-right:<?php echo $s["navhor_space_between_items"]?>px;
				}
				
				ul.gallery_navigation_hor li.last{
					padding-right:0px;
				}
				
				ul.gallery_navigation_hor li a{
					display:block;
					<?php if($s["navhor_height_dynamic"] == "false"):?>
					height:<?php echo $s["navhor_height"]?>px;
					<?php endif?>
					<?php if($s["navhor_width_dynamic"] == "false"):?>
					width:<?php echo $s["navhor_width"]?>px;
					<?php endif?>
					<?php if($s["navhor_text_underline"] == "true"):?>
					text-decoration:underline;
					<?php else:?>
					text-decoration:none;
					<?php endif?>
					color:<?php echo $s["navhor_text_color"]?>;
					
					<?php if($s["navhor_enable_background"] == "true"):?>
					background-color:<?php echo $s["navhor_back_color"]?>;					
					<?php endif?>
					
					<?php if($s["navhor_border"] == "true"):?>
					border-style:<?php echo $s["navhor_border_style"]?>;
					border-width:<?php echo $s["navhor_border_size"]?>px;
					border-color:<?php echo $s["navhor_border_color"]?>;
					<?php else: ?>
					border:0px;
					<?php endif?>
				}
				
				ul.gallery_navigation_hor li a span{
					display:block;
					padding-top:<?php echo $s["navhor_text_padding_top"]?>px;
					padding-left:<?php echo $s["navhor_text_padding_left"]?>px;
					
					<?php if($s["navhor_height_dynamic"] == "true"):?>
					padding-bottom:<?php echo $s["navhor_text_padding_bottom"]?>px;
					<?php endif?>
					<?php if($s["navhor_width_dynamic"] == "true"):?>
					padding-right:<?php echo $s["navhor_text_padding_right"]?>px;
					<?php endif?>
					
					font-family:<?php echo $s["navhor_text_font_family"]?>;
					<?php if($s["navhor_text_bold"] == "true"):?>
					font-weight:bold;
					<?php else: ?>
					font-weight:normal;					
					<?php endif?>
					font-size:<?php echo $s["navhor_text_size"]?>px;
					color:<?php echo $s["navhor_text_color"]?>;
					
					text-align:<?php echo $s["navhor_text_align"]?>;					
				}
				
				<?php if($s["navhor_mouseover"] == "true"):?>
				ul.gallery_navigation_hor li a:hover{
					color:<?php echo $s["navhor_text_color_over"]?>;
					<?php if($s["navhor_text_underline_over"] == "true"):?>
					
					text-decoration:underline;
					<?php else:?>
					text-decoration:none;
					<?php endif?>
					
					<?php if($s["navhor_border"] == "true"):?>
					border-color:<?php echo $s["navhor_border_color_over"]?>;
					<?php endif?>
					
					<?php if($s["navhor_enable_background"] == "true"):?>
					background-color:<?php echo $s["navhor_back_color_over"]?>;
					<?php endif?>
				}
				
				ul.gallery_navigation_hor li a:hover span{
					color:<?php echo $s["navhor_text_color_over"]?>;
					<?php if($s["navhor_text_bold_over"] == "true"):?>
					font-weight:bold;
					<?php else:?>
					font-weight:normal;
					<?php endif?>
				}
				<?php endif?>
								
				
				ul.gallery_navigation_hor li.selected a,ul.gallery_navigation_hor li.selected a:hover{
					cursor:default;
					<?php if($s["navhor_selected"] == "true"):?>
					
						color:<?php echo $s["navhor_text_color_selected"]?>;
						<?php if($s["navhor_text_underline_selected"] == "true"):?>
						
						text-decoration:underline;
						<?php else:?>
						text-decoration:none;
						<?php endif?>
						
						<?php if($s["navhor_border"] == "true"):?>
						border-color:<?php echo $s["navhor_border_color_selected"]?>;
						<?php endif?>
						
						<?php if($s["navhor_enable_background"] == "true"):?>
							background-color:<?php echo $s["navhor_back_color_selected"]?>;
						<?php endif?>
						
					<?php endif?>
				}
				
				ul.gallery_navigation_hor li.selected a span,ul.gallery_navigation_hor li.selected a:hover span{
					<?php if($s["navhor_selected"] == "true"):?>
						color:<?php echo $s["navhor_text_color_selected"]?>;
						<?php if($s["navhor_text_bold_selected"] == "true"):?>
						font-weight:bold;
						<?php else:?>
						font-weight:normal;
						<?php endif?>
					<?php endif?>						
				}
			<?php
		}

		//------------------------------------------------------
		//put navigation vertical styles
		private function putNavigation_vert_Styles(){
			$s = $this->settings;
			
			?>	
				/* Vertical navigation Navigation */ 
				
				ul.gallery_navigation_vert{
					list-style:none;
					margin:0px;
					padding:0px;					
				}
				
				ul.gallery_navigation_vert li{
					display:block;
					padding-bottom:<?php echo $s["navvert_space_between_items"]?>px;
				}
				
				ul.gallery_navigation_vert li.last{
					padding-bottom:0px;
				}
				
				ul.gallery_navigation_vert li a{
					display:block;
					<?php if($s["navvert_height_dynamic"] == "false"):?>
					height:<?php echo $s["navvert_height"]?>px;
					<?php endif?>
					<?php if($s["navvert_width_dynamic"] == "false"):?>
					width:<?php echo $s["navvert_width"]?>px;
					<?php endif?>
					<?php if($s["navvert_text_underline"] == "true"):?>
					text-decoration:underline;
					<?php else:?>
					text-decoration:none;
					<?php endif?>
					color:<?php echo $s["navvert_text_color"]?>;
					
					<?php if($s["navvert_enable_background"] == "true"):?>
					background-color:<?php echo $s["navvert_back_color"]?>;					
					<?php endif?>
					
					<?php if($s["navvert_border"] == "true"):?>
					border-style:<?php echo $s["navvert_border_style"]?>;
					border-width:<?php echo $s["navvert_border_size"]?>px;
					border-color:<?php echo $s["navvert_border_color"]?>;
					<?php else: ?>
					border:0px;
					<?php endif?>
				}
				
				ul.gallery_navigation_vert li a span{
					display:block;
					padding-top:<?php echo $s["navvert_text_padding_top"]?>px;
					padding-left:<?php echo $s["navvert_text_padding_left"]?>px;
					
					<?php if($s["navvert_height_dynamic"] == "true"):?>
					padding-bottom:<?php echo $s["navvert_text_padding_bottom"]?>px;
					<?php endif?>
					<?php if($s["navvert_width_dynamic"] == "true"):?>
					padding-right:<?php echo $s["navvert_text_padding_right"]?>px;
					<?php endif?>
										
					font-family:<?php echo $s["navvert_text_font_family"]?>;
					<?php if($s["navvert_text_bold"] == "true"):?>
					font-weight:bold;
					<?php endif?>
					font-size:<?php echo $s["navvert_text_size"]?>px;
					color:<?php echo $s["navvert_text_color"]?>;
					
					text-align:<?php echo $s["navvert_text_align"]?>;					
				}
				
				<?php if($s["navvert_mouseover"] == "true"):?>
				ul.gallery_navigation_vert li a:hover{
					color:<?php echo $s["navvert_text_color_over"]?>;
					<?php if($s["navvert_text_underline_over"] == "true"):?>
					
					text-decoration:underline;
					<?php else:?>
					text-decoration:none;
					<?php endif?>
					
					<?php if($s["navvert_border"] == "true"):?>
					border-color:<?php echo $s["navvert_border_color_over"]?>;
					<?php endif?>
					
					<?php if($s["navvert_enable_background"] == "true"):?>
					background-color:<?php echo $s["navvert_back_color_over"]?>;
					<?php endif?>
				}
				
				ul.gallery_navigation_vert li a:hover span{
					color:<?php echo $s["navvert_text_color_over"]?>;
					<?php if($s["navvert_text_bold_over"] == "true"):?>
					font-weight:bold;
					<?php else:?>
					font-weight:normal;
					<?php endif?>
				}
				<?php endif?>
								
				
				ul.gallery_navigation_vert li.selected a,ul.gallery_navigation_vert li.selected a:hover{
					cursor:default;
					<?php if($s["navvert_selected"] == "true"):?>
					
						color:<?php echo $s["navvert_text_color_selected"]?>;
						<?php if($s["navvert_text_underline_selected"] == "true"):?>
						
						text-decoration:underline;
						<?php else:?>
						text-decoration:none;
						<?php endif?>
						
						<?php if($s["navvert_border"] == "true"):?>
						border-color:<?php echo $s["navvert_border_color_selected"]?>;
						<?php endif?>
						
						<?php if($s["navvert_enable_background"] == "true"):?>
						background-color:<?php echo $s["navvert_back_color_selected"]?>;
						<?php endif?>
						
					<?php endif?>
				}
				
				ul.gallery_navigation_vert li.selected a span,ul.gallery_navigation_vert li.selected a:hover span{
					<?php if($s["navvert_selected"] == "true"):?>
						color:<?php echo $s["navvert_text_color_selected"]?>;
						<?php if($s["navvert_text_bold_selected"] == "true"):?>
						font-weight:bold;
						<?php else:?>
						font-weight:normal;
						<?php endif?>
					<?php endif?>						
				}
			<?php
		}
		
		
		//------------------------------------------------------
		// main function for put css
		public function putCSS(){
			header('Content-type: text/css');
			$this->putListCss();
			$this->putLightboxStyles();
			$this->putNavigation_hor_Styles();
			$this->putNavigation_vert_Styles();
		}
		
	}
?>