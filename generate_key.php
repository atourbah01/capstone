<?php
session_start();
global $pdo;
require_once 'dbconf.php'; // Include your database configuration file

if (isset($_SESSION['userid'])) {
    // Get form data
    $servername = isset($_POST['servername']) ? $_POST['servername'] : '';
    $ip = isset($_POST['ip']) ? $_POST['ip'] : '';
    $port = isset($_POST['port']) ? $_POST['port'] : '';
    $sys = isset($_POST['sys']) ? $_POST['sys'] : '';
    $bits = isset($_POST['bits']) ? intval($_POST['bits']) : 2048;
    $mode = isset($_POST['mode']) ? $_POST['mode'] : '';

    // Validate form data
    if ($servername === '') {
        echo json_encode(['error' => 'Server Name is empty']);
        exit;
    }

    if ($ip === '') {
        echo json_encode(['error' => 'IP Address is empty']);
        exit;
    }

    if ($port === '') {
        echo json_encode(['error' => 'Port Number is empty']);
        exit;
    }

    if ($sys === '') {
        echo json_encode(['error' => 'System is empty']);
        exit;
    }

    // Validate bits (adjust the range as needed)
    if ($bits !== 1024 && $bits !== 2048 && $bits !== 3072 && $bits !== 4096) {
        echo json_encode(['error' => 'Invalid bits value']);
        exit;
    }

    // Check if the port is available
    $isPortAvailable = false;
    $connection = @fsockopen($ip, $port, $errno, $errstr, 1);
    if (!$connection) {
        // Port is available
        $isPortAvailable = true;
    } else {
        // Port is not available
        fclose($connection);
    }
    if (!$isPortAvailable) {
        echo json_encode(['error' => 'Port is busy']);
        exit;
    }

    if ($sys === 'Mac OS X'||$sys=== 'Windows'||$sys==='Linux') {
        // Check if the port is already in use
        $portInUse = shell_exec("lsof -i :$port");

        if ($portInUse) {
            echo json_encode(['error' => 'Port is already in use']);
            exit;
        }

        // Check if public key already exists
        $publicKey = ''; // Assign the public key value here
        $query = "SELECT COUNT(*) AS count FROM configurations WHERE public_key = :public_key";
        $stmt = $pdo->prepare($query);
        $stmt->execute(['public_key' => $publicKey]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result['count'] > 0) {
            // Public key already exists, do not insert
            echo json_encode(['error' => 'Public key already exists']);
            exit;
        }
        $config = [
            'private_key_bits' => $bits,
            'private_key_type' => OPENSSL_KEYTYPE_RSA,
        ];

        // Create a new private and public key pair
        $res = openssl_pkey_new($config);
        // Get the private key
        openssl_pkey_export($res, $privateKey);

        // Get the public key
        $publicKey = openssl_pkey_get_details($res)['key'];

        file_put_contents('/Users/abdallah/Documents/public_key.pem',$publicKey);
        file_put_contents('/Users/abdallah/Documents/private_key.p12',$privateKey);
        $data = [
            'servername' => $servername,
            'ip' => $ip,
            'sys' => $sys,
            'bits' => $bits,
            'mode' => $mode,
            'public_key' => $publicKey,
            'private_key' => $privateKey,
            'port' => $port
        ];
        $dataToSign = json_encode($data);
        // Encrypt data with the public key
        openssl_public_encrypt($dataToSign, $encryptedData, $publicKey);
        // Sign the data with the private key
        openssl_sign($dataToSign, $signature, $privateKey, OPENSSL_ALGO_SHA256);

        // Insert data into the database
        $query = "INSERT INTO configurations (servername, ip, sys, bits, mode, public_key, private_key, port) 
                  VALUES (:servername, :ip, :sys, :bits, :mode, :public_key, :private_key, :port)";

        $stmt = $pdo->prepare($query);
        $stmt->execute($data);

        $response = [
            'success' => true,
            'public_key' => $publicKey,
            'private_key' => $privateKey,
            'data' => $data,
            'signature' => base64_encode($signature)
        ];
        $_SESSION['ip'] = $ip;
        $_SESSION['port'] = $port;
        $_SESSION['public_key']= $publicKey;
        $_SESSION['private_key']=$privateKey;

        echo json_encode($response);
        exit;

    }
}

echo json_encode(['error' => 'User not authenticated']);
?>