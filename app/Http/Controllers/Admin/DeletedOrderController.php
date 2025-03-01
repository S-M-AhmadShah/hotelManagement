<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DeletedOrder;

class DeletedOrderController extends Controller
{
    public function index()
{
    $deletedOrders = DeletedOrder::latest()->paginate(10);

    return view('admin.deleted_orders.index', compact('deletedOrders'));
}

}
