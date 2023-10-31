<?php

namespace App\Livewire\Products;

use Livewire\Component;
use App\Models\Product;
use Illuminate\Support\Facades\Hash;
use Livewire\WithPagination;

class ProductList extends Component
{
    use WithPagination;

    public $name, $price;
    public $product_id;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function render()
    {
        return view('livewire.products.product-list',[
            'products' => Product::paginate(15)
        ]);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    private function resetInputFields()
    {
        $this->name = '';
        $this->price = '';
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $this->product_id = $id;
        if ($product) {
            $this->name = $product->name;
            $this->price = $product->price;
        }
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function cancel()
    {
        $this->product_id = null;
        $this->resetInputFields();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function save()
    {
        $validatedData = $this->validate([
            'name' => 'required',
            'price' => 'required',
            'product_id' => 'nullable'
        ]);

        $productQuery = Product::query();
        if (!empty($validatedData['product_id'])) {
            $product = $productQuery->find($validatedData['product_id']);
            if ($product) {
                $product->update($validatedData);
            }
        } else {
            $productQuery->create($validatedData);
        }

        $this->product_id = null;
        session()->flash('message', 'Product Created Successfully.');
        $this->resetInputFields();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function delete($id)
    {
        $product = Product::find($id);
        if ($product) {
            $product->delete();
        }
        session()->flash('message', 'Product Deleted Successfully.');
    }
}