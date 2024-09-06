<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Input Asset</title>
    </head>
    <body>
    
<?php
?>

<link rel="stylesheet" href="form.css">
<link href="https://fonts.googleapis.com/css?family=Pacifico" rel="stylesheet">
<br>

<div class="center">
        <div class="container">
            <div class="text">EAAS</div>
                <form action="" method="post">
                    <div class="data">
                        <label>Plaintext</label>
                        <input type="text" name="plaintext"> 
                    </div>
					<div class="data">
                        <label>Ciphertext</label>
                        <input type="text" name="ciphertext"> 
                    </div>
                    <div class="btn">
						<div class="inner"></div>
						<input type="submit" value="Encrypt" name="encrypt" class="tombol_login">
					</div>
					<div class="btn">
						<div class="inner"></div>
						<input type="submit" value="Decrypt" name="decrypt" class="tombol_login">
					</div>
                    <center>
						<a class="link" href="index.php">Empty this input?</a>
                    </center>



<?php

$role_id = getenv('role_id_app01');
$secret_id = getenv('secret_id_app01');
// $role_id="686510e7-b6bd-b6c6-0b31-c5d069f8231b";
// $secret_id="f8e4eeaf-9d14-5a1b-221c-48d3df470ec4";
if(isset($_POST['encrypt'])){
    
        if (empty($_POST['plaintext']) )
        {
        echo "<center>Plaintext is required</center>";
        sleep(1);
       
        }
        else{
			$role_key = 'role_id';
    		// $role_key = $_POST['role_id'];
			$secret_key = 'secret_id';

			$ch = curl_init();
    		curl_setopt($ch, CURLOPT_URL, 'https://10.20.213.161:8200/v1/auth/approle/login');
    		curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

			$data = array(
				"role_id" => $role_id,
				"secret_id" => $secret_id
			);
			$data_string = json_encode($data);

			// curl_setopt($ch, CURLOPT_POSTFIELDS, "$role_key=$role_id", "$r=$role_id");
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

			$token_response = curl_exec ($ch);
			$token_client = json_decode($token_response, true);

			// echo $token_client;

			curl_close ($ch);

			$site_id = 'plaintext';
    		$api_key = $_POST['plaintext'];
			$header_id = 'X-Vault-Token';

			$header_key = $token_client['auth']['client_token'];

			// echo $header_key;

    		$ch1 = curl_init();
    		curl_setopt($ch1, CURLOPT_URL, 'https://10.20.213.161:8200/v1/transit/encrypt/BCA-DEV-EMATERAI');
    		curl_setopt($ch1, CURLOPT_POST, 1);
			curl_setopt($ch1, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER, 0);

    		############  Only one of the statement as per condition ########### 

   			//if they have asked for post
    		// curl_setopt($ch, CURLOPT_POSTFIELDS, "$site_id=$api_key" );

    		//or if they have asked for raw post
    		curl_setopt($ch1, CURLOPT_POSTFIELDS, "$site_id=$api_key" );

    		####################################################################

    		curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
    		curl_setopt($ch1, CURLOPT_HTTPHEADER, ["$header_id:$header_key"] );

    		$api_response = curl_exec ($ch1);
			$decoded_json = json_decode($api_response, true);

			
			

			// echo $api_response;
    		curl_close ($ch1);

			?>

			<div class="data">
                <label>Results</label>
                <input type="text" value="Plaintext: <?php echo $_POST['plaintext']; ?>">
				<input type="text" value="Ciphertext: <?php echo $decoded_json['data']['ciphertext']; ?>">
            </div>
			<br><br>

<?php	
        }
}
$role_id = getenv('role_id_app01');
$secret_id = getenv('secret_id_app01');
// $role_id="686510e7-b6bd-b6c6-0b31-c5d069f8231b";
// $secret_id="f8e4eeaf-9d14-5a1b-221c-48d3df470ec4";

if(isset($_POST['decrypt'])){
    
	if (empty($_POST['ciphertext']) )
	{
	echo "<center>Ciphertext is required</center>";
	sleep(1);
   
	}
	else{
			$role_key = 'role_id';
    		// $role_key = $_POST['role_id'];
			$secret_key = 'secret_id';

			$ch = curl_init();
    		curl_setopt($ch, CURLOPT_URL, 'https://10.20.213.161:8200/v1/auth/approle/login');
    		curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

			$data = array(
				"role_id" => $role_id,
				"secret_id" => $secret_id
			);
			$data_string = json_encode($data);

			// curl_setopt($ch, CURLOPT_POSTFIELDS, "$role_key=$role_id", "$r=$role_id");
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

			$token_response = curl_exec ($ch);
			$token_client = json_decode($token_response, true);

			// echo $token_client;

			curl_close ($ch);

			$cipher_id = 'ciphertext';
    		$cipher_key = $_POST['ciphertext'];
		
			$header_id = 'X-Vault-Token';

			$header_key = $token_client['auth']['client_token'];

			// echo $header_key;

    		$ch1 = curl_init();
    		curl_setopt($ch1, CURLOPT_URL, 'https://10.20.213.161:8200/v1/transit/decrypt/BCA-DEV-EMATERAI');
    		curl_setopt($ch1, CURLOPT_POST, 1);
			curl_setopt($ch1, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER, 0);

    		############  Only one of the statement as per condition ########### 

   			//if they have asked for post
    		// curl_setopt($ch, CURLOPT_POSTFIELDS, "$site_id=$api_key" );

    		//or if they have asked for raw post
    		curl_setopt($ch1, CURLOPT_POSTFIELDS, "$cipher_id=$cipher_key" );

    		####################################################################

    		curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
    		curl_setopt($ch1, CURLOPT_HTTPHEADER, ["$header_id:$header_key"] );

    		$api_response = curl_exec ($ch1);
			$decoded_json = json_decode($api_response, true);
			// echo $api_response;
			
			

			// echo $api_response;
    		curl_close ($ch1);

			?>

			<div class="data">
                <label>Results</label>
                <input type="text" value="Ciphertext: <?php echo $_POST['ciphertext']; ?>">
				<input type="text" value="Plaintext: <?php echo $decoded_json['data']['plaintext']; ?>">
            </div>
			<br><br>
		<?php
		}
}
?>

</form>
</div>
</div></div>
</body>
</html>
