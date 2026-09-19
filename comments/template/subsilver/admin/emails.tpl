   <center>
   <font color="#c00000"><b>${acn_updated}</b></font>
   </center>

   <table width=350 align=center border=0 cellpadding=3 cellspacing=1>
    <form action="emails.${phpEx}" method=post>
    <tr>
     <td>
      <font color="#ffffff"><b>${aeb_conf}</b></font>
     </td>
    </tr>
    <tr>
     <td bgcolor="#ffffff">
      <b>${aeb_add_email} : </b><input type=text name="email">
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
    <form action="emails.${phpEx}" method=post>
    <tr>
     <td>
      <font color="#ffffff"><b>${aeb_banned_emails}</b></font>
     </td>
    </tr>
    <tr>
     <td bgcolor="#ffffff">
      <select name="email[]" multiple="multiple" size="5">

        <!-- Don't change --> 
        <!-- $BeginBlock emails --> 

        <option value=${bid}>${value}</option>

        <!-- $EndBlock emails --> 
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
   ${aeb_example}