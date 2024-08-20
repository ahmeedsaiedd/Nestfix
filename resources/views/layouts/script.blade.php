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