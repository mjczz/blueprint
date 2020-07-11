<?php
/**
 * Created by czz.
 * User: czz
 * Date: 2020/6/25
 * Time: 15:32
 */

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    /**
     * 为数组/ JSON序列化准备一个日期。
     *
     * @param  \DateTimeInterface  $date
     * @return string
     */
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

}
