<?php

use App\Models\User;
// use Illuminate\Support\Carbon;
use Carbon\Carbon;

dataset('User getted', function () {
  return [
    [
      collect(
        [
          'id' => 1,
          'name' => 'name',
          'email' => 'email',
          'created_at' => '2022-01-01T00:00:00.000000Z',
          'updated_at' => '2022-01-01T00:00:00.000000Z',
        ]
      ),
      [
        'id' => 1,
        'name' => 'name',
        'email' => 'email',
        'created_at' => '2022-01-01T00:00:00.000000Z',
        'updated_at' => '2022-01-01T00:00:00.000000Z',
      ]
    ],
  ];
});

// $currentTime = Carbon::now();
// dataset('User created', function ()  use ($currentTime) {
//   return [
//     [
//       collect(
//         [
//           'name' => 'name',
//           'email' => 'email@gmail.com',
//           'password' => 'password',
//           'updated_at' => Carbon::parse('2024-03-27T10:24:49+00:00'),
//           'created_at' => Carbon::parse('2024-03-27T10:24:49+00:00'),
//           'id' => 2,
//         ]
//       ),
//       [
//         'name' => 'name',
//         'email' => 'email@gmail.com',
//         'created_at' => $currentTime->format('Y-m-d H:i:s'),
//         'updated_at' => $currentTime->format('Y-m-d H:i:s'),
//         'id' => 2,
//       ]
//     ]
//   ];
// });
// function getCreatedAtAttribute($value)
// {
//   $date = Carbon::parse($value);
//   return $date->format('Y-m-d H:i');
// }
// function getUpdatedAtAttribute($value)
// {
//   $date = Carbon::parse($value);
//   return $date->format('Y-m-d H:i');
// }

$fixedTimestamp = Carbon::now();

dataset('User created', function () use ($fixedTimestamp) {
  return [
    [
      collect([
        'name' => 'name',
        'email' => 'email@gmail.com',
        'password' => 'password',
        'updated_at' => '2024-03-27T13:42:45.000000Z',
        'created_at' => '2024-03-27T13:42:45.000000Z',
        'id' => 2,
      ]),
      [
        'name' => 'name',
        'email' => 'email@gmail.com',
        
        'updated_at' => '2024-03-27T13:42:45.000000Z',
        'created_at' => '2024-03-27T13:42:45.000000Z',
        'id' => 2,
      ],
      // dd($fixedTimestamp),
    ]
  ];
});


dataset('User updated', function () {
  return [
    [
      collect(
        [
          'name' => 'name',
          'email' => 'email@gmail.com',
          'password' => 'password',
        ]
      ),
      [
        'name' => 'name',
        'email' => 'email@gmail.com',
        'password' => 'password',
      ]
    ]
  ];
});
