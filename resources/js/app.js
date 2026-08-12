

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

document.addEventListener('DOMContentLoaded', () => {
    window.jQuery?.('#department-form, #employee-form').each(function () {
        window.jQuery(this).on('submit', (event) => {
            let valid = true;
            for (const field of event.currentTarget.querySelectorAll('[required]')) {
                field.classList.remove('border-red-500');
                if (!field.value.trim()) {
                    valid = false;
                    field.classList.add('border-red-500');
                }
            }
            if (!valid) event.preventDefault();
        });
    });

    document.querySelectorAll('.js-delete-form').forEach((form) => {
        form.addEventListener('submit', (event) => {
            event.preventDefault();
            window.Swal.fire({
                title: 'Delete this record?',
                text: 'This action can be recovered only by an administrator from the database.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#dc2626',
            }).then((result) => { if (result.isConfirmed) form.submit(); });
        });
    });
});
