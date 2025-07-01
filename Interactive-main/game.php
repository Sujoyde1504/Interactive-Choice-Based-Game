<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Memory Game</title>
  <style>
    /* Same CSS as your original */
    body {
        background-color: #f4e1c1;
        font-family: 'Garamond', serif;
        color: #2d1e2f;
        text-align: center;
        background-image: url('parchment-texture.jpg');
        background-size: cover;
        background-repeat: no-repeat;
    }

    h1, p {
        font-family: 'Cursive', sans-serif;
    }

    .grid {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        grid-gap: 10px;
        max-width: 500px;
        margin: 20px auto;
        border: 2px solid #4c3a4b;
        padding: 10px;
        border-radius: 15px;
        background-color: rgba(255, 255, 255, 0.8);
    }

    .cell {
        width: 80px;
        height: 80px;
        border: 2px solid #4c3a4b;
        background-size: cover;
        background-position: center;
        cursor: pointer;
        border-radius: 10px;
        transition: transform 0.2s ease;
    }

    .cell:hover {
        transform: scale(1.1);
        box-shadow: 0 0 10px rgba(255, 255, 255, 0.5);
    }

    .hidden {
        background-color: #ccc;
    }

    #submit, #start-button {
        background-color: #7a4a72;
        color: white;
        font-size: 1.2em;
        padding: 12px 24px;
        border: none;
        cursor: pointer;
        border-radius: 5px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
    }

    #submit:hover, #start-button:hover {
        background-color: #9b5f85;
        box-shadow: 0 6px 8px rgba(0, 0, 0, 0.4);
    }

    #result, #round-info, #how-to-play {
        margin-top: 20px;
        font-size: 1.5em;
        color: #2d1e2f;
        font-family: 'Georgia', serif;
    }

    #how-to-play p {
        text-align: left;
        font-size: 1.2em;
        padding: 10px;
        background-color: rgba(255, 255, 255, 0.7);
        border-radius: 8px;
        border: 2px solid #4c3a4b;
    }

    #game-info {
        font-size: 1.2em;
        margin-top: 10px;
        font-family: 'Garamond', serif;
        color: #4c3a4b;
    }

    p {
        text-align: center;
        font-family: 'Cursive', sans-serif;
        font-size: 1.1em;
    }
  </style>
</head>
<body>
  <h1>Memory Game</h1>

  <div id="how-to-play" style="display: block;">
    <h2>How to Play</h2>
    <p>1. Coins will appear for a few seconds, remember their positions.</p>
    <p>2. Click on the cells to reveal what's hidden behind them.</p>
    <p>3. Try to match the coin positions to win.</p>
    <button id="start-button" onclick="startGame()">Start Game</button>
  </div>

  <div id="game-container" style="display: none;">
    <div id="round-info"></div>
    <div id="game-board" class="grid"></div>
    <button id="submit" onclick="checkSelection()">Submit</button>
    <p id="result"></p>
  </div>

  <script>
    const board = document.getElementById('game-board');
    const submitButton = document.getElementById('submit');
    const startButton = document.getElementById('start-button');
    const roundInfo = document.getElementById('round-info');
    const result = document.getElementById('result');
    let coinPositions = [];
    let selectedCells = [];
    let currentRound = 1;
    let totalRounds = 3;
    let coinsInRound = 3;

    const coinImg = 'coin.jpg';
    const goblinImg = 'goblin.jpg';

    function startGame() {
        document.getElementById('how-to-play').style.display = 'none';
        document.getElementById('game-container').style.display = 'block';
        initGame();
    }

    function initGame() {
        coinPositions = [];
        selectedCells = [];
        board.innerHTML = '';
        roundInfo.textContent = `Round ${currentRound}`;
        coinsInRound = currentRound === 1 ? 3 : (currentRound === 2 ? 5 : 7);

        for (let i = 0; i < 25; i++) {
            const cell = document.createElement('div');
            cell.classList.add('cell');
            cell.dataset.index = i;
            cell.addEventListener('click', handleCellClick);
            board.appendChild(cell);
        }

        while (coinPositions.length < coinsInRound) {
            const randIndex = Math.floor(Math.random() * 25);
            if (!coinPositions.includes(randIndex)) {
                coinPositions.push(randIndex);
            }
        }

        showImages();
        setTimeout(hideImages, 3000);
    }

    function showImages() {
        const cells = document.querySelectorAll('.cell');
        cells.forEach((cell, index) => {
            if (coinPositions.includes(index)) {
                cell.style.backgroundImage = `url(${coinImg})`;
            } else {
                cell.style.backgroundImage = `url(${goblinImg})`;
            }
        });
    }

    function hideImages() {
        const cells = document.querySelectorAll('.cell');
        cells.forEach(cell => {
            cell.classList.add('hidden');
            cell.style.backgroundImage = '';
        });
    }

    function handleCellClick(event) {
        const index = parseInt(event.target.dataset.index);
        if (!selectedCells.includes(index)) {
            selectedCells.push(index);
            event.target.classList.remove('hidden');
        } else {
            selectedCells = selectedCells.filter(i => i !== index);
            event.target.classList.add('hidden');
        }
    }

  function checkSelection() {
    selectedCells.sort((a, b) => a - b);
    coinPositions.sort((a, b) => a - b);

    if (JSON.stringify(selectedCells) === JSON.stringify(coinPositions)) {
        result.textContent = 'You win this round!';
        alert(`🎉 Round ${currentRound} Won!`);

        setTimeout(() => {
            if (currentRound < totalRounds) {
                currentRound++;
                initGame();
            } else {
                alert('🏆 Congratulations! All rounds completed!');
                window.location.href = 'scene3.1.php';
            }
        }, 1000);

    } else {
        result.textContent = 'You lose! Try again from Round 1.';
        alert(`❌ Wrong guess! Restarting from Round 1.`);
        currentRound = 1;

        setTimeout(initGame, 1000);
    }
}

  </script>
</body>
</html>
