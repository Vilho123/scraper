<?php
# scraping books
require 'vendor/autoload.php';
$httpClient = new \GuzzleHttp\Client();
$response = $httpClient->get('https://piki.finna.fi/Search/Results?filter%5B%5D=~format%3A%221%2FBook%2FBook%2F%22&type=AllFields&sort=first_indexed+desc%2Cid+asc&filter%5B%5D=%7Ebuilding%3A%220%2FPiki%2F%22');
$htmlString = (string) $response->getBody();
//add this line to suppress any warnings
libxml_use_internal_errors(true);
$doc = new DOMDocument();
$doc->loadHTML($htmlString);
$xpath = new DOMXPath($doc);

$myfile = fopen("newfile.txt", "w") or die ("Unable to open file!");

for ($x = 0; $x < 20; $x++) {
    $titles = $xpath->evaluate("//*[@id='result$x']/div/div/div[2]/div/div[1]/h2/a/text()");
    $extractedTitles = [];

    foreach ($titles as $title) {
        echo $title->textContent;
        
        $txt = $title->textContent;
        fwrite($myfile, trim($txt));
        fwrite($myfile, "\n");
    };
};


fclose($myfile);
?>