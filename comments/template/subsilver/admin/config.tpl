   <center>
   <font color="#c00000"><b>${acn_updated}</b></font>
   </center>

   <table align=center border=0 cellpadding=3 cellspacing=1>
    <form action="config.${phpEx}" method=post>
    <tr>
     <td colspan=2>
      <font color="#ffffff"><b>${acn_cn}</b></font>
     </td>
    </tr>

    <tr>
     <td bgcolor="#ffffff">
      <b>${acn_an}</b> : 
     </td>
     <td bgcolor="#ffffff">
      <input type=text name=admin_name value="${admin_name}">
     </td>
    </tr>

    <tr>
     <td bgcolor="#ffffff">
      <b>${acn_ap}</b> : 
     </td>
     <td bgcolor="#ffffff">
      <input type=password name=admin_pass value="">
     </td>
    </tr>

    <tr>
     <td bgcolor="#ffffff">
      <b>${acn_amail}</b> : 
     </td>
     <td bgcolor="#ffffff">
      <input type=text name=admin_mail value="${admin_mail}">
     </td>
    </tr>

    <tr>
     <td bgcolor="#ffffff">
      <b>${acn_title}</b> : 
     </td>
     <td bgcolor="#ffffff">
      <input type=text name=gb_title value="${gb_title}">
     </td>
    </tr>

    <tr>
     <td bgcolor="#ffffff">
      <b>${acn_webpath}</b> : 
     </td>
     <td bgcolor="#ffffff">
      <input type=text name=gb_webpath value="${gb_webpath}">
     </td>
    </tr>

    <tr>
     <td bgcolor="#ffffff">
      <b>${acn_uwc}</b> : 
     </td>
     <td bgcolor="#ffffff">
      <select name="word_censor">
       <option value="1" ${uwc_selected1}>${oa_on}</option>
       <option value="0" ${uwc_selected0}>${oa_off}</option>
      </select>
     </td>
    </tr>

    <tr>
     <td bgcolor="#ffffff">
      <b>${acn_uvc}</b> : 
     </td>
     <td bgcolor="#ffffff">
      <select name="captcha">
       <option value="1" ${uvc_selected1}>${oa_on}</option>
       <option value="0" ${uvc_selected0}>${oa_off}</option>
      </select>
     </td>
    </tr>

    <tr>
     <td bgcolor="#ffffff">
      <b>${acn_uav}</b> : 
     </td>
     <td bgcolor="#ffffff">
      <select name="admin_valid">
       <option value="1" ${uav_selected1}>${oa_on}</option>
       <option value="0" ${uav_selected0}>${oa_off}</option>
      </select>
     </td>
    </tr>

    <tr>
     <td bgcolor="#ffffff">
      <b>${acn_enot}</b> : 
     </td>
     <td bgcolor="#ffffff">
      <select name="enot">
       <option value="1" ${enot_selected1}>${oa_on}</option>
       <option value="0" ${enot_selected0}>${oa_off}</option>
      </select>
     </td>
    </tr>

    <tr>
     <td bgcolor="#ffffff">
      <b>${acn_ah}</b> : 
     </td>
     <td bgcolor="#ffffff">
      <select name="allow_html">
       <option value="1" ${ah_selected1}>${oa_on}</option>
       <option value="0" ${ah_selected0}>${oa_off}</option>
      </select>
     </td>
    </tr>

    <tr>
     <td bgcolor="#ffffff">
      <b>${acn_aht}</b> : 
     </td>
     <td bgcolor="#ffffff">
      <input type=text name="allowed_tags" value="${allowed_tags}">
     </td>
    </tr>

    <tr>
     <td bgcolor="#ffffff">
      <b>${acn_dt}</b> : 
     </td>
     <td bgcolor="#ffffff">
      <select name="template">
        <!-- Don't change --> 
	<!-- $BeginBlock templates --> 
         <option value="${template_name}" ${tselected}>${template_name}</option>
       <!-- $EndBlock templates --> 
       <!-- Don't change -->
      </select>
     </td>
    </tr>

    <tr>
     <td bgcolor="#ffffff">
      <b>${acn_dl}</b> : 
     </td>
     <td bgcolor="#ffffff">
      <select name="lang">
        <!-- Don't change --> 
	<!-- $BeginBlock languages --> 
         <option value="${language_name}" ${lselected}>${language_name}</option>
       <!-- $EndBlock languages --> 
       <!-- Don't change -->
      </select>
     </td>
    </tr>

    <tr>
     <td bgcolor="#ffffff">
      <b>${acn_gc}</b> : 
     </td>
     <td bgcolor="#ffffff">
      <select name="gzip">
       <option value="1" ${gc_selected1}>${oa_on}</option>
       <option value="0" ${gc_selected0}>${oa_off}</option>
      </select>
     </td>
    </tr>

    <tr>
     <td bgcolor="#ffffff">
      <b>${acn_min}</b> : 
     </td>
     <td bgcolor="#ffffff">
      <input type=text name="min_len" value="${min_len}">
     </td>
    </tr>

    <tr>
     <td bgcolor="#ffffff">
      <b>${acn_max}</b> : 
     </td>
     <td bgcolor="#ffffff">
      <input type=text name="max_len" value="${max_len}">
     </td>
    </tr>

    <tr>
     <td bgcolor="#ffffff">
      <b>${acn_mwl}</b> : 
     </td>
     <td bgcolor="#ffffff">
      <input type=text name="max_word_lenght" value="${max_word_lenght}">
     </td>
    </tr>

    <tr>
     <td bgcolor="#ffffff">
      <b>${acn_fc}</b> : 
     </td>
     <td bgcolor="#ffffff">
      <input type=text name="flood_time" value="${flood_time}">
     </td>
    </tr>

    <tr>
     <td bgcolor="#ffffff">
      <b>${acn_pp}</b> : 
     </td>
     <td bgcolor="#ffffff">
      <input type=text name="per_page" value="${per_page}">
     </td>
    </tr>

    <tr>
     <td bgcolor="#ffffff">
      <b>${acn_tz}</b> : 
     </td>
     <td bgcolor="#ffffff">
      <select name="timezone">
        <!-- Don't change --> 
	<!-- $BeginBlock timezone --> 
         <option value="${tz_value}" ${tzselected}>${tz_value_disp}</option>
       <!-- $EndBlock timezone --> 
       <!-- Don't change -->
      </select>
     </td>
    </tr>

    <tr>
     <td bgcolor="#ffffff" colspan=2 align=center>
      <input type=submit name="Update" value="${acn_update}">
     </td>
    </tr>

    </form>

   </table>

