<?php
namespace App;
class OrcidFetcher {
    public static function fetch($orcid) {
        $url = "https://pub.orcid.org/v3.0/$orcid/works";
        $opts = ["http" => ["header" => "Accept: application/json"]];
        $context = stream_context_create($opts);
        $json = file_get_contents($url, false, $context);
        return json_decode($json, true);
    }
}
