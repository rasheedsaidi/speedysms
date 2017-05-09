<table width="217" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top" bgcolor="#8E8EBA"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              
			 
		
              
			   <?php
			   function seoUrl2($string) 
				{
					//Unwanted:  {UPPERCASE} ; / ? : @ & = + $ , . ! ~ * ' ( )
					$string = strtolower($string);
					//Strip any unwanted characters
					$string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
					//Clean multiple dashes or whitespaces
					$string = preg_replace("/[\s-]+/", " ", $string);
					//Convert whitespaces and underscore to dash
					$string = preg_replace("/[\s_]/", "_", $string);
					return $string;
				}
			   
				  if(@$parent > 0 && @$useparent == 1)
				  {
				  }
				  else
				  {
				  	$parent = $pid;
				  }
				  $lsql = "Select noalias,PageName,id,pageurl from page where parent = ".$parent." and `show` = 1 order by v_int,id desc";
				  $con = mysql_query($lsql) or die(mysql_error());
				  	while($con2 = mysql_fetch_array($con))
					{
						$cct = "?";
						$dpageurl = "pages.php";
						$subid = $con2["id"];
						if(@$con2["pageurl"] != "")
						{ 
							$dpageurl = @$con2["pageurl"];
							if(strpos($dpageurl,"?") > 0)
							{
								$cct = "&";
							}
						}
						
							if($subid == $pid)
							{
								$bg = "#18183E";
							}
							else
							{
								$bg = "";
							}
					?>
			 
                          <tr>
                            <td width="5%"  bgcolor="<?php echo $bg?>"><img src="../images/spacer.gif" width="20" height="25" /></td>
                            <td width="95%" class="footer"  bgcolor="<?php echo $bg?>"><?php if(strpos($dpageurl,"http") > 0)
							{
								?>
								<a href="<?php echo $dpageurl;?>"  target="_blank"><?php echo $con2["PageName"];?></a>
								<?php
							}
							else
							{
							
								if(strpos($dpageurl,"gid") > 0)
								{
								?>
								<a href="http://www.cwlgroup.com/<?php echo str_replace(".php","",$dpageurl)?>"><?php echo $con2["PageName"];?></a>
								<?php
								}
								else
								{
								if($con2["noalias"] != '1'){
if ($con2["pageName"] = 'Vol1 No1 2014') {
 $dpageurl = $dpageurl . '-vol1_no1_2014.php';
}
								?>
                                <a href="http://www.cwlgroup.com/<?php echo str_replace(".php","",$dpageurl)?>"><?php echo $con2["PageName"];?></a>
                                
                                <!--<a href="http://www.cwlgroup.com/<?php //echo str_replace(".php","",$dpageurl)?>-<?php //echo seoUrl2($con2["PageName"]);?>"><?php //echo $con2["PageName"];?></a>-->
                                <?php
								}
								else
								{
								?>
                                 <a href="http://www.cwlgroup.com/<?php echo str_replace(".php","",$dpageurl)?>"><?php echo $con2["PageName"];?></a>
                                <?php
								}
								}
							}
						?></td>
              </tr>
			  
			   <?php
				  }
				  ?>
			  
           
            </table></td>
          </tr>
          <tr>
            <td valign="top" bgcolor="#FFFFFF"><img src="../images/spacer.gif" alt="" width="217" height="25" /></td>
          </tr>
          <tr>
            <td valign="top" bgcolor="#FFFFFF"><table width="217" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td bgcolor="#DDDDDD"><table width="217" height="30" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td class="contentheader">CONTACT US</td>
                    </tr>
                </table></td>
              </tr>
              <tr>
                <td><img src="../images/index_34.jpg" width="217" height="114" alt="" /></td>
              </tr>
              <tr>
                <td bgcolor="#CCCCCC"><img src="../images/spacer.gif" alt="" width="217" height="5" /></td>
              </tr>
              <tr>
                <td bgcolor="#DDDDDD"></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td valign="top" bgcolor="#FFFFFF"><img src="../images/spacer.gif" alt="" width="217" height="25" /></td>
          </tr>
          <tr>
            <td valign="top" bgcolor="#434371"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td bgcolor="#434371"><img src="../images/spacer.gif" alt="" width="20" height="25" /></td>
                <td bgcolor="#434371" class="footer"><strong>QUICK LINKS</strong></td>
              </tr>
              <tr>
                <td width="5%"><img src="../images/spacer.gif" width="20" height="25" /></td>
                <td width="95%" class="footer"><a href="http://www.cwlgroup.com/">Computer Warehouse Group</a></td>
              </tr>
              <tr>
                <td><img src="../images/spacer.gif" alt="" width="20" height="25" /></td>
                <td class="footer"><a href="http://www.cwlgroup.com/pages-cwl_new">CWL Systems</a></td>
              </tr>
              <tr>
                <td><img src="../images/spacer.gif" alt="" width="20" height="25" /></td>
                <td class="footer"><a href="http://www.cwlgroup.com/pages-dcc_networks">DCC Networks</a></td>
              </tr>
              <tr>
                <td><img src="../images/spacer.gif" alt="" width="20" height="25" /></td>
                <td class="footer"><a href="http://www.cwlgroup.com/pages-expertedge_software">Expert Edge Software</a></td>
              </tr>
              <tr>
                <td><img src="../images/spacer.gif" alt="" width="20" height="25" /></td>
                <td class="footer"><a href="http://www.cwlgroup.com/pages-expertedge_training_center">Expert Edge Training Center</a></td>
              </tr>
            </table></td>
          </tr>
        </table>