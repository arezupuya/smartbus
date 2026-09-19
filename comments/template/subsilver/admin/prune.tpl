<p>
   <center>
   <font color="#c00000"><b>${ap_removed}</b></font>
   </center>
<p>
<form action="prune.${phpEx}" method=post>
${ap_remove_b} 
<select name=days>
 <option value=30>30</option>
 <option value=90>90</option>
 <option value=180>180</option>
 <option value=360>360</option>
</select>
${ap_remove_a}
<input type=submit name="Update" value="${ap_prune}">
</form>