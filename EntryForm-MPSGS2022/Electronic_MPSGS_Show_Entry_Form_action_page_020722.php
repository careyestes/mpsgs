<?php
    // error_reporting(E_ALL|E_STRICT);
    // ini_set('display_errors', 1);

    // define variables and set to initial values
    $to = $subject = $i = $formdata = $headers = $confirmTo = $status = "";
    $txt = array ("","","","","","","","","","","");
    $SQLInj = false;
    $LastName = $_POST["02LastName"];   //save sender's last name for use in subject line
    $FirstName = $_POST["01FirstName"]; //save sender's first name for use in subject line
    $submissionEmail = $_POST["11Email"];     //save sender's e-mail address for later confirmation of submission

    // who are we sending this to?
    $to = "miniartsupply@gmail.com, carey@careyestes.com";
    // $to = "priced@provide.net";

    $emailRecipients = $to . ", " . $submissionEmail;

    // create a subject line that includes the artist's name
    
    $LastName = trim($LastName, "\x00..\x1F");   //remove all leading and trailing ASCII control char's
    $LastName = trim($LastName);                 //remove all leading and trailing spaces and print directives (\t,\n,\r,...)
    $LastName = stripslashes($LastName);
    $LastName = htmlspecialchars($LastName);     //replace &, ", >, and < (used for cross-site scripting) with codes
    
    $FirstName = trim($FirstName, "\x00..\x1F"); //remove all leading and trailing ASCII control char's
    $FirstName = trim($FirstName);               //remove all leading and trailing spaces and print directives (\t,\n,\r,...)
    $FirstName = stripslashes($FirstName);
    $FirstName = htmlspecialchars($FirstName);   //replace &, ", >, and < (used for cross-site scripting) with codes
    
    $subject = "$LastName $FirstName MPSGS Entry Form"; //full subject line
    
    // continue only if the form is submitted via 'POST'
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        
        
        //    loop through every field in the form
        foreach($_POST as $x => $x_value) {
            
            //        filter the form data to prevent cross-site scripting exploits

            $x_value = trim($x_value, "\x00..\x1F");         //remove all leading and trailing ASCII control char's

            $x_value = trim($x_value);                       //remove all leading and trailing spaces and print directives (\t,\n,\r,...)

            $x_value = stripslashes($x_value);

            $x_value = htmlspecialchars($x_value);           //replace &, ", >, and < (used for cross-site scripting) with codes

            $x_value = str_replace('\n.', '\n..', $x_value); //work around for a known problem with some browsers



            //        filter field names to prevent possible problems later

            $x = trim($x, "\x00..\x1F");                     //remove all leading and trailing ASCII control char's

            $x = trim($x);                                   //remove all leading and trailing spaces and print directives (\t,\n,\r,...)

            $x = stripslashes($x);

            $x = htmlspecialchars($x);                       //replace &, ", >, and < (used for cross-site scripting) with codes



            //        stop processing if malicious SQL code is found

            if ((stripos($x_value, "drop table ") !== false) ||

                (stripos($x_value, "alter table ") !== false)) {

                    $formdata = "";                          //empty the body of the e-mail message

                    $SQLInj = true;                          //flag an attack

                    break;                                   //abandon the 'foreach loop

            }
            str_replace(";", "", $x_value); //semi-colons are used in malicious SQL code


            // accumulate data for the body of the e-mail message

            if (!empty($x_value)) {                          //if a value is stored in this field



                $txt[0] = "$x=$x_value";                     //create a new line of data as <field name>=<field data>



                $txt[0] .= "\r\n";                           //add line break characters at the end of the line



                switch ($x) {

                    case "39EntFee": $txt[1] = $txt[0]; break;  //Save the new line of data to be appended later in different order

                    case "42Dues": $txt[2] = $txt[0]; break;

                    case "41Ins": $txt[3] = $txt[0]; break;

                    case "43Donate": $txt[4] = $txt[0]; break;

                    case "44Total": $txt[5] = $txt[0]; break;

                    case "40PayMethod": $txt[6] = $txt[0]; break;

                    case "50ReceiveByPayPal": $txt[7] = $txt[0]; break;

                    case "190OtherPayPalName": $txt[8] = $txt[0]; break;

                    case "45ChkNo": $txt[9] = $txt[0]; break;

                    case "46Notes": $txt[10] = $txt[0]; break;

                    default: $formdata .= $txt[0];              //append the new line of data to what has been gathered already

                }

            }

        }

        for ($i = 1; $i <= 10; $i++) { 
            $formdata .= $txt[$i];
        }  
        //append previously saved lines in new order

        //    define headers for the e-mail
        $headers = "MIME-Version: 1.0\r\n";

        //    $headers .= "Content-Type: text/plain; charset=ISO-8859-1\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
        $headers .= "To: miniartsupply@gmail.com\r\n";

        if (strlen($LastName) <= 0) {     //    if the artist has not entered a last name

            $status = "2";                //    set status code to 2

        } elseif ($SQLInj) {              //    if malicious SQL code was entered

            $status = "";                 //    set status code to "" indicating failure

        } else {                          //    otherwise send an email using parameters defined above and set a status code

            $status = mail($emailRecipients,$subject,$formdata,$headers);

        }

    }
    

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Submission Form Result</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>


        <p id="statusMsg"></p>
        <p>To return to the form, click or tap <a href="javascript:history.go(-1)">here</a>.</p>

        <script type="text/javascript">

            function statusMsgTxt() {

                var emStatus = "<?php echo $status; ?>";
                var payMethod = "<?php echo $_POST["40PayMethod"]; ?>";
                var successMsg = "";

                if (payMethod == "PayPal" || payMethod == "altPayPal") {

                    successMsg = "<p>Your exhibit entry has been submitted to MPSGS.</p>" +

                                "<p>You must also go to <a href='www.paypal.com'>www.paypal.com</a> to pay your entry fee.</p>" +

                                "<p>Thank you for entering the MPSGS 2022 exhibit.</p>";

                } else {

                    successMsg = "<p>Your exhibit entry has been submitted to MPSGS.</p>" +

                                "<p>Thank you for entering the MPSGS 2022 exhibit.";

                }

                //            $status outputs "" if failed, "1" if succeeded, and "2" if user's name is missing

                switch (emStatus) {

                    case "1":

                        return successMsg;

                        break;

                    case "2":

                        return "<p>Your exhibit entry was not processed because your name is missing.</p>";

                        break;

                    default:

                        return "<p>An internal error occurred that prevented your exhibit entry from being processed.</p>";

                }

            }

            var formdata = statusMsgTxt();
            document.getElementById("statusMsg").innerHTML = formdata;

        </script>



    </body>

</html>

<?php exit(); ?>

