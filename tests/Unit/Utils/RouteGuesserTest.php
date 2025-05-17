<?php

namespace Tests\Unit\Utils;

use App\Utils\RouteGuesser;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;
use function abort;
use function resolve;

class RouteGuesserTest extends TestCase
{
    public function test_returns_route_corresponding_to_url(): void
    {
        Route::get('/example/{uuid}', static function (string $uuid) {
            abort(123);
        })->name('example');

        $guesser = resolve(RouteGuesser::class);

        $this->assertSame(
            'example',
            $guesser->fromUrl('/example/1234')->getName()
        );
    }

    public function test_throw_if_no_route_corresponding_to_url(): void
    {
        $guesser = resolve(RouteGuesser::class);

        $this->assertThrows(function () use ($guesser) {
            $guesser->fromUrl('/example-that-does-not-exist');
        });
    }
}
