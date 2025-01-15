<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// Use your actual Pizza model if you want to retrieve from DB
use App\Models\Pizza;

class PizzaController extends Controller
{
    /**
     * Display the Pizza Page with a list of best-selling pizzas.
     */
    public function home()
    {
        // Static list of best-selling pizzas (no 'image' key)
        $pizzas = Pizza::all();

        // Return the 'pizza.blade.php' view with $pizzas
        return view('home', compact('pizzas'));
    }

    /**
     * Add a pizza to the session-based cart/basket.
     */
    public function addToCart($id, Request $request)
    {
        // Retrieve or create an empty cart
        $cart = session()->get('cart', []);

        $pizzas = $this->getPizzaList();

        // Validate pizza ID
        if (!array_key_exists($id, $pizzas)) {
            return redirect()->back()->with('error', 'Pizza not found!');
        }

        $pizza = $pizzas[$id];

        // If pizza is already in the cart, increment quantity. Otherwise, add it new.
        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                'id'       => $pizza['id'],
                'name'     => $pizza['name'],
                'price'    => $pizza['price'],
                'quantity' => 1,
            ];
        }

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Pizza added to the basket!');
    }

    /**
     * Update the quantity of a pizza in the cart.
     */
    public function updateCart($id, Request $request)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $cart = session()->get('cart', []);

        // If the pizza isn't in the cart, show an error
        if (!isset($cart[$id])) {
            return redirect()->back()->with('error', 'Item not found in the basket!');
        }

        // Update quantity
        $cart[$id]['quantity'] = $request->input('quantity');
        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Basket updated successfully!');
    }

    /**
     * Remove a pizza from the cart entirely.
     */
    public function removeFromCart($id)
    {
        $cart = session()->get('cart', []);

        // If the pizza is in the cart, remove it
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);

            return redirect()->back()->with('success', 'Item removed from basket.');
        }

        return redirect()->back()->with('error', 'Item not found in the basket!');
    }

    /**
     * Helper method: Returns pizzas keyed by ID (no images).
     */
    private function getPizzaList()
    {
        return [
            1 => [
                'id'          => 1,
                'name'        => 'Margherita',
                'description' => 'Classic delight with 100% mozzarella cheese',
                'price'       => 8.99
            ],
            2 => [
                'id'          => 2,
                'name'        => 'Pepperoni',
                'description' => 'Loaded with pepperoni & extra cheese',
                'price'       => 10.99
            ],
            3 => [
                'id'          => 3,
                'name'        => 'BBQ Chicken',
                'description' => 'Smoky BBQ sauce topped with grilled chicken',
                'price'       => 12.99
            ],
            4 => [
                'id'          => 4,
                'name'        => 'Veggie Supreme',
                'description' => 'Crunchy bell peppers, fresh tomatoes & olives',
                'price'       => 9.99
            ],
            5 => [
                'id'          => 5,
                'name'        => 'Hawaiian',
                'description' => 'Juicy pineapple chunks and ham',
                'price'       => 11.99
            ],
            6 => [
                'id'          => 6,
                'name'        => 'Four Cheese',
                'description' => 'A cheese lover’s dream: mozzarella, cheddar, feta & gouda',
                'price'       => 13.99
            ],
        ];
    }
}
