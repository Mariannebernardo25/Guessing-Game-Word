<?php
// Semantic Game - Guess a Word

// List of words and corresponding questions for the game
$wordList = [
    "apple" => "What is a type of fruit that is typically red or green, and can be used in pies or eaten fresh off the tree?",
    "banana" => "What is a long, curved fruit with a yellow skin and soft, sweet flesh inside?",
    "orange" => "What is a citrus fruit that is typically orange in color and known for its juicy and tangy taste?",
    "grape" => "What small, round fruit is often found in clusters, and can be red, green, or purple in color?",
    "strawberry" => "What is a red, heart-shaped fruit that is often associated with desserts and is known for its sweetness?",
    "kiwi" => "What small, brown, and fuzzy fruit has bright green flesh and tiny black seeds on the inside?"
];

// Function to get a random word and its corresponding question from the list
function getRandomWordAndQuestion($wordList) {
    $index = array_rand($wordList);
    $word = $index;
    $question = $wordList[$index];
    return compact('word', 'question');
}

// Function to check the player's guess
function checkGuess($secretWord, $playerGuess) {
    // Convert both the secret word and player's guess to lowercase
    $secretWord = strtolower($secretWord);
    $playerGuess = strtolower($playerGuess);

    return ($secretWord === $playerGuess);
}

// Initialize variables
$randomWordData = getRandomWordAndQuestion($wordList);
$secretWord = $randomWordData['word'];
$question = $randomWordData['question'];
$attempts = 0;
$maxAttempts = 3;
$feedback = '';

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user input and trim whitespace
    $playerGuess = strtolower(trim($_POST["guess"]));

    // Validate input
    if (empty($playerGuess)) {
        $feedback = "Please enter a valid guess.";
    } else {
        // Check if the guess is correct
        if (checkGuess($secretWord, $playerGuess)) {
            $feedback = "Congratulations! You guessed the word correctly: $secretWord";
        } else {
            $attempts++;
            $feedback = "Incorrect guess. Try again! Question: $question";
        }
    }
}

// Display the correct word and question if the player couldn't guess in the allowed attempts
if ($attempts === $maxAttempts) {
    $feedback = "Sorry, you couldn't guess the word in $maxAttempts attempts. The correct word was: $secretWord. Question: $question";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Semantic Game - Guess a Word</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            max-width: 600px;
        }
        .jumbotron {
            background-color: #ffffff;
            padding: 30px;
            margin-top: 50px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .alert-info {
            background-color: #d1ecf1;
            color: #0c5460;
        }
    </style>
</head>
<body class="text-center">
    <div class="container">
        <div class="jumbotron">
            <h1 class="display-4">Guess a Word!</h1>
            <p class="lead">Try to guess the word based on semantic clues.</p>

            <?php if (!empty($feedback)) : ?>
                <div class="alert alert-info" role="alert">
                    <?php echo $feedback; ?>
                </div>
            <?php endif; ?>

            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="form-group">
                    <label for="guess">Your Guess:</label>
                    <input type="text" id="guess" name="guess" required class="form-control">
                </div>
                <button type="submit" class="btn btn-success btn-lg">Submit Guess</button>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
