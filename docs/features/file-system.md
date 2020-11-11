# File System

[[toc]]

Mantle includes the [Flysystem](https://github.com/thephpleague/flysystem)
package to power an abstract interface to various local and remote filesystems.
Files can exist local on the disk (inside the normal `wp-content/uploads`
folder), on a FTP server, or in a S3 bucket. The API remains the same for all
drivers, allowing a fluent interface to storing a file in a remote bucket with
only a few lines of configuration.

## Configuration

The configuration for the filesystem lives in `config/filesystem.php`. This file
will contain the "disks" that you can access as well as the "disk's" driver. For
example, a application can have multiple S3 disks that all use the 's3' driver.
The disk can reference a different bucket set of configuration for the same driver.

You may configure as many disks as you like, and may even have multiple disks
that use the same driver.

## Local Storage

By default, the application will use the local storage disk/driver. This will
store files in WordPress' upload directory. Storage of files here will always be
assumed to be public.

```php
Storage::put( 'file.txt', 'Contents' );
Storage::drive( 'local' )->put( 'file.txt', 'Contents' );
```

## Remote Storage

The filesystem can store files with any adapter that Flysystem supports. Out of
the box, Mantle supports the FTP and S3 adapter.

### Composer Dependency

Before using the SFTP or S3 drivers, you will need to install the appropriate package via Composer:

* SFTP: `league/flysystem-sftp ~1.0`
* Amazon S3: `league/flysystem-aws-s3-v3 ~1.0`

### Configuration

The S3/FTP configuration is located int he `config/filesystem.php` file. To use
the S3/FTP disk you need to fill in your own S3/FTP configuration and
credentials.

## Caching

To enable caching for a given disk, you may add a cache directive to the disk's
configuration options. The cache option should be an array of caching options
containing the disk name, the expire time in seconds, and the cache prefix:

```php
's3' => [
  'driver' => 's3',

  // Other Disk Options...

  'cache' => [
    'store' => 'memcached',
    'expire' => 600,
    'prefix' => 'cache-prefix',
  ],
],
```

## Obtaining Disk Instances

The `Storage` facade may be used to interact with any of your configured disks.
For example, you may use the put method on the facade to store an avatar on the
default disk. If you call methods on the Storage facade without first calling
the disk method, the method call will automatically be passed to the default
disk:

```php
use Mantle\Framework\Facade\Storage;

Storage::put( 'avatars/1', $file_contents );
```

If your application interacts with multiple disks, you may use the disk method
on the `Storage` facade to work with files on a particular disk:

```php
Storage::drive( 's3' )->put( 'avatars/1', $file_contents );
```

## Storing Files

Files can be stored using the `put()` method by passing either file contents or
a file stream.

```php
use Mantle\Framework\Facade\Storage;

Storage::put( 'avatars/1', $file_contents );
```

You can upload a local file with the `put_file()` method. Use the `put_file_as`
to specify a name.

```php
use Mantle\Framework\Facade\Storage;

Storage::put_file( '/path/to/store', '/var/local.jpg' );
```

### File Uploads

Files can be uploaded directly from HTTP requests to any storage disk.

```php
namespace App\Http\Controller;

use Mantle\Framework\Http\Controller;
use Mantle\Framework\Http\Request;

class Photo_Controller extends Controller {
	public function __invoke( Request $request ) {
		$path = $request->file( 'avatar' )->store( 'disk-name' );

		return $path;
	}
}
```

You can also use the `Storage` facade directly.

```php
use Mantle\Framework\Facade\Storage;

Storage::put_file( 'avatars', $request->file( 'avatar' ) );
```

### File Visibility

By default files will assume to be stored publicly. All local files will be
stored publicly out of the box, too. You can use a remote disk such as S3 to
store a file privately.

::: tip
To add a private local disk, add a disk and specify a path to a private folder.
:::

```php
use Mantle\Framework\Facade\Storage;

Storage::put( 'file.jpg', $contents, 'public' );
```

You can store a private file by changing the third argument.

```php
use Mantle\Framework\Facade\Storage;

Storage::disk( 's3' )->put( 'file.jpg', $contents, 'private' );
Storage::disk( 's3' )->put( 'file.jpg', $contents, [ 'visibility' => 'private' ] );
```

## Retrieving Files

Files can be retrieved using the `Storage` facade.

```php
use Mantle\Framework\Facade\Storage;

$path = Storage::url( '/path/to/file.jpg' );
```

### Retrieving Private Files

Private files commonly need to use a temporary URL to retrieve the file. For a
private file on S3, Mantle can generate a temporary S3 URL.

```php
$url = Storage::disk( 's3' )->temporary_url( '/path/to/file.jpg' );
```
