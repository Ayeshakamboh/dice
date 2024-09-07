<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dice Roll Game</title>
    <style>
        body {
            text-align: center;
            font-family: Arial, sans-serif;
            background-color: lightblue;
        }
        h1 {
            background-color: grey;
            color: grey;
        }
        img {
            width: 100px;
            cursor: pointer;
        }
        p {
            margin: 10px 0;
        }
        #currentRoll {
            color: red;
        }
        #total {
            color: green;
            margin-top: 20px;
            font-size: 20px;
        }
        #rollHistory {
            color: orange;
            margin-top: 20px;
            font-size: 18px;
            list-style-type: none;
            padding: 0;
        }
        #rollHistory li {
            display: flex;
            align-items: top;
            margin-bottom: 10px;
        }
        #rollHistory img {
            width: 50px;
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <h1 style="background-color: crimson; color:white">Roll the Dice!</h1>

    <?php
    session_start();

    // Initialize total and history if not already set
    if (!isset($_SESSION['totalRoll'])) {
        $_SESSION['totalRoll'] = 0;
    }
    if (!isset($_SESSION['rollHistory'])) {
        $_SESSION['rollHistory'] = [];
    }

    // Dice images
    $diceImages = [
        '../dice/1.jfif',
        '../dice/2.png',
        '../dice/3.png',
        '../dice/4.png',
        '../dice/5.jfif',
        '../dice/6.png'
    ];

    // Roll the dice when form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $randomIndex = rand(0, 5); // Random number between 0 and 5
        $currentRoll = $randomIndex + 1; // Dice roll (1 to 6)
        $_SESSION['totalRoll'] += $currentRoll;

        // Store roll history
        $_SESSION['rollHistory'][] = [
            'roll' => $currentRoll,
            'image' => $diceImages[$randomIndex]
        ];
    }
    ?>

    <!-- Image tag to display the dice -->
    <form method="post">
        <img id="diceImage" src="<?php echo isset($randomIndex) ? $diceImages[$randomIndex] : '../dice/1.jfif'; ?>" alt="Dice" onclick="this.closest('form').submit();">
    </form>

    <p style="background-color: orange; color:green">Current Roll: 
        <span id="currentRoll"><?php echo isset($currentRoll) ? $currentRoll : 0; ?></span>
    </p>
    <p style="background-color: yellow; color:red">Total of Rolls: 
        <span id="total"><?php echo $_SESSION['totalRoll']; ?></span>
    </p>
    <p style="background-color: green; color:pink">Roll History:</p>
    <ul id="rollHistory">
        <?php
        foreach ($_SESSION['rollHistory'] as $entry) {
            echo "<li><img src='{$entry['image']}' alt='Dice'><span>Roll: {$entry['roll']}</span></li>";
        }
        ?>
    </ul>

    <?php
    // Optionally reset the game if needed (e.g., after reaching a certain total)
    if (isset($_POST['reset'])) {
        $_SESSION['totalRoll'] = 0;
        $_SESSION['rollHistory'] = [];
    }
    ?>
    
    <form method="post">
        <button type="submit" name="reset">Reset Game</button>
    </form>

</body>
</html>
