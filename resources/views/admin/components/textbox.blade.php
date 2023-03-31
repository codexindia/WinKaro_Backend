<div class="form-group mb-3">
    {{ Form::label($name, null, ['class' => 'form-label']) }}
    {{ Form::text($name,$value, array_merge(['placeholder' => 'Enter '.str_replace('_', ' ', ucfirst($name)),'class' => 'form-control'. ($errors->has($name) ? ' is-invalid' : null)], $attributes)) }}
    @error($name)
    <p class="text-danger mt-2" style="text-transform:capitalize;">{{ $message }}</p>
    @enderror

</div>
