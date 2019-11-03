<?php


use BitPayKeyUtils\KeyHelper\PrivateKey;
use BitPayKeyUtils\Storage\EncryptedFilesystemStorage;
use Symfony\Component\Yaml\Yaml;

require __DIR__.'/../vendor/autoload.php';

/**
 * DEFINE THE FOLLOWING VARIEBLES FOR YOUR NEW CONFIGURATION FILE
 */

$isProd = false; // Set to true if the environment for which the configuration file will be generated is Production.
// Will be set to Test otherwise

$privateKeyname = 'PrivateKeyName.key'; // Add here the name for your Private key

$generateMerchantToken = true; // Set to true to generate a token for the Merchant facade
$generatePayrollToken = false; // Set to true to generate a token for the Payroll facade (Request to Support if you need it)

$yourMasterPassword = 'YourMasterPassword'; //Will be used to encrypt your PrivateKey

$generateJSONfile = true; // Set to true to generate the Configuration File in Json format
$generateYMLfile = true; // Set to true to generate the Configuration File in Yml format


/**
 * WARNING: DO NOT CHANGE ANYTHING FROM HERE ON
 */

/**
 * Generate new private key.
 * Make sure you provide an easy recognizable name to your private key
 * NOTE: In case you are providing the BitPay services to your clients,
 *       you MUST generate a different key per each of your clients
 *
 * WARNING: It is EXTREMELY IMPORTANT to place this key files in a very SECURE location
 **/
$privateKey = new PrivateKey($privateKeyname);
$storageEngine = new EncryptedFilesystemStorage($yourMasterPassword);

try {
//  Use the EncryptedFilesystemStorage to load the Merchant's encrypted private key with the Master Password.
    $privateKey = $storageEngine->load($privateKeyname);
} catch (Exception $ex) {
//  Check if the loaded keys is a valid key
    if (!$privateKey->isValid()) {
        $privateKey->generate();
    }

//  Encrypt and store it securely.
//  This Master password could be one for all keys or a different one for each Private Key
    $storageEngine->persist($privateKey);
}

/**
 * Generate the public key from the private key every time (no need to store the public key).
 **/
try {
    $publicKey = $privateKey->getPublicKey();
} catch (Exception $ex) {
    echo $ex->getMessage();
}

/**
 * Derive the SIN from the public key.
 **/
try {
    $sin = $publicKey->getSin()->__toString();
} catch (Exception $ex) {
    echo $ex->getMessage();
}

/**
 * Use the SIN to request a pairing code and token.
 * The pairing code has to be approved in the BitPay Dashboard
 * THIS is just a cUrl example, which explains how to use the key pair for signing requests
 **/
$baseUrl = $isProd ? 'https://bitpay.com' : 'https://test.bitpay.com';
$env = $isProd ? 'Prod' : 'Test';


$merchantToken = null;
$payrolToken = null;


/**
 * Request a token for the Merchant facade
 */

try {
    if ($generateMerchantToken) {
        $facade = 'merchant';

        $postData = json_encode(
            [
                'id'     => $sin,
                'facade' => $facade,
            ]);

        $curlCli = curl_init($baseUrl . "/tokens");

        curl_setopt(
            $curlCli, CURLOPT_HTTPHEADER, [
            'x-accept-version: 2.0.0',
            'Content-Type: application/json',
            'x-identity'  => $publicKey->__toString(),
            'x-signature' => $privateKey->sign($baseUrl . "/tokens".$postData),
        ]);

        curl_setopt($curlCli, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($curlCli, CURLOPT_POSTFIELDS, stripslashes($postData));
        curl_setopt($curlCli, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($curlCli);
        $resultData = json_decode($result, true);
        curl_close($curlCli);

        if (array_key_exists('error', $resultData)) {
            echo $resultData['error'];
            exit;
        }

        /**
         * Example of a pairing Code returned from the BitPay API
         * which needs to be APPROVED on the BitPay Dashboard before being able to use it.
         **/
        $merchantToken = $resultData['data'][0]['token'];
        echo "\r\nMerchant Facade\r\n";
        echo "    -> Pairing Code: ";
        echo $resultData['data'][0]['pairingCode'];
        echo "\r\n    -> Token: ";
        echo $merchantToken;
        echo "\r\n";

        /** End of request **/
    }

    /**
     * Repeat the process for the Payroll facade
     */

    if ($generatePayrollToken) {

        $facade = 'merchant';

        $postData = json_encode(
            [
                'id'     => $sin,
                'facade' => $facade,
            ]);

        $curlCli = curl_init($baseUrl . "/tokens");

        curl_setopt(
            $curlCli, CURLOPT_HTTPHEADER, [
            'x-accept-version: 2.0.0',
            'Content-Type: application/json',
            'x-identity'  => $publicKey->__toString(),
            'x-signature' => $privateKey->sign($baseUrl . "/tokens".$postData),
        ]);

        curl_setopt($curlCli, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($curlCli, CURLOPT_POSTFIELDS, stripslashes($postData));
        curl_setopt($curlCli, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($curlCli);
        $resultData = json_decode($result, true);
        curl_close($curlCli);

        if (array_key_exists('error', $resultData)) {
            echo $resultData['error'];
            exit;
        }

        /**
         * Example of a pairing Code returned from the BitPay API
         * which needs to be APPROVED on the BitPay Dashboard before being able to use it.
         **/
        $payrolToken = $resultData['data'][0]['token'];
        echo "\r\nPayroll Facade\r\n";
        echo "    -> Pairing Code: ";
        echo $resultData['data'][0]['pairingCode'];
        echo "\r\n    -> Token: ";
        echo $payrolToken;
        echo "\r\n";

        /** End of request **/
    }
} catch (Exception $ex) {
    echo $ex->getMessage();
}

echo "\r\nPlease, copy the above pairing code/s and approve on your BitPay Account at the following link:\r\n";
echo $baseUrl . "/dashboard/merchant/api-tokens\r\n";
echo "\r\nOnce you have this Pairing Code/s approved you can move the generated files to a secure location and start using the Client.\r\n";

/**
 * Generate Config File
 */

$config = [
    "BitPayConfiguration" => [
        "Environment" => $env,
        "EnvConfig"   => [
            $env => [
                "PrivateKeyPath"   => $privateKeyname,
                "PrivateKeySecret" => $yourMasterPassword,
                "ApiTokens"        => [
                    "merchant" => $merchantToken,
                    "payroll"  => $payrolToken,
                ],
            ],
            'Prod' => [
                "PrivateKeyPath"   => $privateKeyname,
                "PrivateKeySecret" => $yourMasterPassword,
                "ApiTokens"        => [
                    "merchant" => $merchantToken,
                    "payroll"  => $payrolToken,
                ],
            ],
        ],
    ],
];

try {
    if ($generateJSONfile) {
        $json_data = json_encode($config, JSON_PRETTY_PRINT);
        file_put_contents('BitPay.config.json', $json_data);
    }

    if ($generateYMLfile) {
        $yml_data = Yaml::dump($config, 8, 4, Yaml::DUMP_MULTI_LINE_LITERAL_BLOCK);
        file_put_contents('BitPay.config.yml', $yml_data);
    }
} catch (Exception $ex) {
    echo $ex->getMessage();
}