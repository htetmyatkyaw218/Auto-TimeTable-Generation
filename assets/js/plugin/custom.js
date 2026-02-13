document.addEventListener("DOMContentLoaded", function () {
  const table = document.querySelector("#add-row");
  const searchInput = document.getElementById("customSearchInput"); // use your existing input
  if (!table || !searchInput) return;

  const originalRows = Array.from(table.querySelectorAll("tbody tr"));
  let filteredRows = [...originalRows];
  const rowsPerPage = 10;
  let currentPage = 1;

  const info = document.createElement("div");
  info.className = "mt-2 ms-2";

  const pagination = document.createElement("div");
  pagination.className = "d-flex justify-content-center mt-2 flex-wrap gap-2";

  function updateInfoText(start, end) {
    info.textContent = `Showing ${start + 1} to ${end} of ${filteredRows.length} entries`;
  }

  function showPage(page) {
    const start = (page - 1) * rowsPerPage;
    const end = Math.min(start + rowsPerPage, filteredRows.length);

    originalRows.forEach(row => row.style.display = "none");
    filteredRows.forEach((row, index) => {
      row.style.display = (index >= start && index < end) ? "" : "none";
    });

    updateInfoText(start, end);
  }

  function createPagination() {
    pagination.innerHTML = "";
    const totalPages = Math.ceil(filteredRows.length / rowsPerPage);

    const prevBtn = document.createElement("button");
    prevBtn.textContent = "Previous";
    prevBtn.className = "btn btn-sm " + (currentPage === 1 ? "btn-secondary" : "btn-outline-primary");
    prevBtn.disabled = currentPage === 1;
    prevBtn.onclick = () => {
      if (currentPage > 1) {
        currentPage--;
        showPage(currentPage);
        createPagination();
      }
    };
    pagination.appendChild(prevBtn);

    for (let i = 1; i <= totalPages; i++) {
      const pageBtn = document.createElement("button");
      pageBtn.textContent = i;
      pageBtn.className = "btn btn-sm " + (i === currentPage ? "btn-primary" : "btn-outline-secondary");
      pageBtn.onclick = () => {
        currentPage = i;
        showPage(currentPage);
        createPagination();
      };
      pagination.appendChild(pageBtn);
    }

    const nextBtn = document.createElement("button");
    nextBtn.textContent = "Next";
    nextBtn.className = "btn btn-sm " + (currentPage === totalPages ? "btn-secondary" : "btn-outline-primary");
    nextBtn.disabled = currentPage === totalPages;
    nextBtn.onclick = () => {
      if (currentPage < totalPages) {
        currentPage++;
        showPage(currentPage);
        createPagination();
      }
    };
    pagination.appendChild(nextBtn);
  }

  function filterRows(keyword) {
    const lowerKeyword = keyword.toLowerCase();
    filteredRows = originalRows.filter(row =>
      row.innerText.toLowerCase().includes(lowerKeyword)
    );
    currentPage = 1;
    showPage(currentPage);
    createPagination();
  }

  //  Hook up search input
  searchInput.addEventListener("input", function () {
    filterRows(this.value);
  });

  // Initial render
  table.insertAdjacentElement("afterend", info);
  info.insertAdjacentElement("afterend", pagination);

  showPage(currentPage);
  createPagination();
});