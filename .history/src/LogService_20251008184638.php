<?php

class LogService {
    private $db;
    public function __construct($path = __DIR__.'/../data/logs.sqlite') {
        $this->db = new \SQLite3($path);
        $this->db->exec("CREATE TABLE IF NOT EXISTS logs (id INTEGER PRIMARY KEY, user TEXT, action TEXT, timestamp TEXT)");
    }
    public function log($user, $action) {
        $stmt = $this->db->prepare("INSERT INTO logs (user, action, timestamp) VALUES (?, ?, ?)");
        $stmt->bindValue(1, $user);
        $stmt->bindValue(2, $action);
        $stmt->bindValue(3, date('c'));
        $stmt->execute();
    }
    public function expungeOld($days = 365) {
        $limit = date('c', strtotime("-$days days"));
        $this->db->exec("DELETE FROM logs WHERE timestamp < '$limit'");
    }

    public function getLogs($limit = 100) {
        $results = $this->db->query("SELECT user, action, timestamp FROM logs ORDER BY timestamp DESC LIMIT $limit");
        $logs = [];
        while ($row = $results->fetchArray(SQLITE3_ASSOC)) {
            $logs[] = $row;
        }
        return $logs;
    }
}
