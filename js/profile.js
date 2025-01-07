
document.addEventListener('DOMContentLoaded', function() {
    const editProfileBtn = document.getElementById('edit-btn');
    const updateCPBtn = document.getElementById('update-btn');
    const registerCPBtn = document.getElementById('register-btn');
    const editUserForm = document.getElementById('edit-form');
    const editCpForm = document.getElementById('editcp-form');
    const registerCpForm = document.getElementById('register-form');

    const cancelEditProfileBtn = document.getElementById('canceledit-btn');
    const cancelUpdateChargePointBtn = document.getElementById('canceleditcp-btn');
    const cancelRegisterChargePointBtn = document.getElementById('cancelregister-btn');

    const userDetailsTable = document.getElementById('user-table');
    const chargePointDetailsTable = document.getElementById('cp-table');

    function hideAllForms() {
        editUserForm.style.display = 'none';
        editCpForm.style.display = 'none';

        if(registerCpForm){
            registerCpForm.style.display = 'none';
        }

    }

    function showAllTables(showTable) {
        if (showTable === 'userDetails') {
            userDetailsTable.style.display = 'table';
        } else if (showTable === 'chargePointDetails') {
            chargePointDetailsTable.style.display = 'table';
        }
    }

    cancelEditProfileBtn.addEventListener('click', function(event) {
        event.preventDefault();
        hideAllForms();
        showAllTables('userDetails');
        editProfileBtn.style.display = 'block';
    });

    cancelUpdateChargePointBtn.addEventListener('click', function(event) {
        event.preventDefault();
        hideAllForms();
        showAllTables('chargePointDetails');
        updateChargePointBtn.style.display = 'block';
    });

    if (cancelRegisterChargePointBtn) {
        cancelRegisterChargePointBtn.addEventListener('click', function(event) {
            event.preventDefault();
            hideAllForms();
        });
    }


    editProfileBtn.addEventListener('click', function() {
        editProfileBtn.style.display = 'none';
        hideAllForms();
        userDetailsTable.style.display = 'none';
        editUserForm.style.display = 'block';
    });

    updateChargePointBtn.addEventListener('click', function() {
        updateChargePointBtn.style.display = 'none';
        hideAllForms();
        chargePointDetailsTable.style.display = 'none';
        editCpForm.style.display = 'block';
    });

    if (registerChargePointBtn) {
        registerChargePointBtn.addEventListener('click', function () {
            hideAllForms();
            registerCpForm.style.display = 'block';
        });
    }

    hideAllForms();
    showAllTables('userDetails');
    showAllTables('chargePointDetails');
});