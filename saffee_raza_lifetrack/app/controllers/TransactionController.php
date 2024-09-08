<?php
class TransactionController {
    public function get() {
        $startDate = isset($_GET['startDate']) ? $_GET['startDate'] : '';
        $endDate = isset($_GET['endDate']) ? $_GET['endDate'] : '';

        $transactionModel = new Transaction();
        $transactions = $transactionModel->getTransactions($startDate, $endDate);

        $totalExpense = $totalIncome = 0;
        foreach ($transactions as $key => $transaction) {
            if($transaction['type'] == 'income'){
                $totalIncome += $transaction['amount'];
            }else if($transaction['type'] == 'expense'){
                $totalExpense += $transaction['amount'];
            }
            $transaction['amount'] = number_format($transaction['amount'], 2);
            $transactions[$key]['date'] = date('h:i a | d M, Y', strtotime($transaction['date']));
        }

        echo json_encode(array('transactions' => $transactions,'totalExpense' => $totalExpense,'totalIncome' => $totalIncome));
    }

    public function add() {
        $description = $_POST['desc'];
        $amount = $_POST['amount'];
        $type = $_POST['type'];
        $user_id = $_SESSION['user_id'];

        $transactionModel = new Transaction();
        $transactionModel->addTransaction($user_id, $description, $type, $amount);
    }

    public function edit() {
        $description = $_POST['edit_desc'];
        $amount = $_POST['edit_amount'];
        $type = $_POST['edit_type'];
        $user_id = $_SESSION['user_id'];
        $edit_id = $_POST['edit_id'];

        $transactionModel = new Transaction();
        $transactionModel->editTransaction($user_id, $edit_id, $description, $type, $amount);
    }
    
    public function delete() {
        $id = $_POST['id'];

        $transactionModel = new Transaction();
        $transactionModel->deleteTransaction($id);
    }
}
