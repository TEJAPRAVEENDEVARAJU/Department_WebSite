<?php
$JUDGE0_API_URL = "https://judge0-ce.p.rapidapi.com/submissions?base64_encoded=false&wait=true";
$RAPIDAPI_HOST = "judge0-ce.p.rapidapi.com";
$RAPIDAPI_KEY = "2fb0988169msheb718fdf27e59f4p18e08djsn74519bfd95c5"; // your key

 
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $language = $_POST["language"];
    $code = $_POST["code"];

    $language_ids = [
        "c" => 50,
        "cpp" => 54,
        "python" => 71,
        "java" => 62
    ];

    if (!isset($language_ids[$language])) {
        echo "❌ Unsupported language!";
        exit;
    }

    $data = [
        "language_id" => $language_ids[$language],
        "source_code" => $code,
        "stdin" => ""
    ];

    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => $JUDGE0_API_URL,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_HTTPHEADER => [
            "Content-Type: application/json",
            "x-rapidapi-host: $RAPIDAPI_HOST",
            "x-rapidapi-key: $RAPIDAPI_KEY"
        ],
        CURLOPT_POSTFIELDS => json_encode($data)
    ]);

    $response = curl_exec($curl);
    $error = curl_error($curl);
    curl_close($curl);

    if ($error) {
        echo "❌ CURL Error: $error";
        exit;
    }

    $result = json_decode($response, true);

    if (isset($result["stderr"]) && $result["stderr"]) {
        echo "❌ Error:\n" . $result["stderr"];
    } elseif (isset($result["compile_output"]) && $result["compile_output"]) {
        echo "⚙️ Compilation Error:\n" . $result["compile_output"];
    } elseif (isset($result["message"]) && $result["message"]) {
        echo "⚠️ Runtime Error:\n" . $result["message"];
    } elseif (isset($result["stdout"])) {
        echo "✅ Output:\n" . $result["stdout"];
    } else {
        echo "❌ Unknown Error: " . $response;
    }
}
?>
