<?php
function centerText($text, $width)
{
    $length = strlen($text);
    if ($length >= $width) {
        return $text;
    }

    // Hitung sisa spasi
    $left = floor(($width - $length) / 2);
    $right = $width - $length - $left;

    return str_repeat(" ", $left) . $text . str_repeat(" ", $right);
    // return $right;
}

$data1 = centerText(25, 10);
echo centerText(20, 10);
echo "\n";

echo sprintf("|" . centerText("Nama", 10) . "|" . centerText("Umur", 10) . "|");
echo "\n";
echo sprintf("|%-10s|" . centerText(20, 10) . "|", "Oded");
echo "\n";
echo sprintf("|%-10s|" . centerText(20, 10) . "|", "Ujang");
echo "\n";
echo sprintf("|%-10s|" . centerText(20, 10) . "|", "Dudung");
echo "\n";
