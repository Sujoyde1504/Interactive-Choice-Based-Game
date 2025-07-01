<?php
session_start();

// Initialize game variables if not set
if (!isset($_SESSION['game_started'])) {
    $_SESSION['game_started'] = false;
    $_SESSION['game_won'] = false;
    $_SESSION['game_lost'] = false;
    $_SESSION['start_time'] = null;
    $_SESSION['time_limit'] = 60; // 60 seconds time limit
    $_SESSION['maze'] = [
        ['#', '#', '#', '#', '#', '#', '#', '#', '#', '#'],
        ['#', 'P', ' ', '#', ' ', '#', ' ', ' ', ' ', '#'],
        ['#', '#', ' ', '#', ' ', '#', '#', '#', ' ', '#'],
        ['#', ' ', ' ', ' ', ' ', ' ', ' ', '#', ' ', '#'],
        ['#', ' ', '#', '#', '#', '#', ' ', '#', '#', '#'],
        ['#', ' ', '#', ' ', ' ', '#', ' ', ' ', ' ', '#'],
        ['#', ' ', '#', ' ', '#', '#', '#', '#', ' ', '#'],
        ['#', ' ', '#', ' ', ' ', ' ', ' ', '#', ' ', '#'],
        ['#', '#', '#', '#', '#', '#', ' ', '#', ' ', '#'],
        ['#', ' ', ' ', ' ', ' ', '#', ' ', 'E', ' ', '#'],

    ];


}

// Handle AJAX requests
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
    handleAjaxRequest();
    exit();
}

// Handle regular form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['start_game'])) {
        $_SESSION['game_started'] = true;
        $_SESSION['game_won'] = false;
        $_SESSION['game_lost'] = false;
        $_SESSION['start_time'] = time();
    } elseif (isset($_POST['retry'])) {
        $_SESSION['game_started'] = true;
        $_SESSION['game_won'] = false;
        $_SESSION['game_lost'] = false;
        $_SESSION['start_time'] = time();
        // Reset maze to initial state
    $_SESSION['maze'] = [
        ['#', '#', '#', '#', '#', '#', '#', '#', '#', '#'],
        ['#', 'P', ' ', '#', ' ', '#', ' ', ' ', ' ', '#'],
        ['#', '#', ' ', '#', ' ', '#', '#', '#', ' ', '#'],
        ['#', ' ', ' ', ' ', ' ', ' ', ' ', '#', ' ', '#'],
        ['#', ' ', '#', '#', '#', '#', ' ', '#', '#', '#'],
        ['#', ' ', '#', ' ', ' ', '#', ' ', ' ', ' ', '#'],
        ['#', ' ', '#', ' ', '#', '#', '#', '#', ' ', '#'],
        ['#', ' ', '#', ' ', ' ', ' ', ' ', '#', ' ', '#'],
        ['#', '#', '#', '#', '#', '#', ' ', '#', ' ', '#'],
        ['#', ' ', ' ', ' ', ' ', '#', ' ', 'E', ' ', '#'],

    ];


    }
}

function handleAjaxRequest() {
    if (!$_SESSION['game_started'] || $_SESSION['game_lost']) {
        echo json_encode(['status' => 'inactive']);
        return;
    }

    // Check if time has run out
    $elapsed = time() - $_SESSION['start_time'];
    if ($elapsed >= $_SESSION['time_limit']) {
        $_SESSION['game_lost'] = true;
        echo json_encode([
            'status' => 'lost',
            'html' => getGameOverHtml()
        ]);
        return;
    }

    // Handle movement
    if (isset($_POST['direction'])) {
        $direction = $_POST['direction'];
        $maze = $_SESSION['maze'];
        
        // Find player position
        $player_pos = [];
        foreach ($maze as $y => $row) {
            foreach ($row as $x => $cell) {
                if ($cell === 'P') {
                    $player_pos = ['x' => $x, 'y' => $y];
                    break 2;
                }
            }
        }
        
        // Calculate new position
        $new_x = $player_pos['x'];
        $new_y = $player_pos['y'];
        
        switch ($direction) {
            case 'up': $new_y--; break;
            case 'down': $new_y++; break;
            case 'left': $new_x--; break;
            case 'right': $new_x++; break;
        }
        
        // Check if new position is valid
        if ($new_x >= 0 && $new_x < count($maze[0]) && $new_y >= 0 && $new_y < count($maze)) {
            // Check if player reached the exit
            if ($maze[$new_y][$new_x] === 'E') {
                $_SESSION['game_won'] = true;
                // Update player position to show them on exit
                $maze[$player_pos['y']][$player_pos['x']] = ' ';
                $maze[$new_y][$new_x] = 'P';
                $_SESSION['maze'] = $maze;
                
                echo json_encode([
                    'status' => 'won',
                    'html' => getVictoryHtml(),
                    'maze' => $maze
                ]);
                return;
            }
            
            // Only move if the space is empty
            if ($maze[$new_y][$new_x] === ' ') {
                // Update player position
                $maze[$player_pos['y']][$player_pos['x']] = ' ';
                $maze[$new_y][$new_x] = 'P';
                $_SESSION['maze'] = $maze;
            }
        }
    }

    // Return updated game state
    echo json_encode([
        'status' => 'active',
        'timer' => max(0, $_SESSION['time_limit'] - (time() - $_SESSION['start_time'])),
        'maze' => $_SESSION['maze']
    ]);
}

function getVictoryHtml() {
    return '
        <div class="message win">
            Victory! You\'ve escaped the maze, Your Highness!
            <div class="redirect-message">Redirecting to the next scene in 3 seconds...</div>
        </div>
    ';
}

function getGameOverHtml() {
    return '
        <div class="message lose">
            Alas! Time has run out, Your Highness. The enemy has captured you!
        </div>
        <form method="post">
            <button type="submit" name="retry">Try Again</button>
        </form>
    ';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prince's Maze Escape</title>
    <style>
        body {
            font-family: 'Times New Roman', serif;
            background-color: #1a1a2e;
            color: #f8f8f8;
            text-align: center;
            background-image: url('https://example.com/royal-pattern.jpg');
            background-size: cover;
            margin: 0;
            padding: 20px;
        }
        
        .game-container {
            max-width: 800px;
            margin: 0 auto;
            background-color: rgba(40, 40, 70, 0.9);
            border: 3px solid #d4af37;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 20px rgba(212, 175, 55, 0.5);
        }
        
        h1 {
            color: #d4af37;
            text-shadow: 2px 2px 4px #000;
            font-size: 2.5em;
            margin-bottom: 20px;
        }
        
        .rulebook {
            background-color: rgba(20, 20, 40, 0.9);
            border: 2px solid #d4af37;
            padding: 15px;
            margin-bottom: 20px;
            text-align: left;
            border-radius: 5px;
        }
        
        .rulebook h2 {
            color: #d4af37;
            border-bottom: 1px solid #d4af37;
            padding-bottom: 5px;
        }
        
        .rulebook ul {
            padding-left: 20px;
        }
        
        .maze {
            display: inline-block;
            margin: 20px 0;
            background-color: #2a2a4a;
            padding: 10px;
            border: 2px solid #d4af37;
        }
        
        .row {
            display: flex;
        }
        
        .cell {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            font-weight: bold;
        }
        
        .wall {
            background-color: #3a3a5a;
            color: #aaa;
        }
        
        .player {
            color: #ff0;
            background-color: #4a4a7a;
        }
        
        .exit {
            color: #0f0;
            background-color: #4a4a7a;
            animation: glow 1s infinite alternate;
        }
        
        @keyframes glow {
            from { box-shadow: 0 0 5px #0f0; }
            to { box-shadow: 0 0 15px #0f0; }
        }
        
        .controls {
            margin: 20px 0;
        }
        
        button {
            background-color: #d4af37;
            color: #1a1a2e;
            border: none;
            padding: 10px 20px;
            margin: 5px;
            font-size: 16px;
            font-weight: bold;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        button:hover {
            background-color: #f8f8f8;
            transform: scale(1.05);
        }
        
        .timer {
            font-size: 24px;
            color: #d4af37;
            margin: 10px 0;
        }
        
        .message {
            font-size: 24px;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
        }
        
        .win {
            background-color: rgba(0, 255, 0, 0.2);
            color: #0f0;
            border: 2px solid #0f0;
        }
        
        .lose {
            background-color: rgba(255, 0, 0, 0.2);
            color: #f00;
            border: 2px solid #f00;
        }
        
        .redirect-message {
            font-size: 16px;
            margin-top: 10px;
            font-style: italic;
        }
        
        .hidden {
            display: none;
        }
        
        .instructions {
            margin-top: 20px;
            font-style: italic;
            color: #d4af37;
        }
    </style>
</head>
<body>
    <div class="game-container">
        <h1>Prince's Maze Escape</h1>
        
        <?php if (!$_SESSION['game_started']): ?>
            <div class="rulebook">
                <h2>The Royal Decree</h2>
                <p>Your Highness, the kingdom needs your help! Navigate through the treacherous maze to escape the enemy's castle before time runs out.</p>
                
                <h2>Rules of the Challenge:</h2>
                <ul>
                    <li>Use the arrow keys to move the Prince (P) through the maze</li>
                    <li>Avoid the walls (gray blocks)</li>
                    <li>Reach the exit (E) before time runs out</li>
                    <li>You have <?php echo $_SESSION['time_limit']; ?> seconds to complete your escape</li>
                    <li>If you fail, you may try again</li>
                    <li>Success will automatically take you to the next scene</li>
                </ul>
                
                <form method="post">
                    <button type="submit" name="start_game">Accept the Challenge</button>
                </form>
            </div>
        <?php else: ?>
            <div class="timer" id="timer">
                Time remaining: <?php 
                    if ($_SESSION['game_won'] || $_SESSION['game_lost']) {
                        echo "0";
                    } else {
                        $remaining = $_SESSION['time_limit'] - (time() - $_SESSION['start_time']);
                        echo max(0, $remaining);
                    }
                ?> seconds
            </div>
            
            <div class="maze" id="maze">
                <?php foreach ($_SESSION['maze'] as $row): ?>
                    <div class="row">
                        <?php foreach ($row as $cell): ?>
                            <div class="cell <?php 
                                echo $cell === '#' ? 'wall' : '';
                                echo $cell === 'P' ? 'player' : '';
                                echo $cell === 'E' ? 'exit' : '';
                            ?>">
                                <?php echo $cell; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <div class="instructions">
                Use arrow keys to move the Prince
            </div>
            
            <?php if ($_SESSION['game_won']): ?>
                <div class="message win">
                    Victory! You've escaped the maze, Your Highness!
                    <div class="redirect-message">Redirecting to the next scene in 3 seconds...</div>
                </div>
                <script>
                    setTimeout(function() {
                        window.location.href = 'scene6.php';
                    }, 3000);
                </script>
            <?php elseif ($_SESSION['game_lost']): ?>
                <div class="message lose">
                    Alas! Time has run out, Your Highness. The enemy has captured you!
                </div>
                <form method="post">
                    <button type="submit" name="retry">Try Again</button>
                </form>
            <?php endif; ?>
        <?php endif; ?>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle arrow key presses
            document.addEventListener('keydown', function(e) {
                if (!<?php echo $_SESSION['game_started'] ? 'true' : 'false'; ?> || 
                    <?php echo $_SESSION['game_won'] ? 'true' : 'false'; ?> || 
                    <?php echo $_SESSION['game_lost'] ? 'true' : 'false'; ?>) {
                    return;
                }

                let direction = null;
                switch(e.key) {
                    case 'ArrowUp': direction = 'up'; break;
                    case 'ArrowDown': direction = 'down'; break;
                    case 'ArrowLeft': direction = 'left'; break;
                    case 'ArrowRight': direction = 'right'; break;
                    default: return;
                }

                e.preventDefault();
                movePlayer(direction);
            });

            // Update timer every second
            <?php if ($_SESSION['game_started'] && !$_SESSION['game_won'] && !$_SESSION['game_lost']): ?>
                setInterval(updateTimer, 1000);
            <?php endif; ?>
        });

        function movePlayer(direction) {
            const formData = new FormData();
            formData.append('direction', direction);

            fetch(window.location.href, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'won') {
                    // Update maze display to show player on exit
                    document.getElementById('maze').innerHTML = renderMaze(data.maze);
                    // Show victory message
                    document.querySelector('.instructions').insertAdjacentHTML('afterend', data.html);
                    document.getElementById('timer').textContent = 'Time remaining: 0 seconds';
                    // Redirect after delay
                    setTimeout(function() {
                        window.location.href = 'scene6.php';
                    }, 3000);
                } else if (data.status === 'lost') {
                    document.querySelector('.instructions').insertAdjacentHTML('afterend', data.html);
                    document.getElementById('timer').textContent = 'Time remaining: 0 seconds';
                } else if (data.status === 'active') {
                    document.getElementById('maze').innerHTML = renderMaze(data.maze);
                    document.getElementById('timer').textContent = 'Time remaining: ' + data.timer + ' seconds';
                }
            });
        }

        function updateTimer() {
            const formData = new FormData();
            formData.append('check_timer', true);

            fetch(window.location.href, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'lost') {
                    document.querySelector('.instructions').insertAdjacentHTML('afterend', data.html);
                    document.getElementById('timer').textContent = 'Time remaining: 0 seconds';
                } else if (data.status === 'active') {
                    document.getElementById('timer').textContent = 'Time remaining: ' + data.timer + ' seconds';
                }
            });
        }

        function renderMaze(maze) {
            let html = '';
            maze.forEach(row => {
                html += '<div class="row">';
                row.forEach(cell => {
                    let cellClass = 'cell';
                    if (cell === '#') cellClass += ' wall';
                    if (cell === 'P') cellClass += ' player';
                    if (cell === 'E') cellClass += ' exit';
                    html += `<div class="${cellClass}">${cell}</div>`;
                });
                html += '</div>';
            });
            return html;
        }
    </script>
</body>
</html>