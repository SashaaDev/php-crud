<?php

use function Pest\Laravel\get;
use function Pest\Laravel\post;
//sum test
describe('sum', function () {
  it('may sum integers', function () {
    $result = sum(1, 2);

    expect($result)->toBe(3);
  });

  it('may sum floats', function () {
    $result = sum(1.5, 2.5);

    expect($result)->toBe(4.0);
    
  });
});

//minus test
it('test function minus', function () {
  $result = minus(1,2);
  expect($result)->toBe(-1);
});

function sum($a, $b)
{
  return $a + $b;
}

function minus($a, $b) {
  return $a-$b;
}