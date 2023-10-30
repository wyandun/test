@props(['type' => 'text', 'label', 'name', 'value','data'])

<div class="mb-6">
    <label for="{{ $name }}"
        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ $label }}</label>
    <select name="{{ $name }}" class="form-control" style="width: 100%">
            @foreach($data as $value)
            <option value="{{$value->id}}">{{$value->name}}</option>
            @endforeach
    </select>
</div>