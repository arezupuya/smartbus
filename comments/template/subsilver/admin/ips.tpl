   <center>
   <font color="#c00000"><b>${acn_updated}</b></font>
   </center>

   <table width=350 align=center border=0 cellpadding=3 cellspacing=1>
    <form action="ips.${phpEx}" method=post>
    <tr>
     <td>
      <font color="#ffffff"><b>${aip_conf}</b></font>
     </td>
    </tr>
    <tr>
     <td bgcolor="#ffffff">
      <b>${aip_add_ip} : </b><input type=text name="ip">
     </td>
    </tr>
    <tr>
     <td bgcolor="#ffffff" align=center>
      <input type=submit name="add_action" Value="${acn_update}">
     </td>
    </tr>
    </form>
   </table>

<p>

   <table width=350 align=center border=0 cellpadding=3 cellspacing=1>
    <form action="ips.${phpEx}" method=post>
    <tr>
     <td>
      <font color="#ffffff"><b>${aip_banned_ips}</b></font>
     </td>
    </tr>
    <tr>
     <td bgcolor="#ffffff">
      <select name="ip[]" multiple="multiple" size="5">

        <!-- Don't change --> 
        <!-- $BeginBlock ips --> 

        <option value=${bid}>${value}</option>

        <!-- $EndBlock ips --> 
        <!-- Don't change -->

      </select>
     </td>
    </tr>
    <tr>
     <td bgcolor="#ffffff" align=center>
      <input type=submit name="del_action" Value="${acn_remove}">
     </td>
    </tr>
    </form>
   </table>

<p>
   ${aip_example}