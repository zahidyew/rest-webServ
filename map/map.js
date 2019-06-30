// the ArrayList passed by the app will be kept/passed as a long String, so split the String by comma.
function loadMap(latitude, longitude, itemName, placeName) {
   let lat = new Array();
   let longi = new Array();
   let item = new Array();
   let place = new Array();

   // remove the brackets 1st, then split the String
   lat = latitude.replace(/[\[\]]+/g, '').split(",");
   longi = longitude.replace(/[\[\]]+/g, '').split(",");
   item = itemName.replace(/[\[\]]+/g, '').split(",");
   place = placeName.replace(/[\[\]]+/g, '').split(",");
   let arraySize = item.length;

   //document.getElementById('map').innerHTML = lat[1];

   var map = L.map('map').fitWorld().setView([lat[0], longi[0]], 11);
   L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
      maxZoom: 16,
      id: 'mapbox.streets'
   }).addTo(map);

   //map.locate({ setView: true, maxZoom: 16 });

   // for each Item, place a Marker on the Map
   for (let i = 0; i < arraySize; i++) {
      var marker = L.marker([lat[i], longi[i]]).addTo(map);
      marker.bindPopup("" + item[i] + ", " + place[i]);//.openPopup(); 
   }
}   