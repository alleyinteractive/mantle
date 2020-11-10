# Hooks

[[toc]]

## Introduction

Mantle provides an interface for testing WordPress hooks in declarative and
assertive formats.

## Declaring Hook Usage

Inside your unit test declare the hooks you expect to fire, optionally
specifying the amount of times and the return values. Then run the subsequent
function you wish to unit test and Mantle will handle the assertions.

```php
$this->expectApplied( 'action_to_check' )
	->twice()
	->with( 'value_to_check', 'secondary_value_to_check' );
```

### Defining Count

Define how many times a hook was applied. You can specify the number of times
directly with `times()` or use `once()`, `twice()`, or `never()` instead.

```php
$this->expectApplied( 'action_to_check' )->twice();

do_action( 'action_to_check', 'value_to_check' );
do_action( 'action_to_check', 'value_to_check' );
```

### Defining Arguments

Define the arguments that you expect to be passed to the filter. These would be
the arguments passed to `do_action()`/`apply_filters()`/etc. at the start of the
hook.

```php
$this->expectApplied( 'filter_to_check' )
	->once()
	->with( 'value_to_check' );

apply_filters( 'filter_to_check', 'value_to_check' );
```

### Defining Return Value

Define the expected return value for the filter. Return values can be specified
using `andReturn(mixed $value)` or with some helper functions.

* `andReturn(mixed $value)`: Returns with the value of `$value`.
* `andReturnNull()`: Returns `null`.
* `andReturnFalse()`: Returns `false.`
* `andReturnTrue()`: Returns `true`.

```php
$this->expectApplied( 'falsey_filter_to_check' )
	->once()
	->andReturnFalse();

add_filter( 'falsey_filter_to_check', '__return_false' );
apply_filters( 'falsey_filter_to_check', true );
```

## Asserting Hook Usage

Hooks can be asserted against after they have already been applied. This can be
used interchangeably. No setup or declarations are required.

```php
$this->assertHookApplied( 'the_hook', 2 );
$this->assertHookNotApplied( 'the_hook_that_didnt_run' );
```
