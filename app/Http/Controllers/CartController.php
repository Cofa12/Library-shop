<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartAddingRequest;
use App\Services\CartService;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Http\Resources\CartResource;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(
        private CartService $cartService
    ) {

    }

    public function addBookToCart(CartAddingRequest $request):Response
    {
        $input = $request->dto();
        $this->cartService->addToCart($input);

        return response()->json([
            'message' => 'Book added to cart successfully',
        ], Response::HTTP_OK);
    }

    public function getCart(): AnonymousResourceCollection
    {
        $cart = $this->cartService->getCart();
        return CartResource::collection($cart);
    }

    public function update(Request $request, $id): Response
    {
        $cartItem = \App\Models\Cart::findOrFail($id);
        if ($cartItem->user_id != auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], Response::HTTP_FORBIDDEN);
        }

        $quantity = $request->input('quantity');
        $cartItem->quantity = $quantity;
        $cartItem->price = $cartItem->book->price * $quantity;
        $cartItem->save();

        return response()->json(['message' => 'Cart updated successfully'], Response::HTTP_OK);
    }

    public function destroy($id): Response
    {
        $cartItem = \App\Models\Cart::findOrFail($id);
        if ($cartItem->user_id != auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], Response::HTTP_FORBIDDEN);
        }

        $cartItem->delete();
        return response()->json(['message' => 'Item removed from cart'], Response::HTTP_OK);
    }
}
