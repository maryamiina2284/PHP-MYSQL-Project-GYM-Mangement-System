

<!-- Class Modal -->
<div class="modal fade" id="ClassModal" tabindex="-1" aria-labelledby="ClassModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ClassModalLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="class.php" id="classForm">
                    <input type="hidden" name="action" id="action" value="insert">
                    <input type="hidden" name="classid" id="classid" value="0">

                    <!-- Class Name Input -->
                    <div class="mb-3">
                        <label for="class_name" class="form-label">Class Name</label>
                        <input type="text" class="form-control" id="class_name" name="class_name">
                        <span id="class_name_error" class="text-danger"></span>
                    </div>

                    <!-- Description Input -->
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        <span id="description_error" class="text-danger"></span>
                    </div>

                    <!-- Trainer Name Select -->
                    <div class="mb-3">
                        <label for="trainer_id" class="form-label">Trainer Name</label>
                        <select name="trainer_id" id="trainer_id" class="form-select">
                            <option value="" selected disabled>Please Select Trainer Name</option>
                            <?php foreach (read('trainers') as $trainer) { ?>
                                <option value="<?= htmlspecialchars($trainer['id']) ?>"><?= htmlspecialchars($trainer['FullName']) ?></option>
                            <?php } ?>
                        </select>
                        <span id="trainer_error" class="text-danger"></span>
                    </div>

                    <!-- Capacity Input -->
                    <div class="mb-3">
                        <label for="capacity" class="form-label">Capacity</label>
                        <input type="number" class="form-control" id="capacity" name="capacity" min="5" max="20">
                        <span id="capacity_error" class="text-danger"></span>
                    </div>

                    <!-- Submit Button -->
                    <div class="mb-3">
                        <button type="submit" name="btnSave" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Modal for Delete -->

<div class="modal fade" id="delete-class-modal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <form method="post" id="deleteForm">
            <div class="modal-content">
                <div class="modal-header bg-danger text-light">
                    <h5 class="modal-title">Delete Class</h5>
                    <button type="button" class="btn-close m-3" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="class_id" id="class_id">
                    <p class="lead">Are you sure you want to delete this Class?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary m-2" data-bs-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-danger" name="btnDelete">Yes</button>
                </div>
            </div>
        </form>
    </div>
</div>


<!-- JavaScript Validation -->
<script>
    document.getElementById("classForm").addEventListener("submit", function(event) {
        let isValid = true;

        // Clear previous error messages
        document.getElementById("class_name_error").innerText = '';
        document.getElementById("description_error").innerText = '';
        document.getElementById("trainer_error").innerText = '';
        document.getElementById("capacity_error").innerText = '';

        // Validate Class Name
        const className = document.getElementById("class_name").value.trim();
        if (className === "") {
            document.getElementById("class_name_error").innerText = "Class name is required.";
            isValid = false;
        }

        // Validate Description
        const description = document.getElementById("description").value.trim();
        if (description === "") {
            document.getElementById("description_error").innerText = "Description is required.";
            isValid = false;
        }

        // Validate Trainer Name
        const trainerId = document.getElementById("trainer_id").value;
        if (trainerId === "") {
            document.getElementById("trainer_error").innerText = "Please select a trainer.";
            isValid = false;
        }

        // Validate Capacity
        const capacity = document.getElementById("capacity").value;
        if (capacity < 5 || capacity > 20) {
            document.getElementById("capacity_error").innerText = "Capacity must be between 5 and 20.";
            isValid = false;
        }

        // If the form is not valid, prevent submission
        if (!isValid) {
            event.preventDefault();
        }
    });

    function removeAlert() {
        setTimeout(() => {
            document.querySelector('.alerts').remove()
        }, 3000);
    }
</script>
