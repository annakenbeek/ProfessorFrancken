<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Broadway\EventSourcing\EventSourcingRepository;
use Broadway\EventStore\EventStoreInterface;
use Broadway\EventHandling\EventBusInterface;
use Broadway\EventSourcing\AggregateFactory\AggregateFactoryInterface;
use Francken\Domain\Committees\CommitteeRepository;

class AppServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerRepository(CommitteeRepository::class);
    }

    /**
     * Creates a new binding for an event sourced aggregate repository
     * @param string $repository classname
     * @param string $aggregae classname
     */
    private function registerRepository($repository)
    {
        $this->app->bind(
            $repository,
            function ($app) use ($repository) {
                $eventStore = $app->make(EventStoreInterface::class);
                $eventBus = $app->make(EventBusInterface::class);
                $factory = $app->make(AggregateFactoryInterface::class);

                return new $repository(
                    $eventStore,
                    $eventBus,
                    $factory
                );
            }
        );
    }
}
