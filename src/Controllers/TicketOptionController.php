<?php

namespace Sdkcodes\LaraTicket\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Sdkcodes\LaraTicket\Models\TicketOption;

class TicketOptionController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            "categories" => "required|string",
            "priorities" => "required|string"
        ]);

        $categories = str_replace("\r\n", "\n", strip_tags($request->categories));
        $priorities = str_replace("\r\n", "\n", strip_tags($request->priorities));

        TicketOption::updateOrCreate(['key' => 'categories'], ['values' => $categories]);
        TicketOption::updateOrCreate(['key' => 'priorities'], ['values' => $priorities]);

        return back()->with(['status' => 'success', 'message' => "Ticket options updated successfully"]);
    }

    public function options(TicketOption $option)
    {
        $data['categories'] = $option->getCategories();
        $data['priorities'] = $option->getPriorities();
        return view('laraticket::admin.options', $data);
    }
}
