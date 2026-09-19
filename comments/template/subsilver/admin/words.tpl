   <center>
   <font color="#c00000"><b>${acn_updated}</b></font>
   </center>

   <table width=350 align=center border=0 cellpadding=3 cellspacing=1>
    <form action="words.${phpEx}" method=post>
    <tr>
     <td>
      <font color="#ffffff"><b>${aw_conf}</b></font>
     </td>
    </tr>
    <tr>
     <td bgcolor="#ffffff">
      <b>${aw_add_word} : </b><input type=text name="word">
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
    <form action="words.${phpEx}" method=post>
    <tr>
     <td>
      <font color="#ffffff"><b>${aw_banned_words}</b></font>
     </td>
    </tr>
    <tr>
     <td bgcolor="#ffffff">
      <select name="word[]" multiple="multiple" size="5">

        <!-- Don't change --> 
        <!-- $BeginBlock words --> 

        <option value=${bid}>${value}</option>

        <!-- $EndBlock words --> 
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
