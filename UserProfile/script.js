function saveChanges() {
    alert('Changes saved successfully!');
}

function cancelChanges() {
    if(confirm('Are you sure you want to discard changes?')) {
        // Reset form or redirect
        window.location.reload();
    }
}
