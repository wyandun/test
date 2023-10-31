<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
<div>
    
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <form
        class="w-full max-w-sm p-4 mt-4 mb-4 bg-white border border-gray-200 rounded-lg shadow sm:p-6 dark:bg-gray-800 dark:border-gray-700">
        <input type="hidden" wire:model="invoice_id">
        <x-forms.select label="Product" name="product_id" value="{{ old('product_id') }}" data="{{$products}}" 
            required />
        <x-forms.select label="User" name="user_id" value="{{ old('user_id') }}" data="{{$users}}" 
            required />
        <x-forms.input type="text" label="Price" name="price" value="{{ old('price') }}"
            placeholder="Enter Price" required />
        <button wire:click.prevent="save()"
            class="px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Save</button>
        <button wire:click.prevent="cancel()"
            class="px-3 py-2 text-sm font-medium text-center text-white bg-red-700 rounded-lg hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">Cancel</button>
    </form>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        No.
                    </th>
                    <th scope="col" class="px-6 py-3">
                        User
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Product
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Price
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Action
                    </th>
                </tr>
            </thead>
            <tbody>
                @php
                    $i = (request()->input('page', 1) - 1) * 15;
                @endphp
                @foreach ($invoices as $key => $invoice)
                    <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                        <th scope="row"
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ ++$i }}
                        </th>
                        <td class="px-6 py-4">
                            {{ $invoice->user->name }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $invoice->product->name }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $invoice->price }}
                        </td>
                        <td class="px-6 py-4">
                            <button wire:click="edit({{ $invoice->id }})"
                                class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</button>
                            <button wire:click="delete({{ $invoice->id }})"
                                class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="p-3">
            {{ $invoices->links() }}
        </div>
    </div>
</div>
</x-app-layout>