<!-- app/views/dashboard.php -->
<?php 
include 'header.php'; 
// Redirect to login if user is not logged in and accessing a protected route
if (!isUserLoggedIn() && $controllerName !== 'UserController' && $methodName !== 'login' && $methodName !== 'register') {
    header('Location: ' . BASE_URL . 'user/login');
    exit();
}
?>
<h2>Dashboard</h2>
<div id="addFormDiv">
    <!-- Add Transaction Form -->
    <h3>Add Transaction</h3>
    <form id="addTransactionForm">
        <label for="desc">Description:</label>
        <input type="text" id="desc" name="desc" required>
        <br><br>
        <label for="type">Type:</label>
        <select id="type" name="type" required>
            <option value="expense">Expense</option>
            <option value="income">Income</option>
        </select>
        <br><br>
        <label for="amount">Amount:</label>
        <input type="number" id="amount" name="amount" required>
        <br><br>
        <button type="submit">Add Transaction</button>
    </form>
</div>
<div id="editFormDiv">
    <!-- Edit Transaction Form -->
    <h3>Edit Transaction</h3>
    <form id="editTransactionForm">
        <input type="hidden" name="edit_id" id="edit_id">
        <label for="desc">Description:</label>
        <input type="text" id="edit_desc" name="edit_desc" required>
        <br><br>
        <label for="type">Type:</label>
        <select id="edit_type" name="edit_type" required>
            <option value="expense">Expense</option>
            <option value="income">Income</option>
        </select>
        <br><br>
        <label for="amount">Amount:</label>
        <input type="number" id="edit_amount" name="edit_amount" required>
        <br><br>
        <button type="submit">Update Transaction</button>
    </form>
</div>
<!-- Date Range Filter Form -->
<form id="dateFilterForm">
    <label for="startDate">Start Date:</label>
    <input type="date" id="startDate" name="startDate">
    <br><br>
    <label for="endDate">End Date:</label>
    <input type="date" id="endDate" name="endDate">
    <br><br>
    <button type="submit">Filter</button>
</form>
<!-- Transactions Table -->
<h3>Transactions</h3>
<table id="transactionsTable">
    <thead>
        <tr>
            <th>ID</th>
            <th>Description</th>
            <th>Type</th>
            <th>Amount</th>
            <th>Date</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <!-- Table rows will be populated by AJAX -->
    </tbody>
</table>
<script>
    // Load transactions on page load
    $(document).ready(function () {
        loadTransactions();

        // Handle date filter form submission
        $('#dateFilterForm').on('submit', function (e) {
            e.preventDefault();
            loadTransactions();
        });

        // Handle add transaction form submission
        $('#addTransactionForm').on('submit', function (e) {
            e.preventDefault();
            $.ajax({
                url: '<?php echo BASE_URL; ?>transaction/add',
                type: 'POST',
                data: $(this).serialize(),
                success: function (response) {
                    console.log(response);
                    alert('Transaction added successfully!');
                    $('#addTransactionForm')[0].reset();
                    loadTransactions();
                },
                error: function () {
                    alert('Error adding transaction.');
                }
            });
        });

        $('#editTransactionForm').on('submit', function (e) {
            e.preventDefault();
            if($('#edit_id').val() == ''){
                alert('No edit id is present!');
            }else{
                $.ajax({
                url: '<?php echo BASE_URL; ?>transaction/edit',
                type: 'POST',
                data: $(this).serialize(),
                success: function (response) {
                    console.log(response);
                    alert('Transaction updated successfully!');
                    $('#editTransactionForm')[0].reset();
                    loadTransactions();
                },
                error: function () {
                    alert('Error adding transaction.');
                }
            });
            }
        });
    });

    // Function to load transactions based on date range
    function loadTransactions() {
        $.ajax({
            url: '<?php echo BASE_URL; ?>transaction/get',
            type: 'GET',
            data: $('#dateFilterForm').serialize(),
            success: function (response) {
                $('#transactionsTable tbody').html('');
                console.log(response);
                response = JSON.parse(response);
                let transactions = response.transactions;
                if (transactions.length > 0) {
                    for (let i = 0; i < transactions.length; i++) {
                        let transaction = transactions[i];
                        let transactionType = (transaction.type == 'expense') ? '<span class="expense-badge">' + transaction.type + '</span>' : '<span class="income-badge">' + transaction.type + '</span>';
                        $('#transactionsTable tbody').append(`<tr><td>${transaction.id}</td><td>${transaction.description}</td><td>${transactionType}</td><td>${transaction.amount}</td><td>${transaction.date}</td><td><button onclick="populateEditTransaction(${transaction.id},'${transaction.description}',${transaction.amount},'${transaction.type}')">Edit</button><button onclick="deleteTransaction(${transaction.id})">Delete</button></td></tr>`);
                    }
                }
            },
            error: function () {
                alert('Error loading transactions.');
            }
        });
    }

    function populateEditTransaction(id, description, amount, type) {
        $('#edit_id').val(id);
        $('#edit_desc').val(description);
        $('#edit_amount').val(amount);
        $('#edit_type').val(type);
    }
    
    function deleteTransaction(id) {
        $.ajax({
            url: '<?php echo BASE_URL; ?>transaction/delete',
            type: 'POST',
            data: {
                id:id
            },
            success: function (response) {
                console.log(response);
                loadTransactions();
            },
            error: function () {
                alert('Error loading transactions.');
            }
        })
    }
</script>
<?php include 'footer.php'; ?>