<!-- Bank Modal -->
<div class="modal fade" id="bankModal" tabindex="-1" aria-labelledby="bankModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="bankModalLabel">Add / Edit Bank Account</h5>
        <button type="button" class="btn-close m-3" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Form to add/update bank account -->
        <form method="POST" action="bank.php" id="bankForm">
          <input type="hidden" name="action" id="action" value="insert">
          <input type="hidden" name="bank_account_id" id="bank_account_id" value="">

          <!-- Name -->
          <div class="mb-3">
            <label for="name" class="form-label">Account Name</label>
            <input type="text" class="form-control" id="name" name="name" >
            <span id="name_error" class="text-danger"></span>
          </div>

          <!-- Account Number -->
          <div class="mb-3">
            <label for="account_num" class="form-label">Account Number</label>
            <input type="text" class="form-control" id="accountNum" name="accountNum" >
            <span id="account_num_error" class="text-danger"></span>
          </div>

          <!-- Balance -->
          <div class="mb-3">
            <label for="balance" class="form-label">Balance</label>
            <input type="number" class="form-control" id="balance" name="balance"  min="0" step="0.01">
            <span id="balance_error" class="text-danger"></span>
          </div>

          <!-- Submit Button -->
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary m-2" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" name="btnSave">Save Changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>



<!-- Modal for Delete -->

<div class="modal fade" id="delete-account-modal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <form method="post" id="deleteForm">
            <div class="modal-content">
                <div class="modal-header bg-danger text-light">
                    <h5 class="modal-title">Delete Account</h5>
                    <button type="button" class="btn-close m-3" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="account_id" id="account_id">
                    <p class="lead">Are you sure you want to delete this Account?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary m-2" data-bs-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-danger" name="btnDelete">Yes</button>
                </div>
            </div>
        </form>
    </div>
</div>


<!-- JavaScript for form reset -->
<script>
function removeAlert(){
        setTimeout(() => {
            document.querySelector('.alerts').remove()
        }, 3000);
    }
</script>
