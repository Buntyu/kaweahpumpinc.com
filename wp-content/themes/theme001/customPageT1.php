<?php /* Template Name: CustomPageT1 */ ?>
 
<?php get_header(); ?>
 <?php

require_once "config.php";

$type = "";
$message = "";

if (!empty($_POST["pay_now"])) {
	
    require_once 'AuthorizeNetPayment.php';
    $authorizeNetPayment = new AuthorizeNetPayment();
    
    $response = $authorizeNetPayment->chargeCreditCard($_POST);
     
    if ($response != null)
    {
        
        $tresponse = $response->getTransactionResponse();
   // echo $tresponse->getResponseCode();
    //echo "bunty";
        
        if (($tresponse != null) && ($tresponse->getResponseCode()=="1"))
        {
            
            $authCode = $tresponse->getAuthCode();
            $paymentResponse = $tresponse->getMessages()[0]->getDescription();
            $reponseType = "success";
           
         $to = "sarah.gargan@kaweahpump.com, William.gargan@kaweahpump.com,Yadira.Cerrillos@kaweahpump.com";
          //$to = "testing@mc-solutions.com";
         $subject = "Payment on kaweahpumpinc";
         
         $message =   "<b>Customer name.</b>" .$_POST['customer_name'] ."<br>";
        $message .= "<b>Invoice number.</b>" .$_POST['invoice_number'] ."<br>";
         $message .= "<b>Customer number.</b>" .$_POST['customer_number'] ."<br>";
         $message .= "<b>Amount.</b>" .$_POST['cust_amount'] ."<br>";
           $message .= "<b>First name.</b>" .$_POST['f_name'] ."<br>";
        $message .= "<b>Last number.</b>" .$_POST['l_name'] ."<br>";
         $message .= "<b>Bill Address.</b>" .$_POST['bill_add'] ."<br>";
         $message .= "<b>Country.</b>" .$_POST['country_name'] ."<br>";
         $message .= "<b>State.</b>" .$_POST['state_name'] ."<br>";
         $message .= "<b>City.</b>" .$_POST['city_name'] ."<br>";
         $message .= "<b>Postal Code.</b>" .$_POST['postal_code_val'] ."<br>";
         $message .= "<b>Phone.</b>" .$_POST['phone'] ."<br>";
         $message .= "<b>Email.</b>" .$_POST['email_user'] ."<br>";
         
         $header = "From:kaweahpumpinc \r\n";
         $header .= "Cc:afgh@somedomain.com \r\n";
         $header .= "MIME-Version: 1.0\r\n";
         $header .= "Content-type: text/html\r\n";
         
         $retval = mail ($to,$subject,$message,$header);
            $location = "https://kaweahpumpinc.com/thank-you/";
			wp_redirect( $location, 301 );
exit;   
            $message = "This transaction has been approved. <br/> Charge Credit Card AUTH CODE : " . $tresponse->getAuthCode() .  " <br/>Charge Credit Card TRANS ID  : " . $tresponse->getTransId() . "\n";
        }
        else
        {
            $authCode = "";
            $paymentResponse = $tresponse->getErrors()[0]->getErrorText();
            $reponseType = "error";
           //$message = "Charge Credit Card ERROR :  Invalid response\n";
           $location = "https://kaweahpumpinc.com/error-page/";
			wp_redirect( $location, 301 );
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
        die("error");
        $reponseType = "error";
        $message= "Charge Credit Card Null response returned";
    }
}
?>
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
  font-family: helvetica;
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
  font-family: helvetica;
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
  padding: 10px 30px;
  font-size: 17px;
  font-family: helvetica;
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
form#frmPayment {
    width: 70%;
    margin: 0 auto;
    margin-top: 120px;
    background-color: #dcd9d9;
     margin-bottom: 50px;
}
.tab {
    width: 60% !important;
    margin: 0 auto;
    padding-top:20px;
}
.infobill {
    font-size: 16px;
    color: #000;
    font-weight: 600;
    padding-left: 15px;
    padding-top: 10px;
}
h4.billpaymnt {
    font-size: 16px;
    font-weight: 600;
   
}
input::placeholder {
    color: #868181;
    font-size: 15px;
}
span.tab-label {
    font-size: 16px;
}
.tab p {https://kaweahpumpinc.com/payment/
    padding: 5px;
}
#year {
    padding: 5px 25px;
}
#month {
    padding: 5px 15px;
}
.mnthnmber {
    margin-top: 15px;
    margin-bottom: 20px;
    width: 80%;
}
#card-number {
    width: 80%;
}
#select-country {
	padding: 7px;
	width: 100%;
}
#frmPayment .tab {
	padding-top: 90px;
}
#email_message {
    color: #ea2d2d;
}
.infobill {
    font-size: 16px;
    color: #000;
    font-weight: 600;
    padding-left: 15px;
    padding-top: 10px;
}
h4.billpaymnt {
    font-size: 16px;
    font-weight: 600;
   
}
</style>
<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">
     
<form id="frmPayment" action="" method="post" onSubmit="return cardValidation();">
 
  <!-- One "tab" for each step in the form: -->
  <div class="tab">
      <h1 class="infobill"> Please enter your bill information. </h1>
  <h4 class="billpaymnt">Bill Payment :</h4>
    <p><input placeholder="Customer Name ..." oninput="this.className = ''" name="customer_name"></p>
    <p><input placeholder="Invoice Number" oninput="this.className = ''" name="invoice_number"></p>
    <p><input placeholder="Customer Number " oninput="this.className = ''" name="customer_number"></p>
    <p><input placeholder="Amount " oninput="this.className = ''" name="cust_amount" id="cust_amt"></p>
  </div>
  <div class="tab">
      <h1 class="infobill"> Credit card billing information </h1>
    <p><input placeholder="First Name" oninput="this.className = ''" name="f_name"></p>
    <p><input placeholder="Last name..." oninput="this.className = ''" name="l_name"></p>
    <p><input placeholder="Billing Address..." oninput="this.className = ''" name="bill_add"></p>
    <p>
         <select name="country_name" id="select-country">
<option value="">Country</option>
<option value="Afganistan">Afghanistan</option>
<option value="Albania">Albania</option>
<option value="Algeria">Algeria</option>
<option value="American Samoa">American Samoa</option>
<option value="Andorra">Andorra</option>
<option value="Angola">Angola</option>
<option value="Anguilla">Anguilla</option>
<option value="Antigua &amp; Barbuda">Antigua &amp; Barbuda</option>
<option value="Argentina">Argentina</option>
<option value="Armenia">Armenia</option>
<option value="Aruba">Aruba</option>
<option value="Australia">Australia</option>
<option value="Austria">Austria</option>
<option value="Azerbaijan">Azerbaijan</option>
<option value="Bahamas">Bahamas</option>
<option value="Bahrain">Bahrain</option>
<option value="Bangladesh">Bangladesh</option>
<option value="Barbados">Barbados</option>
<option value="Belarus">Belarus</option>
<option value="Belgium">Belgium</option>
<option value="Belize">Belize</option>
<option value="Benin">Benin</option>
<option value="Bermuda">Bermuda</option>
<option value="Bhutan">Bhutan</option>
<option value="Bolivia">Bolivia</option>
<option value="Bonaire">Bonaire</option>
<option value="Bosnia &amp; Herzegovina">Bosnia &amp; Herzegovina</option>
<option value="Botswana">Botswana</option>
<option value="Brazil">Brazil</option>
<option value="British Indian Ocean Ter">British Indian Ocean Ter</option>
<option value="Brunei">Brunei</option>
<option value="Bulgaria">Bulgaria</option>
<option value="Burkina Faso">Burkina Faso</option>
<option value="Burundi">Burundi</option>
<option value="Cambodia">Cambodia</option>
<option value="Cameroon">Cameroon</option>
<option value="Canada">Canada</option>
<option value="Canary Islands">Canary Islands</option>
<option value="Cape Verde">Cape Verde</option>
<option value="Cayman Islands">Cayman Islands</option>
<option value="Central African Republic">Central African Republic</option>
<option value="Chad">Chad</option>
<option value="Channel Islands">Channel Islands</option>
<option value="Chile">Chile</option>
<option value="China">China</option>
<option value="Christmas Island">Christmas Island</option>
<option value="Cocos Island">Cocos Island</option>
<option value="Colombia">Colombia</option>
<option value="Comoros">Comoros</option>
<option value="Congo">Congo</option>
<option value="Cook Islands">Cook Islands</option>
<option value="Costa Rica">Costa Rica</option>
<option value="Cote DIvoire">Cote D'Ivoire</option>
<option value="Croatia">Croatia</option>
<option value="Cuba">Cuba</option>
<option value="Curaco">Curacao</option>
<option value="Cyprus">Cyprus</option>
<option value="Czech Republic">Czech Republic</option>
<option value="Denmark">Denmark</option>
<option value="Djibouti">Djibouti</option>
<option value="Dominica">Dominica</option>
<option value="Dominican Republic">Dominican Republic</option>
<option value="East Timor">East Timor</option>
<option value="Ecuador">Ecuador</option>
<option value="Egypt">Egypt</option>
<option value="El Salvador">El Salvador</option>
<option value="Equatorial Guinea">Equatorial Guinea</option>
<option value="Eritrea">Eritrea</option>
<option value="Estonia">Estonia</option>
<option value="Ethiopia">Ethiopia</option>
<option value="Falkland Islands">Falkland Islands</option>
<option value="Faroe Islands">Faroe Islands</option>
<option value="Fiji">Fiji</option>
<option value="Finland">Finland</option>
<option value="France">France</option>
<option value="French Guiana">French Guiana</option>
<option value="French Polynesia">French Polynesia</option>
<option value="French Southern Ter">French Southern Ter</option>
<option value="Gabon">Gabon</option>
<option value="Gambia">Gambia</option>
<option value="Georgia">Georgia</option>
<option value="Germany">Germany</option>
<option value="Ghana">Ghana</option>
<option value="Gibraltar">Gibraltar</option>
<option value="Great Britain">Great Britain</option>
<option value="Greece">Greece</option>
<option value="Greenland">Greenland</option>
<option value="Grenada">Grenada</option>
<option value="Guadeloupe">Guadeloupe</option>
<option value="Guam">Guam</option>
<option value="Guatemala">Guatemala</option>
<option value="Guinea">Guinea</option>
<option value="Guyana">Guyana</option>
<option value="Haiti">Haiti</option>
<option value="Hawaii">Hawaii</option>
<option value="Honduras">Honduras</option>
<option value="Hong Kong">Hong Kong</option>
<option value="Hungary">Hungary</option>
<option value="Iceland">Iceland</option>
<option value="India">India</option>
<option value="Indonesia">Indonesia</option>
<option value="Iran">Iran</option>
<option value="Iraq">Iraq</option>
<option value="Ireland">Ireland</option>
<option value="Isle of Man">Isle of Man</option>
<option value="Israel">Israel</option>
<option value="Italy">Italy</option>
<option value="Jamaica">Jamaica</option>
<option value="Japan">Japan</option>
<option value="Jordan">Jordan</option>
<option value="Kazakhstan">Kazakhstan</option>
<option value="Kenya">Kenya</option>
<option value="Kiribati">Kiribati</option>
<option value="Korea North">Korea North</option>
<option value="Korea Sout">Korea South</option>
<option value="Kuwait">Kuwait</option>
<option value="Kyrgyzstan">Kyrgyzstan</option>
<option value="Laos">Laos</option>
<option value="Latvia">Latvia</option>
<option value="Lebanon">Lebanon</option>
<option value="Lesotho">Lesotho</option>
<option value="Liberia">Liberia</option>
<option value="Libya">Libya</option>
<option value="Liechtenstein">Liechtenstein</option>
<option value="Lithuania">Lithuania</option>
<option value="Luxembourg">Luxembourg</option>
<option value="Macau">Macau</option>
<option value="Macedonia">Macedonia</option>
<option value="Madagascar">Madagascar</option>
<option value="Malaysia">Malaysia</option>
<option value="Malawi">Malawi</option>
<option value="Maldives">Maldives</option>
<option value="Mali">Mali</option>
<option value="Malta">Malta</option>
<option value="Marshall Islands">Marshall Islands</option>
<option value="Martinique">Martinique</option>
<option value="Mauritania">Mauritania</option>
<option value="Mauritius">Mauritius</option>
<option value="Mayotte">Mayotte</option>
<option value="Mexico">Mexico</option>
<option value="Midway Islands">Midway Islands</option>
<option value="Moldova">Moldova</option>
<option value="Monaco">Monaco</option>
<option value="Mongolia">Mongolia</option>
<option value="Montserrat">Montserrat</option>
<option value="Morocco">Morocco</option>
<option value="Mozambique">Mozambique</option>
<option value="Myanmar">Myanmar</option>
<option value="Nambia">Nambia</option>
<option value="Nauru">Nauru</option>
<option value="Nepal">Nepal</option>
<option value="Netherland Antilles">Netherland Antilles</option>
<option value="Netherlands">Netherlands (Holland, Europe)</option>
<option value="Nevis">Nevis</option>
<option value="New Caledonia">New Caledonia</option>
<option value="New Zealand">New Zealand</option>
<option value="Nicaragua">Nicaragua</option>
<option value="Niger">Niger</option>
<option value="Nigeria">Nigeria</option>
<option value="Niue">Niue</option>
<option value="Norfolk Island">Norfolk Island</option>
<option value="Norway">Norway</option>
<option value="Oman">Oman</option>
<option value="Pakistan">Pakistan</option>
<option value="Palau Island">Palau Island</option>
<option value="Palestine">Palestine</option>
<option value="Panama">Panama</option>
<option value="Papua New Guinea">Papua New Guinea</option>
<option value="Paraguay">Paraguay</option>
<option value="Peru">Peru</option>
<option value="Phillipines">Philippines</option>
<option value="Pitcairn Island">Pitcairn Island</option>
<option value="Poland">Poland</option>
<option value="Portugal">Portugal</option>
<option value="Puerto Rico">Puerto Rico</option>
<option value="Qatar">Qatar</option>
<option value="Republic of Montenegro">Republic of Montenegro</option>
<option value="Republic of Serbia">Republic of Serbia</option>
<option value="Reunion">Reunion</option>
<option value="Romania">Romania</option>
<option value="Russia">Russia</option>
<option value="Rwanda">Rwanda</option>
<option value="St Barthelemy">St Barthelemy</option>
<option value="St Eustatius">St Eustatius</option>
<option value="St Helena">St Helena</option>
<option value="St Kitts-Nevis">St Kitts-Nevis</option>
<option value="St Lucia">St Lucia</option>
<option value="St Maarten">St Maarten</option>
<option value="St Pierre &amp; Miquelon">St Pierre &amp; Miquelon</option>
<option value="St Vincent &amp; Grenadines">St Vincent &amp; Grenadines</option>
<option value="Saipan">Saipan</option>
<option value="Samoa">Samoa</option>
<option value="Samoa American">Samoa American</option>
<option value="San Marino">San Marino</option>
<option value="Sao Tome &amp; Principe">Sao Tome &amp; Principe</option>
<option value="Saudi Arabia">Saudi Arabia</option>
<option value="Senegal">Senegal</option>
<option value="Serbia">Serbia</option>
<option value="Seychelles">Seychelles</option>
<option value="Sierra Leone">Sierra Leone</option>
<option value="Singapore">Singapore</option>
<option value="Slovakia">Slovakia</option>
<option value="Slovenia">Slovenia</option>
<option value="Solomon Islands">Solomon Islands</option>
<option value="Somalia">Somalia</option>
<option value="South Africa">South Africa</option>
<option value="Spain">Spain</option>
<option value="Sri Lanka">Sri Lanka</option>
<option value="Sudan">Sudan</option>
<option value="Suriname">Suriname</option>
<option value="Swaziland">Swaziland</option>
<option value="Sweden">Sweden</option>
<option value="Switzerland">Switzerland</option>
<option value="Syria">Syria</option>
<option value="Tahiti">Tahiti</option>
<option value="Taiwan">Taiwan</option>
<option value="Tajikistan">Tajikistan</option>
<option value="Tanzania">Tanzania</option>
<option value="Thailand">Thailand</option>
<option value="Togo">Togo</option>
<option value="Tokelau">Tokelau</option>
<option value="Tonga">Tonga</option>
<option value="Trinidad &amp; Tobago">Trinidad &amp; Tobago</option>
<option value="Tunisia">Tunisia</option>
<option value="Turkey">Turkey</option>
<option value="Turkmenistan">Turkmenistan</option>
<option value="Turks &amp; Caicos Is">Turks &amp; Caicos Is</option>
<option value="Tuvalu">Tuvalu</option>
<option value="Uganda">Uganda</option>
<option value="Ukraine">Ukraine</option>
<option value="United Arab Erimates">United Arab Emirates</option>
<option value="United Kingdom">United Kingdom</option>
<option value="United States of America">United States of America</option>
<option value="Uraguay">Uruguay</option>
<option value="Uzbekistan">Uzbekistan</option>
<option value="Vanuatu">Vanuatu</option>
<option value="Vatican City State">Vatican City State</option>
<option value="Venezuela">Venezuela</option>
<option value="Vietnam">Vietnam</option>
<option value="Virgin Islands (Brit)">Virgin Islands (Brit)</option>
<option value="Virgin Islands (USA)">Virgin Islands (USA)</option>
<option value="Wake Island">Wake Island</option>
<option value="Wallis &amp; Futana Is">Wallis &amp; Futana Is</option>
<option value="Yemen">Yemen</option>
<option value="Zaire">Zaire</option>
<option value="Zambia">Zambia</option>
<option value="Zimbabwe">Zimbabwe</option>
</select>
        
        
    </p>
    <p><input placeholder="State..." oninput="this.className = ''" name="state_name"></p>
    <p><input placeholder="City..." oninput="this.className = ''" name="city_name"></p>
    <p><input placeholder="Postal Code..." oninput="this.className = ''" name="postal_code_val"></p>
    <p><input type="number" placeholder="Phone..." oninput="this.className = ''" name="phone"></p>
    <p><input placeholder="Email Address..." oninput="this.className = ''" name="email_user" id="em1"></p>
    <p><input placeholder="Retype Email Address..." oninput="this.className = ''" name="re_email" id="em2"></p>
    
    <div id="email_message" class="email_valid"></div>
 
  </div>
 
  <div class="tab"> 
   <div class="field-row">
        <h1 class="infobill"> Card details </h1>
                    <label>Card Number</label> <span
                        id="card-number-info" class="info"></span><br> <input
                        type="text" id="card-number" name="card-number_detail"
                        class="demoInputBox">
                </div>
                <div class="field-row">
                    <div class="contact-row column-right">
                        <label>Expiry Month / Year</label> <span
                            id="userEmail-info" class="info"></span><br>
                        <select name="month_card" id="month"
                            class="demoSelectBox">
                            <option value="01">01</option>
                            <option value="02">02</option>
                             <option value="03">03</option>
                            <option value="04">04</option>
                             <option value="05">05</option>
                            <option value="06">06</option>
                             <option value="07">07</option>
                            <option value="08">08</option>
                             <option value="09">09</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                        </select> <select name="year_card" id="year"
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
                     <input type='hidden' id='amount' name='amount11' value=''> 
                </div>
  </div>
  <div style="overflow:auto;">
    <div style="text-align: center;padding:15px;">
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
 
    </main><!-- .site-main -->
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
  if (currentTab >=x.length) {
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
   if($("#em1").val() != $("#em2").val())
{
   $("#email_message").html("Email not matched").show();

 return false;
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
    <?php get_sidebar( 'content-bottom' ); ?>
 
</div><!-- .content-area -->
 
<?php get_sidebar(); ?>
<?php get_footer(); ?>