<?php
    header("content-type: text/xml");
    $body = urlencode($_REQUEST['Body']);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_URL, 'https://watson-api-explorer.mybluemix.net/tone-analyzer/api/v3/tone?version=2016-05-19&text=' . $body);
    $result = curl_exec($ch);
    curl_close($ch);

    $obj = array_values(json_decode($result, true))[0];
    $obj = array_values($obj)[0];

    $toneDescription = " .\nTone Analyzer:\n\n\n";

    foreach($obj as $val) {
      $toneDescription = $toneDescription . $val["category_name"] . ":\n\n";
      $toneArray = array_values($val)[0];
      foreach($toneArray as $tone) {
        $toneDescription = $toneDescription . $tone["tone_name"] . ": ";
        $toneDescription = $toneDescription . round((float)$tone["score"] * 100 ) . '%' . "\n";
      }
      $toneDescription = $toneDescription . "\n";
    }
    rtrim($toneDescription, "\n");
?>
<Response>
    <Message><?php echo $toneDescription ?></Message>
</Response>
