<?php
if (isset($_POST['submit'])) {
    date_default_timezone_set('Africa/Nairobi');

    # Access token credentials
    $consumerKey = 'nk16Y74eSbTaGQgc9WF8j6FigApqOMWr'; // Replace with your app Consumer Key
    $consumerSecret = '40fD1vRXCq90XFaU'; // Replace with your app Secret

    # Define other variables
    $BusinessShortCode = '174379';
    $Passkey = 'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919';

    $PartyA = $_POST['phone']; // Client's phone number
    $AccountReference = '2255';
    $TransactionDesc = 'Test Payment';
    $Amount = $_POST['amount'];

    # Get the timestamp in the format YYYYmmddhms -> 20181004151020
    $Timestamp = date('YmdHis');

    # Get the base64 encoded password string
    $Password = base64_encode($BusinessShortCode . $Passkey . $Timestamp);

    # Header for access token request
    $headers = ['Content-Type:application/json; charset=utf8'];

    # M-PESA endpoint URLs
    $access_token_url = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
    $initiate_url = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';

    # Callback URL
    $CallBackURL = 'https://morning-basin-87523.herokuapp.com/callback_url.php';

    # Get access token
    $curl = curl_init($access_token_url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($curl, CURLOPT_HEADER, FALSE);
    curl_setopt($curl, CURLOPT_USERPWD, $consumerKey . ':' . $consumerSecret);
    $result = curl_exec($curl);
    $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    
    if ($status !== 200 || $result === false) {
        die("Error: Unable to obtain access token. HTTP Status Code: " . $status);
    }

    $result = json_decode($result, true);
    
    if (isset($result['access_token'])) {
        $access_token = $result['access_token'];
    } else {
        die("Error: Access token not received. Check your credentials or API response.");
    }
    curl_close($curl);

    # Header for STK push
    $stkheader = [
        'Content-Type:application/json',
        'Authorization:Bearer ' . $access_token
    ];

    # Initiating the transaction
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $initiate_url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $stkheader);

    $curl_post_data = array(
        'BusinessShortCode' => $BusinessShortCode,
        'Password' => $Password,
        'Timestamp' => $Timestamp,
        'TransactionType' => 'CustomerPayBillOnline',
        'Amount' => $Amount,
        'PartyA' => $PartyA,
        'PartyB' => $BusinessShortCode,
        'PhoneNumber' => $PartyA,
        'CallBackURL' => $CallBackURL,
        'AccountReference' => $AccountReference,
        'TransactionDesc' => $TransactionDesc
    );

    $data_string = json_encode($curl_post_data);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
    $curl_response = curl_exec($curl);
    
    if ($curl_response === false) {
        die("Error: Failed to initiate transaction. cURL error: " . curl_error($curl));
    }

    curl_close($curl);

    // Decode JSON response into an associative array
    $responseArray = json_decode($curl_response, true);

    // Check if the response was successful and display a concise message
    if (isset($responseArray['ResponseCode']) && $responseArray['ResponseCode'] === "0") {
        echo "Transaction successfully initiated.";
    } else {
        $errorDescription = isset($responseArray['ResponseDescription']) ? $responseArray['ResponseDescription'] : 'Unknown error';
        echo "Failed to initiate transaction: " . $errorDescription;
    }
}
?>
