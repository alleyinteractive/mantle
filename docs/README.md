---
home: true
heroText: Mantle
heroImage: /logo.jpg
tagline: Mantle is a framework for building large, robust websites and applications with WordPress
actionText: Get Started →
actionLink: /getting-started/installation/
footer: Copyright © 2020-present Alley
---

<div class="features">
  <div class="feature">
    <h2>Simplicity First</h2>
    <p>Mantle believes that enterprise-level WordPress development is possible and should have a simple and delightful syntax.</p>
  </div>
  <div class="feature">
    <h2>Inspired by Laravel</h2>
    <p>Enjoy the flexibility of the Laravel Framework inside of WordPress with a baked-in WordPress integration.</p>
  </div>
  <div class="feature">
    <h2>Modern Toolkit</h2>
    <p>
      Includes a <a href="/models/models/">powerful ORM</a>, simple to use <a href="/basics/requests/">routing</a>,
			<a href="/basics/templating/">blade-powered templating</a>, and a <a href="/testing/testing/">fast independent testing library for WordPress</a> out of the box.
    </p>
  </div>
</div>

<div class="home-code">

```php
Route::get( '/blog/{post}', 'Post_Controller@show' );

Route::rest_api(
	'namespace/v1',
	'/route-to-use',
	function() {
		return [ ... ];
	}
);
```

```php
/**
 * Display the post.
 *
 * @param Post $post Post object.
 * @return Response
 */
public function show( Post $post ) {
	return response()->view( 'single' )
		->with( 'categories', $post->categories );
}
```

</div>

<div class="home-lower">

<div>

### [Flexible RESTful Routing](./basics/requests.md)

Use a Symfony-powered routing framework on top of WordPress to respond to
requests in your application. Respond to requests using native PHP or Blade templates, both supporting a set
of powerful template helpers to help DRY up your templates.

</div>

<div>

### [Interface with Data Models](./models/models.md)

Work with actual models to interact with data in your application. Mantle
streamlines WordPress development to provide a uniform interface to work with
core WordPress data structures. Define relationships between models and data
structures bringing WordPress into the 21st century.

</div>

<div>

### [Test Framework](./testing/test-framework.md)

Use the independent Mantle Test Framework to make writing unit tests simpler
than ever. Supports a drop-in replacement for WordPress core testing framework that will
run faster and allow IDE-friendly assertions. Runs PHPUnit 9.5+ out of the box.

</div>

</div>


<div class="goals">

Mantle is a heavily Laravel-inspired framework for improving the WordPress
developer experience. It aims to make the development process delightful for the
developer. WordPress can already accomplish great things out of the box. Mantle
aims to make it easier and simpler to use. Code should be fluent, reusable, easy
to read, testable, and delightful to work with.

[Get started here](./getting-started/installation.md) or visit our
[GitHub](https://github.com/alleyinteractive/mantle) to contribute.

</div>
