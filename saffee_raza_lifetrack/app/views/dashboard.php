<?php
include 'header.php';
if (!isUserLoggedIn() && $controllerName !== 'UserController' && $methodName !== 'login' && $methodName !== 'register') {
    header('Location: ' . BASE_URL . 'user/login');
    exit();
}
?>
<div class="container">
    <h2 class="title">Dashboard</h2>
    <div>
        <button class="btn btn-success" id="add-transaction-btn" style="margin-bottom: 20px;">Add Transaction</button>
    </div>
    <div id="addFormDiv" class="form-box" style="display: none;">
        <!-- Add Transaction Form -->
        <h3 class="form-title">Add Transaction</h3>
        <form id="addTransactionForm">
            <div class="form-group">
                <label for="desc">Description:</label>
                <input type="text" id="desc" class="inp" name="desc" required>
            </div>
            <div class="form-group">
                <label for="type">Type:</label>
                <select id="type" class="inp" name="type" required>
                    <option value="expense">Expense</option>
                    <option value="income">Income</option>
                </select>
            </div>
            <div class="form-group">
                <label for="amount">Amount:</label>
                <input type="number" id="amount" class="inp" name="amount" required>
            </div>
            <div class="form-group">
                <button type="button" class="btn btn-warning" onclick="hideBox(event)">Cancel</button>
                <button type="submit" class="btn btn-success">Add Transaction</button>
            </div>
        </form>
    </div>
    <div id="editFormDiv" class="form-box" style="display: none;">
        <!-- Edit Transaction Form -->
        <h3 class="form-title">Edit Transaction</h3>
        <form id="editTransactionForm">
            <input type="hidden" name="edit_id" id="edit_id">
            <div class="form-group">
                <label for="desc">Description:</label>
                <input type="text" id="edit_desc" class="inp" name="edit_desc" required>
            </div>
            <div class="form-group">
                <label for="type">Type:</label>
                <select id="edit_type" class="inp" name="edit_type" required>
                    <option value="expense">Expense</option>
                    <option value="income">Income</option>
                </select>
            </div>
            <div class="form-group">
                <label for="amount">Amount:</label>
                <input type="number" id="edit_amount" class="inp" name="edit_amount" required>
            </div>
            <div class="form-group">
                <button type="button" class="btn btn-warning" onclick="hideBox(event)">Cancel</button>
                <button type="submit" class="btn btn-info">Update Transaction</button>
            </div>
        </form>
    </div>
    <div class="form-box">
        <!-- Date Range Filter Form -->
        <form id="dateFilterForm" class="date-filter-form">
            <div class="form-group">
                <label for="startDate">Start Date:</label>
                <input type="date" id="startDate" class="inp" name="startDate">
            </div>
            <div class="form-group">
                <label for="endDate">End Date:</label>
                <input type="date" id="endDate" class="inp" name="endDate">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </form>
    </div>
    <div class="">
        <!-- Transactions Table -->
        <h3 class="form-title">Transactions</h3>
        <div class="totals">
            <div class="income-total">
                <span>Total Income</span>
                <h3 class="income-total-amount">$0.00</h3>
            </div>
            <div class="expense-total">
                <span>Total Expense</span>
                <h3 class="expense-total-amount">$0.00</h3>
            </div>
            <div class="net-total">
                <span>Net Total</span>
                <h3 class="net-total-amount">$0.00</h3>
            </div>
        </div>
        <table id="transactionsTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') { ?>
                        <th>User</th>
                    <?php } ?>
                    <th>Description</th>
                    <th>Type</th>
                    <th>Amount</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
<script>
    function hideBox(e) {
        let target = e.target;
        $(target).closest('.form-box').hide();
    }
    // Load transactions on page load
    $(document).ready(function () {
        $('#add-transaction-btn').on('click', function () {
            $('#addFormDiv').fadeIn();
        });
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
                    $('#addFormDiv').hide();
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
            if ($('#edit_id').val() == '') {
                alert('No edit id is present!');
            } else {
                $.ajax({
                    url: '<?php echo BASE_URL; ?>transaction/edit',
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function (response) {
                        console.log(response);
                        $('#editFormDiv').hide();
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
        let isAdmin = <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
            echo 'true';
        } else {
            echo 'false';
        } ?>;
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
                        let userName = (isAdmin) ? `<td>${transaction['user']}</td>` : '';
                        let transactionType = (transaction.type == 'expense') ? '<span class="expense-badge">' + transaction.type + '</span>' : '<span class="income-badge">' + transaction.type + '</span>';
                        $('#transactionsTable tbody').append(`<tr><td>${transaction.id}</td>${userName}<td>${transaction.description}</td><td>${transactionType}</td><td>$${transaction.amount}</td><td>${transaction.date}</td><td><button class="btn btn-primary" onclick="populateEditTransaction(${transaction.id},'${transaction.description}',${transaction.amount},'${transaction.type}')">Edit</button>&nbsp;<button class="btn btn-danger" onclick="deleteTransaction(${transaction.id})">Delete</button></td></tr>`);
                    }

                    $('.income-total-amount').text('$' + response.totalIncome.toFixed(2));
                    $('.expense-total-amount').text('$' + response.totalExpense.toFixed(2));
                    let net_total = response.totalIncome - response.totalExpense;
                    if (net_total < 0) {
                        $('.net-total-amount').css('color', 'red').text('-$' + Math.abs(net_total).toFixed(2));
                    } else {
                        $('.net-total-amount').css('color', 'green').text('$' + net_total.toFixed(2));
                    }
                }
            },
            error: function () {
                alert('Error loading transactions.');
            }
        });
    }

    function populateEditTransaction(id, description, amount, type) {
        $('#editFormDiv').fadeIn();
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
                id: id
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