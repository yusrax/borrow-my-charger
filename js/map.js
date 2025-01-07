// Variable declarations
let mapInstance;
const maxDistKm = 50;
let selectedCPId = null;
let cpData = [];
let prevFilteredData = [];
window.onSearch = onSearch;
window.mapMarkersArray = [];

// Set charge point data
function setCPData(data) {
    cpData = data;
}

// Add charge point markers
function addCPMarkers(data) {
    console.log('cpData:', cpData);
    setCPData(data);
    if (mapInstance) {
        addToMap(data);
    }
}

// Add markers to map
function addToMap(filteredCPs) {
    if (!filteredCPs) {
        filteredCPs = cpData;
    }

    clearMarkers();
    const userLatLong = mapInstance.getCenter();

    filteredCPs.forEach(cp => {
        const marker = L.marker([cp.lat, cp.lng]).addTo(mapInstance);
        marker.bindPopup(`<strong>${cp.name}</strong><br>${cp.address}`);
        window.mapMarkersArray.push(marker);
        marker.on('click', () => {
            selectedCPId = cp.id;
            document.getElementById('requestBtn').disabled = false;
        });
    });

    if (cpData.length === 0) {
        const alertBox = document.createElement('div');
        alertBox.classList.add('alert', 'alert-warning', 'alert-dismissible', 'fade', 'show');
        alertBox.setAttribute('role', 'alert');
        alertBox.innerHTML = `<strong>No ChargePoints nearby!</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>`;
        document.getElementById('alertContainer').appendChild(alertBox);
    } else {
        mapInstance.invalidateSize();
    }
}

// Initialize map
function initMap(userLatLong) {
    if (!mapInstance) {
        mapInstance = L.map('map').setView(userLatLong, 16);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(mapInstance);
    }

    addToMap();

    liveSearch.onSearch(cpData, mapInstance);

    document.getElementById('searchInput').addEventListener('keydown', function (event) {
        if (event.key === 'Enter') {
            event.preventDefault();
            liveSearch.onSearch(cpData, mapInstance);
        }
    });
}

// Clear map markers
function clearMarkers() {
    window.mapMarkersArray.forEach(marker => marker.remove());
    window.mapMarkersArray = [];
}

// DOM content loaded event
document.addEventListener('DOMContentLoaded', function() {
    navigator.geolocation.getCurrentPosition(function(position) {
        const userLatLong = [position.coords.latitude, position.coords.longitude];
        initMap(userLatLong);
    }, function() {
        alert('Failed to get user location');
        initMap([51.505, -0.09]);
    });

    addCPMarkers(cpDataJson);
    initPagination(cpDataJson);
});

// Request button event listener
document.getElementById('requestBtn').addEventListener('click', function() {
    if (selectedCPId) {
        window.location.href = 'request.php?chargeid= ${selectedCPId}';
    }
});

// View toggle event listener
document.getElementById('viewToggle').addEventListener('change', function () {
    if (this.checked) {
        document.getElementById('listView').style.display = 'none';
        document.getElementById('mapView').style.display = 'block';
    } else {
        document.getElementById('listView').style.display = 'block';
        document.getElementById('mapView').style.display = 'none';
    }
});
















