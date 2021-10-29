<?php

namespace Sdkcodes\LaraTicket\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Sdkcodes\LaraTicket\Models\TicketOption;

class TicketOptionController extends Controller
{
    public function store(Request $request)
    {
        $request->validate(
            [
            "categories" => "required|string",
            "priorities" => "required|string",
            ],
            [],
            [
            "categories" => __("Categories"),
            "priorities" => __("Priority")
            ]
        );

        $categories = str_replace(PHP_EOL, "\n", strip_tags($request->categories));
        $priorities = str_replace(PHP_EOL, "\n", strip_tags($request->priorities));

        TicketOption::updateOrCreate(['key' => 'categories'], ['values' => $categories]);
        TicketOption::updateOrCreate(['key' => 'priorities'], ['values' => $priorities]);

        return back()->with(['status' => 'success', 'message' => "Ticket options updated successfully"]);
    }

    public function options()
    {
        return view('laraticket::admin.options', [
        'categories' => implode(PHP_EOL, TicketOption::getCategories()),
        'priorities' => implode(PHP_EOL, TicketOption::getPriorities()),
        ]);
    }
}
