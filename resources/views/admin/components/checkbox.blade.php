<div class="">
    <div class="form-check">
       {{ Form::checkbox($name, 1,$status,['for'=>$label,'class' => 'form-check-input'])}}
       {{ Form::label($label, null, ['id'=>$label,'class' => 'form-check-label']) }}
    
    </div>
  </div>