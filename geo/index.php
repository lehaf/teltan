
<script src="https://api.mapbox.com/mapbox-gl-js/v2.8.2/mapbox-gl.js"></script> <style>
body { margin: 0; padding: 0; }
#map { position: absolute; top: 0; bottom: 0; width: 100%;  height: 100%}
</style> <script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.0/mapbox-gl-geocoder.min.js"></script> <style>
#geocoder-container > div {
min-width: 50%;
margin-left: 25%;
}
</style>
<div id="map" bis_size="{&quot;x&quot;:18,&quot;y&quot;:58,&quot;w&quot;:349,&quot;h&quot;:0,&quot;abs_x&quot;:70,&quot;abs_y&quot;:207}">
</div>
<script>
	mapboxgl.accessToken = 'pk.eyJ1Ijoicm9vdHRlc3QxMjMiLCJhIjoiY2w0ZHppeGJzMDczZDNndGc2eWR0M2R5aSJ9.wz6xj8AGc7s6Ivd09tOZrA';
const map = new mapboxgl.Map({
container: 'map',
style: 'mapbox://styles/mapbox/streets-v11',
center: [-79.4512, 43.6568],
zoom: 13
});
 
const geocoder = new MapboxGeocoder({
accessToken: mapboxgl.accessToken,
marker: {
color: 'orange'
},
mapboxgl: mapboxgl
});
 
map.addControl(geocoder);
