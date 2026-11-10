<?php
declare(strict_types=1);

/**
 * Static export: crawls the running PHP app and writes plain HTML files.
 *
 * Usage: php scripts/static-export.php <base-url> <out-dir>
 *
 * Output layout (works with Vercel cleanUrls):
 *   /            -> index.html          /ml          -> ml/index.html
 *   /about       -> about.html          /ml/welfare  -> ml/welfare.html
 */

$base = rtrim($argv[1] ?? '', '/');
$out = rtrim($argv[2] ?? '', '/');
if ($base === '' || $out === '') {
    fwrite(STDERR, "Usage: php static-export.php <base-url> <out-dir>\n");
    exit(2);
}

// Public routes (each exported in English and under /ml)
$routes = [
    '/', '/about', '/achievements', '/welfare', '/interest-rates', '/calculators',
    '/branches', '/contact', '/feedback', '/grievance', '/service-request',
    '/legal-framework', '/privacy-policy', '/terms', '/sitemap',
    '/board', '/chairperson-message', '/news', '/downloads', '/tenders', '/careers', '/search',
];
$seed = [];
foreach (['', '/ml'] as $lang) {
    foreach ($routes as $r) {
        $seed[] = $r === '/' ? ($lang === '' ? '/' : $lang) : $lang . $r;
    }
}

const SKIP_PREFIXES = ['/admin', '/assets', '/clients', '/uploads', '/en', '/products', '/services', '/__'];

function fetchUrl(string $url): array
{
    $ctx = stream_context_create(['http' => [
        'method' => 'GET', 'follow_location' => 0, 'ignore_errors' => true, 'timeout' => 30,
    ]]);
    $body = @file_get_contents($url, false, $ctx);
    $status = 0;
    $location = null;
    foreach (($http_response_header ?? []) as $h) {
        if (preg_match('#^HTTP/\S+\s+(\d{3})#', $h, $m)) {
            $status = (int)$m[1];
        } elseif (stripos($h, 'Location:') === 0) {
            $location = trim(substr($h, 9));
        }
    }
    return [$status, (string)$body, $location];
}

function outputFile(string $out, string $path): string
{
    if ($path === '/') {
        return $out . '/index.html';
    }
    if ($path === '/ml') {
        return $out . '/ml/index.html';
    }
    return $out . $path . '.html';
}

function previewScript(string $path): string
{
    $ml = $path === '/ml' || str_starts_with($path, '/ml/');
    $msg = $ml
        ? 'ഇത് പ്രിവ്യൂ പതിപ്പാണ്. ഓൺലൈൻ ഫോം സമർപ്പണം ഇവിടെ ലഭ്യമല്ല; ദയവായി ഫോൺ/ഇമെയിൽ വഴി ബന്ധപ്പെടുക.'
        : 'This is a static preview. Online form submission is not available here; please contact the bank by phone or email.';
    $js = json_encode($msg, JSON_UNESCAPED_UNICODE);
    return "<script>document.addEventListener('DOMContentLoaded',function(){document.querySelectorAll('form').forEach(function(f){f.addEventListener('submit',function(e){e.preventDefault();alert($js);});});});</script>\n";
}

function discoverLinks(string $html): array
{
    $found = [];
    if (preg_match_all('/href="(\/[^"#]*)"/i', $html, $m)) {
        foreach ($m[1] as $href) {
            if (str_starts_with($href, '//')) {
                continue;
            }
            $path = rtrim((string)parse_url($href, PHP_URL_PATH), '/');
            if ($path === '' || str_contains(basename($path), '.')) {
                continue;
            }
            foreach (SKIP_PREFIXES as $p) {
                if ($path === $p || str_starts_with($path, $p . '/')) {
                    continue 2;
                }
            }
            $found[$path] = true;
        }
    }
    return array_keys($found);
}

// Wait for the server
for ($i = 0; $i < 30; $i++) {
    [$st] = fetchUrl($base . '/');
    if ($st === 200) {
        break;
    }
    sleep(1);
    if ($i === 29) {
        fwrite(STDERR, "Server did not become ready at $base\n");
        exit(1);
    }
}

$queue = $seed;
$seen = [];
$saved = 0;
$errors = [];
$seedSet = array_flip($seed);

while ($queue) {
    $path = array_shift($queue);
    if (isset($seen[$path])) {
        continue;
    }
    $seen[$path] = true;

    [$status, $body, $loc] = fetchUrl($base . $path);
    if ($status !== 200) {
        $note = "$path -> HTTP $status" . ($loc ? " ($loc)" : '');
        if (isset($seedSet[$path])) {
            $errors[] = $note;
        } else {
            echo "  skip  $note\n";
        }
        continue;
    }

    foreach (discoverLinks($body) as $link) {
        if (!isset($seen[$link])) {
            $queue[] = $link;
        }
    }

    $html = str_ireplace('</body>', previewScript($path) . '</body>', $body);
    $file = outputFile($out, $path);
    if (!is_dir(dirname($file))) {
        mkdir(dirname($file), 0755, true);
    }
    file_put_contents($file, $html);
    $saved++;
    echo "  saved $path\n";
}

// Branded 404 page
[$st404, $body404] = fetchUrl($base . '/__not-found__');
if ($st404 === 404 && $body404 !== '') {
    file_put_contents($out . '/404.html', $body404);
}

echo "\nExported $saved pages to $out\n";
if ($errors) {
    fwrite(STDERR, "ERROR: expected routes failed:\n  " . implode("\n  ", $errors) . "\n");
    exit(1);
}
