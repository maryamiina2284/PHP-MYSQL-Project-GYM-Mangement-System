<!-- Modal -->
<div class="modal fade" id="trainer-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="post" id="trainerForm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Trainer</h5>
                    <button type="button" class="btn-close m-3" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="action" id="action" value="insert">
                    <input type="hidden" name="trainerid" id="trainerid" value="0">

                    <div class="mb-3">
                        <label for="FullName" class="form-label">Full Name</label>
                        <input type="text" class="form-control" name="FullName" id="FullName" placeholder="Full Name" >
                        <span class="text-danger" id="FullNameError"></span>
                    </div>
                    <div class="mb-3">
                        <label for="Gender" class="form-label">Gender</label>
                        <select class="form-control" name="Gender" id="Gender" >
                            <option value="">Select Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                        <span class="text-danger" id="GenderError"></span>
                    </div>
                    <div class="mb-3">
                        <label for="Phone" class="form-label">Phone</label>
                        <input type="text" class="form-control" name="Phone" id="Phone" placeholder="Phone" pattern="^[0-9]{10}$" title="Phone number should be 10 digits long" >
                        <span class="text-danger" id="PhoneError"></span>
                    </div>
                    <div class="mb-3">
                        <label for="Email" class="form-label">Email</label>
                        <input type="email" class="form-control" name="Email" id="Email" placeholder="Email" >
                        <span class="text-danger" id="EmailError"></span>
                    </div>
                    <div class="mb-3">
                        <label for="Address" class="form-label">Address</label>
                        <input type="text" class="form-control" name="Address" id="Address" placeholder="Address" >
                        <span class="text-danger" id="AddressError"></span>
                    </div>
                    <div class="mb-3">
                        <label for="HireDate" class="form-label">Hire Date</label>
                        <input type="date" class="form-control" name="HireDate" id="HireDate" >
                        <span class="text-danger" id="HireDateError"></span>
                    </div>
                    <div class="mb-3">
                        <label for="Status" class="form-label">Status</label>
                        <select class="form-control" name="Status" id="Status" >
                            <option value="">Select Status</option>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                        <span class="text-danger" id="StatusError"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary m-2" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" name="btnSave">Save changes</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" tabindex="-1" id="delete-trainer-modal">
    <div class="modal-dialog modal-sm">
        <form method="post" id="deleteTrainerForm">
            <div class="modal-content">
                <div class="modal-header bg-danger text-light">
                    <h5 class="modal-title text-white text-center">Delete Trainer</h5>
                    <button type="button" class="btn-close m-3" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="trainer_id" id="trainer_id">
                    <p class="lead">Are you sure you want to delete this trainer?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary m-2" data-bs-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-primary" name="btnDelete">Yes</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('trainerForm').addEventListener('submit', function(event) {
        

        // Clear previous error messages
        clearErrors();

        let valid = true;

        // Form values
        const fullName = document.getElementById('FullName').value.trim();
        const gender = document.getElementById('Gender').value.trim();
        const phone = document.getElementById('Phone').value.trim();
        const email = document.getElementById('Email').value.trim();
        const address = document.getElementById('Address').value.trim();
        const hireDate = document.getElementById('HireDate').value.trim();
        const status = document.getElementById('Status').value.trim();

        // Full Name Validation
        if (fullName === '') {
            document.getElementById('FullNameError').textContent = 'Please enter full name';
            valid = false;
        }

        // Gender Validation
        if (gender === '') {
            document.getElementById('GenderError').textContent = 'Please select gender';
            valid = false;
        }

        // Phone Validation
        const phonePattern = /^[0-9]{10}$/;
        if (!phonePattern.test(phone)) {
            document.getElementById('PhoneError').textContent = 'Phone number must be 10 digits';
            valid = false;
        }

        // Email Validation
        const emailPattern = /^\S+@\S+\.\S+$/;
        if (!emailPattern.test(email)) {
            document.getElementById('EmailError').textContent = 'Please enter a valid email address';
            valid = false;
        }

        // Address Validation
        if (address === '') {
            document.getElementById('AddressError').textContent = 'Please enter address';
            valid = false;
        }

        // Hire Date Validation
        if (hireDate === '') {
            document.getElementById('HireDateError').textContent = 'Please select a hire date';
            valid = false;
        }

        // Status Validation
        if (status === '') {
            document.getElementById('StatusError').textContent = 'Please select status';
            valid = false;
        }

        // If the form is valid, submit it. Otherwise, prevent submission.
    if (!valid) {
        event.preventDefault(); // Prevent form submission if there are validation errors
    }
    });

    function clearErrors() {
        document.getElementById('FullNameError').textContent = '';
        document.getElementById('GenderError').textContent = '';
        document.getElementById('PhoneError').textContent = '';
        document.getElementById('EmailError').textContent = '';
        document.getElementById('AddressError').textContent = '';
        document.getElementById('HireDateError').textContent = '';
        document.getElementById('StatusError').textContent = '';
    }
    
function removeAlert(){
        setTimeout(() => {
            document.querySelector('.alerts').remove()
        }, 3000);
    }
</script>
