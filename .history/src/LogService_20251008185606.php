<?php

class LogService {
    private $db;
    private $config;
    
    public function __construct($config = null) {
        $this->config = $config;
        $logPath = $config['data_paths']['logs'] ?? __DIR__.'/../data/logs.sqlite';
        
        // Ensure directory exists
        $dir = dirname($logPath);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        
        $this->db = new \SQLite3($logPath);
        $this->db->exec("CREATE TABLE IF NOT EXISTS logs (
            id INTEGER PRIMARY KEY, 
            level TEXT, 
            message TEXT, 
            context TEXT,
            user TEXT, 
            action TEXT, 
            timestamp TEXT
        )");
    }
    
    /**
     * Log with level, message and context (LGPD compatible)
     */
    public function log($level, $message, $context = []) {
        $stmt = $this->db->prepare("INSERT INTO logs (level, message, context, timestamp) VALUES (?, ?, ?, ?)");
        $stmt->bindValue(1, $level);
        $stmt->bindValue(2, $message);
        $stmt->bindValue(3, json_encode($context));
        $stmt->bindValue(4, date('c'));
        $stmt->execute();
    }
    
    /**
     * Legacy method for backward compatibility
     */
    public function logAction($user, $action) {
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
        $results = $this->db->query("SELECT level, message, context, user, action, timestamp FROM logs ORDER BY timestamp DESC LIMIT $limit");
        $logs = [];
        while ($row = $results->fetchArray(SQLITE3_ASSOC)) {
            if ($row['context']) {
                $row['context'] = json_decode($row['context'], true);
            }
            $logs[] = $row;
        }
        return $logs;
    }
}
