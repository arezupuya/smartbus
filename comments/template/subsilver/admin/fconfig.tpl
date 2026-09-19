   <center>
   <font color="#c00000"><b>${acn_updated}</b></font>
   </center>

   <table align=center border=0 cellpadding=3 cellspacing=1>
    <form action="fconfig.${phpEx}" method=post>
    <tr>
     <td colspan=4>
      <font color="#ffffff"><b>${afc_fc}</b></font>
     </td>
    </tr>


    <tr>
     <td bgcolor="#ffffff">
      &nbsp;
     </td>
     <td bgcolor="#ffffff">
      <b>${afc_enabled}</b>
     </td>
     <td bgcolor="#ffffff">
      <b>${afc_required}</b>
     </td>
     <td bgcolor="#ffffff">
       <b>${afc_field_name}</b>
     </td>
    </tr>

    <tr>
     <td bgcolor="#ffffff">
      <b>${afc_email}</b> : 
     </td>
     <td align=center bgcolor="#ffffff">
      <input ${em_e} type=checkbox name=poster_mail value="${poster_mail}">
     </td>
     <td align=center bgcolor="#ffffff">
      <input ${em_r} type=checkbox name=poster_mail_req value="${poster_mail_req}">
     </td>
     <td align=center bgcolor="#ffffff">
      &nbsp;
     </td>
    </tr>

    <tr>
     <td bgcolor="#ffffff">
      <b>${afc_location}</b> : 
     </td>
     <td align=center bgcolor="#ffffff">
      <input ${pl_e} type=checkbox name=poster_location value="${poster_location}">
     </td>
     <td align=center bgcolor="#ffffff">
      <input ${pl_r} type=checkbox name=poster_location_req value="${poster_location_req}">
     </td>
     <td align=center bgcolor="#ffffff">
      &nbsp;
     </td>
    </tr>

    <tr>
     <td bgcolor="#ffffff">
      <b>${afc_msn}</b> : 
     </td>
     <td align=center bgcolor="#ffffff">
      <input ${msn_e} type=checkbox name=msn value="${msn}">
     </td>
     <td align=center bgcolor="#ffffff">
      <input ${msn_r} type=checkbox name=msn_req value="${msn_req}">
     </td>
     <td align=center bgcolor="#ffffff">
      &nbsp;
     </td>
    </tr>

    <tr>
     <td bgcolor="#ffffff">
      <b>${afc_aim}</b> : 
     </td>
     <td align=center bgcolor="#ffffff">
      <input ${aim_e} type=checkbox name=aim value="${aim}">
     </td>
     <td align=center bgcolor="#ffffff">
      <input ${aim_r} type=checkbox name=aim_req value="${aim_req}">
     </td>
     <td align=center bgcolor="#ffffff">
      &nbsp;
     </td>
    </tr>

    <tr>
     <td bgcolor="#ffffff">
      <b>${afc_yim}</b> : 
     </td>
     <td align=center bgcolor="#ffffff">
      <input ${yim_e} type=checkbox name=yim value="${yim}">
     </td>
     <td align=center bgcolor="#ffffff">
      <input ${yim_r} type=checkbox name=yim_req value="${yim_req}">
     </td>
     <td align=center bgcolor="#ffffff">
      &nbsp;
     </td>
    </tr>

    <tr>
     <td bgcolor="#ffffff">
      <b>${afc_homepage}</b> : 
     </td>
     <td align=center bgcolor="#ffffff">
      <input ${homepage_e} type=checkbox name=homepage value="${homepage}">
     </td>
     <td align=center bgcolor="#ffffff">
      <input ${homepage_r} type=checkbox name=homepage_req value="${homepage_req}">
     </td>
     <td align=center bgcolor="#ffffff">
      &nbsp;
     </td>
    </tr>

    <tr>
     <td bgcolor="#ffffff">
      <b>${afc_icq}</b> : 
     </td>
     <td align=center bgcolor="#ffffff">
      <input ${icq_e} type=checkbox name=icq value="${icq}">
     </td>
     <td align=center bgcolor="#ffffff">
      <input ${icq_r} type=checkbox name=icq_req value="${icq_req}">
     </td>
     <td align=center bgcolor="#ffffff">
      &nbsp;
     </td>
    </tr>

    <tr>
     <td bgcolor="#ffffff">
      <b>${afc_gender}</b> : 
     </td>
     <td align=center bgcolor="#ffffff">
      <input ${gender_e} type=checkbox name=gender value="${gender}">
     </td>
     <td align=center bgcolor="#ffffff">
      <input ${gender_r} type=checkbox name=gender_req value="${gender_req}">
     </td>
     <td align=center bgcolor="#ffffff">
      &nbsp;
     </td>
    </tr>

    <tr>
     <td bgcolor="#ffffff">
      <b>${afc_age}</b> : 
     </td>
     <td align=center bgcolor="#ffffff">
      <input ${age_e} type=checkbox name=age value="${age}">
     </td>
     <td align=center bgcolor="#ffffff">
      <input ${age_r} type=checkbox name=age_req value="${age_req}">
     </td>
     <td align=center bgcolor="#ffffff">
      &nbsp;
     </td>
    </tr>

    <tr>
     <td bgcolor="#ffffff">
      <b>${afc_c_field_1}</b> : 
     </td>
     <td align=center bgcolor="#ffffff">
      <input ${c_field_1_e} type=checkbox name=c_field_1 value="${c_field_1}">
     </td>
     <td align=center bgcolor="#ffffff">
      <input ${c_field_1_r} type=checkbox name=c_field_1_req value="${c_field_1_req}">
     </td>
     <td align=center bgcolor="#ffffff">
      <input type=text name=c_field_1_name value="${c_field_1_name}">
     </td>
    </tr>

    <tr>
     <td bgcolor="#ffffff">
      <b>${afc_c_field_2}</b> : 
     </td>
     <td align=center bgcolor="#ffffff">
      <input ${c_field_2_e} type=checkbox name=c_field_2 value="${c_field_2}">
     </td>
     <td align=center bgcolor="#ffffff">
      <input ${c_field_2_r} type=checkbox name=c_field_2_req value="${c_field_2_req}">
     </td>
     <td align=center bgcolor="#ffffff">
      <input type=text name=c_field_2_name value="${c_field_2_name}">
     </td>
    </tr>

    <tr>
     <td bgcolor="#ffffff">
      <b>${afc_c_field_3}</b> : 
     </td>
     <td align=center bgcolor="#ffffff">
      <input ${c_field_3_e} type=checkbox name=c_field_3 value="${c_field_3}">
     </td>
     <td align=center bgcolor="#ffffff">
      <input ${c_field_3_r} type=checkbox name=c_field_3_req value="${c_field_3_req}">
     </td>
     <td align=center bgcolor="#ffffff">
      <input type=text name=c_field_3_name value="${c_field_3_name}">
     </td>
    </tr>

    <tr>
     <td bgcolor="#ffffff">
      <b>${afc_c_field_4}</b> : 
     </td>
     <td align=center bgcolor="#ffffff">
      <input ${c_field_4_e} type=checkbox name=c_field_4 value="${c_field_4}">
     </td>
     <td align=center bgcolor="#ffffff">
      <input ${c_field_4_r} type=checkbox name=c_field_4_req value="${c_field_4_req}">
     </td>
     <td align=center bgcolor="#ffffff">
      <input type=text name=c_field_4_name value="${c_field_4_name}">
     </td>
    </tr>

    <tr>
     <td bgcolor="#ffffff">
      <b>${afc_c_field_5}</b> : 
     </td>
     <td align=center bgcolor="#ffffff">
      <input ${c_field_5_e} type=checkbox name=c_field_5 value="${c_field_5}">
     </td>
     <td align=center bgcolor="#ffffff">
      <input ${c_field_5_r} type=checkbox name=c_field_5_req value="${c_field_5_req}">
     </td>
     <td align=center bgcolor="#ffffff">
      <input type=text name=c_field_5_name value="${c_field_5_name}">
     </td>
    </tr>

    <tr>
     <td bgcolor="#ffffff" colspan=4 align=center>
      <input type=submit name="Update" value="${acn_update}">
     </td>
    </tr>

    </form>

   </table>

   <center>
      ${afc_notes}
   </center>
