@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-slate-200 focus:border-green-600 focus:ring-green-600 rounded-lg shadow-sm']) !!}>
