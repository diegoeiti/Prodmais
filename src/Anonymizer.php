<?php
namespace App;
class Anonymizer {
    public static function anonymize($data) {
        // Exemplo: remove nome e email
        unset($data['nome']);
        unset($data['email']);
        return $data;
    }
}
