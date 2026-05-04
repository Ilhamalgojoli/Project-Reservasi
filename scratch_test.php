<?php
$periode = '2026-genap';
$parts = explode('-', $periode);
$year = $parts[0];
$semester = $parts[1];

if ($semester === 'genap') {
    $start = $year . '-02-01';
    $end = $year . '-07-31';
} else {
    $start = $year . '-08-01';
    $end = ($year + 1) . '-01-31';
}

echo "$start to $end\n";
