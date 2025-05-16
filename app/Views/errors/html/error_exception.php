<?php

/**
 * Error Exception
 *
 * @var \Throwable $exception
 */

$message = $exception->getMessage();
$file = $exception->getFile();
$line = $exception->getLine();
$trace = $exception->getTrace();

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error Exception</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
            background: #f8f9fa;
            color: #333;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        h1 {
            color: #dc3545;
            margin-top: 0;
        }
        .error-details {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 4px;
            margin: 20px 0;
        }
        .error-message {
            font-size: 1.2em;
            margin-bottom: 10px;
        }
        .error-file {
            color: #666;
            font-size: 0.9em;
        }
        .error-trace {
            margin-top: 20px;
        }
        .error-trace pre {
            background: #f8f9fa;
            padding: 10px;
            border-radius: 4px;
            overflow-x: auto;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Error Exception</h1>
        
        <div class="error-details">
            <div class="error-message">
                <strong>Message:</strong> <?= esc($message) ?>
            </div>
            <div class="error-file">
                <strong>File:</strong> <?= esc($file) ?><br>
                <strong>Line:</strong> <?= $line ?>
            </div>
        </div>

        <?php if (ENVIRONMENT !== 'production'): ?>
            <div class="error-trace">
                <h2>Stack Trace</h2>
                <pre><?= esc(print_r($trace, true)) ?></pre>
            </div>
        <?php endif; ?>
    </div>
</body>
</html> 