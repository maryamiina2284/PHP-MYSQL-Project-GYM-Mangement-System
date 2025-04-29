<!-- Modal -->
<div class="modal fade" id="ScheduleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="post" id="scheduleForm" novalidate>
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Schedule</h5>
                    <button type="button" class="btn-close m-3" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="action" id="action" value="insert">
                    <input type="hidden" name="scheduleid" id="scheduleid" value="0">

                    <div class="mb-3">
                        <label for="class_id" class="form-label">Class</label>
                        <select name="class_id" id="class_id" class="form-select" required>
                            <option value="" selected disabled>Please Select Class Name</option>
                            <?php foreach (read('class') as $cls) { ?>
                                <option value="<?= htmlspecialchars($cls['id']) ?>"><?= htmlspecialchars($cls['class_name']) ?></option>
                            <?php } ?>
                        </select>
                        <span class="error-message text-danger" id="class_idError"></span>
                    </div>

                    <div class="mb-3">
                        <label for="start_time" class="form-label">Start Time</label>
                        <input type="time" class="form-control" name="start_time" id="start_time" required>
                        <span class="error-message text-danger" id="StartTimeError"></span>
                    </div>
                    <div class="mb-3">
                        <label for="end_time" class="form-label">End Time</label>
                        <input type="time" class="form-control" name="end_time" id="end_time" required>
                        <span class="error-message text-danger" id="EndTimeError"></span>
                    </div>
                    <div class="mb-3">
                        <label for="location" class="form-label">Location</label>
                        <input type="text" class="form-control" name="location" id="location" required>
                        <span class="error-message text-danger" id="locationError"></span>
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
<div class="modal fade" id="delete-schedule-modal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <form method="post" id="deleteForm">
            <div class="modal-content">
                <div class="modal-header bg-danger text-light">
                    <h5 class="modal-title">Delete schedule</h5>
                    <button type="button" class="btn-close m-3" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="schedule_Id" id="schedule_Id">
                    <p class="lead">Are you sure you want to delete this schedule?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary m-2" data-bs-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-danger" name="btnDelete">Yes</button>
                </div>
            </div>
        </form>
    </div>
</div>


<script>
    document.getElementById('scheduleForm').addEventListener('submit', function(event) {
        // Clear previous error messages
        clearErrors();

        let valid = true;

        // Validate Class Selection
        if (document.getElementById('class_id').value === '') {
            document.getElementById('class_idError').textContent = 'Class is required';
            valid = false;
        }
        
        // Validate Start Time
        if (document.getElementById('start_time').value === '') {
            document.getElementById('StartTimeError').textContent = 'Start Time is required';
            valid = false;
        }

        // Validate End Time
        if (document.getElementById('end_time').value === '') {
            document.getElementById('EndTimeError').textContent = 'End Time is required';
            valid = false;
        }

        // Validate Location
        if (document.getElementById('location').value === '') {
            document.getElementById('locationError').textContent = 'Location is required';
            valid = false;
        }

        // Prevent form submission if invalid
        if (!valid) {
            event.preventDefault();
        }
    });

    function clearErrors() {
        document.getElementById('StartTimeError').textContent = '';
        document.getElementById('EndTimeError').textContent = '';
        document.getElementById('class_idError').textContent = '';
        document.getElementById('locationError').textContent = '';
    }

    function removeAlert() {
        setTimeout(() => {
            document.querySelector('.alerts').remove()
        }, 3000);
    }
</script>
