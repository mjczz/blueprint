<?php
/**
 * Created by czz.
 * User: czz
 * Date: 2020/8/3
 * Time: 10:38
 */

namespace App\Services;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

class RedisRedlockService
{
    protected static $redlock = null;

    public static function getRedLockIns()
    {
        if (self::$redlock == null) {
            $server = new \Redis;
            $server->connect(env('REDIS_HOST'), env('REDIS_PORT'), 1);
            $server->auth(env('REDIS_PASSWORD'));
            $servers = [$server];

            foreach (config('redlock.servers') as $item) {
                $servers[] = $item;
            }

            self::$redlock = new \RedLock\RedLock($servers);
        }

        return self::$redlock;
    }


    /**
     * To acquire a lock:
     *
     * @param     $key
     * @param int $ttl
     * @return array|bool
     */
    public static function lock($key, $ttl = 1000)
    {
        return self::getRedLockIns()->lock($key, $ttl);
    }


    /**
     * To release a lock:
     *
     * @param $lock
     * @return bool
     */
    public static function unlock($lock)
    {
        return self::getRedLockIns()->unlock($lock);
    }

    /**
     * redis分布式锁
     *
     * @param string   $key
     * @param int      $ttl
     * @param \Closure $closure
     *
     * @return bool
     */
    public static function distributionLock($key = 'my_resource_name', $ttl = 1000, \Closure $closure)
    {
        while (true) {
            // 获得锁
            $lock = self::lock($key, $ttl);

            // 获得锁失败，重试
            if ($lock == false) {
                sleep(1);
                continue;
            };

            try {
                $closure($lock, Carbon::now());
                return;
            } catch(\Throwable $e) {
                Log::info($e->getMessage());
                return;
            } finally {
                self::unlock($lock);
                return;
            }
        }
    }

}
