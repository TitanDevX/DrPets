<?php

namespace App\Services;

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\OrderProvider;
use Illuminate\Support\Facades\Log;


class OrderService
{
    public function __construct(
        protected CartService $cartService,
        protected NotificationService $notificationService,
        protected UserService $userService,
    ) {
    }
    public function all($user, $withes = [], $paginated = true)
    {
        $orders = Order::where('user_id', '=', $user->id);

        $allowedRelationships = ['user', 'providers', 'products', 'orderProducts', 'orderProviders'];


        if ($withes != null) {
            $relations = collect($withes)
                ->intersect($allowedRelationships)
                ->all();
            $orders = $orders->with($relations);
        }
        if ($paginated) {
            return $orders->paginate();
        } else {
            return $orders->get();
        }

    }

    public function storeOrder($user, $carts, $invoice)
    {

        $order = Order::create([
            'user_id' => $user->id,
            'invoice_id' => $invoice->id
        ]);

        $carts->each(function ($cart) use ($order) {

            $prod = $cart->product;
            OrderProduct::create([
                'order_id' => $order->id,
                'product_id' => $prod->id,
                'price' => $prod->price,
                'quantity' => $cart->quantity,
                'notes' => $cart->notes
            ]);

        });
        $cartsByProvider = $this->cartService->groupCartsByProvider($carts);
        $cartsByProvider->each(function ($carts, $providerId) use ($order) {
            OrderProvider::create([
                'order_id' => $order->id,
                'provider_id' => $providerId,
            ]);
        });

        return $order;

    }

    public function activateOrder($order)
    {

        $order->status = OrderStatus::IN_PREPARATION;
        $order->save();
        foreach ($order->orderProviders as $orderProvider) {
            $orderProvider->status = OrderStatus::IN_PREPARATION;
            $orderProvider->save();
        }

    }

    public function updateProviderStatus($provider, $order, OrderStatus $newStatus)
    {
        if ($order->status == $newStatus)
            return;
        $orderProvider = $order->orderProviders()->where('provider_id', '=', $provider->id)->first();

        $orderProvider->update([
            'status' => $newStatus
        ]);
        $flag = true;
        foreach ($order->orderProviders as $op) {
            if ($op->status != $newStatus->value) {
                $flag = false;

            }

        }
        if ($flag) {
            $order->update([
                'status' => $newStatus
            ]);
            if ($newStatus == OrderStatus::DELIVERED) {
                $user = $order->user;
                $this->userService->increaseRatingLimit($user);
                $this->notificationService->send($user->fcm_token, [
                    __('notif.order_delivered_title'),
                    __('notif.order_delivered_body')
                ], [
                    'order_id' => $order->id
                ]);
                


            }
        }
    }
    public function showOrder($id)
    {
    }
    public function deleteOrder($id)
    {
    }
}