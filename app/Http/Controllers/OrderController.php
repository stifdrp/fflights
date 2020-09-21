<?php

namespace App\Http\Controllers;

use App\Budget;
use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $filter = array();
        $filter[] = 'F';
        $orders = Order::whereNotIn('status', [ $filter ])->with('user')->with('budget')->paginate(8);
        return view('order.list', [
            'orders' => $orders
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $budgets = Budget::all();
        return view('order.create', [
            'budgets' => $budgets,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'description' => 'required',
            'budget' => 'required|exists:budgets,id'
            ]);
        $order = new Order();
        $order->user_id = Auth::user()->id;
        $order->description = $request->input('description');
        $order->budget_id = $request->input('budget');
        $order->save();
        return redirect()->route('home');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        $order->budget;
        $order->tickets;
        return view('order.show', [
            'order' => $order
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        $budgets = Budget::all();
        return view('order.edit', [
            'budgets' => $budgets,
            'order' => $order
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
