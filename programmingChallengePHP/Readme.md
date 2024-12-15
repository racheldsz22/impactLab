
# Programming Challenge (PHP)

This folder contains solutions to various programming challenges that demonstrate problem-solving skills using PHP. These challenges focus on algorithmic thinking and include tasks related to string manipulation, arrays, and mathematical problems.

---

## Challenges Solved

1. **Palindrome Checker**: A function to check if a string is a palindrome.
2. **Second-Highest Value**: A function to find the second-highest value in an array.
3. **Sum of Even Numbers**: A function to calculate the sum of all even values in an array.

---

## Files and Functions

### **Palindrome Checker**

public function isPalindrome(string $input): bool {
    $input = strtolower(str_replace(' ', '', $input));
    return $input === strrev($input);
}

**validations**
- Check if input is empty

### web form is created to take the input from the users
**url** - http://localhost/impactLab/programmingChallengePHP/palindrome.php

### **nth highest number (second Highest default)**
public function secondHighest(array $numbers): int {
    $uniqueNumbers = array_unique(array_map('intval', $numbers));
    rsort($numbers); // Sort the array in descending order
    return $numbers[$n - 1]; // Return the second element
}

**validations**
- Validate each element to ensure it's an integer
- Check if nth element 
- Check if input is empty
- Validate `n` is numeric and positive

### web form is created to take the input from the users
**url** - http://localhost/impactLab/programmingChallengePHP/second_highest_number.php

### **Sum of Even Numbers**

public function sumEven(array $numbers): int {
    $sum = 0;
    foreach ($numbers as $number) {
        if ($number % 2 == 0) {
            $sum += $number;
        }
    }
    return $sum;
}


**validations**
- Check if input is empty
- Validate if all elements in the array are integers


### web form is created to take the input from the users
**url** - http://localhost/impactLab/programmingChallengePHP/sum_even_numbers.php
