<?php ?>

<!-- Modal structure -->
<div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmationModalLabel">Confirm Lease Finalization</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    Are you sure you want to finalize the lease? Please review all details before proceeding.
                </div>
                <div class="mb-3">
                    <label for="managerPassword" class="form-label">Enter your password to proceed</label>
                    <input type="password" class="form-control" id="managerPassword" name="managerPassword" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" form="leaseConfirmationForm" class="btn btn-primary">Confirm</button>
            </div>
        </div>
    </div>
</div>
