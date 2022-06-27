<?PHP
/*
    Contact Form from HTML Form Guide
    This program is free software published under the
    terms of the GNU Lesser General Public License.
    See this page for more info:
    http://www.html-form-guide.com/contact-form/creating-a-contact-form.html
*/
require_once("./include/fgcontactform.php");

$formproc = new FGContactForm();


//1. Add your email address here.
//You can add more than one receipients.
$formproc->AddRecipient('salesmpsgs@gmail.com'); //<<---Put your email address here


//2. For better security. Get a random tring from this link: http://tinyurl.com/randstr
// and put it here
$formproc->SetFormRandomKey('CnRrspl1FyEylUj');


if(isset($_POST['submitted']))
{
   if($formproc->ProcessForm())
   {
        $formproc->RedirectToURL("thank-you.php");
   }
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<head>
      <meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
      <title>MPSGS - Contact Sales</title>
      <link rel="STYLESHEET" type="text/css" href="contact.css" />
      <script type='text/javascript' src='scripts/gen_validatorv31.js'></script>
</head>
<body background="Backgrd-blue.gif" text="#996600" link="#996600" vlink="#996600" alink="#996600">
<!-- Form Code Start -->
<form id='contactus' action='<?php echo $formproc->GetSelfScript(); ?>' method='post' accept-charset='UTF-8'>
  <blockquote> 
    <blockquote> <legend><font face="Times New Roman, Times, serif" size="6" color="006699"><b><font size="5">The 
      Annual Exhibition of Fine Art in Miniature,<br>
      The Miniature Painters, Sculptors &amp; Gravers<br>
      Society of Washington, D.C. (MPSGS)</font></b><br>
      </font></legend> 
      <p align="left"><b><font size="4" color="006699">&nbsp;&nbsp;&nbsp;&nbsp;Please 
        use this contact form to send an email to Strathmore to <br>
        <u>purchase</u> an artwork in our Exhibit. A Strathmore representative 
        <br>
        will get in touch with you for payment info within 24 hours.</font></b><font size="4"><br>
        </font><font face="Times New Roman, Times, serif" size="4" color="006699"><b>* 
        Don't forget to click the &quot;Submit&quot; button at the bottom.</b></font><font size="4"><br>
        <br>
        <font face="Times New Roman, Times, serif" color="006699"><b>&nbsp;&nbsp;&nbsp;&nbsp;If 
        you have a general question about the exhibit, please contact<br>
        MPSGS at info@mpsgs.org.</b></font></font><font size="4"><legend><font face="Times New Roman, Times, serif" color="006699"><font face="Times New Roman, Times, serif" color="006699"><br>
        </font><font size="4"><font face="Times New Roman, Times, serif" color="006699"><b>&nbsp;&nbsp;&nbsp;Click 
        here to return to Artworks: </b></font></font><font size="4"><font face="Times New Roman, Times, serif" size="5" color="006699"><font face="Times New Roman, Times, serif" size="5" color="006699"><font face="Times New Roman, Times, serif" size="5" color="006699"><b><font size="4"><b><a href="../MPSGS-Artworks1.htm" target="_self"><img src="../ButtonGold-MPSGS-Artworks.jpg" width="130" height="36" border="0"></a></b></font></b></font></font></font></font></font></legend></font><legend></legend></p>
      </blockquote>
    <p> 
      <input type='hidden' name='submitted' id='submitted' value='1'/>
      <input type='hidden' name='<?php echo $formproc->GetFormIDInputName(); ?>' value='<?php echo $formproc->GetFormIDInputValue(); ?>'/>
      <input type='text'  class='spmhidip' name='<?php echo $formproc->GetSpamTrapInputName(); ?>' />
    </p>
    <blockquote>
<div class='short_explanation' align="left"><font face="Times New Roman, Times, serif" color="006699"><font size="4"><br>
        </font><font color="006699" size="3" face="Times New Roman, Times, serif"><b><font size="4">* 
        required fields</font><br>
        </b></font><br>
        </font></div>
      <div align="left"><font color="006699"><span class='error'> 
        <?php echo $formproc->GetErrorMessage(); ?>
        </span></font> </div>
      <div class='container' align="left"> <font color="006699"><label for='name' ></label></font>
        <div class='container' align="left"><font color="006699"><label for='name' ><font face="Times New Roman, Times, serif" size="4"><b>*Your 
          Name:</b></font></label><br>
          </font><font color="006699"> 
          <input type='text' name='name' id='name' value='<?php echo $formproc->SafeDisplay('name') ?>' maxlength="100" />
          <br/>
          </font></div>
        <div class='container' align="left"> <font color="006699"><label for='email' ><font face="Times New Roman, Times, serif" size="4"><br>
          <b>*Your Address:</b></font></label></font><font color="006699"><br/>
          <input type='text' name='Address' id='Address' value='<?php echo $formproc->SafeDisplay('name') ?>' maxlength="100" />
          </font><font color="006699"><label for='message' ><font face="Times New Roman, Times, serif" size="4"><br>
          </font></label></font><font color="006699" size="4" face="Times New Roman, Times, serif"><br>
          </font></div>
        </div>
      <div class='container' align="left"> <font color="006699" size="4" face="Times New Roman, Times, serif"><label for='name' ></label></font><font color="006699"><label for='name' ><font face="Times New Roman, Times, serif"><b><font size="4">*Your 
        Phone:</font></b></font></label><font size="4" face="Times New Roman, Times, serif"></font></font><font color="006699" size="4" face="Times New Roman, Times, serif"></font><font color="006699" size="4" face="Times New Roman, Times, serif"><br>
        <input type='text' name='Phone' id='name' value='<?php echo $formproc->SafeDisplay('name') ?>' maxlength="100" />
        <br>
        <br>
        <label for='email' ></label></font><font color="006699"><label for='name' ><font face="Times New Roman, Times, serif"><b><font size="4">*Your 
        Email:</font></b></font></label><font size="4" face="Times New Roman, Times, serif"></font></font><font color="006699" size="4" face="Times New Roman, Times, serif"></font><font color="006699" size="4" face="Times New Roman, Times, serif"><br/>
        <input type='text' name='email' id='email' value='<?php echo $formproc->SafeDisplay('email') ?>' maxlength="50" />
        <br>
        <br>
        </font> 
        <div class='container' align="left"> <font color="006699" size="4" face="Times New Roman, Times, serif"><label for='email' ></label></font><font color="006699"><label for='name' ><font face="Times New Roman, Times, serif"><b><font size="4">*Artwork 
          #, artwork title, artist name, and price that you would<br>
          like to purchase: </font></b></font></label></font><font color="006699" size="4" face="Times New Roman, Times, serif"><br>
          <input type='text' name='Artwork Info' id='name' value='<?php echo $formproc->SafeDisplay('name') ?>' maxlength="200" />
          <label for='email' > </label><label for='message' ><br>
          <br>
          </label></font><font color="006699"><label for='message' ><font color="006699"><font face="Times New Roman, Times, serif"><b><font size="4">Comments:</font></b></font></font><font face="Times New Roman, Times, serif" size="4"><br>
          <br>
          <textarea rows="15
			" cols="100" name='message' id='message'><?php echo $formproc->SafeDisplay('message') ?></textarea>
          </font></label></font> 
          <p><font color="006699"><label for='message' ></label></font></p>
        </div>
      </div>
      </blockquote>
  </blockquote>
  <div class='container' align="left"></div>
  <blockquote>
<blockquote>
      <div class='container' align="left"><span id='contactus_message_errorloc' class='error'></span> 
      </div>
      <div class='container' align="left"> 
 <p> 
          <input type='submit' name='Submit' value='Submit' />
        </p>
      </div>
    </blockquote>
  </blockquote>
</form>
<!-- client-side Form Validations:
Uses the excellent form validation script from JavaScript-coder.com-->
<p align="left"> 
  <script type='text/javascript'>
// <![CDATA[

    var frmvalidator  = new Validator("contactus");
    frmvalidator.EnableOnPageErrorDisplay();
    frmvalidator.EnableMsgsTogether();
    frmvalidator.addValidation("name","req","Please provide your name");

    frmvalidator.addValidation("email","req","Please provide your email address");

    frmvalidator.addValidation("email","email","Please provide a valid email address");

    frmvalidator.addValidation("message","maxlen=2048","The message is too long!(more than 2KB!)");

// ]]>
</script>
</p>
<p align="center">&nbsp;</p>
</body>
</html>