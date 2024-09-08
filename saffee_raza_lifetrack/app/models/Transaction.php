<?php
class Transaction {
    private $db;

    public function __construct() {
        $this->db = (new Database())->connect();
    }

    public function getTransactions($startDate, $endDate) {
        $sql = "SELECT * FROM transactions";
        $conditions = [];

        if ($startDate) {
            $conditions[] = "DATE(date) >= :startDate";
        }
        if ($endDate) {
            $conditions[] = "DATE(date) <= :endDate";
        }

        if ($conditions) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }

        $sql .= " ORDER BY date DESC";

        $stmt = $this->db->prepare($sql);

        if ($startDate) {
            $stmt->bindParam(':startDate', $startDate);
        }
        if ($endDate) {
            $stmt->bindParam(':endDate', $endDate);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addTransaction($user_id, $description, $type, $amount) {
        $sql = "INSERT INTO transactions (user_id, description, type, amount) VALUES (:user_id, :description, :type, :amount)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':type', $type);
        $stmt->bindParam(':amount', $amount);
        $stmt->execute();
    }
    

    public function deleteTransaction($transaction_id) {
        $sql = "DELETE FROM transactions WHERE `id` = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $transaction_id);
        $stmt->execute();
    }
    public function editTransaction($user_id, $edit_id, $description, $type, $amount) {
        $sql = "UPDATE transactions SET description = :description, type = :type, amount = :amount WHERE user_id = :user_id AND id = :edit_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':edit_id', $edit_id);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':type', $type);
        $stmt->bindParam(':amount', $amount);
        $stmt->execute();
    }
}
