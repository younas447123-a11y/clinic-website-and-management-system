// assets/js/main.js - AJAX Appointment Flow
document.addEventListener('DOMContentLoaded', function() {
    const serviceSelect = document.getElementById('service_id');
    const doctorSelect = document.getElementById('doctor_id');
    const dateInput = document.getElementById('appointment_date');
    const timeSlotSelect = document.getElementById('time_slot');
    const appointmentForm = document.getElementById('appointment-form');
    
    if (serviceSelect) {
        serviceSelect.addEventListener('change', function() {
            fetch(`../api/get-doctors.php?service_id=${this.value}`)
                .then(res => res.json())
                .then(data => {
                    doctorSelect.innerHTML = '<option value="">Select Doctor</option>';
                    data.forEach(doc => {
                        doctorSelect.innerHTML += `<option value="${doc.id}">${doc.name} (${doc.clinic_name})</option>`;
                    });
                });
        });
    }
    
    if (doctorSelect && dateInput) {
        function loadSlots() {
            const doctorId = doctorSelect.value;
            const date = dateInput.value;
            if (doctorId && date) {
                fetch(`../api/get-slots.php?doctor_id=${doctorId}&date=${date}`)
                    .then(res => res.json())
                    .then(slots => {
                        timeSlotSelect.innerHTML = '<option value="">Select Time</option>';
                        slots.forEach(slot => {
                            timeSlotSelect.innerHTML += `<option value="${slot}">${slot}</option>`;
                        });
                    });
            }
        }
        doctorSelect.addEventListener('change', loadSlots);
        dateInput.addEventListener('change', loadSlots);
    }
    
    if (appointmentForm) {
        appointmentForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(appointmentForm);
            fetch('../api/book-appointment.php', { method: 'POST', body: formData })
                .then(res => res.json())
                .then(data => {
                    alert(data.message);
                    if (data.success) appointmentForm.reset();
                });
        });
    }
});