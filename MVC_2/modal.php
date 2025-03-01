<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">Fill out the information</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="signupProcess.php" method="POST">
                    <div class="mb-3">
                        <label class="form-label" for="firstName">First Name</label>
                        <input type="text" class="form-control" id="firstName" name="firstName" placeholder="First Name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="lastName">Last Name</label>
                        <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Last Name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="address">Address</label>
                        <input type="text" class="form-control" id="address" name="address" placeholder="Your Address" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100" name="save">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>
