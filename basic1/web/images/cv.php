<?php

include("conn.php");

$pid = @$_GET['Index'];

if(!isset($pid) || $pid == "")

{

$pid = 25;

}

$sql = "select parent,pagename,bannerimage,body from page where id = $pid";

$con = mysql_query($sql) or die(mysql_error());

if(@mysql_num_rows($con) > 0)

{

$con2 =  mysql_fetch_array($con);

$pagename = $con2['pagename'];

$bannerimage = $con2['bannerimage'];

$body = $con2['body'];

$parent = $con2['parent'];

}

else

{

$bannerimage = "";

}?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Welcome to St. Nicholas ::: <?php echo $pagename?></title>

<LINK href="css/transmenu.css" type=text/css rel=stylesheet>

<link href="css.css" rel="stylesheet" type="text/css" />

<script type="text/javascript">

//Disable select-text script (IE4+, NS6+)

function disableselect(e)

{

    return false

}



function reEnable()

{

    return true

}



//if IE4+

document.onselectstart = new Function ("return false")



//if NS6+

if (window.sidebar)

{

    document.onmousedown = disableselect

    document.onclick = reEnable

}

</script>



<script type="text/javascript">

//Disable right click script

//It works for both firefox and internet explorer

var message="";



function clickIE() {if (document.all) {(message);return false;}}

function clickNS(e) {if 

(document.layers||(document.getElementById&&!document.all)) {

if (e.which==2||e.which==3) {(message);return false;}}}

if (document.layers) 

{document.captureEvents(Event.MOUSEDOWN);document.onmousedown=clickNS;}

else{document.onmouseup=clickNS;document.oncontextmenu=clickIE;}



document.oncontextmenu=new Function("return false")

</script>



<SCRIPT language=javascript src="js/transmenu.js"></SCRIPT>

<SCRIPT language=javascript src="js/js_menu.js"></SCRIPT>

<script type="text/javascript">

<!--

function MM_validateForm() { //v4.0

  if (document.getElementById){

    var i,p,q,nm,test,num,min,max,errors='',args=MM_validateForm.arguments;

    for (i=0; i<(args.length-2); i+=3) { test=args[i+2]; val=document.getElementById(args[i]);

      if (val) { nm=val.name; if ((val=val.value)!="") {

        if (test.indexOf('isEmail')!=-1) { p=val.indexOf('@');

          if (p<1 || p==(val.length-1)) errors+='- '+nm+' must contain an e-mail address.\n';

        } else if (test!='R') { num = parseFloat(val);

          if (isNaN(val)) errors+='- '+nm+' must contain a number.\n';

          if (test.indexOf('inRange') != -1) { p=test.indexOf(':');

            min=test.substring(8,p); max=test.substring(p+1);

            if (num<min || max<num) errors+='- '+nm+' must contain a number between '+min+' and '+max+'.\n';

      } } } else if (test.charAt(0) == 'R') errors += '- '+nm+' is required.\n'; }

    } if (errors) alert('The following error(s) occurred:\n'+errors);

    document.MM_returnValue = (errors == '');

} }

//-->

</script>

<style type="text/css">

<!--

.style1 {color: #FFFFFF}

-->

</style>

</head>



<body>

<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">

  <tr>

    <td class="style1"><table width="1000" border="0" cellspacing="0" cellpadding="0">

      <tr>

        <td valign="top" bgcolor="#FFFFFF"><img src="images/aboutus_01.jpg" width="22" height="760"></td>

        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">

          <tr>

            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">

              <tr>

                <td><img src="images/aboutus_02.jpg" width="290" height="131"></td>

                <td><table width="100%" border="0" cellspacing="0" cellpadding="0">

                    <tr>

                      <td><table width="100%" border="0" cellspacing="0" cellpadding="0">

                        <tr>

                          <td><img src="images/index_03.jpg" width="445" height="55" /></td>

                          <td><table width="100%" border="0" cellspacing="0" cellpadding="0">

                            <tr>

                              <td><img src="images/index_04.jpg" width="221" height="19" /></td>

                            </tr>

                            <tr>

                              <td><img src="images/index_06.jpg" width="221" height="28" /></td>

                            </tr>

                            <tr>

                              <td><img src="images/index_07.jpg" width="221" height="8" /></td>

                            </tr>

                          </table></td>

                        </tr>

                      </table></td>

                    </tr>

                    <tr>

                      <td><?php include("menu.php");?></td>

                    </tr>

                    <tr>

                      <td><img src="images/index_15.jpg" width="666" height="24" /></td>

                    </tr>

                  </table></td>

              </tr>

            </table></td>

          </tr>

          <tr>

            <td>

			<?php

			$src = "cms/uploads/".$bannerimage;

			if(!(file_exists($src) && $bannerimage != ""))

{

if($parent != "")

{

$sqlb = "select bannerimage,parent from page where id = $parent";

$conb = mysql_query($sqlb) or die(mysql_error());

$conarr = mysql_fetch_array($conb);

$bannerimagen = $conarr['bannerimage'];

$parent2 = $conarr['parent'];

$src = "cms/uploads/".$bannerimagen;

if(!(file_exists($src) && $bannerimagen != ""))

{

if($parent2 != "")

{

$sqlb = "select bannerimage,parent from page where id = $parent2";

$conb = mysql_query($sqlb) or die(mysql_error());

$conarr = mysql_fetch_array($conb);

$bannerimagen = $conarr['bannerimage'];

$src = "cms/uploads/".$bannerimagen;

if(!(file_exists($src) && $bannerimagen != ""))

{

$src = "images/aboutus1_16.jpg";

}

}

else

{

$src = "images/aboutus1_16.jpg";

			}

			}

			}

			else

			{

			$src = "images/aboutus1_16.jpg";

			}

			}

			?>

			<img src="images/careers.jpg" width="956" height="223"></td>

          </tr>

          <tr>

            <td><table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">

              <tr>

                <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">

                  <tr>

                    <td valign="top"><table width="215" border="0" cellspacing="0" cellpadding="0">

                      <tr>

                        <td><?php include("inc_services.php");?></td>

                        <td>&nbsp;</td>

                      </tr>

                    </table></td>

                  </tr>

                  <tr>

                    <td><img src="images/aboutus1_23.jpg" width="215" height="165"></td>

                  </tr>

                </table></td>

                <td valign="top" style="padding-left:"><table width="90%" border="0" cellspacing="0" cellpadding="0">

                  <tr>

                    <td><img src="images/aboutus1_18.jpg" width="450" height="15"></td>

                  </tr>

                  <tr>

                    <td background="images/aboutus_hd.jpg" style="background-repeat:no-repeat"><table width="450" height="31" border="0" cellspacing="0" cellpadding="0">

                      <tr>

                        <td width="10"><img src="images/spacer.gif" alt="" width="20" height="20" /></td>

                        <td width="440" class="contentheader3" onfocus="MM_validateForm('Name','','R','lName','','R','email','','NisEmail','pno','','R');return document.MM_returnValue">Careers</td>

                      </tr>

                    </table></td>

                  </tr>

                  <tr valign="top">

                    <td width="86%" class="content" style="padding-left:10px; padding-top:10px"><form action="uploadcvaction.php" method="post" name="ks" id="ks" enctype="multipart/form-data" onsubmit="MM_validateForm('name','','R','company','','R','street','','R','locality','','R','city','','R','pin','','R','phone','','RisNum','MobileNo','','RisNum','email','','R','std','','R','fax','','RisNum','appointmentno','','RisNum','date','','R','appointmenttime','','R','regno','','R','vin','','R','engine','','R','mileage','','R','bookingdate','','R','bookingtime','','R','email','','NisEmail');return document.MM_returnValue">

                     <table width="100%" border="0" cellpadding="3" cellspacing="0" onfocus="MM_validateForm('Fname','','R','lname','','R','email','','NisEmail','pno','','R');return document.MM_returnValue">

                       <tr>

                         <td colspan="4" align="right" valign="middle"><?php

						 if ($body != "" && ($pid  == 98 || $pid  == 148 || $pid  == 93 || $pid  == 94 || $pid  == 149 || $pid  == 151 || $pid == 91 || $pid  == 153 || $pid  == 154 || $pid == 155))

						 {

						 

								 echo $body	;	

								 }

								 

								 else		

								 {

						 

								 //echo $body;		
								 }		 

						 

						               ?></td>

                         </tr>

                       <tr>

                         <td width="28%" align="right" valign="middle">First Name<span class="star">*</span></td>

                         <td width="40%"><input type="text" name="x_Name" id="Name" value="<?php echo htmlspecialchars(@$x_Name) ?>" /></td>

                         <td width="2%" align="right" valign="middle">&nbsp;</td>

                         <td width="30%">&nbsp;</td>

                       </tr>

                       <tr>

                         <td align="right" valign="middle">Last Name<span class="star">*</span></td>

                         <td><input type="text" name="x_lName" id="lName" value="<?php echo htmlspecialchars(@$x_lName) ?>" /></td>

                         <td align="right" valign="middle">&nbsp;</td>

                         <td>&nbsp;</td>

                       </tr>

                       <tr>

                         <td align="right" valign="middle">Email Address<span class="star">*</span></td>

                         <td><input name="x_Email_Address" value="<?php echo htmlspecialchars(@$x_Email_Address) ?>" type="text" id="email" onblur="MM_validateForm('textfield14','','R','textfield15','','R','textfield16','','RisEmail','textfield17','','R','textfield3','','R');return document.MM_returnValue" /></td>

                         <td align="right" valign="middle">&nbsp;</td>

                         <td>&nbsp;</td>

                       </tr>

                       <tr>

                         <td align="right" valign="middle">Phone Number<span class="star">*</span></td>

                         <td><input type="text" name="x_Telephone" id="pno" value="<?php echo htmlspecialchars(@$x_Telephone) ?>" /></td>

                         <td align="right" valign="middle">&nbsp;</td>

                         <td>&nbsp;</td>

                       </tr>

                       <tr>

                         <td align="right" valign="middle">Upload CV<span class="star"></span></td>

                         <td colspan="3"><?php echo @$x_message; ?><input name="filename" type="file" id="filename" /></td>

                       </tr>

                       <tr>

                         <td align="right" valign="middle">&nbsp;</td>

                         <td><input name="imageField3" type="image" id="imageField3" style="width:auto; padding:inherit; border:none;" onclick="MM_validateForm('textfield14','','R','textfield15','','R','textfield16','','R','textfield17','','R');return document.MM_returnValue" src="images/btn-submit.jpg" /></td>

                         <td>&nbsp;</td>

                         <td>&nbsp;</td>

                       </tr>

                     </table>

                     </form> </td>

                  </tr>

                </table></td>

                <td valign="top">&nbsp;</td>

              </tr>

            </table></td>

          </tr>

        </table>

          </td>

        <td valign="top" bgcolor="#FFFFFF"><img src="images/aboutus_05.jpg" width="22" height="760"></td>

      </tr>

    </table></td>

  </tr>

</table>

<span class="style1">

<?php include("inc_footer.php")?>

<?php include("inc_transmenu.php")?>

</span>



<map name="Map" id="Map"><area shape="rect" coords="215,86,273,110" href="pages.php?Index=40" />

</map>

</body>

