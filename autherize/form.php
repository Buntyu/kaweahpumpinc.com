<?php

//require_once "config.php";

$type = "";
$message = "";
if (!empty($_POST["pay_now"])) {
    require_once 'AuthorizeNetPayment.php';
    $authorizeNetPayment = new AuthorizeNetPayment();
    
    $response = $authorizeNetPayment->chargeCreditCard($_POST);
    
    if ($response != null)
    {
        $tresponse = $response->getTransactionResponse();
        
        if (($tresponse != null) && ($tresponse->getResponseCode()=="1"))
        {
            $authCode = $tresponse->getAuthCode();
            $paymentResponse = $tresponse->getMessages()[0]->getDescription();
            $reponseType = "success";
             header("Location: thanku.php");
            die();
            $message = "This transaction has been approved. <br/> Charge Credit Card AUTH CODE : " . $tresponse->getAuthCode() .  " <br/>Charge Credit Card TRANS ID  : " . $tresponse->getTransId() . "\n";
        }
        else
        {
            $authCode = "";
            $paymentResponse = $tresponse->getErrors()[0]->getErrorText();
            $reponseType = "error";
            $message = "Charge Credit Card ERROR :  Invalid response\n";
        }
        
        $transactionId = $tresponse->getTransId();
        $responseCode = $tresponse->getResponseCode();
        $paymentStatus = $authorizeNetPayment->responseText[$tresponse->getResponseCode()];
       // require_once "DBController.php";
        //$dbController = new DBController();
        
        $param_type = 'sssdss';
       /* $param_value_array = array(
            $transactionId,
            $authCode,
            $responseCode,
            $_POST["amount"],
            $paymentStatus,
            $paymentResponse
        );*/
        /*print "<PRE>";
        print_r($param_value_array);
        exit; */
        /*$query = "INSERT INTO tbl_authorizenet_payment (transaction_id, auth_code, response_code, amount, payment_status, payment_response) values (?, ?, ?, ?, ?, ?)";
        $id = $dbController->insert($query, $param_type, $param_value_array);*/
    }
    else
    {
        $reponseType = "error";
        $message= "Charge Credit Card Null response returned";
    }
}
?>
<!DOCTYPE html>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
<style>
* {
  box-sizing: border-box;
}

body {
  background-color: #f1f1f1;
}

#regForm {
  background-color: #ffffff;
  margin: 100px auto;
  font-family: Raleway;
  padding: 40px;
  width: 70%;
  min-width: 300px;
}

h1 {
  text-align: center;  
}

input {
  padding: 10px;
  width: 100%;
  font-size: 17px;
  font-family: Raleway;
  border: 1px solid #aaaaaa;
}

/* Mark input boxes that gets an error on validation: */
input.invalid {
  background-color: #ffdddd;
}

/* Hide all steps by default: */
.tab {
  display: none;
}

button {
  background-color: #4CAF50;
  color: #ffffff;
  border: none;
  padding: 10px 20px;
  font-size: 17px;
  font-family: Raleway;
  cursor: pointer;
}

button:hover {
  opacity: 0.8;
}

#prevBtn {
  background-color: #bbbbbb;
}

/* Make circles that indicate the steps of the form: */
.step {
  height: 15px;
  width: 15px;
  margin: 0 2px;
  background-color: #bbbbbb;
  border: none;  
  border-radius: 50%;
  display: inline-block;
  opacity: 0.5;
}

.step.active {
  opacity: 1;
}

/* Mark the steps that are finished and valid: */
.step.finish {
  background-color: #4CAF50;
}
</style>
<body>

<form id="frmPayment" action="" method="post" onSubmit="return cardValidation();">
  <h1>Customer:</h1>
  <!-- One "tab" for each step in the form: -->
  <div class="tab">Name:
    <p><input placeholder="Customer Name ..." oninput="this.className = ''" name="customer_name"></p>
    <p><input placeholder="Invoice Number" oninput="this.className = ''" name="invoice_number"></p>
    <p><input placeholder="Customer Number " oninput="this.className = ''" name="customer_number"></p>
    <p><input placeholder="Amount " oninput="this.className = ''" name="cust_amount" id="cust_amt"></p>
  </div>
  <div class="tab">Credit card billing information:
    <p><input placeholder="First Name" oninput="this.className = ''" name="fname"></p>
    <p><input placeholder="Last name..." oninput="this.className = ''" name="lname"></p>
    <p><input placeholder="Billing Address..." oninput="this.className = ''" name="bill_add"></p>
    <p><input placeholder="Country..." oninput="this.className = ''" name="country"></p>
    <p><input placeholder="State..." oninput="this.className = ''" name="state"></p>
    <p><input placeholder="City..." oninput="this.className = ''" name="city"></p>
    <p><input placeholder="Postal Code..." oninput="this.className = ''" name="postal_code"></p>
    <p><input placeholder="Phone..." oninput="this.className = ''" name="phone"></p>
    <p><input placeholder="Email Address..." oninput="this.className = ''" name="email"></p>
    <p><input placeholder="Retype Email Address..." oninput="this.className = ''" name="re_email"></p>
    
 
  </div>
 
  <div class="tab"> Card detail:
   <div class="field-row">
                    <label>Card Number</label> <span
                        id="card-number-info" class="info"></span><br> <input
                        type="text" id="card-number" name="card-number"
                        class="demoInputBox">
                </div>
                <div class="field-row">
                    <div class="contact-row column-right">
                        <label>Expiry Month / Year</label> <span
                            id="userEmail-info" class="info"></span><br>
                        <select name="month" id="month"
                            class="demoSelectBox">
                            <option value="09">09</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                        </select> <select name="year" id="year"
                            class="demoSelectBox">
                            <option value="2018">2018</option>
                            <option value="2019">2019</option>
                            <option value="2020">2020</option>
                            <option value="2021">2021</option>
                            <option value="2022">2022</option>
                            <option value="2023">2023</option>
                            <option value="2024">2024</option>
                            <option value="2025">2025</option>
                            <option value="2026">2026</option>
                            <option value="2027">2027</option>
                            <option value="2028">2028</option>
                            <option value="2029">2029</option>
                            <option value="2030">2030</option>
                        </select>
                    </div>
                     <input type='hidden' id='amount' name='amount' value=''> 
                </div>
  </div>
  <div style="overflow:auto;">
    <div style="float:right;">
      <button type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
      <button type="submit" id="submit-btn" onclick="nextPrev(1)" name="pay_now" value="Submit" class="btnAction">Next</button>
    </div>
  </div>
  <!-- Circles which indicates the steps of the form: -->
  <div style="text-align:center;margin-top:40px;">
    <span class="step"></span>
    <span class="step"></span>
    <span class="step"></span>
   
  </div>
</form>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"
        type="text/javascript"></script>
    <script>
function cardValidation () {
    var valid = true;
    var cardNumber = $('#card-number').val();
    var month = $('#month').val();
    var year = $('#year').val();
   
    $("#error-message").html("").hide();

    if (cardNumber.trim() == "") {
    	   valid = false;
    }

    if (month.trim() == "") {
    	    valid = false;
    }
    if (year.trim() == "") {
        valid = false;
    }

    if(valid == false) {
        $("#error-message").html("All Fields are required").show();
    }

    return valid;
}
</script>
<script>
var currentTab = 0; // Current tab is set to be the first tab (0)
showTab(currentTab); // Display the current tab

function showTab(n) {
  // This function will display the specified tab of the form...
  var x = document.getElementsByClassName("tab");
  x[n].style.display = "block";
  //... and fix the Previous/Next buttons:
  if (n == 0) {
    document.getElementById("prevBtn").style.display = "none";
  } else {
    document.getElementById("prevBtn").style.display = "inline";
  }
  if (n == (x.length - 1)) {
    document.getElementById("submit-btn").innerHTML = "PAY";
     var amt = $('#cust_amt').val();
    document.getElementById("amount").value = amt;
  } else {
    document.getElementById("submit-btn").innerHTML = "Next";
  }
  //... and run a function that will display the correct step indicator:
  fixStepIndicator(n)
}

function nextPrev(n) {
  // This function will figure out which tab to display
  var x = document.getElementsByClassName("tab");
  // Exit the function if any field in the current tab is invalid:
  if (n == 1 && !validateForm()) return false;
  // Hide the current tab:
  x[currentTab].style.display = "none";
  // Increase or decrease the current tab by 1:
  currentTab = currentTab + n;
  // if you have reached the end of the form...
  if (currentTab >= x.length) {
    // ... the form gets submitted:
    document.getElementById("frmPayment").submit();
    return false;
  }
  // Otherwise, display the correct tab:
  showTab(currentTab);
}

function validateForm() {
  // This function deals with validation of the form fields
  var x, y, i, valid = true;
  x = document.getElementsByClassName("tab");
  y = x[currentTab].getElementsByTagName("input");
  // A loop that checks every input field in the current tab:
  for (i = 0; i < y.length; i++) {
    // If a field is empty...
    if (y[i].value == "") {
      // add an "invalid" class to the field:
      y[i].className += " invalid";
      // and set the current valid status to false
      valid = false;
    }
  }
  // If the valid status is true, mark the step as finished and valid:
  if (valid) {
    document.getElementsByClassName("step")[currentTab].className += " finish";
  }
  return valid; // return the valid status
}

function fixStepIndicator(n) {
  // This function removes the "active" class of all steps...
  var i, x = document.getElementsByClassName("step");
  for (i = 0; i < x.length; i++) {
    x[i].className = x[i].className.replace(" active", "");
  }
  //... and adds the "active" class on the current step:
  x[n].className += " active";
}
</script>

</body>
</html>
