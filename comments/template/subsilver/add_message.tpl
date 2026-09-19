<script language="JavaScript" type="text/javascript">
<!--
function emoticon(text) {
	var txtarea = document.post.message;
	text = ' ' + text + ' ';
	if (txtarea.createTextRange && txtarea.caretPos) {
		var caretPos = txtarea.caretPos;
		caretPos.text = caretPos.text.charAt(caretPos.text.length - 1) == ' ' ? caretPos.text + text + ' ' : caretPos.text + text;
		txtarea.focus();
	} else {
		txtarea.value  += text;
		txtarea.focus();
	}
}
//-->
</script>

<center>
   <font color="#FF0000"><b>
	${MESSAGE}
   </b></font>
</center>

<table border="0" class="forumline" align="center">
	<tr>
		<td><div align="center">


 <table align="center" width="630" border="0" cellspacing="1">
	<tr>
		<th width="470"><b>${add_message}</b></th>
		<th width="160">&nbsp;</th>
	</tr>
 <tr>
  <td align="left" class="row1">
  </td>
  <td align="right" class="row1">
   <a href="index.${phpEx}">${view_guestbook}</a>
  </td>
 </tr>
 <tr>
  <td colspan="2" class="spaceRow">&nbsp;</td>
 </tr>
</table>

<table border="0" width="630" cellspacing="1">
		<tr>
			<th width="630" class="thTop">&nbsp;</th>

		</tr>
</table>

<table align="center" width="630" border="0" cellpadding="3" cellspacing="1">
 <form name="post" action="add_message.${phpEx}" method="POST">

 <tr>
  <td width=230 class="row1" align="left">
   ${add_name} :
  </td>
  <td width=400 class="row1" align="left">
   <input type=text name="poster_name" value="${vposter_name}">
  </td>
 </tr>

 <!-- $BeginBlock add_bemail -->
 <tr>
  <td class="row1" align="left">
   ${add_mail} :
  </td>
  <td class="row1" align="left">
   <input type=text name="poster_mail" value="${vposter_mail}">
  </td>
 </tr>
 <!-- $EndBlock add_bemail -->

 <!-- $BeginBlock add_blocation -->
 <tr>
  <td class="row1" align="left">
   ${add_location} :
  </td>
  <td class="row1" align="left">
   <input type=text name="poster_location" value="${vposter_location}">
  </td>
 </tr>
 <!-- $EndBlock add_blocation -->


 <!-- $BeginBlock add_bmsn -->
 <tr>
  <td class="row1" align="left">
   ${add_msn} :
  </td>
  <td class="row1" align="left">
   <input type=text name="msn" value="${vmsn}">
  </td>
 </tr>
 <!-- $EndBlock add_bmsn -->

 <!-- $BeginBlock add_baim -->
 <tr>
  <td class="row1" align="left">
   ${add_aim} :
  </td>
  <td class="row1" align="left">
   <input type=text name="aim" value="${vaim}">
  </td>
 </tr>
 <!-- $EndBlock add_baim -->

 <!-- $BeginBlock add_byim -->
 <tr>
  <td class="row1" align="left">
   ${add_yim} :
  </td>
  <td class="row1" align="left">
   <input type=text name="yim" value="${vyim}">
  </td>
 </tr>
 <!-- $EndBlock add_byim -->

 <!-- $BeginBlock add_bicq -->
 <tr>
  <td class="row1" align="left">
   ${add_icq} :
  </td>
  <td class="row1" align="left">
   <input type=text name="icq" size=14 value="${vicq}">
  </td>
 </tr>
 <!-- $EndBlock add_bicq -->

 <!-- $BeginBlock add_bhomepage -->
 <tr>
  <td class="row1" align="left">
   ${add_homepage} :
  </td>
  <td class="row1" align="left">
   <input type=text name="homepage" value="${vhomepage}">
  </td>
 </tr>
 <!-- $EndBlock add_bhomepage -->

 <!-- $BeginBlock add_bgender -->
 <tr>
  <td class="row1" align="left">
   ${add_gender} :
  </td>
  <td class="row1" align="left">
   <select name="gender">
    <option ${vmgender} value="M">${add_gender_male}</option>
    <option ${vfgender} value="F">${add_gender_female}</option>
   </select>
  </td>
 </tr>
 <!-- $EndBlock add_bgender -->

 <!-- $BeginBlock add_bage -->
 <tr>
  <td class="row1" align="left">
   ${add_age} :
  </td>
  <td class="row1" align="left">
   <input type=text name="age" size=4 value="${vage}">
  </td>
 </tr>
 <!-- $EndBlock add_bage -->

 <!-- $BeginBlock add_bc_field_1 -->
 <tr>
  <td class="row1" align="left">
   ${c_field_1} :
  </td>
  <td class="row1" align="left">
   <input type=text name="c_field_1" value="${vc_field_1}">
  </td>
 </tr>
 <!-- $EndBlock add_bc_field_1 -->

 <!-- $BeginBlock add_bc_field_2 -->
 <tr>
  <td class="row1" align="left">
   ${c_field_2} :
  </td>
  <td class="row1" align="left">
   <input type=text name="c_field_2" value="${vc_field_2}">
  </td>
 </tr>
 <!-- $EndBlock add_bc_field_2 -->

 <!-- $BeginBlock add_bc_field_3 -->
 <tr>
  <td class="row1" align="left">
   ${c_field_3} :
  </td>
  <td class="row1" align="left">
   <input type=text name="c_field_3" value="${vc_field_3}">
  </td>
 </tr>
 <!-- $EndBlock add_bc_field_3 -->

 <!-- $BeginBlock add_bc_field_4 -->
 <tr>
  <td class="row1" align="left">
   ${c_field_4} :
  </td>
  <td class="row1" align="left">
   <input type=text name="c_field_4" value="${vc_field_4}">
  </td>
 </tr>
 <!-- $EndBlock add_bc_field_4 -->

 <!-- $BeginBlock add_bc_field_5 -->
 <tr>
  <td class="row1" align="left">
   ${c_field_5} :
  </td>
  <td class="row1" align="left">
   <input type=text name="c_field_5" value="${vc_field_5}">
  </td>
 </tr>
 <!-- $EndBlock add_bc_field_5 -->

 <!-- $BeginBlock add_bcaptcha -->
 <tr>
  <td class="row1" align="left">
   ${captcha} :
  </td>
  <td class="row1" align="left">
   <img src="captcha.${phpEx}?tstamp=${tstamp}&code=${md5tstamp}${key}"><br>
   <input type=text name="captcha">
  </td>
 </tr>
 <!-- $EndBlock add_bcaptcha -->

 <tr>
  <td class="row1" align="left" valign="top">
   ${add_message_text} : <br>
   <br><br><br><br>
   <!-- $BeginBlock add_bhtml -->
   ${add_html} : ${allow_html} <br>
   ${add_html_tags} ${allowed_tags}
   <!-- $EndBlock add_bhtml -->
  </td>
  <td class="row1" align="left">

   <!-- $BeginBlock add_bemoticons -->
   ${add_emoticon}
   <!-- $EndBlock add_bemoticons -->
   <br>

   <textarea wrap="virtual" cols="45" rows="10" name="message">${vmessage}</textarea>
   <br>
   ${REQFS} ${add_req}
  </td>
 </tr>

 <tr>
  <td colspan=2 class="row3"" align="center">
   <input type=submit name="addmessage" value="${add_message}">
  </td>
 </tr>
 <input type="hidden" name="tstamp" value="${tstamp}">
 </form>
</table>

</div></td></tr></table>