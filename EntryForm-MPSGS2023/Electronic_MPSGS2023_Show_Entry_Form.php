<?php
    // define variables and set to initial values
    $currentYear = "2023";
    $to = $subject = $i = $formdata = $headers = $confirmTo = $status = "";
    $txt = array ("","","","","","","","","","","");
    $SQLInj = false;
    $LastName = $_POST["02LastName"];   //save sender's last name for use in subject line
    $FirstName = $_POST["01FirstName"]; //save sender's first name for use in subject line
    $submissionEmail = $_POST["11Email"];     //save sender's e-mail address for later confirmation of submission
    $total = $_POST["44Total"];
    $duesOnly = isset($_POST["DuesOnly"]) ? $_POST["DuesOnly"] : null;
    $paidDues = isset($_POST["42Dues"]) ? $_POST["42Dues"] : null;

    // who are we sending this to?
    $to = "miniartsupply@gmail.com, mpsgsfees@gmail.com, carey@careyestes.com";
    // $to = "carey@careyestes.com";

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
                    case "48OtherPayPalName": $txt[8] = $txt[0]; break;
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
        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
        $headers .= "From: miniartsupply@gmail.com" . "\r\n";
        $headers .= "Reply-To: miniartsupply@gmail.com" . "\r\n";
        $userEmailData = "Dear Artist,\r\n\r\nThank you for your submission to the MPSGS Exhibit 2023.  We look forward to seeing your artworks!  If you have any questions or comments, please contact me at miniartsupply@gmail.com.\r\n\r\n\r\nNancy Still\r\nPresident\r\nThe Miniature Painters, Sculptors &\r\nGravers Society of Washington, DC\r\nwww.mpsgs.org\r\n";

        if (strlen($LastName) <= 0) {     //    if the artist has not entered a last name

            $status = "2";                //    set status code to 2

        } elseif ($SQLInj) {              //    if malicious SQL code was entered

            $status = "";                 //    set status code to "" indicating failure

        } else {                          //    otherwise send an email using parameters defined above and set a status code

            $status = mail($to,$subject,$formdata,$headers);

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
        <script src="https://www.paypal.com/sdk/js?client-id=AQaY4HIe5SPst9tDzmU3svsWF60JO71j1swbXpu88eHuM2tB3pTAHb5vykCpGFdleLOUnawalL0zlkvc&components=buttons,funding-eligibility"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.min.js"></script>
        <script src="html2canvas.js?v06-22-2022"></script> 
        <link rel="stylesheet" href="form.css?v04-03-2023">
        <link rel="stylesheet" href="print.css?v04-24-2023">
    </head>
    <body class="confirmation-page">
        <div class="wrapper">
            
            <?php if($status == "1"): ?>
                <?php if($duesOnly == "Yes"): ?>
                    <h1>Thank you for paying your dues.</h1>
                <?php elseif($paidDues): ?>
                    <h1>Thank you for your submission to the MPSGS Exhibit 2023 and dues payment.</h1>
                <?php else: ?>
                    <h1>Thank you for your submission to the MPSGS Exhibit 2023.</h1>
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
                            <!-- <input type="button" id="downloadBtn" class="basic" value="Download" onclick="generatePDF()"> -->
                            <span id="Loading_Container" style="display: none;" class="flex align-center flex-0">
                                <svg style="margin: auto; background: rgb(255, 255, 255); display: block; shape-rendering: auto;" width="30px" height="30px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid"><circle cx="50" cy="50" fill="none" stroke="#0e3197" stroke-width="10" r="35" stroke-dasharray="164.93361431346415 56.97787143782138"><animateTransform attributeName="transform" type="rotate" repeatCount="indefinite" dur="1s" values="0 50 50;360 50 50" keyTimes="0;1"></animateTransform></circle></svg>
                                <span style="padding-left: 0.5rem;">Generating PDF</span>
                            </span>
                        </div>
                            
                        <hr>
            
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
                                <div class="title" style="">MPSGS <?php echo $currentYear ?>, 90th Annual Exhibition</div>
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
        
            function calculatePDF_height_width(){
                HTML_Width = $(document).width();
                HTML_Height = $(document).height();
            }

            function generatePDF() {
                document.getElementById("downloadBtn").style.display = "none";
                document.getElementById("Loading_Container").style.display = "flex";
                pdf = "";
                html2canvas(document.body, { 
                    allowTaint: true,
                    onclone: function (clonedDoc) {
                        clonedDoc.getElementById("Information_Buttons").style.display = "none";
                    }
                }).then(function(canvas) {

                    calculatePDF_height_width();
                    var imgData = canvas.toDataURL("image/png", 1.0);
                    pdf = new jsPDF('p', 'pt', [HTML_Width, HTML_Height]);
                    pdf.addImage(imgData, 'JPG', 0, 0, HTML_Width, HTML_Height, 'alias', 'NONE');

                    setTimeout(function() {

                        pdf.save("2023-MPSGS-Artwork-Tags.pdf");

                    }, 0);

                    document.getElementById("Loading_Container").style.display = "none";
                    document.getElementById("downloadBtn").style.display = "flex";

                });
            };

            function getPaymentType() {
                console.log("ran");
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

            function downloadPdf() {
                var pdf = new jsPDF('p', 'pt', 'letter');
                pdf.canvas.height = 72 * 11;
                pdf.canvas.width = 72 * 8.5;
            
                pdf.fromHTML(document.body);
            
                pdf.save('test.pdf');
            };

            window.addEventListener('DOMContentLoaded', (event) => {
                getPaymentType();
            });
            
        </script>
    </body>    
</html>    

<?php exit(); ?>