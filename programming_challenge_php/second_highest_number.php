<?php
class HighestNumberFinder {
    public function nthHighestValue(array $numbers, int $n): int {
        // Validate each element to ensure it's an integer
        foreach ($numbers as $value) {
            if (!ctype_digit(strval($value))) {
                throw new Exception("Invalid input detected: All elements must be integers. Found: {$value}");
            }
        }

        // Convert all values to integers and remove duplicates
        $uniqueNumbers = array_unique(array_map('intval', $numbers));

        // Sort in descending order
        rsort($uniqueNumbers);

        // Check if nth element exists
        if (!isset($uniqueNumbers[$n - 1])) {
            throw new Exception("The list does not have {$n} unique elements.");
        }

        return $uniqueNumbers[$n - 1];
    }
}

$errorMessage = '';
$result = null;

// Setting the default value of n as 2, since we have to find the second-highest value in a list of integers
$defaultN = 2;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Get and sanitize input
        $numbersInput = $_POST['numbers'] ?? '';
        $nInput = $_POST['n'] ?? $defaultN; // Use default if not provided

        // Convert numbers to array
        $numbersArray = array_map('trim', explode(',', $numbersInput));

        // Validate `n` is numeric and positive
        if (!is_numeric($nInput) || (int)$nInput <= 0) {
            throw new Exception("Invalid value for 'n'. It must be a positive integer.");
        }

        // Instantiate the class and find the nth highest number
        $highestNumberFinder = new HighestNumberFinder();
        $result = $highestNumberFinder->nthHighestValue($numbersArray, (int)$nInput);
    } catch (Exception $e) {
        $errorMessage = $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Nth Highest Number Finder</title>
</head>
<body>
    <h1>Find the Nth Highest Number</h1>
    <form method="post">
        <label for="numbers">Enter numbers (comma-separated):</label><br>
        <input type="text" id="numbers" name="numbers" value="<?= htmlspecialchars($_POST['numbers'] ?? '') ?>" required><br><br>

        <label for="n">Enter n (positive integer):</label><br>
        <input type="number" id="n" name="n" min="1" value="<?= htmlspecialchars($_POST['n'] ?? $defaultN) ?>" required><br><br>

        <button type="submit">Submit</button>
    </form>

    <?php if ($errorMessage): ?>
        <p style="color: red;"><strong>Error:</strong> <?= htmlspecialchars($errorMessage) ?></p>
    <?php elseif ($result !== null): ?>
        <p style="color: green;">The <?= htmlspecialchars($_POST['n'] ?? $defaultN) ?>th highest number is: <strong><?= htmlspecialchars($result) ?></strong></p>
    <?php endif; ?>
</body>
</html>
