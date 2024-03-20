<?php

namespace App\Repository;

use App\Exceptions\NotFoundException;
use App\Models\User;
use App\Services\UserService;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Storage;

class FileRepository
{

  public function delete(string $filePath): bool
  {
    return Storage::disk('local')->delete($filePath);
  }
  public function put(string $filename, string $file): bool
  {
    $path = UserService::PART_PATH_AVATARS;
    return Storage::disk('local')->put($path . '/' . $filename, $file);
  }
}
