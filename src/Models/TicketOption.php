<?php

namespace Sdkcodes\LaraTicket\Models;

use Illuminate\Database\Eloquent\Model;

class TicketOption extends Model
{
    protected $fillable = ['key', 'values'];
    public static function getCategories()
    {
        $first = static::where('key', 'categories')->first();
        $categories = $first ? explode("\n", $first->values) : [];
        return array_map("trim", $categories);
    }

    public static function getPriorities()
    {
        $first = static::where('key', 'priorities')->first();
        $priorities = $first ? explode("\n", $first->values) : [];
        return array_map("trim", $priorities);
    }
}
