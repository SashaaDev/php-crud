<?php

dataset('Post updated', function () {
  return [
    [
      collect(
        [
          'title' => 'title',
          'description' => 'description',
        ]
      ),
      [
        'title' => 'title',
        'description' => 'description',

      ]
    ]
  ];
});
