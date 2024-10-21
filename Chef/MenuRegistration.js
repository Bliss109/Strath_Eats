document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('MenuForm');

    form.addEventListener('submit', function(event) {
        event.preventDefault();
        let valid = true;

        // Clear previous error messages
        document.querySelectorAll('.error').forEach(error => {
            error.style.display = 'none';
        });

        // Menu Name validation
        const menuName = document.getElementById('menuName').value.trim();
        if (menuName === '') {
            valid = false;
            document.getElementById('menuNameError').textContent = 'Menu name is required.';
            document.getElementById('menuNameError').style.display = 'block';
        }

        // Menu Description validation
        const menuDescription = document.getElementById('menuDescription').value.trim();
        if (menuDescription === '') {
            valid = false;
            document.getElementById('menuDescriptionError').textContent = 'Menu description is required.';
            document.getElementById('menuDescriptionError').style.display = 'block';
        }

        // Menu Price validation
        const menuPrice = document.getElementById('menuPrice').value.trim();
        if (menuPrice === '') {
            valid = false;
            document.getElementById('menuPriceError').textContent = 'Menu price is required.';
            document.getElementById('menuPriceError').style.display = 'block';
        } else if (isNaN(menuPrice) || parseFloat(menuPrice) <= 0) {
            valid = false;
            document.getElementById('menuPriceError').textContent = 'Enter a valid price.';
            document.getElementById('menuPriceError').style.display = 'block';
        }

        // Menu Image validation
        const menuImage = document.getElementById('menuImage').value;
        if (menuImage === '') {
            valid = false;
            document.getElementById('menuImageError').textContent = 'Menu image is required.';
            document.getElementById('menuImageError').style.display = 'block';
        }

        // If valid, you can submit the form or do other actions
        if (valid) {
            alert('Form submitted successfully!');
            form.submit();
        }
    });
});
