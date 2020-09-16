<?php
if (! function_exists('testExport')) {
  /**
   * Change all instances of :argument to {argument}
   *
   * @param $string
   * @return void
   *
   */
  function testExport($string) {
    array_walk_recursive($string, function (&$v, $k) { $v = preg_replace('/:(\w+)/', '{$1}', $v); });

    return $string;
  }
}


if (!function_exists('make_slug')) {
  /**
   * Generate slug from string
   *
   * @param $string
   * @return string|string[]|null $string
   */
  function make_slug($string) {
    return preg_replace('/\s+/u', '-', strtolower(trim($string)));
  }
}
