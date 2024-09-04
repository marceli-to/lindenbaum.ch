// Define a function to load the Mapbox script
function loadMapboxScript() {
  var script = document.createElement('script');
  script.src = 'https://api.mapbox.com/mapbox-gl-js/v2.0.0/mapbox-gl.js';
  script.onload = init;
  document.head.appendChild(script);
}

function init() {
  initializeMap({
    lat: 47.37405208471287,
    lng: 8.783222939825347,
    container: 'map-pfaeffikon',
  });
  initializeMap({
    lat: 47.15661299903208,
    lng: 8.512031691063648,
    container: 'map-zug',
  });
  initializeMap({
    lat: 46.59826143456267,
    lng: 9.956350727195257,
    container: 'map-zuoz',
  });
  initializeMap({
    lat: 46.45579917873923, 
    lng: 6.870650455132087,
    container: 'map-tour-de-peilz',
  });
}

// Define a function to initialize the map
function initializeMap(params) {
  mapboxgl.accessToken = 'pk.eyJ1IjoibWFyY2VsaXRvb29vIiwiYSI6ImNrMHNsdmhwdjAzcjIzZ3BldTlqdWhnaWEifQ.EWZE383Tn4xBt0E5pSXh6Q';
  var map = new mapboxgl.Map({
      container: params.container,
      style: 'mapbox://styles/marcelitoooo/ck16ms7m51nlo1cmwnqrbjuyq',
      center: [params.lng, params.lat],
      zoom: 14
  });
  map.addControl(new mapboxgl.NavigationControl());
  map.scrollZoom.disable();
  
  var geojson = {
    type: 'FeatureCollection',
    features: [{
      type: 'Feature',
      geometry: {
        type: 'Point',
        coordinates: [params.lng, params.lat],
      },
      properties: {
        title: 'Martin Weiss Treuhand AG',
        description: 'Martin Weiss Treuhand AG'
      }
    }]
  };
  
  // add markers to map
  geojson.features.forEach(function(marker) {
  
  // create a HTML element for each feature
  var el = document.createElement('div');
  el.className = 'marker';
  
  // make a marker for each feature and add to the map
  new mapboxgl.Marker(el)
    .setLngLat(marker.geometry.coordinates)
    .addTo(map);
  });
}

function scrollEventHandler() {
  if (window.pageYOffset > 500) {
    loadMapboxScript();
    window.removeEventListener('scroll', scrollEventHandler);
  }
}

window.addEventListener('scroll', scrollEventHandler);