<?php
namespace App\Model;

class SalesModel
{
    /** @var array<int,array{id:string,client:string,product:string,qty:int,unit_price:float,date:string}> */
    private array $ventas;

    public function __construct(array $ventas)
    {
        $this->ventas = array_map(function ($v) {
            return [
                'id' => (string)($v['id'] ?? ''),
                'client' => (string)($v['client'] ?? ''),
                'product' => (string)($v['product'] ?? ''),
                'qty' => (int)($v['qty'] ?? 0),
                'unit_price' => (float)($v['unit_price'] ?? 0),
                'date' => (string)($v['date'] ?? '')
            ];
        }, $ventas);
    }

    public function totalSalesCount(): int
    {
        return count($this->ventas);
    }

    /** @return array{client:string,total:float}|null */
    public function topSpender(): ?array
    {
        $byClient = [];
        foreach ($this->ventas as $v) {
            $byClient[$v['client']] = ($byClient[$v['client']] ?? 0) + ($v['qty'] * $v['unit_price']);
        }
        if (!$byClient) return null;
        arsort($byClient);
        $c = array_key_first($byClient);
        return ['client' => (string)$c, 'total' => round((float)$byClient[$c], 2)];
    }

    /** @return array{product:string,qty:int}|null */
    public function topProductByQuantity(): ?array
    {
        $byProduct = [];
        foreach ($this->ventas as $v) {
            $byProduct[$v['product']] = ($byProduct[$v['product']] ?? 0) + $v['qty'];
        }
        if (!$byProduct) return null;
        arsort($byProduct);
        $p = array_key_first($byProduct);
        return ['product' => (string)$p, 'qty' => (int)$byProduct[$p]];
    }
}