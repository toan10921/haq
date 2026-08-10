document.addEventListener('DOMContentLoaded', function() {
    const enableMegaMenuCheckboxes = document.querySelectorAll('input[name^="enable_megamenu"]');
    const customWidthFields = document.querySelectorAll('.hidden-field[name^="custom_width"]');
    const contentFields = document.querySelectorAll('.hidden-field[name^="content"]');

    function toggleFields() {
        enableMegaMenuCheckboxes.forEach((checkbox, index) => {
            if (checkbox.checked) {
                customWidthFields[index].style.display = 'block';
                customWidthFields[index].parentElement.style.display = 'block';
                contentFields[index].style.display = 'block';
                contentFields[index].parentElement.style.display = 'block';
            } else {
                customWidthFields[index].style.display = 'none';
                customWidthFields[index].parentElement.style.display = 'none';
                contentFields[index].style.display = 'none';
                contentFields[index].parentElement.style.display = 'none';
            }
        });
    }

    enableMegaMenuCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', toggleFields);
    });

    // Initial check
    toggleFields();
});