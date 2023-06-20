<?php

declare(strict_types=1);

namespace MyApp\Tasks;

use Phalcon\Cli\Task;

class CurrentTask extends Task
{
    public function mainAction()
    {
        echo 'This is the default task and the default action' . PHP_EOL;
    }
    public function orderAction($uid, $pid, $pname, $price, $quantity, $category)
    {
        $collection = $this->mongo->order;

        $data = $collection->insertOne([
            "pid" => $pid, "name" => $pname, "price" => $price, "uid" => $uid,
            "quantity" => $quantity, "category" => $category
        ]);
        print_r($data->getInsertedCount());
        echo 'Order placed ' . PHP_EOL;
        die;
    }
    public function productAction($pid, $pname, $price, $category)
    {
        $collection = $this->mongo->product;

        $data = $collection->insertOne(["pid" => $pid, "name" => $pname, "price" => $price, "category" => $category]);
        print_r($data->getInsertedCount());
        echo 'Inserted product ' . PHP_EOL;
        die;
    }
    public function recomAction($uid)
    {

        echo 'Product recommendations according to uid ' . PHP_EOL;
        $collection = $this->mongo->order;
        $data_ele = $collection->find(["uid" => $uid, "category" => "electronics"]);
        $cele = count(iterator_to_array($data_ele));
        $data_pla = $collection->find(["uid" => $uid, "category" => "plastic"]);
        $pla = count(iterator_to_array($data_pla));
        if ($cele > $pla) {
            $c = $this->mongo->product;
            $data = $collection->find(["category" => "electronics"]);
            foreach ($data as  $value) {
                print_r($value);
            }
        } else {
            $c = $this->mongo->product;
            $data = $collection->find(["category" => "plastic"]);
            foreach ($data as  $value) {
                print_r($value);
            }
        }

        echo 'REcommendations of product ' . PHP_EOL;
    }
}
