<?php

namespace App\Providers;

use App\Models\Post;
use App\Models\User;
use App\Repository\AvatarRepository;
use App\Repository\FileRepository;
use App\Repository\PostRepository;
use App\Repository\UserRepository;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class RepositoryServiceProvider extends ServiceProvider
{


  /**
   * Register any events for your application.
   */
  public function boot(): void
  {
  }
  /**
   * Register any application services.
   */
  public function register(): void
  {
    $this->app->bind(FileRepository::class, function () {
      return new FileRepository();
    });
    $this->app->bind(AvatarRepository::class, function () {
      return new AvatarRepository(app(FileRepository::class));
    });
    $this->app->bind(UserRepository::class, function () {
      return new UserRepository(new User(),app(AvatarRepository::class));
    });
    $this->app->bind(PostRepository::class, function () {
      return new PostRepository(new Post());
    });
  }
}
