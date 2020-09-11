<div class="box-body">
    <div class="form-group">
        <label for="title">Verba</label>
        <input type="text" class="form-control @error('title') is-invalid @enderror"
            id="title" name="title" value="{{ $budget->title ?? old('title')  }}" placeholder="Nome da verba">
    </div>
<!-- /.box-body -->

<div class="box-footer">
    <button type="submit" class="btn btn-primary">Criar</button>
</div>
