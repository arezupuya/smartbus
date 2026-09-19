<html>
<head>
<title>${TITLE}</title>
<meta http-equiv="Content-Type" content="${content}">
<LINK REL ='stylesheet' TYPE='text/css' HREF='../template/subsilver/style.css' TITLE='Style'>
</head>
<body>

<p>
<table align=center border=0 cellpadding=4 cellspacing=2 width=300>
 <tr>
  <td bgcolor="#ffffff">

   <table border=0 cellpadding=4 cellspacing=0 width=100%>
   <form action="index.${phpEx}" method="POST">
    <tr>
     <td bgcolor="#8080FF" align=center colspan=2>
      <b><font color="#ffffff">${lf_title}</font></b>
     </td>
    </tr>
    <tr bgcolor="#ffffff">
     <td align=right>
      <b>${lf_user}</b>
     </td>
     <td align=left>
      <input type=text name="admin_name">
     </td>
    </tr>
    <tr bgcolor="#ffffff">
     <td align=right>
      <b>${lf_pass}</b>
     </td>
     <td align=left>
      <input type=password name="admin_pass">
     </td>
    </tr>
    <tr bgcolor="#ffffff">
     <td align=center colspan=2>
      <input type=submit name=login value="${lf_login}">
      <input type=reset value="${lf_reset}">
     </td>
    </tr>
   </form>
   </table>

  </td>
 </tr>
</table>
<center>
 <font color=red>${lf_error}</font>
</center>

  </td>
 </tr>
</table>

</body>
</html>