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
//You can add more than one recipient.
$formproc->AddRecipient('mpsgs100@gmail.com'); //<<---Put your email address here


//2. For better security. Get a random tring from this link: http://tinyurl.com/randstr
// and put it here
$formproc->SetFormRandomKey('CnRrspl1FyEylUj');


if(isset($_POST['submitted']))
{
  var_dump("Post Sub is submitted");
   if($formproc->ProcessForm())
   {
      var_dump("Process Form is true");die;
      $formproc->RedirectToURL("thank-you.php");
   }
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<head>
      <meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
      <title>MPSGS - Contact Us</title>
      <link rel="STYLESHEET" type="text/css" href="contact.css" />
      <script type='text/javascript' src='scripts/gen_validatorv31.js'></script>
</head>
<body background="Backgrd-blue.gif" text="#996600" link="#996600" vlink="#996600" alink="#996600">
<!-- Form Code Start -->
<form id='contactus' action='<?php echo $formproc->GetSelfScript(); ?>' method='post' accept-charset='UTF-8'>
  <blockquote> 
    <blockquote> 
      <p><legend><font face="Times New Roman, Times, serif" size="6" color="006699">The 
        Miniature Painters, Sculptors &amp; Gravers<br>
        Society of Washington, D.C. (MPSGS)<br>
        </font></legend></p>
      <p><legend><font face="Times New Roman, Times, serif" size="6" color="006699">Contact 
        Us &nbsp;&nbsp;&nbsp;&nbsp;<br>
        <font size="5">(or return to <a href="../index.htm">MPSGS Home Page</a>)</font></font></legend></p>
    </blockquote>
    <p> 
      <input type='hidden' name='submitted' id='submitted' value='1'/>
      <input type='hidden' name='<?php echo $formproc->GetFormIDInputName(); ?>' value='<?php echo $formproc->GetFormIDInputValue(); ?>'/>
      <input type='text'  class='spmhidip' name='<?php echo $formproc->GetSpamTrapInputName(); ?>' />
    </p>
    <blockquote> 
      <div class='short_explanation' align="left"><font face="Times New Roman, Times, serif" color="006699"><b><font size="4">Hello! 
        <br>
        <br>
        Thank you for your interest in the MPSGS. If you would like to be on the 
        <br>
        MPSGS mailing list for the prospectus and exhibit invitation, please let 
        us know. <br>
        <br>
        If you just want an invitation to the show, great! We love new patrons.<br>
        Please let us know in your message.</font></b></font></div>
      <div class='short_explanation' align="left"><font face="Times New Roman, Times, serif" color="006699"><b><font size="4"><br>
        </font></b></font><font face="Times New Roman, Times, serif" color="006699"><b><font size="4"><br>
        </font></b></font><font face="Times New Roman, Times, serif" color="006699"><b><font size="4"><br>
        If you have any questions, please let us know. <br>
        You can also </font></b></font><font face="Times New Roman, Times, serif" color="006699"><b><font size="4">send 
        an email to mpsgs100@gmail.com. <br>
        <br>
        Thank you!<br>
        <br>
        </font><font color="006699" size="3" face="Times New Roman, Times, serif"><b>* 
        required fields<br>
        </b></font><font size="4"><br>
        </font></b></font></div>
      <div align="left"><font color="006699"><span class='error'> 
        <?php echo $formproc->GetErrorMessage(); ?>
        </span></font> </div>
      <div class='container' align="left"> <font color="006699"><label for='name' ><font face="Times New Roman, Times, serif" size="4">*Your 
        Name:</font></label><br>
        </font><font color="006699"> 
        <input type='text' name='name' id='name' value='<?php echo $formproc->SafeDisplay('name') ?>' maxlength="100" />
        <br/>
        </font></div>
      <div class='container' align="left"> <font color="006699"><label for='email' ><font face="Times New Roman, Times, serif" size="4"><br>
        *Your Email Address:</font></label></font><font color="006699"><br/>
        <input type='text' name='email' id='email' value='<?php echo $formproc->SafeDisplay('email') ?>' maxlength="50" />
        <br/>
        </font></div>
      <div class='container' align="left"> <font color="006699"><label for='message' ><font face="Times New Roman, Times, serif" size="4"><br>
        Message:<br>
        <br>
        <textarea rows="10" cols="100" name='message' id='message'><?php echo $formproc->SafeDisplay('message') ?></textarea>
        <br>
        </font></label></font> <font color="006699"><label for='message' ></label></font></div>
    </blockquote>
  </blockquote>
  <div class='container' align="left"> </div>
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