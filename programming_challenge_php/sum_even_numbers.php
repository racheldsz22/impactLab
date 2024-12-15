<?php
class SumEvenNumbers {
    // Function to calculate the sum of even numbers in an array
    public function sumEvenValues(array $numbers): int {
        $sum = 0;

        // Loop through the array and add even numbers
        foreach ($numbers as $number) {
            if ($number % 2 == 0) { // Check if the number is even
                $sum += $number;
            }
        }

        return $sum;
    }
}

$errorMessage = '';
$result = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Get user input (numbers)
        $numbersInput = $_POST['numbers'] ?? '';

        // Check if input is empty
        if (empty($numbersInput)) {
            throw new Exception("Input cannot be empty. Please enter a comma-separated list of numbers.");
        }

        // Convert the string to an array and trim any extra spaces
        $numbersArray = array_map('trim', explode(',', $numbersInput));

        // Validate if all elements in the array are integers
        foreach ($numbersArray as $value) {
            if (!is_numeric($value) || (int)$value != $value) {
                throw new Exception("All elements must be valid integers. Found: {$value}");
            }
        }

        // Convert the array elements to integers
        $numbersArray = array_map('intval', $numbersArray);

        // Instantiate the class and calculate the sum of even values
        $sumEvenNumbers = new SumEvenNumbers();
        $result = $sumEvenNumbers->sumEvenValues($numbersArray);

    } catch (Exception $e) {
        // Catch any errors and set the error message
        $errorMessage = $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sum of Even Numbers</title>
</head>
<body>
    <h1>Sum of Even Numbers in Array</h1>
    <form method="post">
        <label for="numbers">Enter numbers (comma-separated):</label><br>
        <input type="text" id="numbers" name="numbers" value="<?= htmlspecialchars($_POST['numbers'] ?? '') ?>" required><br><br>

        <button type="submit">Calculate Sum</button>
    </form>

    <?php if ($errorMessage): ?>
        <p style="color: red;"><strong>Error:</strong> <?= htmlspecialchars($errorMessage) ?></p>
    <?php elseif ($result !== null): ?>
        <p style="color: green;">The sum of all even numbers is: <strong><?= htmlspecialchars($result) ?></strong></p>
    <?php endif; ?>
</body>
</html>
