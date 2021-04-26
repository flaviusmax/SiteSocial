<?php

  require_once 'header.php';



?>
 <div class="data3"><h2 class="">   &nbsp;&nbsp; CONTACTAŢI ADMINISTRATORUL</h2>
<form name="contactform" method="post" action="send_form_email.php">
<table width="450px">
<tr>
 <td valign="top">
  <label for="first_name">Nume *</label>
 </td>
 <td valign="top">
  <input  type="text" name="first_name" maxlength="50" size="30">
 </td>
</tr>
<tr>
 <td valign="top"">
  <label for="last_name">Prenume *</label>
 </td>
 <td valign="top">
  <input  type="text" name="last_name" maxlength="50" size="30">
 </td>
</tr>
<tr>
 <td valign="top">
  <label for="email">Email *</label>
 </td>
 <td valign="top">
  <input  type="email" name="email" maxlength="80" size="30">
 </td>
</tr>
<tr>
 <td valign="top">
  <label for="telephone">Telefon </label>
 </td>
 <td valign="top">
  <input  type="text" name="telephone" maxlength="30" size="30">
 </td>
</tr>
<tr>
 <td valign="top">
  <label for="comments">Mesaj *</label>
 </td>
 <td valign="top">
  <textarea  name="comments" maxlength="250" cols="30" rows="3" placeholder="Aici scrieţi mesajul dorit"></textarea>
 </td>
</tr>
<tr>
 <td colspan="2" style="text-align:center">
  <input type="submit" value="Trimite">
 </td>
</tr>
</table>
</form>
</div>

  </body>
</html>