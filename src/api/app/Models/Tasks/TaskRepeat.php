<?php


namespace App\Models\Tasks;


class TaskRepeat
{
    public static string
        $DAILY = 'daily', // 毎日 決まった時間
        $WEEKLY = 'weekly', // 毎週 決まった曜日
        $DATE_PER_MONTH = 'date_per_month', // 毎月 決まった日付
        $END_OF_MONTH = 'end_of_month', // 月末
        $DAY_OF_WEEK_PER_MONTH = 'day_of_week_per_month', // 毎月 決まった第n週 X曜日
        $YEARLY = 'yearly';
}
