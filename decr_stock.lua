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
