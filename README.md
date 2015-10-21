O2Cache
=====
[O2Cache][3] is an Open Source Cache Management Driver Library. 
Wrappers around some of the most popular forms of fast and dynamic caching. 
All but file-based caching require specific server requirements, and a Fatal Exception will be thrown if server requirements are not met. 
Another amazing product from [PT. Lingkar Kreasi (Circle Creative)][1], released under MIT License.

[O2Cache][3] is build for working more powerfull with O2System Framework, but also can be used for integrated with others as standalone version with limited features.

[O2Cache][3] not just created on the fly but also store the tables information schema into database, it will become very useful in the future.

[O2Cache][3] is insipired by [CodeIgniter][10] Cache Driver, so [O2Cache][3] is has also functionality similar with them, but a little bit different at the syntax.

Installation
------------
The best way to install O2Cache is to use [Composer][9]
```
composer require o2system/o2cache:'dev-master'
```

Usage
-----
```php
// Without Fallback Driver
$cache = new \O2System\Cache(['driver' => 'redis']);

// With Fallback Driver
$cache = new \O2System\Cache(array(
    'storage' => ['driver' => 'redis'],
    'fallback' => ['driver' => 'files']
));

// 5 Minutes Redis Cache
if( ! $foo = $cache->get('foo') )
{
  echo 'Saving to the cache!<br />';
  $foo = 'foobar!';

  // Save into the cache for 5 minutes
  $cache->save('foo', $foo, 300);
}

// Static Redis Cache
if( ! $forever = $cache->get('forever') )
{
  echo 'Saving to the cache!<br />';
  $forever = 'static cache';

  // Save into the cache forever
  $cache->save('forever', $forever, FALSE);
}
```

More details at the Wiki. (Coming Soon)

Ideas and Suggestions
---------------------
Please kindly mail us at [developer@o2system.in][7].

Bugs and Issues
---------------
Please kindly submit your [issues at Github][5] so we can track all the issues along development.

System Requirements
-------------------
- PHP 5.4+
- PHP Extension Memcached (Optional)
- PHP Extension Redis (Optional)
- PHP Extension Wincache (Optional)
- PHP Extension APC (Optional)
- [Composer][9]

Credits
-------
* Founder and Lead Projects: [Steeven Andrian Salim (steevenz.com)][7]

[1]: http://circle-creative.com
[2]: http://o2system.in
[3]: http://o2system.in/features/standalone/o2cache
[4]: http://o2system.in/features/standalone/o2cache/license
[5]: http://github.com/circlecreative/o2cache/issues
[6]: https://packagist.org/packages/o2system/o2cache
[7]: http://steevenz.com
[8]: mailto:developer@o2system.in
[9]: https://getcomposer.org
[10]: http://codeigniter.com
