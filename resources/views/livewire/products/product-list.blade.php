</tr>
</thead>
<tbody>
    @php
        $i = (request()->input('page', 1) - 1) * 15;
    @endphp
    @foreach ($products as $key => $product)
        <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
            <th scope="row"
                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                {{ ++$i }}
            </th>
            <td class="px-6 py-4">
                {{ $product->name }}
            </td>
            <td class="px-6 py-4">
                {{ $product->price }}
            </td>
            <td class="px-6 py-4">
                <button wire:click="edit({{ $product->id }})"
                    class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</button>
                <button wire:click="delete({{ $product->id }})"
                    class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Delete</button>
            </td>
        </tr>
    @endforeach
</tbody>
</table>
<div class="p-3">
{{ $products->links() }}
</div>
</div>
</div>