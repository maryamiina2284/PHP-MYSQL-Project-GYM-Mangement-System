<!-- Modal -->
<div class="modal fade" id="member-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="post" id="memberForm" novalidate>
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Member</h5>
                    <button type="button" class="btn-close m-3" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="TypeOfData" id="action" value="insert">
                    <input type="hidden" name="member_Id" id="memberid" value="0">

                    <div class="mb-3">
                        <label for="FullName" class="form-label">Full Name</label>
                        <input type="text" class="form-control" name="FullName" id="FullName" placeholder="FullName" >
                        <span class="error-message text-danger" id="FullNameError"></span>
                    </div>
                    <div class="mb-3">
                        <label for="DateOfBirth" class="form-label">Date of Birth</label>
                        <input type="date" class="form-control" name="DateOfBirth" id="DateOfBirth" >
                        <span class="error-message text-danger" id="DateOfBirthError"></span>
                    </div>
                    <div class="mb-3">
                        <label for="Gender" class="form-label">Gender</label>
                        <select class="form-control" name="Gender" id="Gender" >
                            <option value="" disabled selected>Select Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                        <span class="error-message text-danger" id="GenderError"></span>
                    </div>
                    <div class="mb-3">
                        <label for="Phone" class="form-label">Phone</label>
                        <input type="text" class="form-control" name="Phone" id="Phone" placeholder="Phone"  pattern="[0-9]{10}">
                        <span class="error-message text-danger" id="PhoneError"></span>
                    </div>
                    <div class="mb-3">
                        <label for="Email" class="form-label">Email</label>
                        <input type="email" class="form-control" name="Email" id="Email" placeholder="Email" >
                        <span class="error-message text-danger" id="EmailError"></span>
                    </div>
                    <div class="mb-3">
                        <label for="Address" class="form-label">Address</label>
                        <input type="text" class="form-control" name="Address" id="Address" placeholder="Address" >
                        <span class="error-message text-danger" id="AddressError"></span>
                    </div>
                    <div class="mb-3">
                        <label for="MemberWeight" class="form-label">MemberWeight</label>
                        <input type="text" class="form-control" name="MemberWeight" id="MemberWeight" placeholder="MemberWeight" >
                        <span class="error-message text-danger" id="MemberWeightError"></span>
                    </div>
                    <div class="mb-3">
                        <label for="type" class="form-label">Membership Type</label>
                        <select class="form-control" name="type" id="type" >
                            <option value="" disabled selected>Select Type</option>
                            <?php foreach (read('memberships') as $membership) { ?>
                                <option value="<?= $membership['id']?>"><?= $membership['MembershipType']?></option>
                            <?php } ?>
                        </select>
                        <span class="error-message text-danger" id="TypeError"></span>
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="member">Select Time</label>
                        <select name="time" id="time" class="form-select" >
                            <option value="" selected disabled>Please select Time</option>
                            <?php foreach(read('schedule') as $scheduleValue) { ?>
                                <option value="<?= htmlspecialchars($scheduleValue['id']) ?>"><?= htmlspecialchars($scheduleValue['start_time']) . " - " . htmlspecialchars($scheduleValue['end_time']); ?></option>
                            <?php } ?>
                        </select>
                        <span class="text-danger" id="memberError"></span>
                    </div>
                    <div class="mb-3">
                        <label for="Status" class="form-label">Status</label>
                        <select class="form-control" name="Status" id="Status" >
                            <option value="" disabled selected>Select Status</option>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                        <span class="error-message text-danger" id="StatusError"></span>
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

<!-- Modal for Delete -->
<div class="modal fade" id="delete-member-modal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <form method="post" id="deleteForm">
            <div class="modal-content">
                <div class="modal-header bg-danger text-light">
                    <h5 class="modal-title text-white">Delete Member</h5>
                    <button type="button" class="btn-close m-3" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="member_id" id="member_id">
                    <p class="lead">Are you sure you want to delete this member?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-primary" name="btnDelete">Yes</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('memberForm').addEventListener('submit', function(event) {
    // Clear previous error messages
    clearErrors();

    let valid = true;

    // Validate Full Name
    if (document.getElementById('FullName').value.trim() === '') {
        document.getElementById('FullNameError').textContent = 'Full Name is required';
        valid = false;
    }

    // Validate Date of Birth
    if (document.getElementById('DateOfBirth').value === '') {
        document.getElementById('DateOfBirthError').textContent = 'Date of Birth is required';
        valid = false;
    }

    // Validate Gender
    if (document.getElementById('Gender').value === '') {
        document.getElementById('GenderError').textContent = 'Gender is required';
        valid = false;
    }

    // Validate Phone (10 digits)
    const phonePattern = /^[0-9]{10}$/;
    if (!phonePattern.test(document.getElementById('Phone').value.trim())) {
        document.getElementById('PhoneError').textContent = 'Phone number must be 10 digits';
        valid = false;
    }

    // Validate Email
    const emailPattern = /^\S+@\S+\.\S+$/;
    if (!emailPattern.test(document.getElementById('Email').value.trim())) {
        document.getElementById('EmailError').textContent = 'Please enter a valid email address';
        valid = false;
    }

    // Validate Address
    if (document.getElementById('Address').value.trim() === '') {
        document.getElementById('AddressError').textContent = 'Address is required';
        valid = false;
    }

    // Validate MemberWeight
    if (document.getElementById('MemberWeight').value.trim() === '') {
        document.getElementById('MemberWeightErro').textContent = 'MemberWeight is required';
        valid = false;
    }

    // Validate Membership Type
    if (document.getElementById('type').value === '') {
        document.getElementById('TypeError').textContent = 'Membership Type is required';
        valid = false;
    }

    // Validate Start Date
    if (document.getElementById('StartDate').value === '') {
        document.getElementById('StartDateError').textContent = 'Start Date is required';
        valid = false;
    }

    // Validate End Date
    if (document.getElementById('EndDate').value === '') {
        document.getElementById('EndDateError').textContent = 'End Date is required';
        valid = false;
    }

    // Validate Status
    if (document.getElementById('Status').value === '') {
        document.getElementById('StatusError').textContent = 'Status is required';
        valid = false;
    }

    // If the form is valid, submit it. Otherwise, prevent submission.
    if (!valid) {
        event.preventDefault(); // Prevent form submission if there are validation errors
    }
});

function clearErrors() {
    document.getElementById('FullNameError').textContent = '';
    document.getElementById('DateOfBirthError').textContent = '';
    document.getElementById('GenderError').textContent = '';
    document.getElementById('PhoneError').textContent = '';
    document.getElementById('EmailError').textContent = '';
    document.getElementById('AddressError').textContent = '';
    document.getElementById('MemberWeightError').textContent = '';
    document.getElementById('TypeError').textContent = '';
    document.getElementById('StartDateError').textContent = '';
    document.getElementById('EndDateError').textContent = '';
    document.getElementById('StatusError').textContent = '';
}

function removeAlert(){
        setTimeout(() => {
            document.querySelector('.alerts').remove()
        }, 3000);
    }

</script>
