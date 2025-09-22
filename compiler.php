<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Compiler</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Materialize CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- CodeMirror CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/codemirror.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/theme/material.css">
    <style>
        body {
            background-color: #f9f9f9;
        }
        .editor-container {
            height: 300px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center"><i class="fas fa-code"></i>Code Compiler</h1>
        <div class="card mt-4 p-4">
            <form method="POST" action="" id="compiler-form">
                <!-- Language Selector -->
                <div class="mb-3">
                    <label for="language" class="form-label"><i class="fas fa-language"></i> Select Language:</label>
                    <select id="language" name="language" class="form-select" required>
                        <option value="c">C</option>
                        <option value="cpp">C++</option>
                        <option value="python">Python</option>
                        <option value="java">Java</option>
                    </select>
                </div>
                <!-- Code Editor -->
                <div class="mb-3">
                    <label for="code" class="form-label"><i class="fas fa-edit"></i> Write Your Code:</label>
                    <textarea id="code" name="code" class="form-control editor-container" required></textarea>
                </div>
                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary w-100"><i class="fas fa-play"></i> Run Code</button>
            </form>
        </div>
        <!-- Output Section -->
        <?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
            <div class="card mt-4 p-4">
                <h5 class="text-center"><i class="fas fa-terminal"></i> Output:</h5>
                <pre><?php echo htmlspecialchars(handleCodeExecution($_POST['language'], $_POST['code'])); ?></pre>
            </div>
        <?php endif; ?>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Materialize JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <!-- CodeMirror JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/codemirror.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/mode/clike/clike.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/mode/python/python.min.js"></script>
    <script>
        // Initialize CodeMirror editor
        const editor = CodeMirror.fromTextArea(document.getElementById("code"), {
            lineNumbers: true,
            mode: "text/x-csrc", // Default to C language
            theme: "material",
        });

        // Update CodeMirror mode based on selected language
        document.getElementById("language").addEventListener("change", function() {
            const language = this.value;
            let mode = "text/x-csrc"; // Default to C
            if (language === "cpp") mode = "text/x-c++src";
            else if (language === "python") mode = "text/x-python";
            else if (language === "java") mode = "text/x-java";
            editor.setOption("mode", mode);
        });
    </script>
</body>
</html>

<?php
// Backend logic to handle code execution
function handleCodeExecution($language, $code) {
    $tempDir = __DIR__ . '/temp/';
    if (!is_dir($tempDir)) mkdir($tempDir, 0777, true);

    $fileName = uniqid('code_', true);
    $output = '';

    try {
        switch ($language) {
            case 'c':
                $codeFile = $tempDir . $fileName . '.c';
                $outputFile = $tempDir . $fileName;
                file_put_contents($codeFile, $code);
                exec("gcc $codeFile -o $outputFile 2>&1", $output, $returnCode);
                if ($returnCode === 0) exec("$outputFile", $output);
                break;

            case 'cpp':
                $codeFile = $tempDir . $fileName . '.cpp';
                $outputFile = $tempDir . $fileName;
                file_put_contents($codeFile, $code);
                exec("g++ $codeFile -o $outputFile 2>&1", $output, $returnCode);
                if ($returnCode === 0) exec("$outputFile", $output);
                break;

            case 'python':
                $codeFile = $tempDir . $fileName . '.py';
                file_put_contents($codeFile, $code);
                exec("python3 $codeFile 2>&1", $output, $returnCode);
                break;

            case 'java':
                $codeFile = $tempDir . $fileName . '.java';
                $className = $fileName;
                file_put_contents($codeFile, $code);
                exec("javac $codeFile 2>&1", $output, $returnCode);
                if ($returnCode === 0) exec("java -cp $tempDir $className 2>&1", $output);
                break;

            default:
                throw new Exception("Unsupported language selected.");
        }

        if ($returnCode !== 0) {
            $output = implode("\n", $output);
        } else {
            $output = implode("\n", $output);
        }
    } catch (Exception $e) {
        $output = $e->getMessage();
    }

    return $output;
}
?>
