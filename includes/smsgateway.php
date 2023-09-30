<?php
    if(isset($_POST['test'])){
        $number = $_POST['number'];
        $message = $_POST['message'];

        $ch = curl_init();
        $parameters = array(
            'apikey' => 'a98eb9abe2636f1d3c09370d98663a40',
            'number' => $number,
            'message' => $message,
            'sendername' => 'EFarmErce'
        );
        curl_setopt( $ch, CURLOPT_URL,'https://semaphore.co/api/v4/messages' );
        curl_setopt( $ch, CURLOPT_POST, 1 );

        //Send the parameters set above with the request
        curl_setopt( $ch, CURLOPT_POSTFIELDS, http_build_query( $parameters ) );

        // Receive response from server
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        $output = curl_exec( $ch );
        curl_close ($ch);

        echo $output;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="" method="POST">
    <input type="text" name="number">
    <input type="text" name="message">
    <button type="submit" name="test"></button>
    </form>
</body>
</html>