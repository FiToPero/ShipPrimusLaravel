<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}"> 

        <title>ShipPrimus</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <script src="https://cdn.tailwindcss.com"></script>
     
    </head>
    <body class="w-full h-screen bg-gray-100 dark:bg-gray-900 dark:text-white">
     
    <div class="m-10 p-6 pb-12 lg:p-20 bg-white dark:bg-black dark:text-white rounded-xl">
        
        <div id="form" class="mb-6">
            <label for="username" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Username</label>
            <input type="text" id="username" placeholder="Username" value="testDemo" class="w-full m-3 p-2.5 border border-gray-300 rounded dark:bg-[#161615] dark:border-gray-600">

            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Password</label>
            <input type="password" id="password" placeholder="Password" value="1234" class="w-full m-3 p-2.5 border border-gray-300 rounded dark:bg-[#161615] dark:border-gray-600">

            <label for="freightInfo" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Freight Info</label>
            <textarea id="freightInfo" placeholder="freightInfo" class="w-full m-3 p-2.5 border border-gray-300 rounded dark:bg-[#161615] dark:border-gray-600 text-sm h-64">
                {
                    "originCity": "KEY LARGO",
                    "originState": "FL",
                    "originZipcode": "33037",
                    "originCountry": "US",
                    "destinationCity": "LOS ANGELES",
                    "destinationState": "CA",
                    "destinationZipcode": "90001",
                    "destinationCountry": "US",
                    "UOM": "US",
                    "freightInfo": [
                        {
                            "qty": 1,
                            "weight": 100,
                            "weightType": "each",
                            "length": 40,
                            "width": 40,
                            "height": 40,
                            "class": 100,
                            "hazmat": 0,
                            "commodity": "",
                            "dimType": "PLT",
                            "stack": false
                        }
                    ]
                }

            </textarea>

            <button id="search" class="w-full m-3 py-2.5 px-5 bg-[#1b1b18] text-white rounded cursor-pointer hover:bg-black dark:bg-gray-500 dark:text-black dark:hover:bg-gray-200">Search</button>
        </div>

        <h1>Token</h1>
        <pre id="get-token"></pre>
        <br><hr><br>
        <h1>Minimum Rates</h1>
        <pre id="get-rates-minimum"></pre>
        <br><hr><br>
        <h1>All Rates</h1>
        <pre id="get-rates"></pre>

    </div>
    </body>
    <script>
    document.getElementById('search').addEventListener('click', () => {

        const username = document.getElementById('username').value;
        const password = document.getElementById('password').value;
        const freightInfo = document.getElementById('freightInfo').value;

        const requestData = {
            username: username,
            password: password,
            params: JSON.parse(freightInfo) // Convertir el contenido del textarea a JSON
        };

        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');


        fetch('http://localhost:8080/get-token', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify(requestData)
        })
            .then(response => response.json())
            .then(data => {
                document.getElementById('get-token').textContent = JSON.stringify(data, null, 2);
            });
        
        fetch('http://localhost:8080/get-rates', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify(requestData)
        })
            .then(response => response.json())
            .then(data => {
                document.getElementById('get-rates').textContent = JSON.stringify(data, null, 2);
            });
       
        fetch('http://localhost:8080/get-rates-minimum', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify(requestData)
        })
            .then(response => response.json())
            .then(data => {
                document.getElementById('get-rates-minimum').textContent = JSON.stringify(data, null, 2);
            });
    });
    </script>
</html>
