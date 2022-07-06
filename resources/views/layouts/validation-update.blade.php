<script>
(function() {
    'use strict';
    window.addEventListener('load', function() {
    var formsUpdate = document.getElementsByClassName('validation-update');
    const spinnerUpdate = document.getElementById('spinner-update');
    var validationUpdate = Array.prototype.filter.call(formsUpdate, function(form) {
        form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
        }
        if (form.checkValidity()) {
            spinnerUpdate.classList.toggle('show');
        }
        form.classList.add('was-validated');
        }, false);
    });
    }, false);
})();
</script>