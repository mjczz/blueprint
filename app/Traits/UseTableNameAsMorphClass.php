<?php
/**
 * Created by czz.
 * User: czz
 * Date: 2020/6/25
 * Time: 12:24
 */

namespace App\Traits;

trait UseTableNameAsMorphClass
{
    public function getMorphClass()
    {
        return $this->getTable();
    }
}
