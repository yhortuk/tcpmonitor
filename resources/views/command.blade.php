<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Phillips Sigange Command</title>

        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">

        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
        </style>
    </head>
    <body class="antialiased">
        <div class="container">
            <div class="row">
                <div class="col-md-4 d-flex flex-column">
                    <label class="mt-1">Display IP:</label>
                    <input type="text" name="ip" id="ip" value="10.0.9.198"/>
                    <label class="mt-1">Port:</label>
                    <input type="text" name="port" id="port" value="5000"/>
                    <label class="mt-1">Commands (HEX format):</label>
                    <textarea class="mt-2" rows="10" id="commands">
09 01 00 ac 11 09 01 00 bd
09 01 00 ac 10 09 01 00 bc
09 01 00 ac 10 09 01 00 bc
09 01 00 ac 10 09 01 00 bc
09 01 00 ac 10 09 01 00 bc
09 01 00 ac 10 09 01 00 bc
09 01 00 ac 10 09 01 00 bc</textarea>
                    <a  class="btn btn-primary mt-3" onclick="sendCommands()">Send</a>
                </div>
                <div class="col-md-8 m-auto d-flex flex-column">
                    <pre id="results">
                    </pre>
                </div>
                <div class="col-12 mt-5">
                    Call as API:
                    <i>curl -i -X POST -H "Content-Type: application/json" http://localhost/api/v1/send -d '{"command": "09 01 00 ac 11 09 01 00 bd", "ip": "10.0.9.198", "port": "5000"}'</i>
                </div>
            </div>
        </div>
    <script>
        function sendCommands() {
            document.getElementById("results").innerHTML = '';
            document.getElementById("commands").textContent.split("\n").forEach(function (command) {
                let req = new XMLHttpRequest();
                req.open('POST', '{{ route('api.send') }}', false);
                req.setRequestHeader('Content-Type', 'application/json');
                req.onload = function() {
                    var result = `${command}: ${req.response}<br/>`
                    document.getElementById("results").innerHTML = document.getElementById("results").innerHTML + result;
                };
                req.send(JSON.stringify({
                    "command": command,
                    "ip": document.getElementById('ip').value,
                    "port": document.getElementById('port').value
                }));
            })
        }
    </script>
    </body>
</html>
