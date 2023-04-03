<div class="mb-3 form-password-toggle">
    <div class="d-flex justify-content-between">
        {{ Form::label($name, null, ['class' => 'form-label']) }}
    </div>
    <div class="input-group input-group-merge">
        {{ Form::password($name, ['class' => 'form-control'. ($errors->has($name) ? ' is-invalid' : null), 'placeholder' => "&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"]) }}
        <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
    </div>
    @error($name)
    <p class="text-danger mt-2" style="text-transform:capitalize;">{{ $message }}</p>
    @enderror
</div>
