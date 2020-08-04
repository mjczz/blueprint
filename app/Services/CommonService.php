<?php
/**
 * Created by czz.
 * User: czz
 * Date: 2020/6/25
 * Time: 0:47
 */

namespace App\Services;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

class CommonService
{
    /**
     * 获取数据字典
     *
     * @param null $key
     *
     * @return array|mixed
     */
    public static function getOptions($key = null)
    {
        $options = [
            'news_top' => [
                '1' => '是',
                '2' => '否'
            ],
            'news_recommend' => [
                '1' => '是',
                '2' => '否'
            ],
            'news_type' => [
                '1' => '文字新闻',
                '2' => '图片新闻'
            ],
            'publish_status' => [
                '1' => '是',
                '2' => '否'
            ],
        ];

        if (isset($key)) return !empty($options[$key]) ? $options[$key] : [];

        return $options;
    }

    /**
     * 列举相同前缀的命令
     *
     * @param $prefix
     *
     * @return array
     */
    public static function listKeyCommands($prefix)
    {
        return collect(Artisan::all())->mapWithKeys(function ($command, $key) use ($prefix) {
            if (Str::startsWith($key, $prefix)) {
                return [$key => $command];
            }

            return [];
        })->toArray();
    }

    /**
     * @param (Command|string)[] $commands
     *
     * @return int
     */
    public static function getColumnWidth(array $commands)
    {
        $widths = [];

        foreach ($commands as $command) {
            $widths[] = self::strlen($command->getName());
            foreach ($command->getAliases() as $alias) {
                $widths[] = self::strlen($alias);
            }
        }

        return $widths ? max($widths) + 2 : 0;
    }

    /**
     * Returns the length of a string, using mb_strwidth if it is available.
     *
     * @param string $string The string to check its length
     *
     * @return int The length of the string
     */
    public static function strlen($string)
    {
        if (false === $encoding = mb_detect_encoding($string, null, true)) {
            return strlen($string);
        }

        return mb_strwidth($string, $encoding);
    }

    /**
     * @param     $key
     * @param int $expireTime 过期时间
     * @param int $maxRequestTimes 最大访问次数
     */
    public static function limitRequest($key, $expireTime = 1000, $maxRequestTimes = 1)
    {
        $redis = new \Redis();
        $redis->connect(env('REDIS_HOST'), env('REDIS_PORT'));
        $redis->auth(env('REDIS_PASSWORD'));

        $script = <<<LUA
local max = tonumber(ARGV[1])
local interval_milliseconds = tonumber(ARGV[2])
--- 获取当前值，找不到就设置为0
local current = tonumber(redis.call('get', KEYS[1]) or 0)
print {KEYS[1],ARGV[1],ARGV[2]}
print {"当前访问次数：",current,"最大访问次数：",max,"过期时间：",interval_milliseconds}

--- 限流判断，访问次数+1大于max表示超过最大访问次数
if (current + 1 > max) then
    return current + 1
else
--- 访问次数+1
    redis.call('incrby', KEYS[1], 1)
--- 如果没有访问过，设置过期时间
    if (current == 0) then
        redis.call('pexpire', KEYS[1], interval_milliseconds)
    end
    return false
end
LUA;

        $numKeys = 1; // numKeys指定KEYS数量，其余参数存放在ARGV里
        return $redis->eval($script, [$key, $maxRequestTimes, $expireTime], $numKeys);
    }

    /**
     * 扣库存
     *
     * @param $key
     * @param $decrNum
     *
     * @return mixed
     */
    public static function decrStock($key, $decrNum)
    {
        $redis = new \Redis();
        $redis->connect(env('REDIS_HOST'), env('REDIS_PORT'));
        $redis->auth(env('REDIS_PASSWORD'));

        $script = <<<LUA
--- 要扣除的库存
local decr_num = tonumber(ARGV[1])

--- 获取当前值，找不到就设置为0
local stock = tonumber(redis.call('get', KEYS[1]) or 0)
if (stock == 0) then
    return false
end

--- 库存不足
if (stock - decr_num < 0) then
    return false
end

-- 扣库存操作
return redis.call('decrby', KEYS[1], decr_num)
LUA;

        $numKeys = 1; // numKeys指定KEYS数量，其余参数存放在ARGV里
        return $redis->eval($script, [$key, $decrNum], $numKeys);
    }

}
