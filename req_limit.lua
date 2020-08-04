--- lua脚本限流
local max = tonumber(ARGV[1])
local interval_milliseconds = tonumber(ARGV[2])
--- 获取当前值，找不到就设置为0
local current = tonumber(redis.call('get', KEYS[1]) or 0)
print {KEYS[1],ARGV[1],ARGV[2]}

--- 限流判断，访问次数+1大于max表示超过最大访问次数
if (current + 1 > max) then
    return true
    --- return current
else
    --- 访问次数+1
    redis.call('incrby', KEYS[1], 1)
    --- 如果没有访问过，设置过期时间
    if (current == 0) then
        redis.call('pexpire', KEYS[1], interval_milliseconds)
    end
    return false
    --- return {current,max}
end
