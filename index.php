<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Ввычисление плитки на карте по координатам</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>

<div class="container p-5">
  <div class="row">
    <div class="col-3">
    	 <input type="text" id="coordx" class="form-control" placeholder="Координата X" aria-label="Координата X">
    	 <div id="coordxFeedback" class="invalid-feedback">
        	Необходимо ввести координату Х
      	</div>
    </div>
    <div class="col-3">
      <input type="text" id="coordy" class="form-control" placeholder="Координата Y" aria-label="Координата Y">
      <div id="coordyFeedback" class="invalid-feedback">
        Необходимо ввести координату Y
      </div>
    </div>
    <div class="col-3">
      <input type="text" id="coordz" class="form-control" placeholder="Масштаб" aria-label="Масштаб">
      <div id="coordzFeedback" class="invalid-feedback">
        Необходимо ввести масштаб
      </div>
    </div>
    <div class="col-3">
      <button type="button" class="btn btn-outline-primary" onclick="coord()">Вычислить</button>
    </div>
  </div>
</div>
<div class="container text-center" id="result">
	
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script type="text/javascript">

function coord(){
	// Доступные проекции и соответствующие значения эксцентриситетов.
/*	if (!isNaN(Number(document.getElementById('coordz').value))) {
		let coordz = Number(document.getElementById('coordz').value);
		document.getElementById('coordz').classList.remove('is-invalid');
	} else {
		document.getElementById('coordz').classList.add('is-invalid');
	}

	if (!isNaN(Number(document.getElementById('coordx').value))) {
		let coordx = Number(document.getElementById('coordx').value);
		document.getElementById('coordx').classList.remove('is-invalid');
	} else {
		document.getElementById('coordx').classList.add('is-invalid');
	}

	if (!isNaN(Number(document.getElementById('coordy').value))) {
		let coordy = Number(document.getElementById('coordy').value);
		document.getElementById('coordy').classList.remove('is-invalid');
	} else {
		document.getElementById('coordy').classList.add('is-invalid');
	}*/

let coordz = Number(document.getElementById('coordz').value);
let coordx = Number(document.getElementById('coordx').value);
let coordy = Number(document.getElementById('coordy').value);

if (!isNaN(coordz)) {
		document.getElementById('coordz').classList.remove('is-invalid');
	} else {
		document.getElementById('coordz').classList.add('is-invalid');
	}

	if (!isNaN(coordx)) {
		document.getElementById('coordx').classList.remove('is-invalid');
	} else {
		document.getElementById('coordx').classList.add('is-invalid');
	}

	if (!isNaN(coordy)) {
		document.getElementById('coordy').classList.remove('is-invalid');
	} else {
		document.getElementById('coordy').classList.add('is-invalid');
	}

var projections = [{
name: 'wgs84Mercator',
eccentricity: 0.0818191908426
}, {
name: 'sphericalMercator',
eccentricity: 0
}], 

// Для вычисления номера нужного тайла следует задать параметры:
// - уровень масштабирования карты;
// - географические х объекта, попадающего в тайл;
// - проекцию, для которой нужно получить тайл. 
params = {
z: coordz,
geoCoords: [coordx, coordy],
projection: projections[0]
};

// Функция для перевода географических координат объекта 
// в глобальные пиксельные координаты. 
function fromGeoToPixels (lat, long, projection, z) {
var x_p, y_p,
pixelCoords,
tilenumber = [],
rho,
pi = Math.PI,
beta, 
phi,
theta,
e = projection.eccentricity;

rho = Math.pow(2, z + 8) / 2;
beta = lat * pi / 180;
phi = (1 - e * Math.sin(beta)) / (1 + e * Math.sin(beta));
theta = Math.tan(pi / 4 + beta / 2) * Math.pow(phi, e / 2);

x_p = rho * (1 + long / 180);
y_p = rho * (1 - Math.log(theta) / pi);

return [x_p, y_p];
}

// Функция для расчета номера тайла на основе глобальных пиксельных координат.
function fromPixelsToTileNumber (x, y) {
return [
Math.floor(x / 256),
Math.floor(y / 256)
];
}

// Переведем географические координаты объекта в глобальные пиксельные координаты.
pixelCoords = fromGeoToPixels(
params.geoCoords[0],
params.geoCoords[1],
params.projection,
params.z
);

// Посчитаем номер тайла на основе пиксельных координат.
tileNumber = fromPixelsToTileNumber(pixelCoords[0], pixelCoords[1]);

// Отобразим результат.

document.getElementById("result").innerHTML = "<img src='https://core-carparks-renderer-lots.maps.yandex.net/maps-rdr-carparks/tiles?l=carparks&x="+ tileNumber[0] +"&y="+ tileNumber[1] +"&z="+ params.z +"&scale=1&lang=ru_RU' class='img-fluid' alt='...''>";
}
</script>
</body>
</html>