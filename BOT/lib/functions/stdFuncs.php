<?php
function str_starts_with(string $haystack, string $needle): bool {
    return \strncmp($haystack, $needle, \strlen($needle)) === 0;
}

function str_ends_with(string $haystack, string $needle): bool {
    return $needle === '' || $needle === \substr($haystack, - \strlen($needle));
}
?>