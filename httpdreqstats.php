#!/usr/bin/php

<?php

$fh = fopen($argv[1], 'r');

if ($fh) {
    $stats = [];
    $acum = 0;
    $total = 0;

    while (($line = fgets($fh)) !== false) {
        if (1 === preg_match('/^.+ "(.+)" .+$/', $line, $match)) {
            $request = $match[1];

            $stats[$request] = isset($stats[$request]) ?
                $stats[$request] + 1 :
                1;

            $total++;
        }
    }

    fclose($fh);

    arsort($stats);

    foreach ($stats as $key => $value) {
        $acum += $value;
        print sprintf("%d	%.2f%%	%.2f%%	%s\n", $value, 100 * $value / $total, 100 * $acum / $total, $key);
    }
    print "\nTotal: $total requests\n";
}
