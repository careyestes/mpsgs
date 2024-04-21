// Global Variables:

var validationSequence = "submit";
var ValidationEditFocus = "";
var validationSkipFlags0 = "";
var validationSkipFlags1 = 0;
var validationSkipFlags2 = 0;
var validationSkipFlags3 = 0;
var validationDimension = "";
var gblOtherPPalName = "";
var gblCheckNo = "";

// Simple Show/Hide Toggles

function toggleEntryDetails() {
    document.getElementById("receiverTable").toggleAttribute("hidden");
}

function toggleEntryFee() {
    document.getElementById("Entry_Fee_Container").toggleAttribute("hidden");
}

function hideEntryFee() {
    document.getElementById("Entry_Fee_Container").hidden = true;
}

function showEntryFee() {
    document.getElementById("Entry_Fee_Container").hidden = false;
}

function toggleInsurance() {
    document.getElementById("Insurance_Container").toggleAttribute("hidden");
}

function hideInsurance() {
    document.getElementById("Insurance_Container").hidden = true;
}

function showInsurance() {
    document.getElementById("Insurance_Container").hidden = false;
}

function toggleDues() {
    var duesContainer = document.getElementById("Dues_Container");
    duesContainer.classList.toggle("hidden");
}

function hideDues() {
    document.getElementById("Dues_Container").style.display = 'none';
}


function showDues() {
    document.getElementById("Dues_Container").style.display = 'flex';
}

function hideIntl() {
    document.getElementById("Intl_Container").style.display = 'none';
}

function showIntl() {
    document.getElementById("Intl_Container").style.display = 'flex';
}

function clearEmeritusCheckbox() {
    document.getElementById("Emeritus").checked = false;
    return false;
}


function clearBoardCheckbox() {
    document.getElementById("Board").checked = false;
    return false;
}

function togglePaymentType() {
    var paymentType = document.getElementById("Payment_Type_Container");
    paymentType.classList.toggle("hidden");
}

function toggleDuesOnly() {
    document.getElementById("DuesOnly").toggleAttribute("disabled");
}

function disableDuesOnly() {
    document.getElementById("DuesOnly").disabled = true;
}

function enableDuesOnly() {
    document.getElementById("DuesOnly").disabled = false;
}

function letterCodeLists() {

        var x = 0;

        var y = 0;

        var i = 0;

        var workNo = 0;

        var dimSel = "";

        var s = "";

        var selOpt = "";

        var titleField = "";

        var medNameField = "";

        var medLetField = "";

        var priceField = "";

        for (x = 0; x < 3; x++) {

            workNo = x + 1;

            titleField = (x * 5) + 14 + "Title" + workNo;

            medNameField = (x * 5) + 15 + "Media" + workNo;

            priceField = (x * 5) + 18 + "Price" + workNo;

              // Tooltip titles for artwork data fields

            document.forms["showEntryForm"][titleField].title = "Maximum of 44 characters including spaces.";

            document.forms["showEntryForm"][medNameField].title = "Maximum of 35 characters including spaces.";

            document.forms["showEntryForm"][priceField].title =

                "Enter $100 or more but less than $100,000.\r\n" +

                "Prices will be rounded up to the nearest $5.";

              // Also fractional inch lists for dimensions

            i = 0;

            for (y = 1; y <= 5; y++) {

                switch (y) {

                    case 1: dimSel = "fhighf"; break;

                    case 2: dimSel = "fwidef"; break;

                    case 3: dimSel = "shighf"; break;

                    case 4: dimSel = "swidef"; break;

                    case 5: dimSel = "sdeepf"; break;

                }

                dimSel = dimSel + workNo;

                s = document.getElementById(dimSel);

                selOpt = document.createElement("option");

                selOpt.text = "1/4"; selOpt.value = ".25"; s.add(selOpt); i += 1;

                selOpt = document.createElement("option");

                selOpt.text = "1/2"; selOpt.value = ".5"; s.add(selOpt); i += 1;

                selOpt = document.createElement("option");

                selOpt.text = "3/4"; selOpt.value = ".75"; s.add(selOpt); i += 1;

                selOpt = document.createElement("option");

                selOpt.text = ""; selOpt.value = "0"; s.add(selOpt); s.selectedIndex = i;

            }

        }

}

// Set Tooltips for Fee entries
function feeTitles() {

    document.forms["showEntryForm"]["39EntFee"].title =

        "Fee to enter this show:\r\n" +

        "Member within U.S. - \t\t$25\r\n" +

        "Member outside U.S. - \t$40\r\n" +

        "Non-Member hand delivered - \t$30\r\n" +

        "Non-Member mailed - \t$45";

    document.forms["showEntryForm"]["41Ins"].title =

        "$1 for every $100 of coverage plus the initial $200 of coverage ($3 = $500 coverage)";

    document.forms["showEntryForm"]["42Dues"].title =

        "Members may include their annual dues of $25 for 1 year.";

    document.forms["showEntryForm"]["43Donate"].title = "Thank you for your donation!";

    document.forms["showEntryForm"]["44Total"].title =

        "Click inside this box if the total is missing.";

    document.forms["showEntryForm"]["45ChkNo"].title = "Enter your Check Number.";

}

function priceHandler(inField) {

        var x = 0;
        var y = 0;
        var z = "";
        var i = 0;
        var workNo = 0;
        var p = "";
        var priceMsgX = "";
        var priceXOkbtn = "";
        var inFieldText = "";
        var mustSell = false;
        var v = false;

        z = document.forms["showEntryForm"][inField].value;
        x = 100;
        workNo = inField.slice(-1);

        priceMsgX = "priceMsg" + workNo;
        inFieldText = "priceMsg" + workNo + "Text";
        priceXOkbtn = "price" + workNo + "OkBtn";

        if (z.length > 0) {

            z = z.replace(/l/g,"1");
            z = z.replace(/o/gi,"0");

            if (/[1-9]/.test(z)) {

                i = z.indexOf(".");
                if (i < 0) {
                    i = z.length
                }

                y = (Number(z.slice(i).replace(/\D/g,"")) > 0) ? 1:0;
                z = y + Number(z.slice(0, i).replace(/\D/g,""));

                if (v = (z < x)) {

                    z = x;
                    z = formatNum(inField, z.toString());
                    // disableFormInput();

                    document.getElementById(priceMsgX).style.display="block";
                    document.getElementById(inFieldText).innerHTML = "&nbsp&nbsp<b><i>Note:</b></i> The price you entered was increased to the minimum allowed";

                    document.getElementById(priceXOkbtn).focus();

                } else if (v = (z > 99995)) {

                    v = true;
                    z = 99995;
                    z = formatNum(inField, z.toString());
                    // disableFormInput();

                    document.getElementById(priceMsgX).style.display="block";
                    document.getElementById(inFieldText).innerHTML = "&nbsp&nbsp<b><i>Note:</b></i> The price you entered was decreased to the maximum allowed";
                    document.getElementById(priceXOkbtn).focus();

                } else if (v = (z % 5 > 0)) {

                    z = z - (z % 5) + 5;
                    z = formatNum(inField, z.toString());
                    // disableFormInput();

                    document.getElementById(priceMsgX).style.display="block";
                    document.getElementById(inFieldText).innerHTML = "&nbsp&nbsp<b><i>Note:</b></i> The price you entered was rounded up to the next multiple of $5";
                    document.getElementById(priceXOkbtn).focus();

                } else {

                    z = formatNum(inField, z.toString());

                }

            } else {

                z = x;
                z = formatNum(inField, z.toString());
                // disableFormInput();

                document.getElementById(priceMsgX).style.display = "block";
                document.getElementById(inFieldText).innerHTML = "&nbsp&nbsp<b><i>Note:</b></i> The price was set to the minimum allowed";
                document.getElementById(priceXOkbtn).focus();

            }
        }
}

function formatNum(inField, z) {

    var x = "";

    if (z == 0) {

        x = "";

    } else {

        switch (z.length) {

            case 0:

                x = "";

                break;

            case 1:

            case 2:

            case 3:

                x = z;

                break;

            case 4:

            case 5:

            case 6:

                x = z.slice(0, z.length - 3) + "," + z.slice(-3);

                break;

        }

    }

    document.forms["showEntryForm"][inField].value = x;

    return x;

}

function unformatFee(inField) {

    var x = document.forms["showEntryForm"][inField].value;
    var z = x.replace(/\D/g,"");
    document.forms["showEntryForm"][inField].value = z;

}

function formatFee(inField) {

    var x = document.forms["showEntryForm"][inField].value;
    var i = x.indexOf(".");

    if (i < 0) {
        i = x.length
    }

    var z = Number(x.slice(0, i).replace(/\D/g,"")).toString();
    z = formatNum(inField, z);
    var xMsg = inField.replace(/\d/g,"").toLowerCase();

    if (Number(x.slice(i).replace(/\D/g,"")) > 0) {

        showTipMsg(xMsg);

    }

}

function recalcFeeTotal() {
    var duesOnly = document.getElementById("DuesOnly").checked;
    var emeritus = document.getElementById("Emeritus").checked;
    var memberDuesCheckbox = document.getElementById("42Dues").checked;
    var CurrentMember = document.getElementById("CurrentMember").checked;
    var intl = document.getElementById("43Intl").checked;
    var inField = "44Total"
    var total = 0;
    var z = "";

    var feeElems = document.getElementsByName("39EntFee");
    var feesChecked = false;
    var canPayDues = true;
    for (let i = 0; i < feeElems.length; i++) {

        // Disable Dues box if non member is selected
        if(feeElems[1].checked || feeElems[2].checked) {
            document.getElementById("42Dues").checked = false;
            document.getElementById("42Dues").disabled = true;
            canPayDues = false;
        } else {
            if(CurrentMember) {
                document.getElementById("42Dues").checked = true;
            }
            document.getElementById("42Dues").disabled = false;
            canPayDues = true;
        }
        
        if (feeElems[i].checked) {
            feesChecked = true;
            feeAmount = Number(document.forms["showEntryForm"]["39EntFee"].value.replace(/\D/g,""));
            break;
        }
    }

    if(emeritus) {

        total = Number(document.forms["showEntryForm"]["43Donate"].value.replace(/\D/g,""));

    } else {

        if (memberDuesCheckbox && !feesChecked) {
            total = 
            Number(document.forms["showEntryForm"]["42Dues"].value.replace(/\D/g,"")) + 
            Number(document.forms["showEntryForm"]["43Donate"].value.replace(/\D/g,""));
            
        } else if(feesChecked) {
            total = feeAmount + 
            Number(document.forms["showEntryForm"]["43Donate"].value.replace(/\D/g,""));

            if(canPayDues && memberDuesCheckbox) {
                total = total + Number(document.forms["showEntryForm"]["42Dues"].value.replace(/\D/g,""));
            }
            
            
        } else {
            total = Number(document.forms["showEntryForm"]["43Donate"].value.replace(/\D/g,""));
        }
    }

    if(intl) {
        total += Number(document.forms["showEntryForm"]["43Intl"].value.replace(/\D/g,""))
    }

    total += Number(document.forms["showEntryForm"]["41Ins"].value.replace(/\D/g,""));


    z = total.toString();
    z = formatNum(inField, z);

}

// Update which dimension fields to request based on the sculpture check box, when there is a title
function dimensionDisplayHandler(inField, titleField) {

    var x = document.forms["showEntryForm"][inField].checked;
    var t = document.forms["showEntryForm"][titleField].value;
    var workno = inField.slice(-1);
    var p = "pictureDim" + workno;
    var s = "sculptureDim" + workno;
    var dimField =  '';

    if (x) {
        document.getElementById(p).style.display = "none";
        document.getElementById(s).style.display = "flex";
        dimField = "shigh" + workno;
        DimensionHandler(dimField);
        dimField = "swide" + workno;
        DimensionHandler(dimField);
        dimField = "sdeep" + workno;
        DimensionHandler(dimField);
    } else {

        document.getElementById(p).style.display = "flex";
        document.getElementById(s).style.display = "none";
        dimField = "fhigh" + workno;
        DimensionHandler(dimField);
        dimField = "fwide" + workno;
        DimensionHandler(dimField);
    }


}

// Check dimension input for compliance
function DimensionHandler(inField) {

    var t = "";
    var m = "";
    var f = inField.slice(0, -1);
    var workno = inField.slice(-1);

    var w = "";
    var x = 0;
    var d = 0;

    var df = 0;
    var oppDimw = "";
    var oppDimf = "";
    var oppDim = "";
    var errMsg = "";

    var errno = 0;

    switch (workno) {

        case "1": titlefield = "14Title1"; break;

        case "2": titlefield = "19Title2"; break;

        case "3": titlefield = "24Title3"; break;

        default: alert ("Warning: Internal error\n    '" + workno + "' is out of range.");

    }

    t = document.forms["showEntryForm"][titlefield].value;

    if (t.length > 0) {

        // define Ids for whole number and fractional dimensions

        w = f + "w" + workno;
        f = f + "f" + workno;

        // calculate dimension value
        x = document.getElementById(w).value;
        d = document.getElementById(f).value;

        // trim non-numeric characters

        x = x.replace(/[^0-9]/g, "");
        d = d.replace(/[^1-9.]/g, "");
        x = (d > 0) ? (x + d) : x;
        d = 0;
        errno = 0;

        // check for errors

        if (x == 0) {

            errMsg = "Please enter a dimension greater than 0.";
            errno = 1;

        }

        if (inField.slice(0, 1) == "s") {

            if (x > 6.25) {

                errMsg = "This entry is larger than the 6 inch maximum allowed in the prospectus.";
                errno = 3;

            }

        } else {

                // create the name of the opposite dimension of a pair
                if (inField.slice(1, -1) == "high") {oppDim = "wide";}
                if (inField.slice(1, -1) == "wide") {oppDim = "high";}

                oppDimw = inField.slice(0, 1) + oppDim + "w" + workno;
                oppDimf = inField.slice(0, 1) + oppDim + "f" + workno;
                oppDim = inField.slice(0, 1) + oppDim + inField.slice(-1);

                // calculate the value of the opposite dimension
                d = document.getElementById(oppDimw).value;
                df = document.getElementById(oppDimf).value;

                // trim non-numeric characters
                d = d.replace(/[^0-9]/g, "");
                df = df.replace(/[^1-9.]/g, "");
                d = (df > 0) ? (d + df) : d;

                if ((inField.slice(0, 1) == "f") && ((x * d) > 60)) {

                    errMsg = "The area of this framed work is larger than the 56 sq. in. maximum allowed in the prospectus.";
                    errno = 4;

                }
        }

        // do not display a zero if whole units are zero
        if (x == 0) {
            document.getElementById(w).value = "";
        }

        f = inField.slice(0, -1) + "msg" + workno;

        if (errno == 0) {

            // remove highlighting of the current dimension entry if no error
            document.getElementById(inField).style="padding: 0;border-style: none; border-width: 1px;border-color: transparent;";

            // remove error message from the current dimension entry
            document.getElementById(f).innerHTML = "";
            document.getElementById(f).style="display: none;";

        } else {

            // otherwise highlight the current dimension entry
            document.getElementById(inField).style="padding: 3px 0;border-style: solid; border-width: 1px;border-color: red;border-radius: 2px;";

            // display the appropriate error message
            document.getElementById(f).innerHTML = errMsg;
            document.getElementById(f).style="display: block;";

        }

        if (inField.slice(0, 1) != "s") {

            oppDimf = oppDim.slice(0, -1) + "msg" + workno;

            if ((errno == 0) && (d > 0)) {

                // remove highlighting of the opposite dimension entry of this pair if no error
                document.getElementById(oppDim).style="padding: 0;border-style: none;border-width: 1px;border-color: transparent;";
                
                // remove title message from the currrent dimension entry
                document.getElementById(oppDimf).innerHTML = "";
                document.getElementById(oppDimf).style="display: none;";

                // ignore errno 1, 2, and 3

            } else if (errno > 3) {

                // otherwise highlight the opposite dimension entry if the area is too large
                document.getElementById(oppDim).style="padding: 3px 0;border-style: solid; border-width: 1px;border-color: red;border-radius: 2px;";

                // display the appropriate error message
                document.getElementById(oppDimf).innerHTML = errMsg;
                document.getElementById(oppDimf).style="display: block;";

            }
        }
    }
}

// Finish processing after dimension validation message has been seen
function dimensionBtnHandler() {

    // hide the validation message

    document.getElementById("dimensionValidOk").style.display = "none";

    document.getElementById("dimensionMsg").style.display = "block";

    // move the mouse to the dimension in question

    document.getElementById(validationDimension).focus();

}

// final validation check for any outstanding dimension issues on "print" or "submit"
function Dimensionvalidation() {

    var workno = 0;

    var p = "";

    var s = "";

    var f = "";

    var val = true;

    var err = "";

      // assign initial value to the global variable

    validationDimension = "";

      // check every work in the list until an error is found

    for (workno = 1; ((workno <= 3) && val); workno++) {

        p = "pictureDim" + workno;

        s = "sculptureDim" + workno;

          // for pictures

        if (document.getElementById(p).style.display == "block") {

              // assign a name to the whole inch part of the dimension

            f = "fhighw" + workno;

              // if no previous error retain this name else retain previous name

            err = (val) ? f : err;

              // assign a name to the error message for the dimension

            f = "fhighmsg" + workno;

              // if no error do not change val else make val false

            val = (document.getElementById(f).innerHTML.length == 0) ? val : false;

              // contimue

            f = "fwidew" + workno;

            err = (val) ? f : err;

            f = "fwidemsg" + workno;

            val = (document.getElementById(f).innerHTML.length == 0) ? val : false;

        }

          // for sculpture

        if (document.getElementById(s).style.display == "block") {

            f = "shighw" + workno;

            err = (val) ? f : err;

            f = "shighmsg" + workno;

            val = (document.getElementById(f).innerHTML.length == 0) ? val : false;

            f = "swidew" + workno;

            err = (val) ? f : err;

            f = "swidemsg" + workno;

            val = (document.getElementById(f).innerHTML.length == 0) ? val : false;

            f = "sdeepw" + workno;

            err = (val) ? f : err;

            f = "sdeepmsg" + workno;

            val = (document.getElementById(f).innerHTML.length == 0) ? val : false;

        }

    }

      // if an error was not found 

    if (val) {

          // clear the global variable

        validationDimension = "";

    } else {

          // assign the dimension name to the global variable

        validationDimension = err;

          // show the validation message

        document.getElementById("dimensionMsg").style.display = "none";

        document.getElementById("dimensionValidOk").style.display = "block";

          // move the mouse to the "OK" button

        document.getElementById("dimensionValidOkBtn").focus();

    }

      // indicate validation status

    return val;

}

// Pack dimension fields into a single field
function dimensionPack() {

    var workno = 0;
    var p = "";
    var s = "";
    var d = "";
    var x = "";
    var f = "";
    var i = "";
    var fhighw = "";
    var fwidew = "";
    var shighw = "";
    var swidew = "";
    var sdeepw = "";
    var fhighf = "";
    var fwidef = "";
    var shighf = "";
    var swidef = "";
    var sdeepf = "";

      // For every work listed

    for (workno = 1; workno <= 3; workno++) {

          // Assign the correct dimension field name

	x = "19" + workno + "Dimensions" + workno;

          // Assign names for "span" segments in the HTML above

        p = "pictureDim" + workno;

        s = "sculptureDim" + workno;

        d = "";

        fhighw = "fhighw" + workno; fhighf = "fhighf" + workno;

        fwidew = "fwidew" + workno; fwidef = "fwidef" + workno;

        shighw = "shighw" + workno; shighf = "shighf" + workno;

        swidew = "swidew" + workno; swidef = "swidef" + workno;

        sdeepw = "sdeepw" + workno; sdeepf = "sdeepf" + workno;

          // Add whole inch and fractional inches for each dimension and add separators for each picture dimension

        if (document.getElementById(p).style.display == "block") {

            f = document.getElementById(fhighw).value; d += f.replace(/[^0-9]/g, "");

            f = document.getElementById(fhighf).value; d += (f > 0) ? f.replace(/[^1-9.]/g, "") : ""; d += ' x ';

            f = document.getElementById(fwidew).value; d += f.replace(/[^0-9]/g, "");

            f = document.getElementById(fwidef).value; d += (f > 0) ? f.replace(/[^1-9.]/g, "") : "";

        }

          // Add whole inch and fractional inches for each dimension and add separators for each sculpture dimension

        if (document.getElementById(s).style.display == "block") {

            f = document.getElementById(shighw).value; d += f.replace(/[^0-9]/g, "");

            f = document.getElementById(shighf).value; d += (f > 0) ? f.replace(/[^1-9.]/g, "") : ""; d += ' x ';

            f = document.getElementById(swidew).value; d += f.replace(/[^0-9]/g, "");

            f = document.getElementById(swidef).value; d += (f > 0) ? f.replace(/[^1-9.]/g, "") : ""; d += ' x ';

            f = document.getElementById(sdeepw).value; d += f.replace(/[^0-9]/g, "");

            f = document.getElementById(sdeepf).value; d += (f > 0) ? f.replace(/[^1-9.]/g, "") : "";

        }

          // Convert decimal fractions to single character fractions (Unicode 002E is ".")

        d = d.replace(/\u002E25/g, String.fromCharCode(188)); // Character code 188 is the 1/4 symbol

        d = d.replace(/\u002E5/g, String.fromCharCode(189));  // Character code 189 is the 1/2 symbol

        d = d.replace(/\u002E75/g, String.fromCharCode(190)); // Character code 190 is the 3/4 symbol

          // Assign the value of d to the named dimension field

        document.forms["showEntryForm"][x].value = d;

    }

}

function resetPaymentContainers() {

    document.getElementById("Cash_Type").hidden = true;
    document.getElementById("Check_Type").hidden = true;
    document.getElementById("Paypal_Type").hidden = true;
    document.getElementById("OtherPaypal_Type").hidden = true;

}

function paypalInstructions() {
    document.getElementById("OtherPaypal_Type").hidden = true;
    document.getElementById("Later_Type").hidden = true;

    var paypalMethod = document.forms["showEntryForm"]["47paypalType"].value;
    var otherName = document.forms["showEntryForm"]["48OtherPayPalName"].value;
    console.log(paypalMethod);
    
    if(paypalMethod === "anotherPaypal") {
        document.getElementById("OtherPaypal_Type").toggleAttribute("hidden");
        document.forms["showEntryForm"]["48OtherPayPalName"].disabled = false;
        document.forms["showEntryForm"]["48OtherPayPalName"].value = gblOtherPPalName;
    } else {
        if (otherName.length > 0) {
            gblOtherPPalName = document.forms["showEntryForm"]["48OtherPayPalName"].value;
        }
        document.forms["showEntryForm"]["48OtherPayPalName"].value = "";
        document.forms["showEntryForm"]["48OtherPayPalName"].disabled = true;    
    }
    
    if(paypalMethod === "payLater") {
        document.getElementById("Later_Type").toggleAttribute("hidden");
    }
}

function payMethodHandler(mode) {

    var method = document.forms["showEntryForm"]["40PayMethod"].value;
    var otherName = document.forms["showEntryForm"]["48OtherPayPalName"].value;
    var chkNo = document.forms["showEntryForm"]["45ChkNo"].value;
    let total = document.forms["showEntryForm"]["44Total"].value;
    // let totalString = total.toString();

    switch (mode) {

        case "init":

            document.forms["showEntryForm"]["48OtherPayPalName"].value = "";

            document.forms["showEntryForm"]["48OtherPayPalName"].disabled = true;

            document.forms["showEntryForm"]["45ChkNo"].value = "";

            document.forms["showEntryForm"]["45ChkNo"].disabled = true;

            document.forms["showEntryForm"]["40PayMethod"].value = "";

            break;

        case "enable":

            if(method != "altPayPal") {

                document.forms["showEntryForm"]["48OtherPayPalName"].disabled = true;
                document.forms["showEntryForm"]["45ChkNo"].disabled = false;
                
            }
            
            if (method != "check") {
                
                document.forms["showEntryForm"]["48OtherPayPalName"].disabled = false;
                document.forms["showEntryForm"]["45ChkNo"].disabled = true;

            }

            break;

        case "payMeth":

            resetPaymentContainers();

            let paymentMethods = document.getElementsByClassName("paymentMethods");
            for(let i = 0; i < paymentMethods.length; i++) {
                paymentMethods[i].hidden = true;
            }
            
            if ((method == null) || (method.length < 2)) {
                
                showTipMsg("payMeth");
                
            } else {
                
                if(method == "cash") {
                    document.getElementById("Cash_Type").toggleAttribute("hidden");
                }


                if(method == "altPayPal") {

                    document.getElementById("OtherPaypal_Type").toggleAttribute("hidden");
                    document.forms["showEntryForm"]["48OtherPayPalName"].disabled = false;
                    document.forms["showEntryForm"]["48OtherPayPalName"].value = gblOtherPPalName;

                } else {

                    if (otherName.length > 0) {

                        gblOtherPPalName = document.forms["showEntryForm"]["48OtherPayPalName"].value;

                    }

                    document.forms["showEntryForm"]["48OtherPayPalName"].value = "";
                    // document.forms["showEntryForm"]["48OtherPayPalName"].disabled = true;

                }

                if (method == "check") {

                    document.getElementById("Check_Type").toggleAttribute("hidden");
                    document.forms["showEntryForm"]["45ChkNo"].disabled = false;
                    document.forms["showEntryForm"]["45ChkNo"].value = gblCheckNo;

                } else {

                    if (chkNo.length > 0) {

                        gblCheckNo = document.forms["showEntryForm"]["45ChkNo"].value;

                    }

                    document.forms["showEntryForm"]["45ChkNo"].value = "";
                    document.forms["showEntryForm"]["45ChkNo"].disabled = true;

                }

                if(method == "PayPal") {
                    document.getElementById("Paypal_Type").toggleAttribute("hidden");
                    paypalInstructions();
                }


            }

            break;

        case "altPayPal":

            if ((method == "altPayPal") && (otherName.length < 2)) {

                showTipMsg("altPPal");

            }

            break;

        case "chkNo":

            if ((method == "check") && (chkNo.length < 1)) {

                showTipMsg("chkNo");

            }

            break;

        case "PayPal":

        case "Cash":

            break;

        default:

            alert ("Warning: Internal error\n    '" + mode + "' is not a recognized payment method.");

    }

}

function togglePaymentOptions() {
    const emeritusChecked = document.getElementById("Emeritus").checked;
    const boardChecked = document.getElementById("Board").checked;
    const receiverChecked = document.getElementById("DesignatedReceiver").checked;
    
    if(emeritusChecked) {
        hideEntryFee();
        hideInsurance();
        disableDuesOnly();
        hideDues();
        hideIntl();
    } else if(boardChecked && receiverChecked) {
        hideEntryFee();
        hideInsurance();
        disableDuesOnly();
        hideDues();
    } else if(boardChecked) {
        // showEntryFee();
        hideEntryFee();
        showInsurance();
        disableDuesOnly();
        // enableDuesOnly()
        hideDues();
    } else if(receiverChecked) {
        hideEntryFee();
        hideInsurance();
        enableDuesOnly();
        showDues();
    } else {
        showEntryFee();
        showInsurance();
        enableDuesOnly();
        showDues();
        showIntl();
    }
}

function CurrentMemberSetup(e) {
    duesCheckbox = document.forms["showEntryForm"]["42Dues"].checked;

    if(duesCheckbox) {
        document.forms["showEntryForm"]["42Dues"].checked = false;
        document.forms["showEntryForm"]["42Dues"].removeAttribute('readonly');
    } else {
        document.forms["showEntryForm"]["42Dues"].checked = true;
        document.forms["showEntryForm"]["42Dues"].setAttribute('readonly', true);
    }
    recalcFeeTotal();

}

function EmeritusSetup(e) {
    const boardChecked = clearBoardCheckbox();

    togglePaymentOptions();
    
    let currentRadios = document.getElementsByName("39EntFee");
    for(var i=0; i < currentRadios.length; i++) {
        currentRadios[i].checked = false;
    }
    recalcFeeTotal();
    
}

function NewArtistSetup(e) {
    const newArtistChecked = document.getElementById("New_Artist").checked;
    if(newArtistChecked) {
        document.getElementById("42Dues").checked = false;
        hideDues();
        recalcFeeTotal();
    } else {
        showDues();
        recalcFeeTotal();
    }
}

function BoardSetup(e) {
    const emeritusChecked = clearEmeritusCheckbox();
    duesCheckbox = document.forms["showEntryForm"]["42Dues"].checked;
    
    if(duesCheckbox) {
        document.forms["showEntryForm"]["42Dues"].checked = false;
        document.forms["showEntryForm"]["42Dues"].removeAttribute('readonly');
    } else {
        document.forms["showEntryForm"]["42Dues"].checked = true;
        document.forms["showEntryForm"]["42Dues"].setAttribute('readonly', true);
    }
    
    if (emeritusChecked) {
        togglePaymentOptions();
        
        let currentRadios = document.getElementsByName("39EntFee");
        for(var i=0; i < currentRadios.length; i++) {
            currentRadios[i].checked = false;
        }
    } 

    recalcFeeTotal();
}

function receiverStatusHandler(e) {
    var receiverStatus = document.forms["showEntryForm"]["51IsReceiver"].checked;
    
    togglePaymentOptions();

    if (receiverStatus) {
        document.forms["showEntryForm"]["39EntFee"].value = 0;
        recalcFeeTotal();
    } else {
        recalcFeeTotal();
    }

}

function DuesOnlySetup() {

    toggleEntryDetails();
    toggleEntryFee();
    toggleInsurance();
    
    let currentRadios = document.getElementsByName("39EntFee");
    for(var i=0; i < currentRadios.length; i++) {
        currentRadios[i].checked = false;
    }
    // document.getElementById("entryFee1").toggleAttribute("required");
    document.getElementById("42Dues").toggleAttribute("checked");
    recalcFeeTotal();
    
}

function showTipMsg(tip) {

    disableFormInput();

    switch (tip) {

        case "priceMsg1":

            document.getElementById("priceMsg1").style.visibility="visible";

            document.getElementById("price1OkBtn").focus();

            break;

        case "priceMsg2":

            document.getElementById("priceMsg2").style.visibility="visible";

            document.getElementById("price2OkBtn").focus();

            break;

        case "priceMsg3":

            document.getElementById("priceMsg3").style.visibility="visible";

            document.getElementById("price3OkBtn").focus();

            break;

        case "ins":

            document.getElementById("insMsg").style.visibility="visible";

            document.getElementById("insOkBtn").focus();

            break;

        case "donate":

            document.getElementById("donateMsg").style.visibility="visible";

            document.getElementById("donateOkBtn").focus();

            break;

        case "payMeth":

            document.getElementById("payMethMsg").style.visibility="visible";

            document.getElementById("payMethOkBtn").focus();

            break;

        case "altPPal":

            document.getElementById("altPPalMsg").style.visibility="visible";

            document.getElementById("altPPalOkBtn").focus();

            break;

        case "chkNo":

            document.getElementById("chkNoMsg").style.visibility="visible";

            document.getElementById("chkNoOkBtn").focus();

            break;

        default:

            alert ("Warning: Internal error\n    '" +

                    tip + "' is not a recognized field in the form.");

    }

}

function tipOK(tip) {

    enableFormInput();

    switch (tip) {

        case "price1":

            document.getElementById("priceMsg1").style.display = "none";
            document.forms["showEntryForm"]["19Title2"].focus();
            break;

        case "price2":

            document.getElementById("priceMsg2").style.display="none";
            document.forms["showEntryForm"]["24Title3"].focus();
            break;

        case "price3":

            document.getElementById("priceMsg3").style.display="none";
            document.forms["showEntryForm"]["39EntFee"].focus();
            break;

        case "ins":

            document.getElementById("insMsg").style.display="none";
            document.forms["showEntryForm"]["42Dues"].focus();
            break;

        case "donate":

            document.getElementById("donateMsg").style.display="none";
            document.forms["showEntryForm"]["45ChkNo"].focus();
            break;

        case "payMeth":

            document.getElementById("payMethMsg").style.display="none";
            document.forms["showEntryForm"]["40PayMethod"].focus();
            break;

        case "altPPal":

            document.getElementById("altPPalMsg").style.display="none";
            document.forms["showEntryForm"]["48OtherPayPalName"].focus();
            break;

        case "chkNo":

            document.getElementById("chkNoMsg").style.display="none";
            document.forms["showEntryForm"]["45ChkNo"].focus();
            break;

        default:

            alert ("Warning: Internal error\n    '" + tip + "' is not a recognized field in the form.");

    }

}

function disableFormInput() {

    var x = document.getElementById("electEntForm");
    var n;
    var i;

    for (i = 0; i < x.length; i++) {

        n = x.elements[i].name;

        if (n.length > 0) {

            document.forms["showEntryForm"][n].disabled = true;

        }

    }

    for (i = 1; i <= 3; i++) {

        document.getElementById("fhigh" + i).disabled = true;
        document.getElementById("fwide" + i).disabled = true;
        document.getElementById("shigh" + i).disabled = true;
        document.getElementById("swide" + i).disabled = true;
        document.getElementById("sdeep" + i).disabled = true;

    }

    document.getElementById("PrintBtn").disabled = true;
    document.getElementById("SubmitBtn").disabled = true;
    document.forms["showEntryForm"]["100NameSuf"].focus();

}

function enableFormInput() {

    var x = document.getElementById("electEntForm");
    var n;
    var i;

    for (i = 0; i < x.length; i++) {

        n = x.elements[i].name;

        if (n.length > 0) {

            document.forms["showEntryForm"][n].disabled = false;

        }

    }

    for (i = 1; i <= 3; i++) {

        document.getElementById("fhigh" + i).disabled = false;
        document.getElementById("fwide" + i).disabled = false;
        document.getElementById("shigh" + i).disabled = false;
        document.getElementById("swide" + i).disabled = false;
        document.getElementById("sdeep" + i).disabled = false;

    }

    payMethodHandler('enable');

    document.getElementById("PrintBtn").disabled = false;
    document.getElementById("SubmitBtn").disabled = false;

}

function printHandler() {

    enableFormInput();

    if (validationSequence == "print") {

        if (validateForm()) {

            validationSequence = "submit";

            window.print();

        }

    }

}

function printButtonHandler() {

    validationSequence = "print";
    enableFormInput();
    
    if (validateForm()) {
    
        validationSequence = "submit";
        window.print();

    }
}

function downloadButtonHandler() {

    validationSequence = "download";
    enableFormInput();
    window.print();

}

function submitButtonHandler() {

        validationSequence = "submit";

        dimensionPack();

        enableFormInput();

        if (validateForm()) {

            return validationSkipFlags0;

        } else {

            return false;

        }

}

function keyHandler(event) {

    var x = event.keyCode;

    //    Disable the "Enter" key (default is to submit the form)

    if ((x == 13) && (event.target.nodeName != "TEXTAREA")) {event.preventDefault();}

}

function validationEditHandler(skipField) {

    var validationCheck = skipField + "ValidChk";
    validationSkipHandler(skipField, "reset");

    document.getElementById(validationCheck).style.display="none";
    enableFormInput();

    document.forms["showEntryForm"][ValidationEditFocus].focus();

}

function assignSkipButtonType(skipButton) {

    document.getElementById(skipButton).type = (validationSequence == "submit") ? "submit":"button";

}

function validationSkipHandler(skipField, operation) {

    var colName = skipField.replace(/\d/g,"");
    var workNo = skipField.replace(/\D/g,"");
    var flagsBit = 0;

    switch (colName) {

        case 'title':

            flagsBit = 1;

            break;

        case 'media':

            flagsBit = 2;

            break;

        case 'price':

            flagsBit = 4;

            break;

        case 'contact':

            workNo = "1";

            flagsBit = 8;

            break;

        case 'email':

            workNo = "2";

            flagsBit = 8;

            break;

        case 'rcvr':

            workNo = "1";

            flagsBit = 16;

            break;

        case 'worksCount':

            workNo = "1";

            flagsBit = 32;

            break;

        case 'entFee':

            workNo = "1";

            flagsBit = 64;

            break;

        case 'payMeth':

            workNo = "1";

            flagsBit = 128;

            break;

        case 'altPPal':

            workNo = "1";

            flagsBit = 256;

            break;

        case 'chkNo':

            workNo = "1";

            flagsBit = 512;

            break;

        case 'name':

            workNo = "0";

            break;

        default:

            alert ("Warning: Internal error\n    '" +

                   skipField + "' is not a recognized field in the form.");

    }

    switch (workNo) {

        case "1":

            if (operation == 'set') {

            //  ** a logical 'or' with the flagsBit sets that bit **

                validationSkipFlags1 = validationSkipFlags1 | flagsBit;

            } else {

            // ** a logical 'and' with the flagsBit tests that bit **

                if ((validationSkipFlags1 & flagsBit) > 0) {

                    if (operation == 'reset') {

            // ** a logical 'xor' with the flagsBit toggles that bit **

                        validationSkipFlags1 = validationSkipFlags1 ^ flagsBit;

                    }

                    return true;

                } else {

                    return false;

                }

            }

            break;

        case "2":

            if (operation == 'set') {

                validationSkipFlags2 = validationSkipFlags2 | flagsBit;

            } else {

                if ((validationSkipFlags2 & flagsBit) > 0) {

                    if (operation == 'reset') {

                        validationSkipFlags2 = validationSkipFlags2 ^ flagsBit;

                    }

                    return true;

                } else {

                    return false;

                }

            }

            break;

        case "3":

            if (operation == 'set') {

                validationSkipFlags3 = validationSkipFlags3 | flagsBit;

            } else {

                if ((validationSkipFlags3 & flagsBit) > 0) {

                    if (operation == 'reset') {

                        validationSkipFlags3 = validationSkipFlags3 ^ flagsBit;

                    }

                    return true;

                } else {

                    return false;

                }

            }

            break;

        case "0":

            break;

        default:

            alert ("Warning: Internal error\n    '" +

                   skipField + "' contains an unrecognized work number.");

    }

}

// Final checks for validity of field entries
function validateForm() {

    var fname = document.forms["showEntryForm"]["01FirstName"].value;
    var lname = document.forms["showEntryForm"]["02LastName"].value;
    var rcvr = document.forms["showEntryForm"]["12Receiver"].value;
    
    var workTitle = [
        document.forms["showEntryForm"]["14Title1"].value,            
        document.forms["showEntryForm"]["19Title2"].value,
        document.forms["showEntryForm"]["24Title3"].value
    ];
    
    var workMedia = [
        document.forms["showEntryForm"]["15Media1"].value,
        document.forms["showEntryForm"]["20Media2"].value,
        document.forms["showEntryForm"]["25Media3"].value
    ];
    
    var workSculpt = [
        document.forms["showEntryForm"]["16Sculpture1"].checked,
        document.forms["showEntryForm"]["21Sculpture2"].checked,
        document.forms["showEntryForm"]["26Sculpture3"].checked
    ];
    
    var workPrice = [
        document.forms["showEntryForm"]["18Price1"].value,
        document.forms["showEntryForm"]["23Price2"].value,
        document.forms["showEntryForm"]["28Price3"].value
    ];

    var addr1 = "";
    var xcity = "";
    var xstat = "";
    var pcode = "";
    var xtele = "";
    var xmail = "";

    var missedFieldCount = 0;
    var missingField = false;

    var entFee = "";
    var payMeth = "";

    var altPPal = document.forms["showEntryForm"]["48OtherPayPalName"].value;
    var chkNo = document.forms["showEntryForm"]["45ChkNo"].value;
    var isRcvr = document.forms["showEntryForm"]["51IsReceiver"].checked;
    var feeTot = document.forms["showEntryForm"]["44Total"].value;

    var d = document.getElementById("DuesOnly").checked;
    var emeritus = document.getElementById("Emeritus").checked;
    // var d = document.forms["showEntryForm"]["12Receiver"].disabled;

    var x = 0;
    var c = 0;
    var m = 0;
    var n = "";

    var workNo = 0;
    var skipButton = "";
    var inField = "";

    var worksCount = 0;

    document.getElementById("nameValidChk").style.display = "none";
    document.getElementById("contactValidChk").style.display = "none";
    document.getElementById("rcvrValidChk").style.display = "none";

    for (workNo = 1; workNo <= 3; workNo += 1) {

        document.getElementById("title" + workNo + "ValidChk").style.display = "none";
        document.getElementById("media" + workNo + "ValidChk").style.display = "none";
        document.getElementById("price" + workNo + "ValidChk").style.display = "none";

    }

    document.getElementById("worksCountValidChk").style.display = "none";
    document.getElementById("entFeeValidChk").style.display = "none";
    document.getElementById("payMethValidChk").style.display = "none";
    document.getElementById("chkNoValidChk").style.display = "none";
    document.getElementById("nameValidMsg").innerHTML = "<b><i>Warning:</i></b> You must enter your First and Last Names for this form to be accepted";

    // ** Entry Name **
    if (fname == null || fname == "") {
        
        // disableFormInput();
        ValidationEditFocus = "01FirstName";
        document.getElementById("nameValidChk").style.display = "block";
        document.getElementById("editNameBtn").focus();
        
        return false;
        
    }
    
    if (lname == null || lname == "") {
        
        // disableFormInput();
        ValidationEditFocus = "02LastName";
        document.getElementById("nameValidChk").style.display = "block";
        document.getElementById("editNameBtn").focus();
        
        return false;
        
    }
    
    //    ** Contact Info **
    if (!validationSkipHandler("contact", "test")) {
        
        addr1 = document.forms["showEntryForm"]["04Addr1"].value;
        xcity = document.forms["showEntryForm"]["06City"].value;
        xstat = document.forms["showEntryForm"]["07State"].value;
        pcode = document.forms["showEntryForm"]["09PostCode"].value;
        xtele = document.forms["showEntryForm"]["10Phone"].value;
        xmail = document.forms["showEntryForm"]["11Email"].value;
        
        missedFieldCount = 0;
        
        // ** first check for a valid e-mail entry **
        
        if (!validationSkipHandler("email", "test")) {
            
            if (xmail.length > 0) {
                
                if (!/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(xmail)) {
                    
                    assignSkipButtonType("contactValidskip");
                    
                    validationSkipHandler("email", "set");
                    
                    document.getElementById("contactValidMsg").innerHTML = "Your E-Mail address is not properly formatted. If your E-Mail is not correct, you will not receive e-mail confirmation of this form's submittal.";
                    
                    // disableFormInput();
                    
                    document.getElementById("contactValidChk").style.display = "block";
                    document.getElementById("editContactBtn").focus();
                    
                    return false;
                    
                }
                
            } else {

                    assignSkipButtonType("contactValidskip");
                    validationSkipHandler("email", "set");

                    document.getElementById("contactValidMsg").innerHTML = "Your E-Mail address is missing. If your E-Mail is missing, you will not receive e-mail confirmation of this form's submittal.";

                    // disableFormInput();

                    document.getElementById("contactValidChk").style.display = "block";
                    document.getElementById("editContactBtn").focus();

                    return false;

            }

        }

        if (xtele == null || xtele == "") {

            if (pcode == null || pcode == "") {

                missedFieldCount += 1;
                ValidationEditFocus = "09PostCode";

            }

            if (xstat == null || xstat == "") {

                missedFieldCount += 1;
                ValidationEditFocus = "07State";

            }

            if (xcity == null || xcity == "") {

                missedFieldCount += 1;
                ValidationEditFocus = "06City";

            }

            if (addr1 == null || addr1 == "") {

                missedFieldCount += 1;
                ValidationEditFocus = "04Addr1";

            }

            if (missedFieldCount > 0) {

                assignSkipButtonType("contactValidskip");
                validationSkipHandler("contact", "set");
                document.getElementById("contactValidMsg").innerHTML = "Please enter enough contact information that we can contact you if we have any questions or issues to resolve.";

                // disableFormInput();

                document.getElementById("contactValidChk").style.display = "block";
                document.getElementById("editContactBtn").focus();

                return false;

            }

        }

    }

    if (!d) {

        // ** Receiver **
        if (rcvr == null || rcvr == "") {

            ValidationEditFocus = "12Receiver";
            document.getElementById("rcvrValidMsg").innerHTML = "Please enter your receiver's name from the list in the prospectus.";
            document.getElementById("rcvrAlertMsg").innerHTML = "[Entry is required]";
            // disableFormInput();

            document.getElementById("rcvrValidChk").style.display = "block";
            document.getElementById("editRcvrBtn").focus();

            return false;

        }

        //  ** Works (1-3) **
        for (x = 0; x < 3; x += 1) {

            workNo = x + 1;

            // ** Title **
            inField = "title" + workNo;

            if (!validationSkipHandler(inField, "test")) {

                if (workTitle[x] == null || workTitle[x] == "" || workTitle[x] == " ") {
                    
                    if ((workPrice[x] != null && workPrice[x] != "") || (workMedia[x] != null && workMedia[x] != "") || (workSculpt[x])) {
                        skipButton = "title" + workNo + "Validskip";
                        assignSkipButtonType(skipButton);
                        validationSkipHandler(inField, "set");
                        inField = ((x * 5) + 14 + "Title" + workNo);
                        ValidationEditFocus = inField;
                        inField = "title" + workNo + "ValidMsg";
    
                        document.getElementById(inField).innerHTML = "<b><i>Warning:</b></i> This work of art must have a title to be entered in the show";
    
                        inField = "title" + workNo + "ValidChk";
    
                        // disableFormInput();
    
                        document.getElementById(inField).style.display = "block";
                        inField = "editTitle" + workNo + "Btn";
                        document.getElementById(inField).focus();
    
                        return false;

                    }
                }
            }

            if (workTitle[x] != null && workTitle[x] != "" && workTitle[x] != " ") {

                worksCount += 1;

                // ** Medium **
                inField = "media" + workNo;

                if (!validationSkipHandler(inField, "test")) {

                    if (workMedia[x] == null || workMedia[x] == "" || workMedia[x] == " ") {

                        skipButton = "media" + workNo + "Validskip";
                        assignSkipButtonType(skipButton);
                        validationSkipHandler(inField, "set");
                        inField = ((x * 5) + 15 + "Media" + workNo);
                        ValidationEditFocus = inField;
                        inField = "media" + workNo + "ValidMsg";

                        document.getElementById(inField).innerHTML = "Please indicate the medium you used or the material your sculpture or scrimshaw is made of";

                        inField = "media" + workNo + "ValidChk";

                        // disableFormInput();

                        document.getElementById(inField).style.display = "block";
                        inField = "editMedia" + workNo + "Btn";
                        document.getElementById(inField).focus();

                        return false;

                    }
                }

                // ** Price **
                inField = "price" + workNo;

                if (!validationSkipHandler(inField, "test")) {

                    
                    if (workPrice[x] == null || workPrice[x] == undefined || workPrice[x] == "" || workPrice[x] == " ") {
                        
                        
                        inField = ((x * 5) + 18 + "Price" + workNo);
                        ValidationEditFocus = inField;
                        inField = "price" + workNo + "ValidMsg";
                        
                        document.getElementById(inField).innerHTML = "Please enter a price for this work of art of $100 or more but less than $100,000, rounded to the nearest $5";
                        inField = "price" + workNo + "ValidChk";
                        
                        // disableFormInput();
                        
                        document.getElementById(inField).style.display = "block";
                        inField = "editPrice" + workNo + "Btn";

                        document.getElementById(inField).focus();

                        return false;

                    }
                }
            }
        }

        // ** Number of works **
        if ((!validationSkipHandler("worksCount", "test")) && worksCount < 1) {

            assignSkipButtonType("worksCountValidskip");
            validationSkipHandler("worksCount", "set");
            ValidationEditFocus = "14Title1";
            document.getElementById("worksCountValidMsg").innerHTML = "<b><i>Warning:</b></i> No works of art have been entered on this form";
            // disableFormInput();
            document.getElementById("worksCountValidChk").style.display = "block";
            document.getElementById("editWorksCountBtn").focus();

            return false;

        }

        // ** Entry Fee **
        if (!validationSkipHandler("entFee", "test")) {

            entFee = document.forms["showEntryForm"]["39EntFee"].value;

            if (entFee != 25 && entFee != 30 && entFee != 40 && entFee != 45 && !isRcvr) {

                assignSkipButtonType("entFeeValidskip");

                validationSkipHandler("entFee", "set");

                ValidationEditFocus = "39EntFee";

                document.getElementById("entFeeValidMsg").innerHTML = "Please select the correct Entry Fee:<br />$25 for MPSGS member,<br />$30 for a non-MPSGS member with hand delivered works, or<br />$45 for a non-MPSGS member with mailed works.";

                // disableFormInput();

                document.getElementById("entFeeValidChk").style.display = "block";
                document.getElementById("entFeeValidskip").style.display = "none";
                document.getElementById("editEntFeeBtn").focus();

                return false;

            }
        }
    }

    
    // ** Payment Method **
    document.getElementById("payMethValidMsg").innerHTML = "Please select a payment method from the drop-down list";
    payMeth = document.forms["showEntryForm"]["40PayMethod"].value;

    if (payMeth.length < 2 && feeTot > 0) {

        // disableFormInput();
        ValidationEditFocus = "40PayMethod";
        document.getElementById("payMethValidChk").style.display = "block";
        document.getElementById("editPayMethBtn").focus();

        return false;

    }


    // ** Other Paypal Name **

    document.getElementById("altPPalValidMsg").innerHTML = "Please enter the other person's name";

    if (payMeth == "altPayPal" && (altPPal == null || altPPal.length < 2)) {

        // disableFormInput();
        ValidationEditFocus = "48OtherPayPalName";
        document.getElementById("altPPalValidChk").style.display = "block";
        document.getElementById("editAltPPalBtn").focus();

        return false;

    }

    //    ** Check Number **

    document.getElementById("chkNoValidMsg").innerHTML = "Please enter your check number";

    if (payMeth == "check" && (chkNo == null || chkNo.length < 1)) {

        // disableFormInput();
        ValidationEditFocus = "45ChkNo";
        document.getElementById("chkNoValidChk").style.display = "block";
        document.getElementById("editChkNoBtn").focus();

        return false;

    }

    validationSkipFlags1 = 0;
    validationSkipFlags2 = 0;
    validationSkipFlags3 = 0;

    if (d) {

        return true;

    } else {

        return Dimensionvalidation();
        
    }
}

function downloadPdf() {
    var pdf = new jsPDF('p', 'pt', 'letter');
    pdf.canvas.height = 72 * 11;
    pdf.canvas.width = 72 * 8.5;
  
    pdf.fromHTML(document.body);
  
    pdf.save('test.pdf');
};

document.addEventListener('DOMContentLoaded', (event) => {
    document.getElementById('42Dues').addEventListener('click', function(e) {
        const memberCheckbox = document.forms["showEntryForm"]["CurrentMember"].checked;
        const boardCheckbox = document.forms["showEntryForm"]["Board"].checked;
        
        if (memberCheckbox) {
            e.preventDefault(); // Prevent the click event from changing the checkbox state
        }  
        if (boardCheckbox) {
            e.preventDefault(); // Prevent the click event from changing the checkbox state
        }  
    });
});