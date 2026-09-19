   <center>
   <font color="#c00000"><b>${acn_updated}</b></font>
   </center>

   <table width=500 align=center border=0 cellpadding=3 cellspacing=1>
    <form action="validation.${phpEx}" method=post>
    <tr>
     <td>
      <font color="#ffffff"><b>${avm_conf}</b></font>
     </td>
    </tr>
    <tr><td bgcolor="#ffffff">

    <!-- Don't change --> 
    <!-- $BeginBlock messages --> 
    <table width=100% border=0 cellpadding=3 cellspacing=1>
    <tr bgcolor="#ffffff">
     <td width=150>${poster}</td>
     <td width=350>

	<table width=100% border=0 cellpadding=0 cellspacing=0>
	 <tr bgcolor="#ffffff">
	  <td width=50% align=left>${postdate}</td>
	  <td width=50% align=right>${postnum}</td>
	 </tr>
	</table>
	
     </td>
    </tr>
    <tr bgcolor="#ffffff">
     <td>
       <input type=hidden name=pid[] value="${pid}">
       <input type=radio name=action[${pid}] value="add"> ${avm_add}<br>
       <input type=radio name=action[${pid}] value="delete"> ${avm_delete}
     </td>
     <td valign=top>${message}</td>
    </tr>
    </table>
    <p>
    <!-- $EndBlock messages --> 
    <!-- Don't change -->

    ${total_posts} ${avm_wv}
    </td></tr>
    <tr>
     <td bgcolor="#ffffff" align=center>
      <input type=submit name="Update" value="${acn_update}">
     </td>
    </tr>

    </form>

   </table>

   <center>
      ${afc_notes}
   </center>
