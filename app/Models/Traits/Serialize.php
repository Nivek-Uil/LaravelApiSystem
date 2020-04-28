<?php
namespace App\Models\Traits;

use DateTimeInterface;

trait Serialize {

    /**
     * 解决Laravel 7.0+ 【在 Eloquent 模型上使用 toArray 或 toJson 方法时，Laravel 7 将使用新的日期序列化格式】的问题
     * @param DateTimeInterface $date
     * @return string
     */
    public function serializeDate(DateTimeInterface $date)
    {
        return $date->format($this->dateFormat ?: 'Y-m-d H:i:s');
    }
}
