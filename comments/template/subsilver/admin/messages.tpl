<table class="post" align="center" width="630" border="0" cellpadding="3" cellspacing="1">

 <!-- $BeginBlock messages --> 

 <tr>
  <td width="160" class="msg_header">
   ${gender} ${poster} ${age}
  </td>
  <td width="470" class="msg_header">
   <table class="msg_header" width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
     <td align="left">
      ${date}
     </td>
     <td align="right">
      ${post_num} - ${ip_addr}
     </td>
    </tr>
   </table>
  </td>
 </tr>
 <tr>
  <td width="160" class="msg_post" valign="top">

   <!-- $BeginBlock blocation -->
   ${location} : ${p_location}</a><br>
   <!-- $EndBlock blocation -->

   <!-- $BeginBlock bpostermail -->
   <A target="_blank" rel="nofollow" href="mailto:${posteremail}">${email}</a>
   <!-- $EndBlock bpostermail -->

   <!-- $BeginBlock bhomepage -->
   <A target="_blank" rel="nofollow" href="${p_homepage}">${homepage}</a>
   <!-- $EndBlock bhomepage -->

   <br>

   <!-- $BeginBlock baim -->
   <A target="_blank" rel="nofollow" href="aim:goim?screenname=${p_aim}">${aim}</a>
   <!-- $EndBlock baim -->

   <!-- $BeginBlock bmsn -->
   <A target="_blank" rel="nofollow" href="http://members.msn.com/${p_msn}">${msn}</a>
   <!-- $EndBlock bmsn -->

   <!-- $BeginBlock byim -->
   <A target="_blank" rel="nofollow" href="http://edit.yahoo.com/config/send_webmesg?.target=${p_yim}">${yim}</a>
   <!-- $EndBlock byim -->

   <!-- $BeginBlock bicq -->
   <A target="_blank" rel="nofollow" href="http://wwp.icq.com/scripts/search.dll?to=${p_icq}">${icq}</a>
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
  <td width="470" class="msg_post" valign="top">
   ${text}
   <hr>
   <div align="right">
     [ <a href="editmessage.${phpEx}?pid=${pid}">${aem_edit}</a> ] [ <a href="editmessage.${phpEx}?pid=${pid}">${aem_delete}</a> ]
   </div>
  </td>
 </tr>

 <!-- $EndBlock messages --> 

</table>

<table align="center" width="630" border="0" cellpadding="3" cellspacing="0">
 <tr>
  <td align="right" class="msg_links">
   <!-- $BeginBlock FPL -->
    [<a href='?start=0'>${first_page_link}</a>] ...
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

