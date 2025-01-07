// liveSearch.js

// Make liveSearch object global
window.liveSearch = {
    filterChargePoints: filterChargePoints,
    updateListView: updateListView,
    updateMapView: updateMapView,
    onChangePage: onChangePage,
    onSearchInput: onSearchInput,
};

// Manage pagination
function onChangePage(pageNum) {
// Obtain search text
    const searchText = document.getElementById('searchInput').value;

    // Filter charge points based on search text
    const filteredChargePoints = liveSearch.filterChargePoints(searchText, chargePointData);

// Define items per page
    const itemsPerPage = 5;

// Calculate start and end index of items to display
    const startIndex = (pageNum - 1) * itemsPerPage;
    const endIndex = startIndex + itemsPerPage;

// Determine charge points to display on current page
    const chargePointsToShow = filteredChargePoints.slice(startIndex, endIndex);

// Update list view and map view with charge points to display
    liveSearch.updateListView(chargePointsToShow);
    liveSearch.updateMapView(chargePointsToShow, map);

}

// Manage search input
function onSearchInput(chargePointData, map) {
// Obtain search text
    const searchText = document.getElementById('searchInput').value;

    // Filter charge points based on search text
    const filteredChargePoints = filterChargePoints(searchText, chargePointData);

    console.log('Filtered charge points:', filteredChargePoints);

// Send filtered charge points to addChargePointMarkers in map.js
    addChargePointMarkers(filteredChargePoints);

// Update list view with filtered charge points
    liveSearch.updateListView(filteredChargePoints);

// Display suggestion dropdown
    showSuggestions(filteredChargePoints, searchText);

}

// Display suggestion dropdown
function showSuggestions(filteredChargePoints, searchText) {
    const suggestionList = document.getElementById('suggestionList');
    suggestionList.innerHTML = '';

    // Filter charge points list by search text
    const suggestedChargePoints = filteredChargePoints.filter(cp => {
        return cp.name.toLowerCase().includes(searchText.toLowerCase()) ||
            cp.address.toLowerCase().includes(searchText.toLowerCase());
    });

// Display suggestions
    if (suggestedChargePoints.length > 0) {
        const ul = document.createElement('ul');

        suggestedChargePoints.forEach(cp => {
            const li = document.createElement('li');
            const a = document.createElement('a');
            a.href = `request.php?chargeid=${cp.id}`;
            a.textContent = cp.name;
            li.appendChild(a);
            ul.appendChild(li);
        });

        suggestionList.appendChild(ul);
    }

}

// Filter charge points based on search text
function filterChargePoints(searchText, chargePointData) {
    const filteredChargePoints = chargePointData.filter(cp =>
        cp.name.toLowerCase().includes(searchText.toLowerCase()) ||
        cp.address.toLowerCase().includes(searchText.toLowerCase())
    );

    return filteredChargePoints;
}

// Update list view with filtered charge points
function updateListView(filteredChargePoints) {
    let chargePointList = document.getElementById('chargePointList');
    let htmlContent = '<div class="row row-cols-1 row-cols-md-5 g-4">';
    filteredChargePoints.forEach(chargePoint => {
        htmlContent += `
  <div class="col chargePoint">
    <div class="card align-items-center text-center">
      <div class="card-body">
        <div><img class="rounded-circle" width="100px" src="${chargePoint.photo}">
          <h5 class="card"></h5>
          <h5 class="card-title">${chargePoint.cost}</h5>
        </div>
        <p class="card-text">
          ${chargePoint.address}<br>
          ${chargePoint.name}<br>
          ${chargePoint.number}
          </p>
          <a href="request.php?chargeid=${chargePoint.id}"><button type="button" class="btn btn-outline-primary">Request</button></a>
       </div>
        </div>
        </div>`;
    });

    htmlContent += '</div>';
    chargePointList.innerHTML = htmlContent;

// Call the initPagination function here
    initPagination(filteredChargePoints);
}

function updateMapView(filteredChargePoints, map) {
// Remove existing markers
    window.mapMarkers.forEach(marker => marker.remove());
    window.mapMarkers = [];

    // Add new markers
    filteredChargePoints.forEach(cp => {
        const marker = L.marker([cp.lat, cp.lng]).addTo(map);
        marker.bindPopup(`<strong>${cp.name}</strong><br>${cp.address}`);
        window.mapMarkers.push(marker);
        marker.on('click', () => {
            selectedChargePointId = cp.id;
            document.getElementById('requestBtn').disabled = false;
        });
    });
}









