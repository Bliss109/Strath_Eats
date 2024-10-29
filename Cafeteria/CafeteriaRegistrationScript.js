document.addEventListener('DOMContentLoaded', function () {
    const cafeteriaForm = document.getElementById('CafeteriaForm');
    
    cafeteriaForm.addEventListener('submit', function (e) {
        e.preventDefault();
        let isValid = true;

        // Get form fields and error spans
        const cafeteriaName = document.getElementById('cafeteriaName');
        const cafeteriaNameError = document.getElementById('cafeteriaNameError');

        const location = document.getElementById('location');
        const locationError = document.getElementById('locationError');

        const openingHours = document.getElementById('openingHours');
        const openingHoursError = document.getElementById('openingHoursError');

        const contactInfo = document.getElementById('contactInfo');
        const contactInfoError = document.getElementById('contactInfoError');

        const description = document.getElementById('description');
        const descriptionError = document.getElementById('descriptionError');

        // Reset errors
        cafeteriaNameError.textContent = '';
        locationError.textContent = '';
        openingHoursError.textContent = '';
        contactInfoError.textContent = '';
        descriptionError.textContent = '';

        // Validate Cafeteria Name
        if (cafeteriaName.value.trim() === '') {
            cafeteriaNameError.textContent = 'Please enter the cafeteria name.';
            isValid = false;
        }

        // Validate Location
        if (location.value.trim() === '') {
            locationError.textContent = 'Please enter the location.';
            isValid = false;
        }

        // Validate Opening Hours
        if (openingHours.value.trim() === '') {
            openingHoursError.textContent = 'Please enter the opening hours.';
            isValid = false;
        }

        // Validate Contact Information
        if (contactInfo.value.trim() === '') {
            contactInfoError.textContent = 'Please enter contact information.';
            isValid = false;
        }

        // Validate Description
        if (description.value.trim() === '') {
            descriptionError.textContent = 'Please enter a description of the cafeteria.';
            isValid = false;
        }

        // If the form is valid, submit the form data
        if (isValid) {
            alert('Cafeteria registered successfully!');
            cafeteriaForm.reset(); // Reset form fields after successful submission

            // You can add a server call here to submit data via AJAX or a fetch request if needed
            // For example:
            // fetch('your-api-endpoint', {
            //     method: 'POST',
            //     headers: { 'Content-Type': 'application/json' },
            //     body: JSON.stringify({
            //         name: cafeteriaName.value,
            //         location: location.value,
            //         opening_hours: openingHours.value,
            //         contact_info: contactInfo.value,
            //         description: description.value
            //     })
            // }).then(response => response.json())
            //   .then(data => console.log('Cafeteria registered:', data))
            //   .catch(error => console.error('Error:', error));
        }
    });
});
