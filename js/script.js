document.addEventListener('DOMContentLoaded', function () {
    const updateButtons = document.querySelectorAll('.btn-update');

    updateButtons.forEach(button => {
        button.addEventListener('click', () => {
            Swal.fire({
                icon: 'success',
                title: 'Update Successful',
                text: 'The record has been updated.',
            });
        });
    });
});


/*change color when select  the fire or balance*/
document.addEventListener('DOMContentLoaded', function () {
    const equipmentLabels = document.querySelectorAll('.equipment');

    equipmentLabels.forEach(label => {
        const radioInput = label.querySelector('input[type="radio"]');

        // Add an event listener to the input
        radioInput.addEventListener('change', function () {
            // Remove the selected class from all labels
            equipmentLabels.forEach(lbl => lbl.style.backgroundColor = '#f0f4fa');

            // Apply the new style for the selected label
            if (radioInput.checked) {
                // Check if the radio input value is 'fire-extinguisher'
                if (radioInput.value === 'fire-extinguisher') {
                    label.style.backgroundColor = '#ffe0e0'; // Fire color
                } else {
                    label.style.backgroundColor = '#ffe0e0'; // Balance color (or another color)
                }
            }
        });
    });
});






/*change color when select  the low, medium, high*/
document.addEventListener('DOMContentLoaded', function () {
    const priorityLabels = document.querySelectorAll('.priority');
    
    // Function to update background color based on the selected radio button
    function updateBackgroundColor() {
        // Reset background color for all labels
        priorityLabels.forEach(label => label.style.backgroundColor = '#f0f4fa');
        
        // Find the selected radio button
        const selectedRadio = document.querySelector('input[name="priority"]:checked');
        const selectedLabel = selectedRadio ? selectedRadio.closest('label') : null;

        // Apply color based on selected radio button value
        if (selectedLabel) {
            switch (selectedRadio.value) {
                case 'low':
                    selectedLabel.style.backgroundColor = '#e0ffe0'; // Light green for low priority
                    break;
                case 'medium':
                    selectedLabel.style.backgroundColor = '#ffffe0'; // Light yellow for medium priority
                    break;
                case 'high':
                    selectedLabel.style.backgroundColor = '#ffe0e0'; // Light red for high priority
                    break;
            }
        }
    }

    // Add event listener to radio buttons to update background color on change
    const radios = document.querySelectorAll('input[name="priority"]');
    radios.forEach(radio => {
        radio.addEventListener('change', updateBackgroundColor);
    });

    // Call the function initially to set the default color
    updateBackgroundColor();
});


