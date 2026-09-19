<?php

	/* standart utils used in cms class */

	class Utils{
		
		public static function putButton($text,$onclick="",$id=""){
			$butID = "";
			if($id != "") $butID = 'id="'.$id.'"'; 			
			$butOnClick = "";
			if($onclick != "") $butOnClick = 'onclick="'.$onclick.'"';
			
			?>
			<a <?php echo $butID?> onfucus="this.blur()" href="javascript:void(0)" class="normalButton" <?php echo $butOnClick?>>
				<div>
					<?php echo $text?>				
				</div>
			</a>
			<?php			
		}
		
	}
	
?>