<?php

namespace Laracommerce\Core\Orders\Repositories;

use Laracommerce\Core\Base\BaseRepository;
use Laracommerce\Core\Orders\Events\OrderCreateEvent;
use Laracommerce\Core\Orders\Exceptions\OrderInvalidArgumentException;
use Laracommerce\Core\Orders\Exceptions\OrderNotFoundException;
use Laracommerce\Core\Orders\Order;
use Laracommerce\Core\Orders\Repositories\Interfaces\OrderRepositoryInterface;
use Laracommerce\Core\Orders\Transformers\OrderTransformable;
use Laracommerce\Core\Products\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;

class OrderRepository extends BaseRepository implements OrderRepositoryInterface
{
    use OrderTransformable;

    /**
     * OrderRepository constructor.
     * @param Order $order
     */
    public function __construct(Order $order)
    {
        parent::__construct($order);
        $this->model = $order;
    }

    /**
     * Create the order
     *
     * @param array $params
     * @return Order
     * @throws OrderInvalidArgumentException
     */
    public function createOrder(array $params) : Order
    {
        try {
            $order = $this->create($params);

            event(new OrderCreateEvent($order));

            return $order;
        } catch (QueryException $e) {
            throw new OrderInvalidArgumentException($e->getMessage(), 500, $e);
        }
    }

    /**
     * @param array $params
     * @return Order
     * @throws OrderInvalidArgumentException
     */
    public function updateOrder(array $params) : Order
    {
        try {
            $this->update($params, $this->model->id);
            return $this->find($this->model->id);
        } catch (QueryException $e) {
            throw new OrderInvalidArgumentException($e->getMessage());
        }
    }

    /**
     * @param int $id
     * @return Order
     * @throws OrderNotFoundException
     */
    public function findOrderById(int $id) : Order
    {
        try {
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new OrderNotFoundException($e->getMessage());
        }
    }


    /**
     * Return all the orders
     *
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return Collection
     */
    public function listOrders(string $order = 'id', string $sort = 'desc', array $columns = ['*']) : Collection
    {
        return $this->all($columns, $order, $sort);
    }

    /**
     * @param Order $order
     * @return mixed
     */
    public function findProducts(Order $order) : Collection
    {
        return $order->products;
    }

    /**
     * @param Product $product
     * @param int $quantity
     */
    public function associateProduct(Product $product, int $quantity = 1)
    {
        $this->model->products()->attach($product, ['quantity' => $quantity]);
        $product->quantity = ($product->quantity - $quantity);
        $product->save();
    }

    /**
     * @param string $text
     * @return mixed
     */
    public function searchOrder(string $text) : Collection
    {
        return $this->model->search(
            $text,
            [
                'products.name',
                'products.description',
                'customer.name',
                'reference'
            ]
        )->get();
    }

    /**
     * @return Order
     */
    public function transform()
    {
        return $this->transformOrder($this->model);
    }
}
