<?php
class PalindromeChecker {
    public function isPalindrome(string $input): bool {
        // Remove spaces and convert to lowercase for case-insensitive comparison
        $input = strtolower(str_replace(' ', '', $input));

        // Compare the original string with its reversed version
        return $input === strrev($input);
    }
}

$errorMessage = '';
$result = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Get user input
        $inputString = $_POST['string'] ?? '';

        // Check if input is empty
        if (empty($inputString)) {
            throw new Exception("Input cannot be empty.");
        }

        // Instantiate the class and check if the string is a palindrome
        $palindromeChecker = new PalindromeChecker();
        $result = $palindromeChecker->isPalindrome($inputString);
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
    <title>Palindrome Checker</title>
</head>
<body>
    <h1>Check if a String is a Palindrome</h1>
    <form method="post">
        <label for="string">Enter a string:</label><br>
        <input type="text" id="string" name="string" value="<?= htmlspecialchars($_POST['string'] ?? '') ?>" required><br><br>

        <button type="submit">Check</button>
    </form>

    <?php if ($errorMessage): ?>
        <p style="color: red;"><strong>Error:</strong> <?= htmlspecialchars($errorMessage) ?></p>
    <?php elseif ($result !== null): ?>
        <p style="color: green;">
            '<?= htmlspecialchars($_POST['string'] ?? '') ?>' is <?= $result ? 'a palindrome' : 'not a palindrome' ?>.
        </p>
    <?php endif; ?>
</body>
</html>
