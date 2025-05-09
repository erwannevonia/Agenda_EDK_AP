<?php

// Inclusion des d�pendances
require_once dirname(__FILE__).'../vendor/autoload.php';
use OTPHP\TOTP;

/***********************
 * G�n�ration d'un secret
***********************/
$otp = TOTP::create();
$secret = $otp->getSecret();


// Utilisation d'un secret d�j� g�n�r�
$secret = "VKNXPEUVFKXK24ZKFGPH4KSJ3B4BNCASN45LD3NZ6KNF35BQF4DPCA7DLXPEVL64IEBTJ2G4MAXMGJWX7WG64YPKQY3TCHWK6IDKGQQ";
$secretOutput = "The OTP secret is: {$secret}\n";


/***********************
 * Cr�ation du TOTP avec des informations pr�cises
 ***********************/
$otp = TOTP::create(
    $secret,                   // secret utilis� (g�n�r� plus haut)
    30,                 // p�riode de validit�
    'sha256',           // Algorithme utilis�
    6                   // 6 digits
);
$otp->setLabel('Test'); // The label
$otp->setIssuer('Test Erwann');
$otp->setParameter('image', 'https://media.discordapp.net/attachments/1048215683462336543/1327815107497033961/f60252c76ad9f10c8507e04c588f2488.jpg?ex=67e20a2f&is=67e0b8af&hm=21c80a96502d6f583a3d5e82c687ec91ffd5178edbc4653d5226108affec39c9&=&format=webp'); // FreeOTP can display image

$otpOutput = "The current OTP is: {$otp->now()}\n";

/***********************
 * Affichage du temps pour information
 ***********************/
// D�finition de la zone de temps
date_default_timezone_set('Europe/Paris');
$maintenant = time() ;

// Affichage de maintenant
$dateOutput = date('Y-m-d H:i:s',$maintenant);









/***********************
 * G�n�ration du QrCode
 ***********************/
// Note: You must set label before generating the QR code
$grCodeUri = $otp->getQrCodeUri(
    'https://api.qrserver.com/v1/create-qr-code/?data=[DATA]&size=300x300&ecc=M',
    '[DATA]'
);
$qrCodeOutput = "<img src='{$grCodeUri}' style='height=100px; width:100px' alt='Image d'un QR Code'>";













// /***********************
//  * Fonction de v�rification du formulaire
//  ***********************/
// // Fonction qui renvoie true si login et mot de passe sont corrects
// function checkLoginPassword($login, $password)
// {
//     if ($login=='toto' && $password=='titi') return true;
//     return false;
// }











// // V�rifie la valeur OTP
// function checkOTP($otp_form): bool
// {
//     global $otp;

//     return $otp->verify($otp_form);
// }











// $formOutput = '';
// // Traitement du formulaire de login:
// if (!empty($_POST['login']))
// {
//     if ( checkLoginPassword($_POST['login'], $_POST['password'] ) && checkOTP( $_POST['otp'] ) )
//         $formOutput = "Login OK !";
//     else
//         $formOutput = "Echec login";
// }