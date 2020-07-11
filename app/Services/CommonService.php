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


}
