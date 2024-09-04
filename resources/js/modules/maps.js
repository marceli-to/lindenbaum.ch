const initMap = () => {
  mapboxgl.accessToken = 'pk.eyJ1IjoibWFyY2VsaXRvb29vIiwiYSI6ImNrMHNsdmhwdjAzcjIzZ3BldTlqdWhnaWEifQ.EWZE383Tn4xBt0E5pSXh6Q';
  const mapEl = document.getElementById('map');
  const zoom = mapEl.dataset.zoom;

  // Parse locations from data attribute
  const locations = JSON.parse(mapEl.dataset.locations || '[]');

  var map = new mapboxgl.Map({
    container: 'map',
    style: 'mapbox://styles/marcelitoooo/ck16ms7m51nlo1cmwnqrbjuyq?optimize=true',
    center: locations[0]?.coordinates || [7.570396922242262, 47.55467439287263], 
    zoom: zoom
  });
  map.addControl(new mapboxgl.NavigationControl());
  map.scrollZoom.disable();

  var geojson = {
    type: 'FeatureCollection',
    features: locations.map(location => ({
      type: 'Feature',
      geometry: {
        type: 'Point',
        coordinates: location.coordinates
      },
      properties: {
        title: location.title,
        description: location.description,
        markerClass: location.markerClass
      }
    }))
  };

  // add markers to map
  geojson.features.forEach(function(marker) {
    // create a HTML element for each feature
    var el = document.createElement('div');
    el.className = 'marker-' + marker.properties.markerClass;

    // make a marker for each feature and add to the map
    new mapboxgl.Marker(el)
      .setLngLat(marker.geometry.coordinates)
      .setPopup(new mapboxgl.Popup({ offset: 25, className: "mapboxgl-popup--" + marker.properties.markerClass }) // add popups

     .setHTML('<h3>' + marker.properties.title + '</h3>'))
      .addTo(map);
  });

  // Fit map to show all markers
  if (locations.length > 1) {
    const bounds = new mapboxgl.LngLatBounds();
    locations.forEach(location => bounds.extend(location.coordinates));
    map.fitBounds(bounds, { padding: 50 });
  }
};

const loadMapScript = () => {
  var script = document.createElement('script');
  script.src = 'https://api.mapbox.com/mapbox-gl-js/v2.0.0/mapbox-gl.js';
  script.async = true;
  document.head.appendChild(script);

  script.onload = () => {
    const mapEl = document.getElementById('map');
    if (mapEl !== null) {
      initMap();
    }
  }
}

loadMapScript();