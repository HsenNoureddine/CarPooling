let x, y;
let destMarker;

getLocation();

function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } else {
        alert("Geolocation is not supported by this browser.");
    }
}

function showPosition(position) {
    //current location
    x = position.coords.latitude;
    y = position.coords.longitude;
    loadMap();
}

function loadMap() {
    var map = L.map('map').setView([x, y], 13);

    let latitude = document.getElementsByName("lat")[0];
    let longitude = document.getElementsByName("lng")[0];

    latitude.value = x;
    longitude.value = y;

    let destlat = document.getElementsByName("destlat")[0];
    let destlng = document.getElementsByName("destlng")[0];

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

    var marker = L.marker([x, y]).addTo(map);

    function onMapClick(e) {
        if (destMarker) map.removeLayer(destMarker);
        destMarker = L.marker([e.latlng.lat, e.latlng.lng]).addTo(map);

        destlat.value = e.latlng.lat;
        destlng.value = e.latlng.lng;

        //distance in km
        let dist = marker.getLatLng().distanceTo(destMarker.getLatLng()).toFixed(0) / 1000;
    }
    map.on('click', onMapClick);

    let markdestlat = 0;
    let markdestlng = 0;

    let str = document.cookie;
    str = str.split(";");
    str.forEach((v, k) => {
        v = v.split("=");
        if (v[0].includes("driver")) {
            let driver = v[1].split(".-.");
            console.log(driver[1], driver[2]);
            let driverMarker = L.marker([driver[1], driver[2]]).addTo(map);
            driverMarker.bindPopup("<b>" + driver[0] + "</b>").openPopup();
        } else if (v[0].includes("destlat")) markdestlat = v[1];
        else if (v[0].includes("destlng")) markdestlng = v[1];
    });

    //mark chosen destination
    if (markdestlat || markdestlng) {
        let chosenMarker = L.marker([markdestlat, markdestlng]).addTo(map);
        chosenMarker.bindPopup("<b> destination </b>").openPopup();
    }

}



// var polygon = L.polygon([
//     [51.509, -0.08],
//     [51.503, -0.06],
//     [51.51, -0.047]
// ]).addTo(map);