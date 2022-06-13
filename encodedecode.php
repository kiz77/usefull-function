<?php 
function encode($id,$key){
	// Store the cipher method 
$ciphering = "AES-128-CTR"; 
  
// Use OpenSSl Encryption method 
$iv_length = openssl_cipher_iv_length($ciphering); 
$options = 0; 
  
// Non-NULL Initialization Vector for encryption 
$encryption_iv = '1234567593012161'; 
  
// Store the encryption key 
$encryption_key = $key; 
  
// Use openssl_encrypt() function to encrypt the data 
$encryption = openssl_encrypt($id, $ciphering, 
            $encryption_key, $options, $encryption_iv);
	$encryption=str_replace('/','_s_',$encryption);
	$encryption=str_replace('+','_p_',$encryption);
	$encryption=str_replace('=','',$encryption);
	return $encryption;
}

function decode($id,$key){
	$id=str_replace('_s_','/',$id);
	$id=str_replace('_p_','+',$id);
	// Store the cipher method 
$ciphering = "AES-128-CTR"; 
	$decryption_iv = '1234567593012161'; 
  $iv_length = openssl_cipher_iv_length($ciphering); 
$options = 0; 
// Store the decryption key 
$decryption_key = $key; 
  
// Use openssl_decrypt() function to decrypt the data 
$decryption=openssl_decrypt ($id, $ciphering,  
        $decryption_key, $options, $decryption_iv); 
		
		return $decryption;
}
