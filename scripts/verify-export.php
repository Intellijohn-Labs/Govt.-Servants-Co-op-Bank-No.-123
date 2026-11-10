<?php
declare(strict_types=1);

/**
 * Build gate: fails the build if the static export would ship broken pages.
 * Usage: php scripts/verify-export.php <dist-dir>
 *  - every local /assets/... URL referenced by a page must exist in dist/
 *  - every page must link /assets/css/style.css and start with <!DOCTYPE html>
 *  - no PHP error/warning text may be embedded in the HTML (it would trigger
 *    browser quirks mode and break Bootstrap's layout)
 *  - every internal page link must resolve to an exported page (or a known redirect)
 */
$dist = rtrim($argv[1] ?? '', '/');
if ($dist === '' || !is_dir($dist)) {
    fwrite(STDERR, "Usage: php verify-export.php <dist-dir>\n");
    exit(2);
}

$knownRedirects = ['/services', '/ml/services', '/__not-found__', '/ml/__not-found__'];
$problems = [];
$pages = 0;
$assetRefs = [];

$it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dist, FilesystemIterator::SKIP_DOTS));
foreach ($it as $file) {
    if (strtolower($file->getExtension()) !== 'html') {
        continue;
    }
    $rel = substr($file->getPathname(), strlen($dist));
    if (str_starts_with($rel, '/assets/')) {
        continue;
    }
    $pages++;
    $html = (string)file_get_contents($file->getPathname());

    if (!str_starts_with(ltrim($html), '<!DOCTYPE html>')) {
        $problems[] = "$rel: output does not start with <!DOCTYPE html> (text before it forces quirks mode)";
    }
    if (!str_contains($html, '/assets/css/style.css')) {
        $problems[] = "$rel: missing link to /assets/css/style.css";
    }
    if (preg_match('/<b>(Warning|Fatal error|Deprecated|Notice|Parse error)<\/b>:|^(Warning|Fatal error|Deprecated|Notice|Parse error): .* on line \d+/mi', $html, $m)) {
        $problems[] = "$rel: PHP error text embedded in HTML ({$m[1]})";
    }

    if (preg_match_all('/(?:href|src|poster)="(\/[^"#]*)"/i', $html, $refs)) {
        foreach ($refs[1] as $ref) {
            if (str_starts_with($ref, '//')) {
                continue;
            }
            $path = rtrim((string)parse_url($ref, PHP_URL_PATH), '/');
            if ($path === '') {
                continue;
            }
            if (str_starts_with($path, '/assets/')) {
                $assetRefs[$path][] = $rel;
                continue;
            }
            if (str_contains(basename($path), '.') || str_starts_with($path, '/admin') || in_array($path, $knownRedirects, true)) {
                continue;
            }
            if (!is_file("$dist$path.html") && !is_file("$dist$path/index.html")) {
                $problems[] = "$rel: link to $path has no exported page";
            }
        }
    }
}

foreach ($assetRefs as $path => $from) {
    if (!is_file($dist . $path)) {
        $problems[] = "missing asset $path (referenced by " . count($from) . " page(s), e.g. {$from[0]})";
    }
}

$assetCount = is_dir("$dist/assets")
    ? iterator_count(new RecursiveIteratorIterator(new RecursiveDirectoryIterator("$dist/assets", FilesystemIterator::SKIP_DOTS)))
    : 0;
echo "Verify: $pages pages, " . count($assetRefs) . " distinct asset URLs referenced, $assetCount files in dist/assets\n";

if ($problems) {
    fwrite(STDERR, "EXPORT VERIFICATION FAILED:\n  - " . implode("\n  - ", array_slice(array_unique($problems), 0, 40)) . "\n");
    exit(1);
}
echo "Verify: OK\n";
