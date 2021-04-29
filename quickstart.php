
<?php
/*
//use vendor\google\apiclient\src\Client.php;
require __DIR__ . '\vendor\autoload.php';
$client = new Google_Client();
$client ->setApplicationName(helpdesksheets);
$client->setScopes([\Google_Service_Sheets::SPREADSHEETS]);
$client->setAccessType('offline');
$client->setAuthConfig(__DIR__.'/credentials.json');
$service = new Google_Service_Sheets($client);
$spreadsheetId ="1LuZO4f2Nq_GVSNw_ZB_A3jI5otjzUVJvrfRdGb7RHU4";

$range = "Form3!B2:C10";
$response = $service->spreadsheets_values->get($spreadsheetId,$range);
$values = $response->getValues();
if(empty($values)){
    print_r("NO data found.\n");
}else{

        foreach($values as $row){
            echo print_r($row[1],$row[0]);
        }
}*/

require __DIR__ . '/vendor/autoload.php';

if (php_sapi_name() != 'cli') {
    throw new Exception('This application must be run on the command line.');
}

/**
 * Returns an authorized API client.
 * @return Google_Client the authorized client object
 */
function getClient()
{
    $client = new Google_Client();
    $client->setApplicationName('Google Sheets API PHP Quickstart');
    $client->setScopes(Google_Service_Sheets::SPREADSHEETS_READONLY);
    $client->setAuthConfig(__DIR__ .'/credentials.json');
    $client->setAccessType('offline');
    $client->setPrompt('select_account consent');

    // Load previously authorized token from a file, if it exists.
    // The file token.json stores the user's access and refresh tokens, and is
    // created automatically when the authorization flow completes for the first
    // time.
    $tokenPath = __DIR__ .'/token.json';
    if (file_exists($tokenPath)) {
        $accessToken = json_decode(file_get_contents($tokenPath), true);
        $client->setAccessToken($accessToken);
    }

    // If there is no previous token or it's expired.
    if ($client->isAccessTokenExpired()) {
        // Refresh the token if possible, else fetch a new one.
        if ($client->getRefreshToken()) {
            $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
        } else {
            // Request authorization from the user.
            $authUrl = $client->createAuthUrl();
            printf("Open the following link in your browser:\n%s\n", $authUrl);
            print 'Enter verification code: ';
            $authCode = trim(fgets(STDIN));

            // Exchange authorization code for an access token.
            $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
            $client->setAccessToken($accessToken);

            // Check to see if there was an error.
            if (array_key_exists('error', $accessToken)) {
                throw new Exception(join(', ', $accessToken));
            }
        }
        // Save the token to a file.
        if (!file_exists(dirname($tokenPath))) {
            mkdir(dirname($tokenPath), 0700, true);
        }
        file_put_contents($tokenPath, json_encode($client->getAccessToken()));
    }
    return $client;
}


// Get the API client and construct the service object.
$client = getClient();
$service = new Google_Service_Sheets($client);

// Prints the names and majors of students in a sample spreadsheet:
// https://docs.google.com/spreadsheets/d/1BxiMVs0XRA5nFMdKvBdBZjgmUUqptlbs74OgvE2upms/edit
$spreadsheetId = '1WvXvvIQp2KJLnK6IJzsK7YOlID9XP2Pns2rk-ZXvglE';
$range = 'Form3!B2:D10';
$response = $service->spreadsheets_values->get($spreadsheetId, $range);
$values = $response->getValues();

if (empty($values)) {
    print "No data found.\n";
} else {

    foreach ($values as $row) {
        // Print columns A and E, which correspond to indices 0 and 4.
        printf("%s, %s, %s\n", $row[0], $row[1],$row[2]);
    }
}

$servername = "127.0.0.1:3306";
$username = "root";
$password = "";
$dbname = "chadha";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT email FROM personne";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_array()) {
        echo "+email1: " . $row["email"].  "++<br>";
        $x[] = $row["email"];

    }
} else {
    echo "0 results";
}

foreach ($x as $x1)
{
    foreach ($values as $row) {
        $y = $row[0];
// Print columns A and E, which correspond to indices 0 and 4.
// printf("%s, %s, %s\n", $row[0], $row[1],$row[2]);
        if($y == $x1)
        {
            $sql1 = "UPDATE `tester` SET `note`= '$row[1]' WHERE id_test = '$row[2]'";
            $result = $conn->query($sql1);
        }

    }



}


$conn->close();

echo php_sapi_name();


?>

