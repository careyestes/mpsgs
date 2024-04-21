<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    // define variables and set to initial values
    $currentYear = "2024";
    $to = $subject = $i = $formdata = $confirmTo = $status = "";
    $txt = array ("","","","","","","","","","","");
    $SQLInj = false;
    $LastName = $_POST["02LastName"];   //save sender's last name for use in subject line
    $FirstName = $_POST["01FirstName"];
    $submissionEmail = $_POST["11Email"];     //save sender's e-mail address for later confirmation of submission
    $total = $_POST["44Total"];
    $duesOnly = isset($_POST["DuesOnly"]) ? $_POST["DuesOnly"] : null;
    $paidDues = isset($_POST["42Dues"]) ? $_POST["42Dues"] : null;

    // who are we sending this to?
    // $to = "miniartsupply@gmail.com, mpsgsfees@gmail.com, carey@careyestes.com";
    $to = "carey@careyestes.com, miniartsupply@gmail.com";

    // create a subject line that includes the artist's name
    
    $LastName = trim($LastName, "\x00..\x1F");   //remove all leading and trailing ASCII control char's
    $LastName = trim($LastName);                 //remove all leading and trailing spaces and print directives (\t,\n,\r,...)
    $LastName = stripslashes($LastName);
    $LastName = htmlspecialchars($LastName);     //replace &, ", >, and < (used for cross-site scripting) with codes
    
    $FirstName = trim($FirstName, "\x00..\x1F"); //remove all leading and trailing ASCII control char's
    $FirstName = trim($FirstName);               //remove all leading and trailing spaces and print directives (\t,\n,\r,...)
    $FirstName = stripslashes($FirstName);
    $FirstName = htmlspecialchars($FirstName);   //replace &, ", >, and < (used for cross-site scripting) with codes
    
    $subject = "MPSGS Entry Form | $LastName, $FirstName"; //full subject line
    $userSubject = "Your MPSGS submission was received!";
    
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
            
            // if (!empty($x_value)) {                          //if a value is stored in this field

            //     $txt[0] = "$x=$x_value";                     //create a new line of data as <field name>=<field data>
            //     $txt[0] .= "\r\n";                           //add line break characters at the end of the line

            //     switch ($x) {

            //         case "39EntFee": $txt[1] = $txt[0]; break;  //Save the new line of data to be appended later in different order
            //         case "42Dues": $txt[2] = $txt[0]; break;
            //         case "41Ins": $txt[3] = $txt[0]; break;
            //         case "43Donate": $txt[4] = $txt[0]; break;
            //         case "44Total": $txt[5] = $txt[0]; break;
            //         case "40PayMethod": $txt[6] = $txt[0]; break;
            //         case "50ReceiveByPayPal": $txt[7] = $txt[0]; break;
            //         case "48OtherPayPalName": $txt[8] = $txt[0]; break;
            //         case "45ChkNo": $txt[9] = $txt[0]; break;
            //         case "46Notes": $txt[10] = $txt[0]; break;

            //         default: $formdata .= $txt[0];              //append the new line of data to what has been gathered already

            //     }

            // }

        }

        $formdata .= "<h2>Contact Information</h2>";
        $formdata .= "<p style='margin-top: 0;margin-bottom: 3px;'>" . $FirstName . " " . $_POST["99MidIni"] . " " . $LastName . " " . $_POST["100NameSuf"] . "</p>";
        $formdata .= "<p style='margin-top: 0;margin-bottom: 3px;'>" . $_POST["04Addr1"] . "</p>";
        $formdata .= "<p style='margin-top: 0;margin-bottom: 3px;'>" . $_POST["05Addr2"] . "</p>";
        $formdata .= "<p style='margin-top: 0;margin-bottom: 3px;'>" . $_POST["06City"] . ", " . $_POST["07State"] . " " . $_POST["09PostCode"] . " " . $_POST["08Country"] . "</p>";
        $formdata .= "<p style='margin-top: 0;margin-bottom: 3px;'>" . $_POST["10Phone"] . "</p>";
        $formdata .= "<p>" . $_POST["11Email"] . "</p>";
        $formdata .= "<p style='margin-top: 0;margin-bottom: 3px;'>Instagram: " . $_POST["12Instagram"] . "</p>";
        $formdata .= "<p style='margin-top: 0;margin-bottom: 3px;'>Facebook: " . $_POST["13Facebook"] . "</p>";
        
        $formdata .= "<br />";
        $formdata .= "<hr />";
        $formdata .= "<br />";
        
        $formdata .= "<h2>Entry Details" . "</h2>";
        $formdata .= "<p>Receiver: " . $_POST["12Receiver"] . "</p>";
    
        // ---------- Artwork 1 ---------- //
        $formdata .= "<h3>Artwork 1</h3>";
        $formdata .= "<h4>Title: " . $_POST["14Title1"] . "</h4>";
        $formdata .= "<p style='margin-top: 0;margin-bottom: 3px;'>Material: " . $_POST["15Media1"] . "</p>";
        $formdata .= "<p style='margin-top: 0;margin-bottom: 3px;'>Price: " . $_POST["18Price1"] . "</p>";
        if(isset($_POST["16Sculpture1"]) && $_POST["16Sculpture1"] == "Yes") {
            $formdata .= "<p style='margin-top: 0;margin-bottom: 3px;'>Is Sculpture? " . $_POST["16Sculpture1"] . "</p>";
            $formdata .= "<p style='margin-top: 0;margin-bottom: 3px;'>Height: " . $_POST["shighw1"] . ($_POST["shighf1"] ?? "") . "</p>";
            $formdata .= "<p style='margin-top: 0;margin-bottom: 3px;'>Width: " . $_POST["swidew1"] .  ($_POST["swidef1"] ?? "") . "</p>";
            $formdata .= "<p style='margin-top: 0;margin-bottom: 3px;'>Depth: " . $_POST["sdeepw1"] .  ($_POST["sdeepf1"] ?? "") . "</p>";
        } else {
            $formdata .= "<p style='margin-top: 0;margin-bottom: 3px;'>Framed Height: " . $_POST["fhighw1"];
            if(isset($_POST["fhighf3"])) { 
                $formdata .= $_POST["fhighf1"]; 
            } 
            $formdata .= "</p>";
            $formdata .= "<p style='margin-top: 0;margin-bottom: 3px;'>Framed Width: " . $_POST["fwidew1"];
            if(isset($_POST["fwidef1"])) { 
                $formdata .= $_POST["fwidef1"]; 
            }
            $formdata .= "</p>";
        }
        $formdata .= "<br />";
        
        // ---------- Artwork 2 ---------- //
        $formdata .= "<h3>Artwork 2" . "</h3>";
        $formdata .= "<h4>Title: " . $_POST["19Title2"] . "</h4>";
        $formdata .= "<p style='margin-top: 0;margin-bottom: 3px;'>Material: " . $_POST["20Media2"] . "</p>";
        $formdata .= "<p style='margin-top: 0;margin-bottom: 3px;'>Price: " . $_POST["23Price2"] . "</p>";
        if(isset($_POST["21Sculpture2"]) && $_POST["21Sculpture2"] == "Yes") {
            $formdata .= "<p style='margin-top: 0;margin-bottom: 3px;'>Is Sculpture? " . $_POST["21Sculpture2"] . "</p>";
            $formdata .= "<p style='margin-top: 0;margin-bottom: 3px;'>Height: " . $_POST["shighw2"] . ($_POST["shighf2"] ?? "") . "</p>";
            $formdata .= "<p style='margin-top: 0;margin-bottom: 3px;'>Width: " . $_POST["swidew2"] .  ($_POST["swidef2"] ?? "") . "</p>";
            $formdata .= "<p style='margin-top: 0;margin-bottom: 3px;'>Depth: " . $_POST["sdeepw2"] .  ($_POST["sdeepf2"] ?? "") . "</p>";
        } else {
            $formdata .= "<p style='margin-top: 0;margin-bottom: 3px;'>Framed Height: " . $_POST["fhighw2"];
            if(isset($_POST["fhighf2"])) { 
                $formdata .= $_POST["fhighf2"];
            }
            $formdata .= "</p>";
            $formdata .= "<p style='margin-top: 0;margin-bottom: 3px;'>Framed Width: " . $_POST["fwidew2"];
            if(isset($_POST["fwidef2"])) { 
                $formdata .= $_POST["fwidef2"];
            }
            $formdata .= "</p>";
        }
        $formdata .= "<br />";
        
        // ---------- Artwork 3 ---------- //
        $formdata .= "<h3>Artwork 3" . "</h3>";
        $formdata .= "<h4>Title: " . $_POST["24Title3"] . "</h4>";
        $formdata .= "<p style='margin-top: 0;margin-bottom: 3px;'>Material: " . $_POST["25Media3"] . "</p>";
        $formdata .= "<p style='margin-top: 0;margin-bottom: 3px;'>Price: " . $_POST["28Price3"] . "</p>";
        if(isset($_POST["26Sculpture3"]) && $_POST["26Sculpture3"] == "Yes") {
            $formdata .= "<p style='margin-top: 0;margin-bottom: 3px;'>Is Sculpture? " . $_POST["26Sculpture3"] . "</p>";
            $formdata .= "<p style='margin-top: 0;margin-bottom: 3px;'>Height: " . $_POST["shighw3"] . ($_POST["shighf3"] ?? "") . "</p>";
            $formdata .= "<p style='margin-top: 0;margin-bottom: 3px;'>Width: " . $_POST["swidew3"] .  ($_POST["swidef3"] ?? "") . "</p>";
            $formdata .= "<p style='margin-top: 0;margin-bottom: 3px;'>Depth: " . $_POST["sdeepw3"] .  ($_POST["sdeepf3"] ?? "") . "</p>";
        } else {
            $formdata .= "<p style='margin-top: 0;margin-bottom: 3px;'>Framed Height: " . $_POST["fhighw3"];
            if(isset($_POST["fhighf3"])) { 
                $formdata .= $_POST["fhighf3"];
            }
            $formdata .= "</p>";
            $formdata .= "<p style='margin-top: 0;margin-bottom: 3px;'>Framed Width: " . $_POST["fwidew3"];
            if(isset($_POST["fwidef3"])) { 
                $formdata .= $_POST["fwidef3"];
            }
            $formdata .= "</p>";
        }
        $formdata .= "<br />";
        $formdata .= "<h3>Additional Comments:</h3>";
        $formdata .= "<p style='margin-top: 0;margin-bottom: 3px;'>" . $_POST["46Notes"] . "</p>";
        
        $formdata .= "<br />";
        $formdata .= "<hr />";
        $formdata .= "<br />";

        // ---------- Entrant Status ---------- //
        $formdata .= "<h2>Entrant Status</h2>";
        if(isset($_POST["NewArtist"]) && $_POST["NewArtist"] == "Yes") {
            $formdata .= "<p style='margin-top: 0;margin-bottom: 3px;'>New Artist " . "</p>";
        }
        if(isset($_POST["CurrentMember"]) && $_POST["CurrentMember"] == "Yes") {
            $formdata .= "<p style='margin-top: 0;margin-bottom: 3px;'>Current MPGS Member" . "</p>";
        }
        if(isset($_POST["Emeritus"]) && $_POST["Emeritus"] == "Yes") {
            $formdata .= "<p style='margin-top: 0;margin-bottom: 3px;'>Emeritus Member" . "</p>";
        }
        if(isset($_POST["Board"]) && $_POST["Board"] == "Yes") {
            $formdata .= "<p style='margin-top: 0;margin-bottom: 3px;'>Board Member" . "</p>";
        }
        if(isset($_POST["51IsReceiver"]) && $_POST["51IsReceiver"] == "Yes") {
            $formdata .= "<p style='margin-top: 0;margin-bottom: 3px;'>Designated Receiver" . "</p>";
        }
        
        $formdata .= "<br />";
        $formdata .= "<hr />";
        $formdata .= "<br />";

        // ---------- Payment ---------- //
        $formdata .= "<h2>Payment</h2>";
        if(isset($_POST["DuesOnly"]) && $_POST["DuesOnly"] == "Yes") {
            $formdata .= "<p style='margin-top: 0;margin-bottom: 3px;'>I am paying my Dues ONLY. I am NOT entering the exhibit.</p>";
        }
        if(isset($_POST["50ReceiveByPayPal"]) && $_POST["50ReceiveByPayPal"] == "Yes") {
            $formdata .= "<p style='margin-top: 0;margin-bottom: 3px;'>I prefer to receive payments via PayPal for awards and/or sales.</p>";
        }
        if(isset($_POST["43Intl"]) && $_POST["43Intl"]) {
            $formdata .= "<p style='margin-top: 0;margin-bottom: 3px;'>I am an International Entrant</p>";
        }
        if(isset($_POST["42Dues"]) && $_POST["42Dues"]) {
            $formdata .= "<p style='margin-top: 0;margin-bottom: 3px;'>I am paying my dues.</p>";
        }
        if(isset($_POST["39EntFee"]) && $_POST["39EntFee"]) {
            $formdata .= "<p style='margin-top: 0;margin-bottom: 3px;'>Entry Fee: " . $_POST["39EntFee"] . "</p>";
        }
        if(isset($_POST["41Ins"]) && $_POST["41Ins"]) {
            $formdata .= "<p style='margin-top: 0;margin-bottom: 3px;'>Additonal Insurance: " . $_POST["41Ins"] . "</p>";
        }
        if(isset($_POST["43Donate"]) && $_POST["43Donate"]) {
            $formdata .= "<p style='margin-top: 0;margin-bottom: 3px;'>Donation: " . $_POST["43Donate"] . "</p>";
        }
        
        $formdata .= "<p style='margin-top: 0;margin-bottom: 3px;'>Payment Method: " . $_POST["40PayMethod"] . "</p>";
        
        if(isset($_POST["43Donate"]) && $_POST["43Donate"] == "check") {
            $formdata .= "<p style='margin-top: 0;margin-bottom: 3px;'>Check Number: " . $_POST["45ChkNo"] . "</p>";
        }
        if(isset($_POST["43Donate"]) && $_POST["43Donate"] == "PayPal") {
            $formdata .= "<p style='margin-top: 0;margin-bottom: 3px;'>Paypal Information: " . $_POST["47paypalType"] . "</p>";
        }
        
        $formdata .= "<h1>Total: " . $_POST["44Total"] . "</h1>";

        // Boilerplate html top
        $htmlEmail = "
        <html>
            <head>
            <title>".$subject."</title>
            </head>
            <body>
            ".$formdata."
            </body>
        </html>
        ";

        //append previously saved lines in new order
        $headers = "MIME-Version: 1.0\r\nContent-type: text/html; charset=iso-8859-1\r\nFrom: donotreply@mpsgs.org\r\nReply-To: miniartsupply@gmail.com";
        $userEmailData = "
            <html>
            <head>
            <title>Thank you for your submission to the MPSGS Exhibit 2024</title>
            </head>
            <body>
                <p>Dear Artist,</p>
                <p>Thank you for your submission to the MPSGS Exhibit 2024.  We look forward to seeing your artworks!  If you have any questions or comments, please contact me at <a href='mailto:miniartsupply@gmail.com'>miniartsupply@gmail.com</a>.</p>
                <p><b>Nancy Still</b></p>
                <p><i>President</i></p>
                <p>The Miniature Painters, Sculptors and Gravers Society of Washington, DC</p>
                <p><a href='http://www.mpsgs.org'>www.mpsgs.org</a></p>
            </body>
            </html>    
        ";

        // Normalize line endings in $htmlEmail and $userEmailData
        $htmlEmail = str_replace("\n", "\r\n", str_replace("\r", "", $htmlEmail));
        $userEmailData = str_replace("\n", "\r\n", str_replace("\r", "", $userEmailData));

        if (strlen($LastName) <= 0) {     //    if the artist has not entered a last name

            $status = "2";                //    set status code to 2

        } elseif ($SQLInj) {              //    if malicious SQL code was entered

            $status = "";                 //    set status code to "" indicating failure

        } else {                          //    otherwise send an email using parameters defined above and set a status code

            $status = mail($to,$subject,$htmlEmail,$headers);

            if($status == "1") {

                $submissionStatus = mail($submissionEmail,$userSubject,$userEmailData,$headers);
            }

        }
    }  
?>
<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Submission Form Result</title>
        <meta charset="UTF-8">
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
        <script src="https://www.paypal.com/sdk/js?client-id=AQaY4HIe5SPst9tDzmU3svsWF60JO71j1swbXpu88eHuM2tB3pTAHb5vykCpGFdleLOUnawalL0zlkvc&components=buttons,funding-eligibility"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.min.js"></script>
        <script src="html2canvas.js?v06-22-2022"></script>
        <link rel="stylesheet" href="form.css?v04-03-2024">
        <link rel="stylesheet" href="print.css?v04-24-2024">
    </head>
    <body class="confirmation-page">
        <div class="wrapper">
            
            <?php if($status == "1"): ?>
                <?php if($duesOnly == "Yes"): ?>
                    <h1>Thank you for paying your dues.</h1>
                <?php elseif($paidDues): ?>
                    <h1>Thank you for your submission to the MPSGS Exhibit 2024 and dues payment.</h1>
                <?php else: ?>
                    <h1>Thank you for your submission to the MPSGS Exhibit 2024.</h1>
                <?php endif ?>
                
                <h2 class="callout"><u>But wait, you must do the following:</u></h2>
                
                <h3>Make your Payment</h3>
                <p id="statusMsg"></p>
                <div id="paypal-button-container"></div>
                <p id="conditionalContainer"></p>
    
                <?php if(!$duesOnly): ?>
                    <section id="Needs_Tags">
                        <h3>Include a return label</h3>
                        <p>A return label must be included in the box of artworks, so we can return your box to the correct address after the exhibition.</p>

                        <h3>Print out your tags</h3>
                        
                        <p>Print 2 copies of tags.  Include one copy in your artwork box.</p>  
                        <p>Cut out the tags from the other copy, and attach them to the backs of your artworks.</p>
                        <div id="Information_Buttons" class="button-wrapper flex">
                            <input type="button" id="PrintBtn" class="basic" value="Print" onclick="printButtonHandler()" />
                            <input type="button" id="saveAsImageBtn" class="basic" value="Save" /> 
                            <span id="Loading_Container" style="display: none;" class="flex align-center flex-0">
                                <svg style="margin: auto; background: rgb(255, 255, 255); display: block; shape-rendering: auto;" width="30px" height="30px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid"><circle cx="50" cy="50" fill="none" stroke="#0e3197" stroke-width="10" r="35" stroke-dasharray="164.93361431346415 56.97787143782138"><animateTransform attributeName="transform" type="rotate" repeatCount="indefinite" dur="1s" values="0 50 50;360 50 50" keyTimes="0;1"></animateTransform></circle></svg>
                                <span style="padding-left: 0.5rem;">Generating PDF</span>
                            </span>
                        </div>
                            
                        <hr>

                        <div id="CardContent">
                            <?php for ($i=1; $i <= 3; $i++): 
                                switch ($i) {
                                    case '1':
                                        $card_title = $_POST["14Title1"];
                                        $card_medium = $_POST["15Media1"];
                                        $card_price = $_POST["18Price1"];
                                        break;
                
                                    case '2':
                                        $card_title = $_POST["19Title2"];
                                        $card_medium = $_POST["20Media2"];
                                        $card_price = $_POST["23Price2"];
                                        break;
                
                                    case '3':
                                        $card_title = $_POST["24Title3"];
                                        $card_medium = $_POST["25Media3"];
                                        $card_price = $_POST["28Price3"];
                                        break;
                                    
                                    default:
                                        $card_title = "";
                                        $card_medium = "";
                                        $card_price = "";
                                        break;
                                }
                                ?>
                                    
                                <div class="print-card">
                                    <div class="title" style="">MPSGS <?php echo $currentYear ?>, 91st Annual Exhibition</div>
                                    <div class="flex no-wrap align-center">
                                        <div class="flex-0 card-number"><?php echo $i ?>. </div>
                                        <div class="flex flex-0 no-wrap align-center">
                                            <input 
                                                readonly
                                                type="checkbox" 
                                                name="isFirstTime" 
                                                value="<?php echo (isset($_POST["NewArtist"]) ? $_POST["NewArtist"] : null) ?>" 
                                                <?php if(isset($_POST["NewArtist"])): ?>
                                                    checked
                                                <?php endif ?> 
                                            > <span>New Artist</span>
                                        </div>
                                        <div class="flex no-wrap align-center">
                                            <span class="flex-0" style="padding-right: 0.3rem;">MPSGS use: </span>
                                            <span class="flex-0" style="display: inline-block; width:2em; height:1.4em; border: 1px solid black;margin-right: 0.3rem;"></span>
                                            <span class="flex-0" style="display: inline-block; width:6.35em; height:1.4em; border: 1px solid black;"></span>
                                        </div>
                                    </div>
                                    <p class="flex no-wrap align-center"><span class="key">Artist:</span> <span><?php echo $_POST["01FirstName"] ?> <?php echo $_POST["99MidIni"] ?> <?php echo $_POST["02LastName"] ?> <?php echo $_POST["100NameSuf"] ?></span></p>
                                    <p class="flex no-wrap align-center"><span class="key">Address:</span> <span><?php echo $_POST["04Addr1"] ?> <?php echo $_POST["05Addr2"] ?></span></p>
                                    <p class="flex no-wrap align-center"><span class="key">Address:</span> <span><?php echo $_POST["06City"] ?>, <?php echo $_POST["07State"] ?> <?php echo $_POST["09PostCode"] ?> <?php echo $_POST["08Country"] ?></span></p>
                                    <p class="flex no-wrap align-center"><span class="key">Phone:</span> <span><?php echo $_POST["10Phone"] ?></span></p>
                                    <p class="flex no-wrap align-center"><span class="key">Email:</span> <span><?php echo $_POST["11Email"] ?></span></p>
                                    <p class="flex no-wrap align-center"><span class="key">Title:</span> <span><?php echo $card_title ?></span></p>
                                    <div class="flex no-wrap align-center">
                                        <div class="flex align-center">
                                            <span class="key">Medium:</span> 
                                            <span><?php echo $card_medium ?></span> 
                                        </div>
                                        <div class="flex align-center">
                                            <span class="key">Price: $</span> 
                                            <span><?php echo $card_price ?></span>
                                        </div>
                                    </div>
                                    <p class="flex no-wrap"><span class="key">Receiver:</span> <span><?php echo $_POST["12Receiver"] ?></span></p>
                                </div>
                            
                            <?php endfor ?>
                        </div>
                    </section>
                <?php endif; ?>
            
            <?php elseif($status == "2"): ?>
                
                <p class="alert error">Your exhibit entry was not processed because your name is missing.</p>
            
            <?php else: ?>
                
                <p class="alert error">An internal error occurred that prevented your exhibit entry from being processed.</p>
    
            <?php endif ?>

            <p><a href="Electronic_MPSGS_Show_Entry_Form.html">Back to the form</a></p>
        
        </div>
        
        <script type="text/javascript">
            var pdf,HTML_Width,HTML_Height;
        

            function getPaymentType() {
                var payMethod = "<?php echo $_POST["40PayMethod"]; ?>";
                var total = "<?php echo $total; ?>";

                if (payMethod == "cash" && document.getElementById("conditionalContainer")) {
                    document.getElementById("conditionalContainer").innerHTML = "<p>If paying by cash, mail to: <br /><b>MPSGS Treasurer</b><br />PO BOX 281<br />Simpsonville, MD 21150-0281</p>";
                }
                
                if (payMethod == "check" && document.getElementById("conditionalContainer")) {
                    document.getElementById("conditionalContainer").innerHTML = '<p>If paying by check, make payable to MPSGS and mail to: <br /><b>MPSGS Treasurer</b><br />PO BOX 281<br />Simpsonville, MD 21150-0281</p><p>Include your check number: <?php echo (isset($_POST["45ChkNo"]) ? $_POST["45ChkNo"] : "") ?></p>';
                }
                
                if (payMethod == "PayPal" || payMethod == "altPayPal") {

                    var FUNDING_SOURCES = [
                        paypal.FUNDING.PAYPAL,
                    ];

                    FUNDING_SOURCES.forEach(function(fundingSource) {

                        // Initialize the buttons
                        var button = paypal.Buttons({
                            createOrder: function(data, actions) {
                                // This function sets up the details of the transaction, including the amount and line item details.
                                return actions.order.create({
                                    purchase_units: [{
                                        amount: {
                                            value: total
                                        }
                                    }]
                                });
                            },
                            onApprove: function(data, actions) {
                                // This function captures the funds from the transaction.
                                return actions.order.capture().then(function(details) {
                                    // This function shows a transaction success message to your buyer.
                                    document.getElementById("statusMsg").remove();
                                    document.getElementById("paypal-button-container").remove();
                                    document.getElementById("conditionalContainer").innerHTML = "Your payment has been successfully processed.";
                                });
                            },
                            fundingSource: fundingSource
                        });

                        // Check if the button is eligible
                        if (button.isEligible()) {

                            // Render the standalone button for that funding source
                            button.render('#paypal-button-container');
                        }
                    });
                }
            }

            function printButtonHandler() {

                window.print();

            }

            document.getElementById('saveAsImageBtn').addEventListener('click', function() {
                html2canvas(document.getElementById('CardContent')).then(function(canvas) {
                    // Convert the canvas to a data URL
                    var imgData = canvas.toDataURL('image/jpeg');

                    // Create a link and set the URL as the href
                    var link = document.createElement('a');
                    link.href = imgData;
                    link.download = 'MPSGS-Exhibit-2024-Tags.jpeg'; // Specify the download filename

                    // Append the link to the document and trigger the click event
                    document.body.appendChild(link);
                    link.click();

                    // Clean up
                    document.body.removeChild(link);
                });
            });

            window.addEventListener('DOMContentLoaded', (event) => {
                getPaymentType();
            });
            
        </script>
    </body>    
</html>    

<?php exit(); ?>