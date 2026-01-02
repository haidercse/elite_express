/* ================================
   GLOBAL DATE FORMATTER
================================ */
window.formatDate = function(input) {
    if (!input) return input;

    if (input.includes('/')) {
        let p = input.split('/');
        if (p.length === 3) {
            return `${p[2]}-${p[1]}-${p[0]}`;
        }
    }
    return input;
};


/* ================================
   GLOBAL MONEY FORMATTER
================================ */
window.formatMoney = function(amount, currency = '৳') {
    if (!amount) return currency + '0';
    return currency + parseFloat(amount)
        .toFixed(2)
        .replace(/\d(?=(\d{3})+\.)/g, '$&,');
};


/* ================================
   BANGLADESH PHONE FORMATTER
================================ */
window.formatPhoneBD = function(phone) {
    if (!phone) return '';
    phone = phone.replace(/\D/g, '');
    if (phone.length === 11) {
        return phone.replace(/(\d{3})(\d{4})(\d{4})/, "$1-$2-$3");
    }
    return phone;
};


/* ================================
   IMAGE PREVIEW
================================ */
window.previewImage = function(input, previewSelector) {
    let file = input.files[0];
    if (!file) return;

    let reader = new FileReader();
    reader.onload = function(e) {
        document.querySelector(previewSelector).src = e.target.result;
    };
    reader.readAsDataURL(file);
};


/* ================================
   DATE VALIDATION (DD/MM/YYYY)
================================ */
window.validateDate = function(dateStr) {
    if (!dateStr) return false;

    let pattern = /^(\d{1,2})\/(\d{1,2})\/(\d{4})$/;
    let match = dateStr.match(pattern);
    if (!match) return false;

    let day = parseInt(match[1]);
    let month = parseInt(match[2]);
    let year = parseInt(match[3]);

    if (month < 1 || month > 12) return false;
    if (day < 1 || day > 31) return false;

    if (month === 2) {
        let isLeap = (year % 4 === 0);
        if (day > (isLeap ? 29 : 28)) return false;
    }

    if ([4, 6, 9, 11].includes(month) && day > 30) return false;

    return true;
};


/* ================================
   SWEETALERT TOAST SUCCESS
================================ */
window.toastSuccess = function(message) {
    Swal.fire({
        toast: true,
        icon: 'success',
        title: message,
        position: 'top-end',
        showConfirmButton: false,
        timer: 2000
    });
};


/* ================================
   SWEETALERT TOAST ERROR
================================ */
window.toastError = function(message) {
    Swal.fire({
        toast: true,
        icon: 'error',
        title: message,
        position: 'top-end',
        showConfirmButton: false,
        timer: 2500
    });
};

///* ================================
//   HANDLE VALIDATION ERRORS
//================================ */

window.handleValidationErrors = function(xhr) {
    if (xhr.status === 422) {
        let errors = xhr.responseJSON.errors;
        let msg = Object.values(errors).join('<br>');

        Swal.fire({
            icon: 'error',
            title: 'Validation Error',
            html: msg
        });
    }
};