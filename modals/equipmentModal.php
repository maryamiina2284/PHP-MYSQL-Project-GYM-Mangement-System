<!-- Modal -->
<div class="modal fade" id="equipment-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Equipment</h5>
                <button type="button" class="btn-close m-3" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="equipment.php" id="equipmentsForm" novalidate>
                    <input type="hidden" name="action" id="action" value="insert">
                    <input type="hidden" name="equipmentid" id="equipmentid" value="0">

                    <!-- Equipment Name -->
                    <div class="mb-3">
                        <label for="EquipmentName" class="form-label">Equipment Name</label>
                        <input type="text" class="form-control" id="EquipmentName" name="EquipmentName">
                        <span class="text-danger" id="EquipmentNameError"></span>
                    </div>

                    <!-- Purchase Cost -->
                    <div class="mb-3">
                        <label for="PurchaseCost" class="form-label">Purchase Cost</label>
                        <input type="number" step="0.01" class="form-control" id="PurchaseCost" name="PurchaseCost">
                        <span class="text-danger" id="PurchaseCostError"></span>
                    </div>

                    <!-- Quantity -->
                    <div class="mb-3">
                        <label for="Quantity" class="form-label">Quantity</label>
                        <input type="number" class="form-control" id="Quantity" name="Quantity" min="1">
                        <span class="text-danger" id="QuantityError"></span>
                    </div>

                    <!-- Purchase Date -->
                    <div class="mb-3">
                        <label for="PurchaseDate" class="form-label">Purchase Date</label>
                        <input type="date" class="form-control" id="PurchaseDate" name="PurchaseDate">
                        <span class="text-danger" id="PurchaseDateError"></span>
                    </div>

                    <button type="submit" name="btnSave" class="btn btn-primary">Save Equipment</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Delete -->
<div class="modal fade" id="delete-equipment-modal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <form method="post" id="deleteForm">
            <div class="modal-content">
                <div class="modal-header bg-danger text-light">
                    <h5 class="modal-title">Delete Equipment</h5>
                    <button type="button" class="btn-close m-3" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="equipment_id" id="equipment_id">
                    <p class="lead">Are you sure you want to delete this equipment?</p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary m-2" data-bs-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-primary" name="btnDelete">Yes</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Script -->
<script>
    // Form validation
    document.getElementById('equipmentsForm').addEventListener('submit', function(event) {

        // Clear previous error messages
        clearErrors();

        let valid = true;

        // Validate Equipment Name
        const EquipmentName = document.getElementById('EquipmentName').value.trim();
        if (EquipmentName === '') {
            document.getElementById('EquipmentNameError').textContent = 'Equipment Name is required';
            valid = false;
        }

        // Validate Purchase Cost
        const PurchaseCost = document.getElementById('PurchaseCost').value.trim();
        if (PurchaseCost === '' || isNaN(PurchaseCost) || PurchaseCost <= 0) {
            document.getElementById('PurchaseCostError').textContent = 'Valid Purchase Cost is required';
            valid = false;
        }

        // Validate Quantity
        const Quantity = document.getElementById('Quantity').value;
        if (Quantity === '' || isNaN(Quantity) || Quantity <= 0) {
            document.getElementById('QuantityError').textContent = 'Valid Quantity is required';
            valid = false;
        }

        // Validate Purchase Date
        const PurchaseDate = document.getElementById('PurchaseDate').value.trim();
        const today = new Date().toISOString().split('T')[0]; // Get today's date in YYYY-MM-DD format
        if (PurchaseDate === '') {
            document.getElementById('PurchaseDateError').textContent = 'Purchase date is required';
            valid = false;
        } else if (PurchaseDate > today) {
            document.getElementById('PurchaseDateError').textContent = 'Purchase date cannot be in the future';
            valid = false;
        }

        // If the form is invalid, prevent submission
        if (!valid) {
            event.preventDefault(); // Prevent form submission
        }
    });

    // Function to clear previous error messages
    function clearErrors() {
        document.getElementById('EquipmentNameError').textContent = '';
        document.getElementById('PurchaseCostError').textContent = '';
        document.getElementById('QuantityError').textContent = '';
        document.getElementById('PurchaseDateError').textContent = '';
    }

    // Remove alert after 3 seconds
    function removeAlert() {
        setTimeout(() => {
            document.querySelector('.alerts').remove();
        }, 3000);
    }
</script>
