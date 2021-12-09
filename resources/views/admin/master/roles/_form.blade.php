<div class="card-body">
    <div class="form-group">
        {!! Form::label('name', 'Name',['class'=> ''])!!}
        {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'name', 'placeholder' => 'Enter Name']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('display_name', 'Display Name',['class'=> ''])!!}
        {!! Form::text('display_name', null, ['class' => 'form-control', 'id' => 'display_name', 'placeholder' => 'Enter Display Name']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('description', 'Description',['class'=> ''])!!}
        {!! Form::text('description', null, ['class' => 'form-control', 'id' => 'description', 'placeholder' => 'Enter Description']) !!}
    </div>
</div>
<!-- /.card-body -->
<div class="card-footer">
    <button type="submit" class="btn btn-primary">Submit</button>
</div>