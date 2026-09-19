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
   <font color="#FF0000"><b>${MESSAGE}</b></font> <a href="${back_refer}">${edit_other_messages}</a><br><br>
</center>

<table align="center" width="630" border="0" cellpadding="3" cellspacing="1">
 <form name="post" action="editmessage.${phpEx}" method="POST">

 <tr>
  <td width=230 class="msg_post" align="left">
   ${add_name} :
  </td>
  <td width=400 class="msg_post" align="left">
   <input type=text name="poster_name" value="${poster_name}">
  </td>
 </tr>

 <tr>
  <td class="msg_post" align="left">
   ${add_mail} :
  </td>
  <td class="msg_post" align="left">
   <input type=text name="poster_mail" value="${poster_mail}">
  </td>              	
 </tr>

 <tr>
  <td class="msg_post" align="left">
   ${add_location} :
  </td>
  <td class="msg_post" align="left">
   <input type=text name="poster_location" value="${poster_location}">
  </td>
 </tr>

 <tr>
  <td class="msg_post" align="left">
   ${add_msn} :
  </td>
  <td class="msg_post" align="left">
   <input type=text name="msn" value="${msn}">
  </td>
 </tr>

 <tr>
  <td class="msg_post" align="left">
   ${add_aim} :
  </td>
  <td class="msg_post" align="left">
   <input type=text name="aim" value="${aim}">
  </td>
 </tr>

 <tr>
  <td class="msg_post" align="left">
   ${add_yim} :
  </td>
  <td class="msg_post" align="left">
   <input type=text name="yim" value="${yim}">
  </td>
 </tr>

 <tr>
  <td class="msg_post" align="left">
   ${add_icq} :
  </td>
  <td class="msg_post" align="left">
   <input type=text name="icq" size=14 value="${icq}">
  </td>
 </tr>

 <tr>
  <td class="msg_post" align="left">
   ${add_homepage} :
  </td>
  <td class="msg_post" align="left">
   <input type=text name="homepage" value="${homepage}">
  </td>
 </tr>

 <tr>
  <td class="msg_post" align="left">
   ${add_gender} :
  </td>
  <td class="msg_post" align="left">
   <select name="gender">
    <option value=""></option>
    <option ${gender_m_selected} value="M">${add_gender_male}</option>
    <option ${gender_f_selected} value="F">${add_gender_female}</option>
   </select>
  </td>
 </tr>

 <tr>
  <td class="msg_post" align="left">
   ${add_age} :
  </td>
  <td class="msg_post" align="left">
   <input type=text name="age" size=4 value="${age}">
  </td>
 </tr>

 <tr>
  <td class="msg_post" align="left">
   ${c_field_1} :
  </td>
  <td class="msg_post" align="left">
   <input type=text name="c_field_1" value="${c_field_1v}">
  </td>
 </tr>

 <tr>
  <td class="msg_post" align="left">
   ${c_field_2} :
  </td>
  <td class="msg_post" align="left">
   <input type=text name="c_field_2" value="${c_field_2v}">
  </td>
 </tr>

 <tr>
  <td class="msg_post" align="left">
   ${c_field_3} :
  </td>
  <td class="msg_post" align="left">
   <input type=text name="c_field_3" value="${c_field_3v}">
  </td>
 </tr>

 <tr>
  <td class="msg_post" align="left">
   ${c_field_4} :
  </td>
  <td class="msg_post" align="left">
   <input type=text name="c_field_4" value="${c_field_4v}">
  </td>
 </tr>

 <tr>
  <td class="msg_post" align="left">
   ${c_field_5} :
  </td>
  <td class="msg_post" align="left">
   <input type=text name="c_field_5" value="${c_field_5v}">
  </td>
 </tr>

 <tr>
  <td class="msg_post" align="left" valign="top">
   ${add_message_text} : <br>
   <br><br><br><br>
   ${add_html} : ${allow_html} <br>
   ${add_html_tags} ${allowed_tags}
  </td>
  <td class="msg_post" align="left">

   <!-- $BeginBlock add_bemoticons -->
   ${add_emoticon}
   <!-- $EndBlock add_bemoticons -->
   <br>

   <textarea wrap="virtual" cols="45" rows="10" name="message">${message_text}</textarea>
  </td>
 </tr>

 <tr>
  <td colspan=2 class="msg_header" align="center">
   <input type=submit name="update_message" value="${aem_update_message}">
   <input type=submit name="del_message" value="${aem_del_message}">
  </td>
 </tr>
 <input type="hidden" name="refer" value="${refer}">
 <input type="hidden" name="pid" value="${pid}">
 </form>
</table>
