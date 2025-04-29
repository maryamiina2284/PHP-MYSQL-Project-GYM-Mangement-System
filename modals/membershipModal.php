<!-- Modal -->
<div class="modal fade" id="membership-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Membership</h5>
                <button type="button" class="btn-close m-3" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="membership.php" id="membershipForm" novalidate>
                    <input type="hidden" name="action" id="action" value="insert">
                    <input type="hidden" name="membershipid" id="membershipid" value="0">
                    <div class="mb-3">
                        <label for="MembershipType" class="form-label">Membership Type</label>
                        <input type="text" class="form-control" id="MembershipType" name="MembershipType">
                        <span class="text-danger" id="MembershipTypeError"></span>
                    </div>
                    <div class="mb-3">
                        <label for="Price" class="form-label">Price</label>
                        <input type="text" class="form-control" id="Price" name="Price">
                        <span class="text-danger" id="PriceError"></span>
                    </div>
                    <div class="mb-3">
                        <label for="Duration" class="form-label">Duration (in days)</label>
                        <input type="number" class="form-control" id="Duration" name="Duration">
                        <!-- <span class="text-danger" id="DurationError"></span> -->
                    </div>
                    <button type="submit" name="btnSaveMembership" class="btn btn-primary">Save Membership</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Delete -->
<div class="modal fade" id="delete-membership-modal" tabindex="-1" aria-labelledby="deleteModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <form method="post" id="deleteForm">
            <div class="modal-content">
                <div class="modal-header bg-danger text-light">
                    <h5 class="modal-title">Delete Membership</h5>
                    <button type="button" class="btn-close m-3" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="membership_id" id="membership_id">
                    <p class="lead">Are you sure you want to delete this membership?</p>
                </div>
               
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary m-2" data-bs-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-primary" name="btnDelete">Yes</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- script -->
<script>
    // form validation
document.getElementById('membershipForm').addEventListener('submit', function(event) {

    // Clear previous error messages
    clearErrors();

    let valid = true;

    // Validate Membership Type
    const membershipType = document.getElementById('MembershipType').value.trim();
    if (membershipType === '') {
        document.getElementById('MembershipTypeError').textContent = 'Membership Type is required';
        valid = false;
    }

    // Validate Price
    const price = document.getElementById('Price').value.trim();
    if (price === '' || isNaN(price) || price <= 0) {
        document.getElementById('PriceError').textContent = 'Valid price is required';
        valid = false;
    }

    // Validate Duration
    const duration = document.getElementById('Duration').value.trim();
    // if (duration === '' || isNaN(duration) || duration <= 0) {
    //     document.getElementById('DurationError').textContent = 'Valid duration in days is required';
    //     valid = false;
    // }

    // If the form is valid, submit it. Otherwise, prevent submission.
    if (!valid) {
        event.preventDefault(); // Prevent form submission if there are validation errors
    }
});

function clearErrors() {
    document.getElementById('MembershipTypeError').textContent = '';
    document.getElementById('PriceError').textContent = '';
}

function removeAlert() {
    setTimeout(() => {
        document.querySelector('.alerts').remove()
    }, 3000);
}
</script>