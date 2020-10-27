<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\Budget;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // $this->authorizeResource(Order::class, 'order');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $status = Order::STATUS;

        // Validar se os filtros constam na constante status de order
        $validate = $request->validate([
            'filter.*' => [ Rule::in(array_keys($status)) ]
        ]);

        if ($request->missing('filter')) {
            $filter[] = 'C';
        } else {
            $filter = $request->input('filter');
        }
        $orders = Order::whereIn('status', $filter )->with('user')->with('budget')->paginate(8);
         return view('order.list', [
            'orders' => $orders,
            'status' => $status,
            'filter' => $filter
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
        $this->validateOrder();
        $order = new Order();
        $order->user()->associate(Auth::user());
        $order->description = $request->input('description');
        $order->budget_id = $request->input('budget');
        $order->save();
        return redirect()->route('ticket.create', [ 'order' => $order]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        // dd($order);
        $this->authorize('view', $order);
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
        $this->authorize('update', $order);
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
        $this->authorize('update', $order);
        $this->validateOrder();
        $order->description = $request->input('description');
        $order->budget_id = $request->input('budget');
        $order->save();
        return redirect($order->path());

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        $this->authorize('delete', $order);
        $order->delete();
        return redirect()->route('orders.my');
    }

    public function mySolicitations()
    {
        $orders = Order::where('user_id', Auth::id())
                    ->with('user')
                    ->with('budget')
                    ->orderBy('status')
                    ->paginate(8);
        return view('order.list', [
            'orders' => $orders
        ]);
    }

    protected function validateOrder()
    {
        return request()->validate([
            'description' => 'required',
            'budget' => 'required|exists:budgets,id'
        ]);
    }

    public function toFinancer(Order $order)
    {
        $this->authorize('update', $order);
        $order->status = 'C';
        $order->save();
        return redirect()->route('orders.my');
    }
}
