<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Clima & CEP - Laravel 12</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-xl mx-auto bg-white p-8 rounded-xl shadow-md">
        <h1 class="text-2xl font-bold mb-6 text-blue-800">Previsão do Tempo</h1>

        <div class="mb-6 p-4 bg-blue-50 rounded-lg">
            <label class="block text-sm font-semibold mb-1">Buscar por CEP (Opcional):</label>
            <div class="flex gap-2">
                <input type="text" id="cep" placeholder="00000-000" class="border p-2 rounded w-full">
                <button onclick="buscarCEP()" class="bg-blue-600 text-white px-4 rounded hover:bg-blue-700">Buscar</button>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-4 mb-6">
            <input type="text" id="city" placeholder="Cidade" class="border p-2 rounded">
            <input type="text" id="state" placeholder="Estado (Ex: RS)" class="border p-2 rounded">
            <input type="text" id="country" placeholder="País (Ex: Brazil)" class="border p-2 rounded">
            <button onclick="obterCoordenadas()" class="bg-green-600 text-white p-3 rounded font-bold hover:bg-green-700">
                VER TEMPERATURA
            </button>
        </div>

        <div id="resultado" class="hidden border-t pt-6 text-center">
            <h2 id="res_nome" class="text-xl font-semibold"></h2>
            <div id="res_temp" class="text-5xl font-black text-orange-500 my-4">--°C</div>
            <p class="text-gray-500 text-sm">Lat: <span id="res_lat"></span> | Lon: <span id="res_lon"></span></p>
        </div>
    </div>

    <script>
        // API 1: VIA CEP (Preenche os campos)
        function buscarCEP() {
            const cep = document.getElementById('cep').value.replace(/\D/g, '');
            if (cep.length !== 8) return alert("CEP inválido");

            const xhr = new XMLHttpRequest();
            xhr.open('GET', `https://viacep.com.br/ws/${cep}/json/`, true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    const data = JSON.parse(xhr.responseText);
                    if (!data.erro) {
                        document.getElementById('city').value = data.localidade;
                        document.getElementById('state').value = data.uf;
                        document.getElementById('country').value = "Brazil";
                    }
                }
            };
            xhr.send();
        }

        // API 2: API NINJAS (Obtém Lat/Lon)
        function obterCoordenadas() {
            const city = document.getElementById('city').value;
            const state = document.getElementById('state').value;
            const country = document.getElementById('country').value;
            const apiKey = 'SUA_API_KEY_AQUI'; // Insira sua chave do api-ninjas.com

            const xhr = new XMLHttpRequest();
            const url = `https://api.api-ninjas.com/v1/geocoding?city=${city}&state=${state}&country=${country}`;

            xhr.open('GET', url, true);
            xhr.setRequestHeader('X-Api-Key', apiKey);

            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    const data = JSON.parse(xhr.responseText);
                    if (data.length > 0) {
                        const { latitude, longitude, name } = data[0];
                        obterTemperatura(latitude, longitude, name);
                    } else {
                        alert("Local não encontrado nas coordenadas.");
                    }
                }
            };
            xhr.send();
        }

        // API 3: OPEN METEO (Obtém Clima)
        function obterTemperatura(lat, lon, nome) {
            const xhr = new XMLHttpRequest();
            xhr.open('GET', `https://api.open-meteo.com/v1/forecast?latitude=${lat}&longitude=${lon}&current_weather=true`, true);

            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    const data = JSON.parse(xhr.responseText);
                    const temp = data.current_weather.temperature;

                    document.getElementById('resultado').classList.remove('hidden');
                    document.getElementById('res_nome').innerText = nome;
                    document.getElementById('res_temp').innerText = `${temp}°C`;
                    document.getElementById('res_lat').innerText = lat.toFixed(2);
                    document.getElementById('res_lon').innerText = lon.toFixed(2);
                }
            };
            xhr.send();
        }
    </script>
</body>
</html>