<?php

namespace App\Livewire\Invoices;

use Livewire\Component;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\User;
use Livewire\WithPagination;

class InvoiceList extends Component
{
    use WithPagination;

    public $user_id, $product_id, $price;
    public $invoice_id;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function render()
    {
        return view('livewire.invoices.invoice-list',[
            'invoices' => Invoice::paginate(15),
            'products' => Product::all(),
            'users' => User::all()
        ]);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    private function resetInputFields()
    {
        $this->user_id = '';
        $this->product_id = '';
        $this->price = '';
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function edit($id)
    {
        $invoice = Invoice::findOrFail($id);
        $this->invoice_id = $id;
        if ($invoice) {
            $this->product_id = $invoice_id->product_id;
            $this->user_id = $invoice_id->user_id;
            $this->price = $invoice_id->price;
        }
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function cancel()
    {
        $this->invoice_id = null;
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
            'product_id' => 'required',
            'user_id' => 'required',
            'price' => 'required',
        ]);

        $invoiceQuery = Invoice::query();
        if (!empty($validatedData['invoice_id'])) {
            $invoice = $invoiceQuery->find($validatedData['invoice_id']);
            if ($invoice) {
                $invoice->update($validatedData);
            }
        } else {
            $invoiceQuery->create($validatedData);
        }

        $this->invoice_id = null;
        session()->flash('message', 'Invoice Created Successfully.');
        $this->resetInputFields();
        $user = User::findOrFail($validatedData['user_id']);
        $product = Product::findOrFail($validatedData['product_id']);
        $price= $validatedData['price'];
        $content = [
            'subject' => 'Invoice created',
            'body' => 'The invoice was created',
            'product'=> $product->name,
            'user' => $user->name,
            'price'=> $price,
        ];

        Mail::to($user->email)->send(new SampleMail($content));

        return "Email has been sent.";
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function delete($id)
    {
        $invoice = Invoice::find($id);
        if ($invoice) {
            $invoice->delete();
        }
        session()->flash('message', 'Invoice Deleted Successfully.');
    }
}
