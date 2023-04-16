window.addEventListener('DOMContentLoaded', function() {

    const typeSelect = document.querySelector('select[name="type_val"]');

    const allFields = document.querySelectorAll('input[type="text"], input[type="button"]');

    const onChange = () => {
        let selectedValue = typeSelect.value;

        for (let i = 0; i < allFields.length; i++) {
            let field = allFields[i];
            const endOfName = field.getAttribute('name').replace(/^\D+/g, '');
            if (endOfName == selectedValue) {
                field.style.display = '';
                field.parentElement.style.display = '';
            } else {
                field.style.display = 'none';
                field.parentElement.style.display = 'none';
            }
        }
    }

    typeSelect.addEventListener('change', onChange);

    onChange();
});
