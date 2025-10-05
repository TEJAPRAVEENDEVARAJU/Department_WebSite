<?php
$code = $_POST['code'];
file_put_contents("temp_user_code.php", $code);

// Hidden test cases
$test_cases = [
    ["input" => "3 5", "expected" => "8"],
    ["input" => "10 20", "expected" => "30"],
    ["input" => "1 999", "expected" => "1000"]
];

$results = [];
$passed = 0;

foreach ($test_cases as $i => $case) {
    $cmd = "echo \"" . $case['input'] . "\" | php temp_user_code.php 2>&1";
    $output = trim(shell_exec($cmd));
    if ($output === $case['expected']) {
        $results[] = "✅ Test Case " . ($i+1) . " Passed";
        $passed++;
    } else {
        $results[] = "❌ Test Case " . ($i+1) . " Failed\nExpected: " . $case['expected'] . "\nGot: " . $output;
    }
}

echo "🏁 Results:\n" . implode("\n\n", $results) . "\n\n";
echo "🎯 Score: $passed / " . count($test_cases);
?>
