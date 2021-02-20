# Scheduling Tasks

- [Scheduling Tasks](#scheduling-tasks)
	- [Introduction](#introduction)
	- [Defining Schedules](#defining-schedules)
		- [Schedule Frequency Options](#schedule-frequency-options)
			- [Day Constraints](#day-constraints)
			- [Between Time Constraints](#between-time-constraints)
			- [Truth Test Constraints](#truth-test-constraints)
			- [Environment Constraints](#environment-constraints)
	- [Future Plans](#future-plans)

## Introduction
To help provide a singular interface for scheduling jobs in WordPress (and to
not interact with WordPress cron) Mantle provides a fluent interface for
defining scheduleable tasks.

## Defining Schedules
Jobs and Console Commands can be scheduled in the
`app/providers/class-app-service-provider.php` file in your application.

```php
namespace App\Providers;

use Mantle\Framework\Providers\App_Service_Provider as Service_Provider;

/**
 * Application Service Provider
 */
class App_Service_Provider extends Service_Provider {
  // ...

  /**
   * Schedule any commands for the Application
   *
   * @param \Mantle\Scheduling\Schedule $schedule Scheduler instance.
   */
  protected function schedule( $schedule ) {
    // Schedule a job class.
    $schedule->job( \App\Jobs\Example_Job::class )->daily();

    // Schedule a console command.
    $schedule->command( \App\Console\Example_Command::class )->hourly();

    $schedule->call(
      function() {
        // Do something!
      }
    )->weekly();
  }
}
```

### Schedule Frequency Options
There are a variety of schedules you may assign to your task:

Method  | Description
------------- | -------------
`->cron( '* * * * *' );`  |  Run the task on a custom Cron schedule
`->everyMinute();`  |  Run the task every minute
`->everyTwoMinutes();`  |  Run the task every two minutes
`->everyThreeMinutes();`  |  Run the task every three minutes
`->everyFourMinutes();`  |  Run the task every four minutes
`->everyFiveMinutes();`  |  Run the task every five minutes
`->everyTenMinutes();`  |  Run the task every ten minutes
`->everyFifteenMinutes();`  |  Run the task every fifteen minutes
`->everyThirtyMinutes();`  |  Run the task every thirty minutes
`->hourly();`  |  Run the task every hour
`->hourlyAt(17);`  |  Run the task every hour at 17 minutes past the hour
`->everyTwoHours();`  |  Run the task every two hours
`->everyThreeHours();`  |  Run the task every three hours
`->everyFourHours();`  |  Run the task every four hours
`->everySixHours();`  |  Run the task every six hours
`->daily();`  |  Run the task every day at midnight
`->dailyAt( '13:00' );`  |  Run the task every day at 13:00
`->twiceDaily(1, 13);`  |  Run the task daily at 1:00 & 13:00
`->weekly();`  |  Run the task every sunday at 00:00
`->weeklyOn(1, '8:00' );`  |  Run the task every week on Monday at 8:00
`->monthly();`  |  Run the task on the first day of every month at 00:00
`->monthlyOn(4, '15:00' );`  |  Run the task every month on the 4th at 15:00
`->monthlyOnLastDay( '15:00' );` | Run the task on the last day of the month at 15:00
`->quarterly();` |  Run the task on the first day of every quarter at 00:00
`->yearly();`  |  Run the task on the first day of every year at 00:00
`->timezone( 'America/New_York' );` | Set the timezone

These methods may be combined with additional constraints to create even more
finely tuned schedules that only run on certain days of the week. For example,
to schedule a command to run weekly on Monday:

```php
// Run once per week on Monday at 1 PM...
$schedule->call( function () {
    //
} )->weekly()->mondays()->at( '13:00' );

// Run hourly from 8 AM to 5 PM on weekdays...
$schedule->command( Example_Command::class )
  ->weekdays()
  ->hourly()
  ->timezone( 'America/Chicago' )
  ->between( '8:00', '17:00' );
```

Below is a list of the additional schedule constraints:

Method  | Description
------------- | -------------
`->weekdays();`  |  Limit the task to weekdays
`->weekends();`  |  Limit the task to weekends
`->sundays();`  |  Limit the task to Sunday
`->mondays();`  |  Limit the task to Monday
`->tuesdays();`  |  Limit the task to Tuesday
`->wednesdays();`  |  Limit the task to Wednesday
`->thursdays();`  |  Limit the task to Thursday
`->fridays();`  |  Limit the task to Friday
`->saturdays();`  |  Limit the task to Saturday
`->days( array|mixed );`  |  Limit the task to specific days
`->between( $start, $end                                                    );`  |  Limit the task to run between start and end times
`->when( Closure );`  |  Limit the task based on a truth test
`->environments($env);`  |  Limit the task to specific environments, accepts multiple environments as additional arguments.

#### Day Constraints

The `days` method may be used to limit the execution of a task to specific days
of the week. For example, you may schedule a command to run hourly on Sundays
and Wednesdays:

```php
$schedule->command( Example_Command::class )
  ->hourly()
  ->days([0, 3]);
```

#### Between Time Constraints

The `between` method may be used to limit the execution of a task based on the
time of day:

```php
$schedule->command( Example_Command::class )
  ->hourly()
  ->between( '7:00', '22:00' );
```

Similarly, the `unlessBetween` method can be used to exclude the execution of a
task for a period of time:

```php
$schedule->command( Example_Command::class )
  ->hourly()
  ->unlessBetween( '23:00', '4:00' );
  ```

#### Truth Test Constraints

The `when` method may be used to limit the execution of a task based on the
result of a given truth test. In other words, if the given `Closure` returns
`true`, the task will execute as long as no other constraining conditions
prevent the task from running:

```php
$schedule->command( Example_Command::class )
  ->daily()
  ->when( function () {
      return true;
  } );
```

The `skip` method may be seen as the inverse of `when`. If the `skip` method
returns `true`, the scheduled task will not be executed:

```php
$schedule->command( Example_Command::class )
  ->daily()
  ->skip( function () {
    return true;
  } );
```

When using chained `when` methods, the scheduled command will only execute if
all `when` conditions return `true`.

#### Environment Constraints

The `environments` method may be used to execute tasks only on the given
environments:

```php
$schedule->command( Example_Command::class )
  ->daily()
  ->environments( 'staging', 'production' );
```

## Future Plans
In the future we plan on adding in additional protection for task overlapping
and task concurrency.
