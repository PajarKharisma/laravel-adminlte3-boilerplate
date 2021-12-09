<div class="card-body">
    <div class="form-group">
        {!! Form::label('id', 'Username',['class'=> ''])!!}
        {!! Form::text('id', null, ['class' => 'form-control', 'id' => 'id', 'placeholder' => 'Masukan Username', "readonly" => isset($disabled) ? true : false]) !!}
    </div>

    <div class="form-group">
        {!! Form::label('name', 'Nama',['class'=> ''])!!}
        {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'name', 'placeholder' => 'Masukan Nama']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('email', 'Email',['class'=> ''])!!}
        {!! Form::email('email', null, ['class' => 'form-control', 'id' => 'email', 'placeholder' => 'Masukan Email']) !!}
    </div>

    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="Masukan Password">
    </div>


    <div class="form-group">
        <label for="customFile">Foto Profil</label>
        <div class="custom-file">
            <input type="file" class="custom-file-input" id="foto" name="foto">
            <label class="custom-file-label" for="customFile">Choose file</label>
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('roles', 'Hak Akses',['class'=> ''])!!}
        {!! Form::select('roles[]', $roles, null, ['class' => 'select2', 'multiple' => 'multiple', "style" => "width: 100%;"]) !!}
    </div>

</div>
<!-- /.card-body -->
<div class="card-footer">
    <button type="submit" class="btn btn-primary">Submit</button>
</div>