function initializePagination(filteredCPs) {
    const cpList = document.getElementById('chargePointList');
    const chargePoints = (filteredCPs || Array.from(cpList.querySelectorAll('.chargePoint'))).filter(cp => cp && cp.style);
    const itemsPerPage = 10;
    let currentPage = 1;

    function displayCPs() {
        for (let i = 0; i < chargePoints.length; i++) {
            if (chargePoints[i]) {
                if (i >= (currentPage - 1) * itemsPerPage && i < currentPage * itemsPerPage) {
                    chargePoints[i].style.display = 'block';
                } else {
                    chargePoints[i].style.display = 'none';
                }
            }
        }
    }

    function goToPage(pageNumber) {
        currentPage = pageNumber;
        displayCPs();
    }

    function createPagination() {
        const paginationContainer = document.getElementById('paginationContainer');

        const totalPages = Math.ceil(chargePoints.length / itemsPerPage);
        const maxButtons = 5;
        let startPage = 1;
        let endPage = Math.min(totalPages, maxButtons);

        function updatePaginationButtons() {
            paginationContainer.innerHTML = '';

            // Add the Previous button
            const prevBtn = document.createElement('button');
            prevBtn.innerText = 'Previous';
            prevBtn.disabled = currentPage === 1;
            prevBtn.addEventListener('click', function () {
                if (currentPage > 1) {
                    currentPage--;
                    if (currentPage < startPage) {
                        startPage--;
                        endPage--;
                    }
                    updatePaginationButtons();
                    goToPage(currentPage);
                }
            });
            paginationContainer.appendChild(prevBtn);

            // Add the page buttons
            for (let i = startPage; i <= endPage; i++) {
                const pageBtn = document.createElement('button');
                pageBtn.innerText = i;
                pageBtn.classList.toggle('current-page', i === currentPage);
                pageBtn.addEventListener('click', function () {
                    goToPage(i);
                });
                paginationContainer.appendChild(pageBtn);
            }

            // Add the Next button
            const nextBtn = document.createElement('button');
            nextBtn.innerText = 'Next';
            nextBtn.disabled = currentPage === totalPages;
            nextBtn.addEventListener('click', function () {
                if (currentPage < totalPages) {
                    currentPage++;
                    if (currentPage > endPage) {
                        startPage++;
                        endPage++;
                    }
                    updatePaginationButtons();
                    goToPage(currentPage);
                }
            });
            paginationContainer.appendChild(nextBtn);
        }

        updatePaginationButtons();
    }

    createPagination();
}





