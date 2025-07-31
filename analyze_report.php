<?php
// Read the report
$report = json_decode(file_get_contents("report.json"), true);

$recommendations = [
    "BLOCKER" => "⚠️ Fix immediately – will break the app",
    "CRITICAL" => "❗ Fix within the same day – major bugs or vulnerabilities",
    "MAJOR" => "🛠️ Fix before deployment or in the next sprint",
    "MINOR" => "📌 Fix during code cleanup or future maintenance",
    "INFO" => "ℹ️ Optional – not urgent"
];

echo "SonarQube Issue Summary:\n";
echo "-------------------------\n";

foreach ($report['issues'] as $issue) {
    $severity = $issue['severity'];
    $message = $issue['message'];
    $line = $issue['line'] ?? "N/A";
    $rec = $recommendations[$severity] ?? "No recommendation";

    echo "$severity - $message at line $line\n";
    echo "→ Recommendation: $rec\n\n";
}
?>
