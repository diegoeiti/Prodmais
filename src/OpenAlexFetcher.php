<?php
namespace App;
class OpenAlexFetcher {
    public static function fetch($doi) {
        $url = "https://api.openalex.org/works/doi:$doi";
        $json = file_get_contents($url);
        return json_decode($json, true);
    }
}
