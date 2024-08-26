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
    document.getElementById('user-menu-button').addEventListener('click', function () {
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