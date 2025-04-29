<!doctype html>
<html lang="en" class="light-style layout-wide customizer-hide" dir="ltr" data-theme="theme-default" data-assets-path="assets/" data-template="vertical-menu-template-free" data-style="light">
<head>
    <!-- Your existing head content here -->
</head>

<body>
    <!-- Registration Modal -->
    <div class="modal fade" id="register-modal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="post" id="formAuthentication" action="users.php" class="modal-content" onsubmit="return validateForm()">
                <div class="modal-header">
                    <h5 class="modal-title" id="registerModalLabel">Register</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="TypeOfData" id="action" value="insert">
                    <input type="text" name="userId" id="userId" value="0">

                    <div class="mb-3">
                        <label for="FullName" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="FullName" name="FullName" placeholder="Enter your Full Name" autofocus />
                        <small class="text-danger" id="FullNameError"></small>
                    </div>
                    <div class="mb-3">
                        <label for="Username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="Username" name="Username" placeholder="Enter your Username"/>
                        <small class="text-danger" id="UsernameError"></small>
                    </div>
                    <div class="mb-3">
                        <label for="Email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="Email" name="Email" placeholder="Enter your Email"/>
                        <small class="text-danger" id="EmailError"></small>
                    </div>
                    <div class="mb-3">
                        <label for="Role" class="form-label">Role</label>
                        <select class="form-control" name="Role" id="Role">
                            <option value="" disabled selected>Select Role</option>
                            <option value="Admin">Admin</option>
                            <option value="User">User</option>
                            <option value="Staff">Staff</option>
                        </select>
                        <small class="text-danger" id="RoleError"></small>
                    </div>
                    <!-- <div class="mb-3">
                        <label for="CreatedAt" class="form-label">Created At</label>
                        <input type="date" class="form-control" id="CreatedAt" name="CreatedAt"/>
                        <small class="text-danger" id="CreatedAtError"></small>
                    </div> -->
                    <div class="mb-3">
                        <label for="Status" class="form-label">Status</label>
                        <select class="form-control" name="Status" id="Status">
                            <option value="" disabled selected>Select Status</option>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                        <small class="text-danger" id="StatusError"></small>
                    </div>
                    <div class="mb-3">
                        <label for="Password" class="form-label">Password</label>
                        <input type="password" id="Password" class="form-control" name="Password" placeholder="Password"/>
                        <small class="text-danger" id="PasswordError"></small>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="terms-conditions" name="terms"/>
                        <label class="form-check-label" for="terms-conditions">
                            I agree to the <a href="#">privacy policy & terms</a>
                        </label>
                        <small class="text-danger" id="TermsError"></small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" name="btnSignup">Sign up</button>
                </div>
            </form>
        </div>
    </div>


    <!-- Modal for Delete -->
<div class="modal fade" id="delete-user-modal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <form method="post" id="deleteForm">
            <div class="modal-content">
                <div class="modal-header bg-danger text-light">
                    <h5 class="modal-title text-white">Delete User</h5>
                    <button type="button" class="btn-close m-3" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="user_id" id="user_id">
                    <p class="lead">Are you sure you want to delete this user?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-primary" name="btnDelete">Yes</button>
                </div>
            </div>
        </form>
    </div>
</div>

    <!-- Validation Script -->
    <script>
        function clearErrors() {
            // Clear all error messages
            document.querySelectorAll('.text-danger').forEach(el => el.textContent = '');
        }

        function validateForm() {
            clearErrors(); // Clear errors at the start of validation
            let isValid = true;

            // Validate Full Name
            const fullName = document.getElementById('FullName').value;
            if (fullName.trim() === "") {
                document.getElementById('FullNameError').textContent = "Full Name is required.";
                isValid = false;
            }

            // Validate Username
            const username = document.getElementById('Username').value;
            if (username.trim() === "") {
                document.getElementById('UsernameError').textContent = "Username is required.";
                isValid = false;
            }

            // Validate Email
            const email = document.getElementById('Email').value;
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailPattern.test(email)) {
                document.getElementById('EmailError').textContent = "Please enter a valid email address.";
                isValid = false;
            }

            // Validate Role
            const role = document.getElementById('Role').value;
            if (role === "") {
                document.getElementById('RoleError').textContent = "Please select a role.";
                isValid = false;
            }

            // Validate Created At
            const createdAt = document.getElementById('CreatedAt').value;
            if (createdAt === "") {
                document.getElementById('CreatedAtError').textContent = "Please select a date.";
                isValid = false;
            }

            // Validate Status
            const status = document.getElementById('Status').value;
            if (status === "") {
                document.getElementById('StatusError').textContent = "Please select a status.";
                isValid = false;
            }

            // Validate Password
            const password = document.getElementById('Password').value;
            if (password.length < 8) {
                document.getElementById('PasswordError').textContent = "Password must be at least 8 characters.";
                isValid = false;
            }

            // Validate Terms and Conditions
            const terms = document.getElementById('terms-conditions').checked;
            if (!terms) {
                document.getElementById('TermsError').textContent = "You must agree to the terms.";
                isValid = false;
            }

            return isValid;
        }
   

        function removeAlert(){
        setTimeout(() => {
            document.querySelector('.alerts').remove()
        }, 3000);
    }
    </script>

    <!-- Your existing scripts here -->
</body>
</html>
