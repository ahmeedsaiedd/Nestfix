<script>
    document.addEventListener('DOMContentLoaded', function() {
        const issueCategorySelect = document.getElementById('issue_category');
        const newCategoryInput = document.getElementById('new_category');

        issueCategorySelect.addEventListener('change', function() {
            if (issueCategorySelect.value === 'others') {
                newCategoryInput.classList.remove('hidden');
            } else {
                newCategoryInput.classList.add('hidden');
            }
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Hide the loader after 2 seconds (adjust the timing as needed)
        setTimeout(function() {
            document.getElementById('spinner-loader').style.display = 'none';
        }, 500);
    });
</script>
<script>
    @if (Session::has('success'))
        toastr.success("{{ Session::get('success') }}", 'Success', {
            positionClass: 'toast-top-right',
            closeButton: true,
            progressBar: true,
            timeOut: 5000
        });
    @endif
</script>
<script>
    function resetFilters() {
        const forms = ['trace-id-form', 'status-form', 'sort-form'];
        forms.forEach(formId => {
            document.getElementById(formId).reset();
        });
        window.location.href = "{{ route('all-tickets') }}";
    }
</script>
<script>
    document.getElementById('user-menu-button').addEventListener('click', function() {
        const menu = document.getElementById('user-menu');
        menu.classList.toggle('hidden');
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const openModalButtons = document.querySelectorAll('.openModalButton');
        const closeModalButton = document.getElementById('closeModalButton');
        const passwordResetModal = document.getElementById('passwordResetModal');
        const passwordResetForm = document.getElementById('passwordResetForm');
        const userIdInput = document.getElementById('userId');

        openModalButtons.forEach(button => {
            button.addEventListener('click', function() {
                const userId = this.getAttribute('data-user-id');
                userIdInput.value = userId; // Set the user ID in the form
                passwordResetModal.classList.remove('hidden');
            });
        });

        closeModalButton.addEventListener('click', function() {
            passwordResetModal.classList.add('hidden');
        });

        // Optional: close modal if user clicks outside of the modal content
        window.addEventListener('click', function(event) {
            if (event.target === passwordResetModal) {
                passwordResetModal.classList.add('hidden');
            }
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var categorySelect = document.getElementById('category_select');
        var newCategoryInput = document.getElementById('new_category');

        // Function to update the input field based on selected option
        function updateCategoryInput() {
            var selectedValue = categorySelect.value;

            if (selectedValue === 'others') {
                newCategoryInput.classList.remove('hidden');
                newCategoryInput.focus();
            } else {
                newCategoryInput.classList.add('hidden');
                newCategoryInput.value = ''; // Clear the input if not needed
            }
        }

        // Event listener for select element
        categorySelect.addEventListener('change', updateCategoryInput);

        // Initial call to set the input state based on the current select value
        updateCategoryInput();
    });
</script>

<script>
    function confirmDelete(ticketId) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'You will not be able to recover this ticket!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit the form if confirmed
                document.getElementById('delete-form-' + ticketId).submit();
            }
        });
    }
</script>

<script>
    function handleDelete(event) {
        event.preventDefault(); // Prevent default form submission

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.getElementById('delete-form');
                const formData = new FormData(form);

                fetch(form.action, {
                        method: form.method,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content'),
                        },
                        body: formData
                    })
                    .then(response => {
                        if (response.ok) {
                            Swal.fire(
                                'Deleted!',
                                'Your user has been deleted.',
                                'success'
                            ).then(() => {
                                window.location.reload(); // Optionally reload the page
                            });
                        } else {
                            Swal.fire(
                                'Failed!',
                                'There was an error deleting the user.',
                                'error'
                            );
                        }
                    })
                    .catch(() => {
                        Swal.fire(
                            'Error!',
                            'An unexpected error occurred.',
                            'error'
                        );
                    });
            }
        });

        return false; // Prevent default form submission
    }
</script>

<script>
    @section('scripts')
        <
        script >
            document.addEventListener('DOMContentLoaded', function() {
                // Check if there is a success message in the session
                @if (session('success'))
                    toastr.success('{{ session('success') }}', 'Success', {
                        "positionClass": "toast-top-right",
                        "timeOut": "5000",
                        "closeButton": true,
                        "progressBar": true
                    });
                @elseif (session('error'))
                    toastr.error('{{ session('error') }}', 'Error', {
                        "positionClass": "toast-top-right",
                        "timeOut": "5000",
                        "closeButton": true,
                        "progressBar": true
                    });
                @endif
            });
</script>
<script>

// Custom function to handle deletion and display toast notifications
function confirmDelete(event, formId) {
event.preventDefault(); // Prevent form submission
const form = document.getElementById(formId);

if (confirm('Are you sure you want to delete this team?')) {
form.submit(); // Submit the form if confirmed
toastr.success('Team deleted successfully!', 'Success', {
"positionClass": "toast-top-right",
"timeOut": "5000",
"closeButton": true,
"progressBar": true
});
} else {
toastr.info('Team deletion canceled.', 'Info', {
"positionClass": "toast-top-right",
"timeOut": "5000",
"closeButton": true,
"progressBar": true
});
}
}
</script>
