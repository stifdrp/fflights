<div class="box-body">
    <div class="form-group">
        <label for="description">Descrição</label>
        <input type="text" class="form-control @error('description') is-invalid @enderror"
            id="descripton" name="description" value="{{ $order->description ?? old('description')  }}" placeholder="Coloque aqui a motivo da solicitação">
    </div>

    <div class="form-group no-gutters">
        <label>Verba</label>
        <select class="form-control col-sm-4 @error('description') is-invalid @enderror" name="budget">
            <option value='' disabled selected hidden>Selecione uma opção</option>
          @foreach ($budgets as $budget)
            <option value="{{$budget->id}}">{{$budget->title}}</option>
          @endforeach
        </select>
      </div>

<!-- /.box-body -->

<div class="box-footer">
    <button type="submit" class="btn btn-primary">Solicitar</button>
</div>
