<?php

namespace App\Providers;

use App\Traits\InteractsWithAlert;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class MacrosServiceProvider extends ServiceProvider
{
    use InteractsWithAlert;

    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Builder::macro('whereLike', function (mixed $attributes, string $searchTerm, bool $caseSensitive = false) {
            /** @var \Illuminate\Database\Eloquent\Builder $this */
            $this->where(function (Builder $query) use ($attributes, $searchTerm, $caseSensitive) {
                foreach (Arr::wrap($attributes) as $attribute) {
                    $query->when(
                        Str::of($attribute)->contains('.'),
                        // Support for searching the attributes of the relations (related models) of
                        // the model in the context.
                        function (Builder $query) use ($attribute, $searchTerm, $caseSensitive) {
                            [$relationName, $relationAttribute] = explode('.', $attribute);

                            $query->orWhereHas(
                                $relationName,
                                function (Builder $query) use ($relationAttribute, $searchTerm, $caseSensitive) {
                                    if ($caseSensitive) {
                                        $query->where($relationAttribute, 'LIKE', "%{$searchTerm}%");
                                    } else {
                                        $query->where($relationAttribute, 'ILIKE', "%{$searchTerm}%");
                                    }
                                }
                            );
                        },
                        function (Builder $query) use ($attribute, $searchTerm, $caseSensitive) {
                            // splits the search term so we can, for example,  search for
                            // “Lesch Hoppe” and find “Lesch and Hoppe” or “Will, Lesch and Hoppe”.
                            // Search terms are AND’ed per field and OR’ed between fields;
                            // so it will not, for example, find “Lesch Else” name
                            // and “hoppe@email.com” mail.
                            $query->orWhere(
                                function ($query) use ($attribute, $searchTerm, $caseSensitive) {
                                    foreach (explode(' ', $searchTerm) as $subTerm) {
                                        if ($caseSensitive) {
                                            $query->where($attribute, 'LIKE', "%{$subTerm}%");
                                        } else {
                                            $query->where($attribute, 'ILIKE', "%{$subTerm}%");
                                        }
                                    }
                                }
                            );
                        }
                    );
                }
            });

            return $this;
        });

        RedirectResponse::macro('alert', function (string $message, string $type = 'success', ?int $duration = null) {
            /** @var \Illuminate\Http\RedirectResponse $this */
            return $this->alert($message, $type, $duration);
        });

        RedirectResponse::macro('warningAlert', function (string $message, ?int $duration = null) {
            /** @var \Illuminate\Http\RedirectResponse $this */
            return $this->warningAlert($message, $duration);
        });

        RedirectResponse::macro('dangerAlert', function (string $message, ?int $duration = null) {
            /** @var \Illuminate\Http\RedirectResponse $this */
            return $this->dangerAlert($message, $duration);
        });
    }
}
