<?php
include 'header.php';
if (!isUserLoggedIn() && $controllerName !== 'UserController' && $methodName !== 'login' && $methodName !== 'register') {
    header('Location: ' . BASE_URL . 'user/login');
    exit();
}
?>
<div class="container">
    <h2 class="title">User Management</h2>
    
    <div id="editUserDiv" class="form-box" style="display: none;">
        <!-- Edit User Form -->
        <h3 class="form-title">Edit User</h3>
        <form id="editUserForm">
            <input type="hidden" name="edit_user_id" id="edit_user_id">
            <div class="form-group">
                <label for="edit_name">Name:</label>
                <input type="text" id="edit_name" class="inp" name="edit_name" required>
            </div>
            <div class="form-group">
                <label for="edit_email">Email:</label>
                <input type="email" id="edit_email" class="inp" name="edit_email" required>
            </div>
            <div class="form-group">
                <label for="edit_role">Role:</label>
                <select id="edit_role" class="inp" name="edit_role" required>
                    <option value="">Select role</option>
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <div class="form-group">
                <label for="edit_password">Password (Leave blank to keep current):</label>
                <input type="password" id="edit_password" class="inp" name="edit_password">
            </div>
            <div class="form-group">
                <button type="button" class="btn btn-warning" onclick="hideBox(event)">Cancel</button>
                <button type="submit" class="btn btn-info">Update User</button>
            </div>
        </form>
    </div>
    
    <div class="">
        <!-- Users Table -->
        <h3 class="form-title">All Users</h3>
        <table id="usersTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Date Registered</th>
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

    // Load users on page load
    $(document).ready(function () {
        loadUsers();

        // Handle edit user form submission
        $('#editUserForm').on('submit', function (e) {
            e.preventDefault();
            $.ajax({
                url: '<?php echo BASE_URL; ?>user/update',
                type: 'POST',
                data: $(this).serialize(),
                success: function (response) {
                    console.log(response);
                    $('#editUserDiv').hide();
                    $('#editUserForm')[0].reset();
                    loadUsers();
                },
                error: function () {
                    alert('Error updating user.');
                }
            });
        });
    });

    // Function to load users
    function loadUsers() {
        $.ajax({
            url: '<?php echo BASE_URL; ?>user/getAllUsers',
            type: 'GET',
            success: function (response) {
                $('#usersTable tbody').html('');
                console.log(response);
                response = JSON.parse(response);
                let users = response.users;
                if (users.length > 0) {
                    for (let i = 0; i < users.length; i++) {
                        let user = users[i];
                        let userRole = (user.role == 'admin') ? '<span class="expense-badge">' + user.role + '</span>' : '<span class="income-badge">' + user.role + '</span>';
                        
                        $('#usersTable tbody').append(`
                            <tr>
                                <td>${user.id}</td>
                                <td>${user.name}</td>
                                <td>${user.email}</td>
                                <td>${userRole}</td>
                                <td>${user.created_at}</td>
                                <td>
                                    <button class="btn btn-primary" onclick="populateEditUser(${user.id},'${user.name}','${user.email}','${user.role}')">Edit</button>&nbsp;
                                    <button class="btn btn-danger" onclick="deleteUser(${user.id})">Delete</button>
                                </td>
                            </tr>
                        `);
                    }
                }
            },
            error: function () {
                alert('Error loading users.');
            }
        });
    }

    function populateEditUser(id, name, email, role) {
        $('#editUserDiv').fadeIn();
        $('#edit_user_id').val(id);
        $('#edit_name').val(name);
        $('#edit_email').val(email);
        $('#edit_role').val(role);
    }

    function deleteUser(id) {
        if (confirm("Are you sure you want to delete this user?")) {
            $.ajax({
                url: '<?php echo BASE_URL; ?>user/delete',
                type: 'POST',
                data: { id: id },
                success: function (response) {
                    console.log(response);
                    loadUsers();
                },
                error: function () {
                    alert('Error deleting user.');
                }
            });
        }
    }
</script>

<?php include 'footer.php'; ?>
