<table border="0" class="forumline" align="center">
	<tr>
		<td><div align="center">

 <table align="center" width="630" border="0" cellspacing="1">
	<tr>
		<th width="470">${search} :</th>
		<th width="160">&nbsp;</th>
	</tr>
 <tr>
  <form action="index.php" method="GET">
  <td align="left" class="row1">
    <input type="text" name="search"><input type="submit" value="Go!">
  </td>
  </form>
  <td align="right" class="row1">
   <a href="add_message.${phpEx}">${add_message}</a>
  </td>
 </tr>
 <tr>
  <td colspan="2" class="spaceRow">&nbsp;</td>
 </tr>

</table>

<table border="0" width="630" cellspacing="1">
		<tr>
			<th width="160" class="thTop">&nbsp;</th>
			<th width="470" class="thTop">&nbsp;</th>

		</tr>
</table>
<table align="center" width="630" border="0" cellspacing="1">

 <!-- $BeginBlock messages --> 

 <tr>
  <td width="160" class="row2">
   ${gender} ${poster} ${age}
  </td>
  <td width="470" class="row2">
   <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
     <td align="left">
      ${date}
     </td>
     <td align="right">
      ${post_num} ${ip_addr}
     </td>
    </tr>
   </table>
  </td>
 </tr>
 <tr>
  <td width="160" class="row1" valign="top">

   <!-- $BeginBlock blocation -->
   ${location} : ${p_location}</a><br>
   <!-- $EndBlock blocation -->

   <!-- $BeginBlock bpostermail -->
   <A target="_blank" rel="nofollow" href="redirect.${phpEx}?LOCATION=mailto:${posteremail}">${email}</a>
   <!-- $EndBlock bpostermail -->

   <!-- $BeginBlock bhomepage -->
   <A target="_blank" rel="nofollow" href="redirect.${phpEx}?LOCATION=${p_homepage}">${homepage}</a>
   <!-- $EndBlock bhomepage -->

   <br>

   <!-- $BeginBlock baim -->
   <A target="_blank" rel="nofollow" href="redirect.${phpEx}?LOCATION=aim:goim?screenname=${p_aim}">${aim}</a>
   <!-- $EndBlock baim -->

   <!-- $BeginBlock bmsn -->
   <A target="_blank" rel="nofollow" href="redirect.${phpEx}?LOCATION=http://members.msn.com/${p_msn}">${msn}</a>
   <!-- $EndBlock bmsn -->

   <!-- $BeginBlock byim -->
   <A target="_blank" rel="nofollow" href="redirect.${phpEx}?LOCATION=http://edit.yahoo.com/config/send_webmesg?.target=${p_yim}">${yim}</a>
   <!-- $EndBlock byim -->

   <!-- $BeginBlock bicq -->
   <A target="_blank" rel="nofollow" href="redirect.${phpEx}?LOCATION=http://wwp.icq.com/scripts/search.dll?to=${p_icq}">${icq}</a>
   <!-- $EndBlock bicq -->

   <!-- $BeginBlock bc_field_1 -->
   <br>${c_field_1} : ${p_c_field_1}</a>
   <!-- $EndBlock bc_field_1 -->

   <!-- $BeginBlock bc_field_2 -->
   <br>${c_field_2} : ${p_c_field_2}</a>
   <!-- $EndBlock bc_field_2 -->

   <!-- $BeginBlock bc_field_3 -->
   <br>${c_field_3} : ${p_c_field_3}</a>
   <!-- $EndBlock bc_field_3 -->

   <!-- $BeginBlock bc_field_4 -->
   <br>${c_field_4} : ${p_c_field_4}</a>
   <!-- $EndBlock bc_field_4 -->

   <!-- $BeginBlock bc_field_5 -->
   <br>${c_field_5} : ${p_c_field_5}</a>
   <!-- $EndBlock bc_field_5 -->
  </td>
  <td width="470" class="row1" valign="top">
   ${text}
  </td>
 </tr>

 <!-- $EndBlock messages --> 

</table>

<table align="center" width="630" border="0" cellspacing="1">
 <tr>
  <td align="right">
   <!-- $BeginBlock FPL -->
    [<a href='?start=0&search=${search_query}'>${first_page_link}</a>] ...
   <!-- $EndBlock FPL -->

   <!-- $BeginBlock CPL -->
     <!-- $BeginBlock BOLDPL -->
      <b>[${bold_page_link}]</b>
     <!-- $EndBlock BOLDPL -->
     <!-- $BeginBlock ALINKPL -->
      [<a href='?start=${alink_page_link}'>${alink_page_number}</a>]
     <!-- $EndBlock ALINKPL -->
   <!-- $EndBlock CPL -->


   <!-- $BeginBlock LPL -->
    ... [<a href='?start=${last_page_num}'>${last_page_link}</a>]
   <!-- $EndBlock LPL -->
  </td>
 </tr>
</table>

<table align="center" width="630" border="0" cellspacing="1">
 <tr>
  <th colspan=2 align="left">
   <b>${who_is_online}</b>
  </th>
 </tr>
 <tr>
  <td width="50" align="center" class="row1">
   <img src='template/subsilver/images/stats.png' width=30 height=30 alt=''>
  </td>
  <td width="580" align="left" class="row1">
   ${total} <b>${total_messages}</b> ${messages}<br>
   ${users_online} <b>${users_online_num}</b> ${user_s} ${online}<br>
   ${max_online} <b>${max_visitors_online}</b> ${on} ${max_visitors_date}
  </td>
 </tr>
 <tr>
 <td colspan=2 align="left" class="row2">
   <p align="right">
  </td>
 </tr>
 <tr>
  <td colspan=2 align="left" class="spaceRow">&nbsp;</td>
 </tr>
</table>

</div></td></tr></table>