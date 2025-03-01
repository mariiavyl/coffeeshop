    <div class='modal fade' id='editModal' tabindex='-1' aria-labelby='editModalLabel' aria-hidden='true'>
            <div class='modal-dialog'>
                <div class='modal-content'>
                    <div class='modal-header'>
                        <h5 class='modal-title' id='editModalLabel'>Edit Record</h5>
                        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='close'></button>
                    </div>

                    <div class='modal-body'>
                        <form method='POST' action='update.php'>
                            <input type='hidden' id='edit_id' name='id'>
                            <div class='mb-3'>
                                <label for="edit_firstName" class="form-label">First Name</label>
                                <input type='text' class='form-control' id='edit_firstName' name='firstName' required>
                            </div>
                            <div class='mb-3'>
                                <label for="edit_lastName" class="form-label">Last Name</label>
                                <input type='text' class='form-control' id='edit_lastName' name='lastName' required>
                            </div>
                            <div class='mb-3'>
                                <label for="edit_address" class="form-label">Address</label>
                                <input type='text' class='form-control' id='edit_address' name='address' required>
                            </div>
                            <button type='submit' class='btn btn-primary' name='update'>Save Changes</button>
                        </form>
                    </div>
                </div>
            </div>
     </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const editButtons = document.querySelectorAll(".edit-btn");
            editButtons.forEach(button => {
                button.addEventListener("click", function() {
                    const id = this.getAttribute("data-id");
                    const firstName = this.getAttribute("data-firstName");
                    const lastName = this.getAttribute("data-lastName");
                    const address = this.getAttribute("data-address");

                    document.getElementById("edit_id").value = id;
                    document.getElementById("edit_firstName").value = firstName;
                    document.getElementById("edit_lastName").value = lastName;
                    document.getElementById("edit_address").value = address;

                    new bootstrap.Modal(document.getElementById("editModal")).show();
                });
            });   
        });
    </script>
