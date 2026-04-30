<?php

namespace App\Services;

use App\DTOs\CartInput;
use App\Models\Book;
use App\Models\Cart;
use App\Exception\QuantityException;

class CartService
{
    public function addToCart(CartInput $input)
    {
        $book = Book::findOrFail($input->book_id);
        $cart = Cart::where('user_id', $input->user_id)
            ->where('book_id', $input->book_id)
            ->first();
        if ($cart) {
            $this->checkProductQuantityAndIncreaseIt($cart, $input->quantity);
        } else {
            $this->createCartItem($book, $input);
        }
    }

    private function checkProductQuantityAndIncreaseIt(Cart $cart, int $quantity)
    {
        $productLimit = $cart->book->stock;
        if ($cart->quantity + $quantity > $productLimit) {
            throw new QuantityException("Product quantity is not enough");
        }

        $cart->quantity += $quantity;
        $cart->price = $cart->book->price * $cart->quantity;
        $cart->save();
    }

    private function createCartItem(Book $book, CartInput $input): Cart
    {
        if ($input->quantity > $book->stock) {
            throw new QuantityException("Book quantity is not enough");
        }

        $cart = new Cart();
        $cart->user_id = $input->user_id;
        $cart->book_id = $input->book_id;
        $cart->quantity = $input->quantity;
        $cart->price = $book->price * $input->quantity;
        $cart->save();
        return $cart;
    }

    public function getCart()
    {
        return Cart::where('user_id', auth()->user()->id)->get();
    }
}