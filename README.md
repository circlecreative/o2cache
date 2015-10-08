O2Cache
=====
[O2Cache][2] is an Open Source Cache Management Driver. Wrappers around some of the most popular forms of fast and dynamic caching. All but file-based caching require specific server requirements, and a Fatal Exception will be thrown if server requirements are not met. Another amazing product from [PT. Lingkar Kreasi (Circle Creative)][1], released under MIT License.

[O2Cache][2] is build for working more powerfull with O2System Framework, but also can be used for integrated with others as standalone version with limited features.

[O2Cache][2] not just created on the fly but also store the tables information schema into database, it will become very useful in the future.

[O2Cache][2] is insipired by [CodeIgniter][3] Cache Driver, so [O2Cache][2] is has also functionality similar with them, but a little bit different at the syntax.

Installation
------------
The best way to install O2Cache is to use [Composer][8]
```
composer require o2system/o2cache:'dev-master'
```

Usage
-----
```
$cache = new \O2System\Cache;
$redis = $cache->setup(['driver' => 'redis']);

// 5 Minutes Redis Cache
if( ! $foo = $redis->get('foo') )
{
  echo 'Saving to the cache!<br />';
  $foo = 'foobar!';

  // Save into the cache for 5 minutes
  $redis->save('foo', $foo, 300);
}

// Static Redis Cache
if( ! $forever = $redis->get('forever') )
{
  echo 'Saving to the cache!<br />';
  $forever = 'static cache';

  // Save into the cache forever
  $redis->save('forever', $forever, FALSE);
}
```

More details at the Wiki. (Coming Soon)

Ideas and Suggestions
---------------------
Please kindly mail us at [developer@circle-creative.com][5] or [steeven@circle-creative.com][6].

Bugs and Issues
---------------
Please kindly submit your issues at Github so we can track all the issues along development.

System Requirements
-------------------
- PHP 5.4+
- PHP Extension Memcached (Optional)
- PHP Extension Redis (Optional)
- PHP Extension Wincache (Optional)
- PHP Extension APC (Optional)
- Composer

Credits
-------
* Founder and Lead Projects: [Steeven Andrian Salim (steevenz.com)][4]

[1]: http://www.circle-creative.com
[2]: http://www.circle-creative.com/products/o2cache
[3]: http://www.codeigniter.com
[4]: http://www.steevenz.com
[5]: mailto:developer@circle-creative.com
[6]: mailto:steeven@circle-creative.com
[7]: https://packagist.org/packages/o2system/o2cache
[8]: https://getcomposer.org
