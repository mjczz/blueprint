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
                $closure($key, $lock, Carbon::now());
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

    /**
     * set命令加锁
     *
     * 问题：
     * 1、redis发现锁失败了要怎么办？中断请求还是循环请求？
     * 2、循环请求的话，如果有一个获取了锁，其它的再去获取锁的时候，是不是容易发生抢锁的可能？
     * 3、锁提前过期后，客户端A还没执行完，然后客户端B获取到了锁，这时候客户端A执行完了，会不会在删锁的时候把B的锁给删掉？
     */
    public static function actionInLock($key = 'lock_key', \Closure $closure, $timeout = 10)
    {
        // 针对问题1，使用循环
        while (true) {
            $value = 'room_'.rand(1,100).time(); // 分配一个随机的值针对问题3

            // 获取锁
            $isLock = \Redis::set($key, $value, 'ex', $timeout, 'nx'); // ex 秒

            // 睡眠，降低抢锁频率，缓解redis压力，针对问题2
            if (!$isLock) {
                usleep(5000);
                continue;
            }

            if (\Redis::get($key) == $value) { // 防止提前过期，误删其它请求创建的锁
                try {
                    // 业务逻辑
                    $closure($key, $value);
                } catch (\Throwable $e) {
                    Log::error($e->getMessage());
                } finally {
                    \Redis::del($key);
                    return; // 执行成功删除key并跳出循环
                }
            }
        }
    }
}
