<?php
// ============================================================
// AI Interview Question Generator — Backend
// Calls the OpenAI Chat Completions API using cURL and
// renders the generated questions as Bootstrap cards.
// ============================================================

// --------------------------------------------------------------
// STEP 1: Add your own API key here.
// Get one free at https://platform.openai.com/api-keys
// Never commit a real key to GitHub — for a class project this
// is fine to leave inline, but in real apps use an environment
// variable instead.
// --------------------------------------------------------------
define('OPENAI_API_KEY', 'PASTE_YOUR_OPENAI_API_KEY_HERE');

$questions = [];
$errorMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $jobRole         = trim($_POST['jobRole'] ?? '');
    $experienceLevel = trim($_POST['experienceLevel'] ?? '');
    $questionCount   = (int) ($_POST['questionCount'] ?? 5);

    if ($jobRole === '') {
        $errorMessage = "Please enter a job role or topic.";
    } elseif (OPENAI_API_KEY === 'PASTE_YOUR_OPENAI_API_KEY_HERE') {
        $errorMessage = "No API key configured yet. Add your OpenAI API key at the top of generate.php.";
    } else {

        // Build the prompt sent to the model
        $prompt = "Generate {$questionCount} interview questions for a {$experienceLevel} candidate "
                 . "applying for a {$jobRole} role. Return ONLY a numbered list of questions, "
                 . "with no extra commentary before or after the list.";

        $payload = [
            "model" => "gpt-4o-mini",
            "messages" => [
                ["role" => "system", "content" => "You are an expert technical interviewer who writes clear, relevant interview questions."],
                ["role" => "user", "content" => $prompt]
            ],
            "temperature" => 0.7
        ];

        $ch = curl_init("https://api.openai.com/v1/chat/completions");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json",
            "Authorization: Bearer " . OPENAI_API_KEY
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);

        $response = curl_exec($ch);
        $curlError = curl_error($ch);
        curl_close($ch);

        if ($curlError) {
            $errorMessage = "Connection error: " . $curlError;
        } else {
            $result = json_decode($response, true);

            if (isset($result['error'])) {
                $errorMessage = "API error: " . $result['error']['message'];
            } elseif (isset($result['choices'][0]['message']['content'])) {
                $rawText = $result['choices'][0]['message']['content'];

                // Split the numbered list into individual questions
                $lines = explode("\n", trim($rawText));
                foreach ($lines as $line) {
                    $line = trim($line);
                    $line = preg_replace('/^\d+[\.\)]\s*/', '', $line); // strip "1. " / "1) "
                    if ($line !== '') {
                        $questions[] = $line;
                    }
                }
            } else {
                $errorMessage = "Unexpected response from the API. Please try again.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generated Questions</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #eef1f7;
        }
        .results-card {
            max-width: 700px;
            margin: 50px auto;
            background: white;
            border-radius: 10px;
            box-shadow: 0 3px 12px rgba(0,0,0,0.08);
            padding: 35px;
        }
        .question-item {
            border-left: 3px solid #263859;
            background-color: #f7f9fc;
            padding: 12px 16px;
            margin-bottom: 10px;
            border-radius: 0 6px 6px 0;
        }
    </style>
</head>
<body>

<div class="results-card">

    <?php if ($errorMessage): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($errorMessage) ?></div>
        <a href="index.html" class="btn btn-outline-primary">Try Again</a>

    <?php elseif (!empty($questions)): ?>
        <h4 class="mb-3">
            Interview Questions: <?= htmlspecialchars($jobRole) ?>
            <small class="text-muted d-block" style="font-size: 14px;"><?= htmlspecialchars($experienceLevel) ?></small>
        </h4>

        <?php foreach ($questions as $index => $q): ?>
            <div class="question-item">
                <strong>Q<?= $index + 1 ?>.</strong> <?= htmlspecialchars($q) ?>
            </div>
        <?php endforeach; ?>

        <a href="index.html" class="btn btn-outline-primary mt-3">Generate More</a>

    <?php else: ?>
        <div class="alert alert-warning">
            This page only responds to a form submission. <a href="index.html">Go back to the generator</a>.
        </div>
    <?php endif; ?>

</div>

</body>
</html>
