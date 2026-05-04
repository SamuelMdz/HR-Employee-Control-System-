function confirmDelete() {
    return confirm("Are you sure you want to delete this employee?");
}

function confirmAdd() {
    return confirm("Are you sure you want to add this employee?");
}

function confirmApprove() {
    return confirm("Are you sure you want to approve this request?");
}

function confirmReject() {
    return confirm("Are you sure you want to reject this request?");
}

const searchInput = document.getElementById("searchInput");

if (searchInput) {
    searchInput.addEventListener("keyup", function() {
        const filter = searchInput.value.toLowerCase();

        const rows = document.querySelectorAll("#employeeTable tbody tr");
        rows.forEach(function(row) {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(filter) ? "" : "none";
        });
    });
}
