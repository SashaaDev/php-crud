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

dataset('All user getted', function () {
  return [
    [
      collect(
        [
          [
            'id' => 1,
            'name' => 'name',
            'email' => 'email',
            'created_at' => '2022-01-01T00:00:00.000000Z',
            'updated_at' => '2022-01-01T00:00:00.000000Z',
          ],
          [
            'id' => 2,
            'name' => 'name',
            'email' => 'email',
            'created_at' => '2022-01-01T00:00:00.000000Z',
            'updated_at' => '2022-01-01T00:00:00.000000Z',
          ],
          [
            'id' => 3,
            'name' => 'name',
            'email' => 'email',
            'created_at' => '2022-01-01T00:00:00.000000Z',
            'updated_at' => '2022-01-01T00:00:00.000000Z',
          ]
        ]
      ),
      [
        [
          'id' => 1,
          'name' => 'name',
          'email' => 'email',
          'created_at' => '2022-01-01T00:00:00.000000Z',
          'updated_at' => '2022-01-01T00:00:00.000000Z',
        ],
        [
          'id' => 2,
          'name' => 'name',
          'email' => 'email',
          'created_at' => '2022-01-01T00:00:00.000000Z',
          'updated_at' => '2022-01-01T00:00:00.000000Z',
        ],
        [
          'id' => 3,
          'name' => 'name',
          'email' => 'email',
          'created_at' => '2022-01-01T00:00:00.000000Z',
          'updated_at' => '2022-01-01T00:00:00.000000Z',
        ]
      ]
    ],
  ];
});

dataset('User created', function () {
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
        'password' => 'password',
        'updated_at' => '2024-03-27T13:42:45.000000Z',
        'created_at' => '2024-03-27T13:42:45.000000Z',
        'id' => 2,
      ],
    ]
  ];
});


dataset('User updated', function () {
  return [
    [

      [
        'id' => 1,
        "name" => "userName1",
        "email" => "UserTest1@gmail.com",
        "email_verified_at" => null,
        "hash" => null,
        "avatar" => "avatars/ETmHuYfEGjWuuC9Lem1Lf9vAHShZFmWJEAv1ry5g.png",
        "created_at" => "2024-03-29T08:12:52.000000Z",
        "updated_at" => "2024-03-29T09:06:54.000000Z"
      ],
      [
        "id" => 1,
        "name" => "UserChange1",
        "email" => "UserTest1@gmail.com",
        "email_verified_at" => null,
        "hash" => null,
        "avatar" => null,
        "created_at" => "2024-03-29T13:42:42.000000Z",
        "updated_at" => "2024-03-29T13:46:19.000000Z"
      ]
    ]
  ];
});

dataset('User deleted', function () {
  return [
    [
      collect(
        [
          'deleted' => true
        ]
      ),
      1
    ]
  ];
});

//avatar
dataset('User getted avatar', function () {
  return [
    [
      collect(
        [
          'avatar' => 'avatar'
        ]
      ),
      [
        'avatar' => 'avatar'
      ]
    ]
  ];
});

dataset('User updated avatar', function () {
  return [
    [
      collect(
        [
          'id' => 1,
          "name" => "userName1",
          "email" => "UserTest1@gmail.com",
          "email_verified_at" => null,
          "hash" => null,
          "avatar" => "avatars/ETmHuYfEGjWuuC9Lem1Lf9vAHShZFmWJEAv1ry5g.png",
          "created_at" => "2024-03-29T08:12:52.000000Z",
          "updated_at" => "2024-03-29T09:06:54.000000Z"
        ]
      ),
      [
        'id' => 1,
      ],
      [
        'id' => 1,
        "name" => "userName1",
        "email" => "UserTest1@gmail.com",
        "email_verified_at" => null,
        "hash" => null,
        "avatar" => "avatars/ETmHuYfEGjWuuC9Lem1Lf9vAHShZFmWJEAv1ry5g.png",
        "created_at" => "2024-03-29T08:12:52.000000Z",
        "updated_at" => "2024-03-29T09:06:54.000000Z"
      ]
    ]
  ];
});

dataset('User deleted avatar', function () {
  return [
    [
      collect(
        [
          'avatar' => 'avatar'
        ]
      ),
      [
        'avatar' => 'avatar'
      ]
    ]
  ];
});

//auth
dataset('User logged in', function () {
  $user = new User();
  return [
    [
      [
        'id' => 1,
        'name' => 'name',
        'email' => 'email@example.com',
        'password' => 'password',
        'hash' => 'hash',
      ],
      [
        "access_token" => "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vMTI3LjAuMC4xL2FwaS9hdXRoL2xvZ2luIiwiaWF0IjoxNzExNzAwMDExLCJleHAiOjE3MTE3MDM2MTEsIm5iZiI6MTcxMTcwMDAxMSwianRpIjoiQlRqNlFKUVVTN3J0YXZ0WSIsInN1YiI6IjEiLCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.1ltU_aZEXk-niLwBcOAhgIMTz8h0jZgdK9CIXlcirPY",
        "token_type" => "bearer",
        "expires_in" => 3600
      ]
    ]
  ];
});

dataset('User registered', function () {
  return [
    [

      collect([
        'id' => 1,
        'name' => 'name',
        'email' => 'email11@example.com',
        'password' => 'password',
        'hash' => null,
        "updated_at" => "2024-03-29T12:56:07.000000Z",
        "created_at" => "2024-03-29T12:56:07.000000Z",
      ]),
      [
        "id" => 1,
        "name" => "name",
        "email" => "email11@example.com",
        'password' => 'password',
        'hash' => null,
        "updated_at" => "2024-03-29T12:56:07.000000Z",
        "created_at" => "2024-03-29T12:56:07.000000Z",

      ]
    ]
  ];
});

dataset('User updated hash', function () {
  return [
    [
      'email' => 'UserTest1@gmail.com',
      collect(
        [
          'id' => 1,
          'name' => 'name',
          'email' => 'UserTest1@gmail.com',
          'hash' => 'hash',
        ]
      ),
      [
        'hash' => 'hash',
      ]
    ]
  ];
});
