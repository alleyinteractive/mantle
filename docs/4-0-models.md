Models
======

Models provide a fluent way to interface with objects in WordPress. Models can be either a post type, a term, or a subset of a post type! Models can also allow dynamic registration of a post type, REST API fields, and more. To make life easier for developers, Mantle models were designed with uniformity in mind

## Generating a Model
Models can be generated through the `wp-cli` command:

```bash
wp mantle make:model <name> --model_type=<model_type> [--registrable] [--object_name] [--label_singular] [--label_plural]
```

## Defining a Model

Models live in the `app/models` folder under the `App\Models` namespace.

### Example Post Model

```php
/**
 * Example_Model class file.
 *
 * @package App\Models
 */

namespace App\Models;

use Mantle\Framework\Database\Model\Post;

/**
 * Example_Model Model.
 */
class Example_Model extends Post {
	/**
	 * Post Type
	 *
	 * @var string
	 */
	public static $object_name = 'example-model';
}
```

### Example Term Model

```php
/**
 * Example_Model class file.
 *
 * @package App\Models
 */

namespace App\Models;

use Mantle\Framework\Database\Model\Term;

/**
 * Example_Model Model.
 */
class Example_Model extends Term {
	/**
	 * Term Type
	 *
	 * @var string
	 */
	public static $object_name = 'example-model';
}
```

## Interacting with Models

### Core Object

## Events
