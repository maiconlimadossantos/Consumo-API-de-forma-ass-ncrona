<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clima Laravel 12</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-10">
    <div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold mb-4 text-center">Consulta de Temperatura</h2>

        <div class="space-y-3">
            <input type="text" id="city" placeholder="Cidade (ex: Camaqua)" class="w-full border p-2 rounded" placeholder="Cidade (ex: Camaqua)" >
            <input type="text" id="state" placeholder="Estado (ex: RS)" class="w-full border p-2 rounded" placeholder="Estado (ex:RS)">
            <input type="text" id="country" placeholder="País (ex: Brazil)" class="w-full border p-2 rounded" placeholder="País (ex: Brazil)">
            <button onclick="getCoordinates()" class="w-full bg-blue-500 text-white p-2 rounded hover:bg-blue-600">
                Ver Temperatura
            </button>
        </div>

        <div id="result" class="mt-6 hidden border-t pt-4">
            <p class="text-lg">Cidade: <span id="res_city" class="font-bold"></span></p>
            <p class="text-3xl font-bold text-blue-600 mt-2"><span id="res_temp"></span>°C</p>
            <p class="text-sm text-gray-500">Lat: <span id="res_lat"></span> | Lon: <span id="res_lon"></span></p>
        </div>
    </div>

    <script>
        function getCoordinates() {
            const city = document.getElementById('city').value;
            const state = document.getElementById('state').value;
            const country = document.getElementById('country').value;
            const apiKey = 'SUA_API_KEY_DO_API_NINJAS'; // Substitua pela sua chave

            const xhrGeo = new XMLHttpRequest();
            const urlGeo = `https://api.api-ninjas.com/v1/geocoding?city=${city}&state=${state}&country=${country}`;

            xhrGeo.open('GET', urlGeo, true);
            xhrGeo.setRequestHeader('X-Api-Key', apiKey);

            xhrGeo.onreadystatechange = function () {
                if (xhrGeo.readyState === 4 && xhrGeo.status === 200) {
                    const data = JSON.parse(xhrGeo.responseText);
                    if (data.length > 0) {
                        getWeather(data[0].latitude, data[0].longitude, data[0].name);
                    } else {
                        alert('Cidade não encontrada.');
                    }
                }
            };
            xhrGeo.send();
        }

        function getWeather(lat, lon, cityName) {
            const xhrWeather = new XMLHttpRequest();
            const urlWeather = `https://api.open-meteo.com/v1/forecast?latitude=${lat}&longitude=${lon}&current_weather=true`;

            xhrWeather.open('GET', urlWeather, true);
            xhrWeather.onreadystatechange = function () {
                if (xhrWeather.readyState === 4 && xhrWeather.status === 200) {
                    const data = JSON.parse(xhrWeather.responseText);
                    displayResult(cityName, data.current_weather.temperature, lat, lon);
                }
            };
            xhrWeather.send();
        }

        function displayResult(city, temp, lat, lon) {
            document.getElementById('result').classList.remove('hidden');
            document.getElementById('res_city').innerText = city;
            document.getElementById('res_temp').innerText = temp;
            document.getElementById('res_lat').innerText = lat.toFixed(2);
            document.getElementById('res_lon').innerText = lon.toFixed(2);
        }
    </script>
</body>
</html>