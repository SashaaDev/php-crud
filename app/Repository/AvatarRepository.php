<?php

namespace App\Repository;

use App\Models\User;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Js;
use Illuminate\Support\Str;
use PhpParser\Node\Expr\Cast\Object_;
use Psy\CodeCleaner\FunctionReturnInWriteContextPass;

class AvatarRepository
{
  private $fileRepository;

  public function __construct(FileRepository $fileRepository)
  {
    $this->fileRepository = $fileRepository;
  }

  public function setAvatar(string $fileName, string $file): bool
  {
    return $this->fileRepository->put($fileName, $file);
  }

  public function deleteAvatar(string $filename): bool
  {
    return $this->fileRepository->delete($filename);
  }

  public function setRandomName($extension): string
  {
    return Str::random(40) . '.' . $extension;
  }
}
