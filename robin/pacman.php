<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jeu de Cibles</title>
    <style>
        body {
            margin: 0;
            overflow: hidden;
            background-color: #f0f0f0;
        }
        #game {
            width: 100%;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: Arial, sans-serif;
            font-size: 24px;
            color: #333;
            position: relative;
        }
        .target {
            position: absolute;
            width: 50px;
            height: 50px;
            background-color: red;
            border-radius: 50%;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div id="game"></div>

    <script>
        const gameDiv = document.getElementById('game');
        let score = 0;
        let timer;
        let gameRunning = true;
        let timeLeft = 30;

        function createTarget() {
            const target = document.createElement('div');
            target.classList.add('target');
            target.style.left = Math.random() * (window.innerWidth - 50) + 'px';
            target.style.top = Math.random() * (window.innerHeight - 50) + 'px';
            target.addEventListener('click', hitTarget);
            gameDiv.appendChild(target);
        }

        function hitTarget(event) {
            event.target.remove();
            score++;
            updateScore();
        }

        function updateScore() {
            gameDiv.innerHTML = 'Score: ' + score + ' Temps restant: ' + timeLeft;
        }

        function gameOver() {
            gameRunning = false;
            clearInterval(timer);
            gameDiv.innerHTML = 'Game Over! Votre score est de ' + score + '. Cliquez pour recommencer.';
            gameDiv.addEventListener('click', startGame);
        }

        function startGame() {
            if (!gameRunning) {
                gameDiv.innerHTML = '';
                score = 0;
                timeLeft = 30;
                gameRunning = true;
                gameDiv.removeEventListener('click', startGame);
                timer = setInterval(function() {
                    if (timeLeft > 0) {
                        timeLeft--;
                        updateScore(); // Mettre à jour le score et le temps
                    } else {
                        gameOver();
                    }
                }, 1000);
                setInterval(createTarget, 1000);
            }
        }

        startGame();
    </script>
</body>
</html>
