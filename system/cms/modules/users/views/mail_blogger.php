<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
   <head>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
      <title><?php echo $subject; ?></title>

      <style type="text/css">
         /* Client-specific Styles */
         #outlook a {padding:0;} /* Force Outlook to provide a "view in browser" menu link. */
         body{width:100% !important; -webkit-text-size-adjust:100%; -ms-text-size-adjust:100%; margin:0; padding:0;}
         /* Prevent Webkit and Windows Mobile platforms from changing default font sizes, while not breaking desktop design. */
         .ExternalClass {width:100%;} /* Force Hotmail to display emails at full width */
         .ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {line-height: 100%;} /* Force Hotmail to display normal line spacing.*/
         #backgroundTable {margin:0; padding:0; width:100% !important; line-height: 100% !important;}
         img {outline:none; text-decoration:none;border:none; -ms-interpolation-mode: bicubic;}
         a img {border:none;}
         .image_fix {display:block;}
         p {margin: 0px 0px !important;}
         table td {border-collapse: collapse;}
         table { border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt; }
         a {color: #0a8cce;text-decoration: none;text-decoration:none!important;}
         /*STYLES*/
         table[class=full] { width: 100%; clear: both; }
         /*IPAD STYLES*/
         @media only screen and (max-width: 640px) {
         a[href^="tel"], a[href^="sms"] {
         text-decoration: none;
         color: #0a8cce; /* or whatever your want */
         pointer-events: none;
         cursor: default;
         }
         .mobile_link a[href^="tel"], .mobile_link a[href^="sms"] {
         text-decoration: default;
         color: #0a8cce !important;
         pointer-events: auto;
         cursor: default;
         }
         table[class=devicewidth] {width: 440px!important;text-align:center!important;}
         table[class=devicewidthinner] {width: 420px!important;text-align:center!important;}
         img[class=banner] {width: 440px!important;height:220px!important;}
         img[class=colimg2] {width: 440px!important;height:220px!important;}


         }
         /*IPHONE STYLES*/
         @media only screen and (max-width: 480px) {
         a[href^="tel"], a[href^="sms"] {
         text-decoration: none;
         color: #0a8cce; /* or whatever your want */
         pointer-events: none;
         cursor: default;
         }
         .mobile_link a[href^="tel"], .mobile_link a[href^="sms"] {
         text-decoration: default;
         color: #0a8cce !important;
         pointer-events: auto;
         cursor: default;
         }
         table[class=devicewidth] {width: 280px!important;text-align:center!important;}
         table[class=devicewidthinner] {width: 260px!important;text-align:center!important;}
         img[class=banner] {width: 280px!important;height:140px!important;}
         img[class=colimg2] {width: 280px!important;height:140px!important;}
         td[class=mobile-hide]{display:none!important;}
         td[class="padding-bottom25"]{padding-bottom:25px!important;}

         }
      </style>
   </head>
   <body>
<!-- Start of preheader -->
<table width="100%" bgcolor="#ffffff" cellpadding="0" cellspacing="0" border="0" id="backgroundTable" st-sortable="preheader" >
   <tbody>
      <tr>
         <td>
            <table width="600" cellpadding="0" cellspacing="0" border="0" align="center" class="devicewidth">
               <tbody>
                  <tr>
                     <td width="100%">
                        <table width="600" cellpadding="0" cellspacing="0" border="0" align="center" class="devicewidth">
                           <tbody>
                              <!-- Spacing -->
                              <tr>
                                 <td width="100%">
                                    <img src="<?php echo site_url('addons/default/themes/wyeth/img/email-top.png'); ?>" alt="" border="0" width="100%" style="display:block; border:none; outline:none; text-decoration:none;">
                                 </td>
                              </tr>
                           </tbody>
                        </table>
                     </td>
                  </tr>
               </tbody>
            </table>
         </td>
      </tr>
   </tbody>
</table>
<!-- End of preheader -->
<!-- Start Full Text -->
<table width="100%" bgcolor="#ffffff" cellpadding="0" cellspacing="0" border="0" id="backgroundTable" st-sortable="full-text">
   <tbody>
      <tr>
         <td>
            <table width="600" cellpadding="0" cellspacing="0" border="0" align="center" class="devicewidth">
               <tbody>
                  <tr>
                     <td width="100%">
                        <table width="600" cellpadding="0" cellspacing="0" border="0" align="center" class="devicewidth">
                           <tbody>
                               <tr>
                                 <td>
                                    <table width="480" align="center" cellpadding="0" cellspacing="0" border="0" class="devicewidthinner">
                                       <tbody>
                                          <!-- Title -->
                                          <tr>
                                             <td style="font-family: Helvetica, arial, sans-serif; font-size: 30px; color: #333333; text-align:center; line-height: 30px;" st-title="fulltext-heading">
                                                <?php echo $headline; ?>
                                             </td>
                                          </tr>
                                          <!-- End of Title -->
                                          <!-- spacing -->
                                          <tr>
                                             <td width="100%" height="20" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">&nbsp;</td>
                                          </tr>

                                          <tr>
                                             <td style="font-family: Helvetica, arial, sans-serif; font-size: 16px; color: #666666; text-align:center; line-height: 30px;" st-content="fulltext-content">
                                                Hello <?=$name?>..
                                             </td>
                                          </tr>
                                          <!-- End of spacing -->
                                          <!-- content -->
                                          <tr>
                                             <td style="font-family: Helvetica, arial, sans-serif; font-size: 16px; color: #666666; text-align:center; line-height: 30px;" st-content="fulltext-content">
                                                 <?php echo $message; ?>
                                             </td>
                                          </tr>
                                          <!-- End of content -->
                                          <!-- spacing -->
                                          <tr>
                                             <td width="100%" height="20" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">&nbsp;</td>
                                          </tr>
                                          <!-- End of spacing -->

                                          <!-- Action -->
                                          <?php if($url!='') { ?>
                                          <tr>
                                             <td style="font-family: Helvetica, arial, sans-serif; font-size: 16px; color: #666666; text-align:center; line-height: 30px;" st-content="fulltext-action">
                                                <a href="<?php echo $url; ?>" style="text-decoration: none; color: #fff; background: #bd1701; padding: 16px 32px 16px 32px; border-radius: 32px;"><?php echo $button_text; ?></a>
                                             </td>
                                          </tr>
                                          <?php } ?>
                                          <!-- End of action -->
                                          <!-- spacing -->
                                          <tr>
                                             <td width="100%" height="20" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">&nbsp;</td>
                                          </tr>
                                          <!-- End of spacing -->
                                          <!-- mini text -->
                                          <?php if($url!='') { ?>
                                          <tr>
                                             <td style="font-family: Helvetica, arial, sans-serif; font-size: 11px; color: #666666; text-align:center; line-height: 30px;" st-content="fulltext-content">
                                                 Mengalami kesulitan? Copy dan paste url berikut ini ke browser:<br><?php echo $url; ?>
                                             </td>
                                          </tr>
                                          <?php } ?>
                                          <!-- mini text -->
                                          <!-- spacing -->
                                          <tr>
                                             <td width="100%" height="20" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">&nbsp;</td>
                                          </tr>
                                          <!-- End of spacing -->
                                          <!-- mini text -->
                                          <tr>
                                             <td style="font-family: Helvetica, arial, sans-serif; font-size: 16px; color: #666666; text-align:center; line-height: 30px;" st-content="fulltext-content">
                                                 <?php echo $footer; ?>
                                                 <br>
                                                 <br>
                                                Terima kasih,<br>Tim Parenting Club

                                             </td>
                                          </tr>
                                          <!-- mini text -->
                                          <!-- spacing -->
                                          <tr>
                                             <td width="100%" height="20" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">&nbsp;</td>
                                          </tr>
                                          <!-- End of spacing -->
                                       </tbody>
                                    </table>
                                 </td>
                              </tr>
                           </tbody>
                        </table>
                     </td>
                  </tr>
               </tbody>
            </table>
         </td>
      </tr>
   </tbody>
</table>
<!-- end of full text -->
<!-- Start of seperator -->
<table width="100%" bgcolor="#ffffff" cellpadding="0" cellspacing="0" border="0" id="backgroundTable" st-sortable="seperator">
   <tbody>
      <tr>
         <td>
            <table width="600" cellpadding="0" cellspacing="0" border="0" align="center" class="devicewidth">
               <tbody>
                  <tr>
                     <td width="100%">
                        <table width="600" cellpadding="0" cellspacing="0" border="0" align="center" class="devicewidth">
                           <tbody>
                             <tr>
                                 <td width="100%">
                                    <img src="<?php echo site_url('addons/default/themes/wyeth/img/orn-sky.png'); ?>" alt="" border="0" width="20%" style="display:block; border:none; outline:none; text-decoration:none;">
                                 </td>
                              </tr>
                              <tr>
                                 <td width="100%" style="font-family: Helvetica, arial, sans-serif; font-size: 12px; color: #666666; text-align:center;">
                                    *Hanya berlaku <a href="https://www.blibli.com/promosi/wnpc" target="_blank">di Blibli</a>. Syarat dan ketentuan berlaku
                                 </td>
                              </tr>
                              <tr>
                                 <td width="100%" height="5" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">&nbsp;</td>
                              </tr>
                           </tbody>
                        </table>
                     </td>
                  </tr>
               </tbody>
            </table>
         </td>
      </tr>
   </tbody>
</table>
<!-- End of seperator -->
<!-- Start of Postfooter -->
<!-- Start of Postfooter -->
<table width="100%" bgcolor="#ffffff" cellpadding="0" cellspacing="0" border="0" id="backgroundTable" st-sortable="postfooter" >
   <tbody>
      <tr>
         <td>
            <table width="600" cellpadding="0" cellspacing="0" border="0" align="center" bgcolor="#f3f3f3" class="devicewidth" style="border-top: 8px solid #fbd42f;">
               <tbody>
                  <tr>
                     <td width="100%">
                        <table width="600" cellpadding="0" cellspacing="0" border="0" align="center" class="devicewidth">
                           <tbody>
                              <!-- Spacing -->
                              <tr>
                                 <td width="100%" height="30" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">&nbsp;</td>
                              </tr>
                              <!-- Spacing -->
                              <tr>
                                 <td>
                                    <table width="170" align="center" cellpadding="0" cellspacing="0" border="0" class="devicewidthinner">
                                       <tbody>
                                          <tr>
                                             <td width="36" height="34" align="center">
                                                <a target="_blank" href="#">
                                                <img src="<?php echo site_url('addons/default/themes/wyeth/img/email-fb.png'); ?>" alt="" border="0" width="30" height="30" style="display:block; border:none; outline:none; text-decoration:none;">
                                                </a>
                                             </td>
                                             <td align="left" width="5" style="font-size:1px; line-height:1px;">&nbsp;</td>
                                             <td width="36" height="34" align="center">
                                                <a target="_blank" href="#">
                                                <img src="<?php echo site_url('addons/default/themes/wyeth/img/email-tw.png'); ?>" alt="" border="0" width="30" height="30" style="display:block; border:none; outline:none; text-decoration:none;">
                                                </a>
                                             </td>
                                             <td align="left" width="5" style="font-size:1px; line-height:1px;">&nbsp;</td>
                                             <td width="36" height="34" align="center">
                                                <a target="_blank" href="#">
                                                <img src="<?php echo site_url('addons/default/themes/wyeth/img/email-ig.png'); ?>" alt="" border="0" width="30" height="30" style="display:block; border:none; outline:none; text-decoration:none;">
                                                </a>
                                             </td><td align="left" width="5" style="font-size:1px; line-height:1px;">&nbsp;</td>
                                             <td width="36" height="34" align="center">
                                                <a target="_blank" href="#">
                                                <img src="<?php echo site_url('addons/default/themes/wyeth/img/email-yt.png'); ?>" alt="" border="0" width="30" height="30" style="display:block; border:none; outline:none; text-decoration:none;">
                                                </a>
                                             </td>
                                          </tr>
                                       </tbody>
                                    </table>
                                 </td>
                              </tr>
                              <!-- Spacing -->
                              <tr>
                                 <td width="100%" height="10" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">&nbsp;</td>
                              </tr>
                              <!-- Spacing -->
                              <tr>
                                 <td>
                                    <table width="540" align="center" cellpadding="0" cellspacing="0" border="0" class="devicewidthinner">
                                       <tbody>
                                          <!-- content -->
                                          <tr>
                                             <td align="center" valign="middle" style="font-family: Helvetica, arial, sans-serif; font-size: 10px;color: #666666" st-content="postfooter-content">
                                                PT Wyeth Nutrition Sduaenam. Wisma Nestle, Perkantoran Hijau Arkadia, Gedung B, Lantai 16 Jalan Let. Jend. TB Simatupang Kav. 88 Jakarta 12520 Indonesia <br />
                                                © 2015 Wyeth. Powered by :
                                             </td>
                                          </tr>
                                           <tr>
                                             <td height="10" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">&nbsp;</td>
                                          </tr>
                                         <!-- End of content -->
                                          <tr>
                                             <td align="center" width="170">
                                                <img src="<?php echo site_url('addons/default/themes/wyeth/img/email-wn.png'); ?>" alt="" border="0" style="display:block; max-width: 100%; border:none; outline:none; text-decoration:none;">
                                             </td>
                                          </tr>
                                       </tbody>
                                    </table>
                                 </td>
                              </tr>
                              <!-- Spacing -->
                              <tr>
                                 <td height="30" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">&nbsp;</td>
                              </tr>
                              <!-- Spacing -->
                           </tbody>
                        </table>
                     </td>
                  </tr>
               </tbody>
            </table>
         </td>
      </tr>
    </tbody>
</table>
<!-- End of postfooter --><!-- End of postfooter -->
</body>
</html>