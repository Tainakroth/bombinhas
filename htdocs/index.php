<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>clima</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #4682b4;
            color: #333;
            margin: 0;
            padding: 0;
            text-align: center;
            background-image: url('nascerdosol.avif');
            background-size: cover; 
            background-repeat: no-repeat; 
            backdrop-filter: blur(1);
        }

        header {
            background-color: #1e90ff;
            color: white;
            padding: 20px;
        }

        header h1 {
            margin: 0;
            font-size: 24px;
        }

        table {
        margin: 30px auto;
        padding: 20px;
        width: 100%;
         max-width: 700px;
        background-color: rgba(255, 255, 255, 0.8); 
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        border-collapse: collapse;
        }


        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 20px;
            text-align: center;
        }

        th {
            background-color: #1e90ff; 
            color: white;
        }

        td {
            background-color: #f0f8ff; 
        }
        .clima-text {
        font-size: 27px;
        font-weight: bold; 
        margin-top: 15px; 
        font-family: 'Arial', sans-serif; 
        }

        .clima-container {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            margin: 20px;
        }

        .clima-item {
            margin: 10px;
            text-align: center;
        }

        .clima-item img {
            width: 110px;
            height: 110px;
        }

        @media (max-width: 600px) {
            table {
                width: 100%;
                padding: 10px;
            }

            h1 {
                font-size: 20px;
            }

            th, td {
                font-size: 16px;
                padding: 10px;
            }
            .image-rotate {
        transform: rotate(<?=$windAngle?>deg);
        }
    }
        
    </style>
</head>
<body>
    <?php
    $url = "http://apiadvisor.climatempo.com.br/api/v1/forecast/locale/5092/days/15?token=c4027c6323b5cca099fb015dfdeadd9e";
    $curl = curl_init();
    
    curl_setopt_array($curl, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true
    ]);
    
    $response = curl_exec($curl);
    curl_close($curl);
    
    $cidade = json_decode($response, true);
    $informacaoHoje = $cidade["data"][0];
    
    $nascerSol = new DateTime($informacaoHoje['sun']['sunrise']);
    $porSol = new DateTime($informacaoHoje['sun']['sunset']);
    
    $nascerSol->modify('-3 hours');
    $porSol->modify('-3 hours');
    
    $nascerSolAjustado = $nascerSol->format('H:i:s');  
    $porSolAjustado = $porSol->format('H:i:s');

    $dawnImg = $informacaoHoje["text_icon"]["icon"]["dawn"];
    $morningImg= $informacaoHoje["text_icon"]["icon"]["morning"];
    $afternoonImg= $informacaoHoje["text_icon"]["icon"]["afternoon"];
    $nigthImg= $informacaoHoje["text_icon"]["icon"]["night"];
    $dayImg= $informacaoHoje["text_icon"]["icon"]["day"];
    $windAngle= $informacaoHoje["wind"]["direction_degrees"];

    $directory = "imagens/.png";

    ?>
    <style>
        
        .image-rotate {
            width: 16px;
            height: 16px;
            transform: rotate(<?=$windAngle?>deg);
        }
    </style>

    </style>
    
    <header>
        <h1>Previsão para Hoje <?= $informacaoHoje["date_br"] ?> de <?= $cidade["name"] ?> - <?= $cidade["state"] ?></h1>
    </header>
    
    <table>
        <tr>
            <th>Condição do Tempo</th>
            <td><?= $informacaoHoje["text_icon"]["text"]["pt"]?></td>
        </tr>
        <tr>
            <th>Temperatura</th>
            <td><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-down" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M8 1a.5.5 0 0 1 .5.5v11.793l3.146-3.147a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 .708-.708L7.5 13.293V1.5A.5.5 0 0 1 8 1"/>
            </svg> <?= $informacaoHoje["temperature"]["min"] ?> Cº | <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-up" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M8 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L7.5 2.707V14.5a.5.5 0 0 0 .5.5" />
                </svg> <?= $informacaoHoje["temperature"]["max"] ?> Cº</td>
        </tr>
        <tr>
        <tr>
        <th style="text-align: center;">Chuva</th>
            <td style="text-align: center; vertical-align: middle; height: 50px;">
             <div style="display: flex; align-items: center; justify-content: center;">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-droplet-half" viewBox="0 0 16 16" style="margin-right: 5px;">
                <path fill-rule="evenodd" d="M7.21.8C7.69.295 8 0 8 0q.164.544.371 1.038c.812 1.946 2.073 3.35 3.197 4.6C12.878 7.096 14 8.345 14 10a6 6 0 0 1-12 0C2 6.668 5.58 2.517 7.21.8m.413 1.021A31 31 0 0 0 5.794 3.99c-.726.95-1.436 2.008-1.96 3.07C3.304 8.133 3 9.138 3 10c0 0 2.5 1.5 5 .5s5-.5 5-.5c0-1.201-.796-2.157-2.181-3.7l-.03-.032C9.75 5.11 8.5 3.72 7.623 1.82z"/>
                <path fill-rule="evenodd" d="M4.553 7.776c.82-1.641 1.717-2.753 2.093-3.13l.708.708c-.29.29-1.128 1.311-1.907 2.87z"/>
            </svg>
            <?= $informacaoHoje['rain']['precipitation'] ?> mm - <?= $informacaoHoje['rain']['probability'] ?>% de chance
        </div>
    </td>
</tr>
            <th>Vento</th>
            <td><img src="imagens/70px/seta.png" class="image-rotate"> <?= $informacaoHoje['wind']['direction'] ?> - <?= $informacaoHoje['wind']['velocity_avg'] ?> Km/h
            </td>
        </tr>
        <tr>
            <th>Umidade</th>
            <td><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-down" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M8 1a.5.5 0 0 1 .5.5v11.793l3.146-3.147a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 .708-.708L7.5 13.293V1.5A.5.5 0 0 1 8 1"/>
</svg> <?= $informacaoHoje['humidity']['min'] ?>% | <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-up" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M8 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L7.5 2.707V14.5a.5.5 0 0 0 .5.5"/>
                </svg> <?= $informacaoHoje['humidity']['max'] ?>%</td>
        </tr>
        <tr>
            <th>Sol</th>
            <td><?= $nascerSolAjustado?>h  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-sunrise" viewBox="0 0 16 16">
  <path d="M7.646 1.146a.5.5 0 0 1 .708 0l1.5 1.5a.5.5 0 0 1-.708.708L8.5 2.707V4.5a.5.5 0 0 1-1 0V2.707l-.646.647a.5.5 0 1 1-.708-.708zM2.343 4.343a.5.5 0 0 1 .707 0l1.414 1.414a.5.5 0 0 1-.707.707L2.343 5.05a.5.5 0 0 1 0-.707m11.314 0a.5.5 0 0 1 0 .707l-1.414 1.414a.5.5 0 1 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0M8 7a3 3 0 0 1 2.599 4.5H5.4A3 3 0 0 1 8 7m3.71 4.5a4 4 0 1 0-7.418 0H.499a.5.5 0 0 0 0 1h15a.5.5 0 0 0 0-1h-3.79zM0 10a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2A.5.5 0 0 1 0 10m13 0a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5"/>
</svg>    <?= $porSolAjustado ?>h</td>
        </tr>
    </table>
    <title>Previsão clima tempo</title>
    <div class="clima-container">
    <div class="clima-item">
        <img src="imagens/70px/<?=$dawnImg ?>.png">
        <p class="clima-text">Madrugada</p>
    </div>
    <div class="clima-item">
        <img src="imagens/70px/<?=$morningImg ?>.png">        
        <p class="clima-text">Manhã</p>
    </div>
    <div class="clima-item">
        <img src="imagens/70px/<?=$afternoonImg ?>.png">        
        <p class="clima-text">Tarde</p>
    </div>
    <div class="clima-item">
        <img src="imagens/70px/<?=$nigthImg ?>.png">
        <p class="clima-text">Noite</p>
    </div>
</div>
</body>
</html>