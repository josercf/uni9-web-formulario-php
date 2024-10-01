<?php
// Simulando a resposta do endpoint com o JSON de previsão do tempo
$weather_data = '{
    "previsao": [
        {
            "dia": "2024-09-17",
            "horas": [
                {"hora": "00:00", "temperatura": 22, "condicao": "Ensolarado", "umidade": 60},
                {"hora": "01:00", "temperatura": 21, "condicao": "Ensolarado", "umidade": 62},
                {"hora": "02:00", "temperatura": 20, "condicao": "Nublado", "umidade": 65}
            ]
        },
        {
            "dia": "2024-09-18",
            "horas": [
                {"hora": "00:00", "temperatura": 24, "condicao": "Nublado", "umidade": 70},
                {"hora": "01:00", "temperatura": 23, "condicao": "Chuva Leve", "umidade": 75},
                {"hora": "02:00", "temperatura": 22, "condicao": "Chuva", "umidade": 78}
            ]
        }
    ]
}';

// Convertendo JSON em um array PHP
$data = json_decode($weather_data, true);

// Função para retornar o ícone apropriado de acordo com a condição do tempo
function getWeatherIcon($condicao) {
    switch ($condicao) {
        case 'Ensolarado':
            return 'https://img.icons8.com/emoji/48/000000/sun-emoji.png';
        case 'Nublado':
            return 'https://img.icons8.com/emoji/48/000000/cloud-emoji.png';
        case 'Chuva Leve':
            return 'https://img.icons8.com/emoji/48/000000/cloud-with-rain-emoji.png';
        case 'Chuva':
            return 'https://img.icons8.com/emoji/48/000000/cloud-with-heavy-showers.png';
        default:
            return 'https://img.icons8.com/emoji/48/000000/question-mark.png';
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Previsão do Tempo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f4f9;
        }
        .weather-card {
            border-radius: 10px;
            background-color: #fff;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 20px;
            margin: 10px;
            text-align: center;
        }
        .hour-details {
            margin-top: 10px;
            text-align: left;
        }
        .selected-day {
            background-color: #f0f8ff;
        }
        .day-list {
            display: flex;
            flex-direction: row;
            overflow-x: hidden;
            padding: 10px;
        }
        .card-header {
            font-weight: bold;
        }
        .weather-icon {
            width: 40px;
            height: 40px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row">
        <!-- Parte 1: Cards de Previsão Diária -->
        <div class="col-md-12">
            <h4>Previsão Diária</h4>
            <div class="day-list">
                <?php foreach ($data['previsao'] as $index => $dia) { ?>
                    <div class="weather-card" onclick="showDetails(<?php echo $index; ?>)">
                        <div class="card-header">
                            <?php echo $dia['dia']; ?>
                        </div>
                        <div class="card-body">
                            <img src="<?php echo getWeatherIcon($dia['horas'][0]['condicao']); ?>" alt="ícone clima" class="weather-icon">
                            <p>Temp: <?php echo $dia['horas'][0]['temperatura']; ?>°C</p>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>

        <!-- Parte 2: Detalhes Hora a Hora -->
        <div class="col-md-12 mt-4">
            <h4>Previsão Hora a Hora</h4>
            <div id="hourly-details" class="hour-details">
                <!-- Aqui os detalhes do dia selecionado serão renderizados -->
            </div>
        </div>
    </div>
</div>

<script>
// JavaScript para renderizar a previsão hora a hora com base no dia selecionado
const weatherData = <?php echo json_encode($data['previsao']); ?>;

function showDetails(dayIndex) {
    const dayData = weatherData[dayIndex];
    let detailsHtml = `<h5>Previsão para ${dayData.dia}</h5><ul class="list-group">`;

    dayData.horas.forEach(hour => {
        detailsHtml += `
            <li class="list-group-item">
                <img src="${getWeatherIcon(hour.condicao)}" alt="ícone clima" class="weather-icon">
                <strong>${hour.hora}:</strong> ${hour.temperatura}°C, ${hour.condicao}, Umidade: ${hour.umidade}%
            </li>
        `;
    });

    detailsHtml += '</ul>';
    document.getElementById('hourly-details').innerHTML = detailsHtml;

    // Remover a classe de seleção de todos os dias e adicionar ao dia atual
    document.querySelectorAll('.weather-card').forEach(card => {
        card.classList.remove('selected-day');
    });
    document.querySelectorAll('.weather-card')[dayIndex].classList.add('selected-day');
}

function getWeatherIcon(condicao) {
    switch (condicao) {
        case 'Ensolarado':
            return 'https://img.icons8.com/emoji/48/000000/sun-emoji.png';
        case 'Nublado':
            return 'https://img.icons8.com/emoji/48/000000/cloud-emoji.png';
        case 'Chuva Leve':
            return 'https://img.icons8.com/emoji/48/000000/cloud-with-rain-emoji.png';
        case 'Chuva':
            return 'https://img.icons8.com/emoji/48/000000/cloud-with-heavy-showers.png';
        default:
            return 'https://img.icons8.com/emoji/48/000000/question-mark.png';
    }
}

</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
