   <center>
   <font color="#c00000"><b>${acn_updated}</b></font>
   </center>

   <table align=center border=0 cellpadding=3 cellspacing=1>
    <form action="smilies.${phpEx}" method=post>
    <tr>
     <td colspan=5>
      <font color="#ffffff"><b>${asm_conf}</b></font>
     </td>
    </tr>


    <tr>
     <td bgcolor="#ffffff">
      &nbsp;
     </td>
     <td bgcolor="#ffffff">
      <b>${asm_code}</b>
     </td>
     <td bgcolor="#ffffff">
      <b>${asm_smile_url}</b>
     </td>
     <td bgcolor="#ffffff">
      <b>${asm_emoticon}</b>
     </td>
     <td bgcolor="#ffffff">
      <b>${asm_delete}</b>
     </td>
    </tr>

    <!-- Don't change --> 
    <!-- $BeginBlock smilies --> 
    <tr>
     <input type=hidden name=sm_sid[] value="${sm_sid}">
     <td bgcolor="#ffffff">
      <img src="../images/smilies/${sm_smile_url}">
     </td>
     <td bgcolor="#ffffff">
      <input type=text name=sm_code[] value="${sm_code}">
     </td>
     <td bgcolor="#ffffff">
      <input type=text name=sm_smile_url[] value="${sm_smile_url}">
     </td>
     <td bgcolor="#ffffff">
      <input type=text name=sm_emoticon[] value="${sm_emoticon}">
     </td>
     <td bgcolor="#ffffff" align="center">
      <input type=checkbox name=sm_delete[${sm_sid}] value="1">
     </td>
    </tr>
    <!-- $EndBlock smilies --> 
    <!-- Don't change -->

    <tr>
     <td bgcolor="#ffffff">
     </td>
     <td bgcolor="#ffffff">
      <input type=text name=sm_code_add value="">
     </td>
     <td bgcolor="#ffffff">
      <input type=text name=sm_smile_url_add value="">
     </td>
     <td bgcolor="#ffffff">
      <input type=text name=sm_emoticon_add value="">
     </td>
     <td bgcolor="#ffffff" align="center">
     </td>
    </tr>


    <tr>
     <td bgcolor="#ffffff" colspan=5 align=center>
      <input type=submit name="Update" value="${acn_update}">
     </td>
    </tr>

    </form>

   </table>

   <center>
      ${afc_notes}
   </center>
