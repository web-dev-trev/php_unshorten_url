<html>    
    <form action="" method="post" style="text-align: center;">
        <input name="urls" placeholder="put those pesky shortened links here" textarea style="width: 100%; height: 30vh;"><br>
        <p><button style="background-color: black; color: white; padding: 5px; border-radius: 5px;" type="submit" name="submit">get me my urls</button><p>
    </form>
</html>

<?php 

function unshorten_url($url) {
    $ch = curl_init($url);
    curl_setopt_array($ch, array(
        CURLOPT_FOLLOWLOCATION => TRUE,  // the magic sauce
        CURLOPT_RETURNTRANSFER => TRUE,
        CURLOPT_SSL_VERIFYHOST => FALSE, // suppress certain SSL errors
        CURLOPT_SSL_VERIFYPEER => FALSE, 
    ));
    curl_exec($ch);
    $url = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
    curl_close($ch);
    return 'url:'.$url;
    echo'url:'.$url;
    }

    if(isset($_POST["submit"])){
    $urls = $_POST["urls"];   
    }
    $pattern = '/(?:[^\s]+@[a-z]+(\.[a-z]+)+)|(?:(?:(?:[a-z]+:\/\/)|(?!\s))[a-z]+(\.[a-z]+)+(\/[^\s]*)?)/';

    preg_match_all($pattern, $urls, $out);

    $count = count($out[0]);
    echo "<b> Number of URLS</b> =" .$count."<br>";
    for ($row=0; $row<$count;$row++){
        $link = $out[0][$row];
        get_headers($link);
        $url = preg_replace(array('/\s{2,}/', '/[\t\n]/'), ' ', $link);
        unshorten_url($link);

        $ch = curl_init($url);
        curl_setopt_array($ch, array(
        CURLOPT_FOLLOWLOCATION => TRUE,  // the magic sauce
        CURLOPT_RETURNTRANSFER => TRUE,
        CURLOPT_SSL_VERIFYHOST => FALSE, // suppress certain SSL errors
        CURLOPT_SSL_VERIFYPEER => FALSE, 
        ));
        curl_exec($ch);
        $url = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
        curl_close($ch);
        echo $row.': <a href='.$url.'>'.$url.'</a><br>';
    }

?>
