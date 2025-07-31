<?php
// Securely load credentials from environment variables
$sonarUrl = "http://localhost:9000/api/issues/search?componentKeys=my-fyp-project";
$username = "admin";
$password = "Admin@123456";

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $sonarUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");

$response = curl_exec($ch);
curl_close($ch);

// Save to report.json
file_put_contents("report.json", $response);

echo "✅ Report downloaded to report.json\n";
?>
