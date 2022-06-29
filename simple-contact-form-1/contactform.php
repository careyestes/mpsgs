<?PHP
error_reporting(E_ALL);
ini_set('display_errors', 'on');

if(isset($_POST['submitted']))
{
    $to = "mpsgs100@gmail.com";
    // $to = "carey@careyestes.com";
    $subject = "MPSGS Contact Submission";
    $name = $_POST["name"];
    $email = $_POST["email"];
    $message = $_POST["message"];
    $mailMessage = $email . " has contacted you.\r\n\r\n" . $message;
    $mailCondition = mail($to, $subject, $mailMessage);
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

    <blockquote>
        <blockquote>
            <p><legend><font face="Times New Roman, Times, serif" size="6" color="006699">The Miniature Painters, Sculptors &amp; Gravers<br>Society of Washington, D.C. (MPSGS)<br></font></legend></p>
            <p><legend><font face="Times New Roman, Times, serif" size="6" color="006699">Contact Us &nbsp;&nbsp;&nbsp;&nbsp;<br><font size="5">(or return to <a href="../index.htm">MPSGS Home Page</a>)</font></font></legend></p>
        </blockquote>
    </blockquote>
        
    <form id='contactus' action='' method='post' accept-charset='UTF-8' <?php if(isset($mailCondition)) { echo "hidden"; } ?>>
        <blockquote> 
            <p> 
            <input type='hidden' name='submitted' id='submitted' value='1'/>
            <input type='hidden' name='' value=''/>
            <input type='text'  class='spmhidip' name='' />
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
                    Please let us know in your message.</font></b></font>
                    </div>
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
                        </font></b></font>
                    </div>
            
                    <div class='container' align="left"> 
                        <font color="006699">
                        <label for='name' ><font face="Times New Roman, Times, serif" size="4">*Your Name:</font></label><br>
                        </font><font color="006699"> 
                        <input type='text' name='name' id='name' value='' maxlength="100" required />
                        <br/>
                        </font>
                    </div>
                    <div class='container' align="left"> <font color="006699">
                        <label for='email' ><font face="Times New Roman, Times, serif" size="4"><br>*Your Email Address:</font></label></font><font color="006699">
                        <br/>
                        <input type='email' name='email' id='email' value='' maxlength="50" required />
                        <br/>
                        </font>
                    </div>
                    <div class='container' align="left"> <font color="006699"><label for='message' ><font face="Times New Roman, Times, serif" size="4">
                        <br>Message:<br>
                        <br>
                        <textarea rows="10" cols="100" name='message' id='message'></textarea>
                        <br>
                        </font></label></font> <font color="006699"><label for='message' ></label></font>
                    </div>
                </blockquote>
        </blockquote>
        <div class='container' align="left"></div>
        <blockquote> 
            <blockquote>
                <div class='container' align="left">
                    <span id='contactus_message_errorloc' class='error'></span> 
                </div>
                <div class='container' align="left"> 
                    <p> 
                    <input type='submit' name='Submit' value='Submit' />
                    </p>
                </div>
            </blockquote>
        </blockquote>
    </form>

    <?php if(isset($mailCondition)): ?>
        <?php if($mailCondition == "1"): ?>
            <blockquote>
                <blockquote>
                    <div align="left">
                        <font color="006699"><span class='error'>We have received your submission</span></font>
                    </div>
                </blockquote>
            </blockquote>
        <?php elseif($mailCondition == "2"): ?>
            <blockquote>
                <blockquote>
                    <div align="left">
                        <font color="006699"><span class='error'>Your name was missing</span></font>
                    </div>
                </blockquote>
            </blockquote>
        <?php else: ?>
            <blockquote>
                <blockquote>
                    <div align="left">
                        <font color="006699"><span class='error'>An internal error occurred that prevented your exhibit entry from being processed.</span></font>
                    </div>
                </blockquote>
            </blockquote>
        <?php endif ?>
    <?php endif ?>
        
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