<fieldset
    @isset($order)
        @if($order->inElaboration())
            disabled
        @endif
    @endisset
>
    <div class="box-body">
        <div class="form-group">
            <label for="description">Descrição</label>
            <input type="text" class="form-control @error('description') is-invalid @enderror"
                id="descripton" name="description" value="{{ $order->description ?? old('description')  }}" placeholder="Coloque aqui a motivo da solicitação">
        </div>

        <div class="form-group no-gutters">
            <label>Verba</label>

            <select class="form-control col-sm-4 @error('description') is-invalid @enderror" name="budget">
                <option value='' disabled
                    @empty($order)
                        selected
                    @endempty

                hidden>Selecione uma opção</option>
            @foreach ($budgets as $budget)
                <option value="{{$budget->id}}"
                    @isset($order)
                        {{$order->budget_id == $budget->id ? 'selected="selected"' : ''}}
                    @endisset
                >{{$budget->title}}</option>
            @endforeach
            </select>
        </div>

    <!-- /.box-body -->

    <div class="box-footer">
        <div class="row justify-content-between no-gutters">
            @isset($order)
                @if($order->inElaboration())
                    <div class="col-auto mr-auto mx-auto">
                        <button type="submit" class="btn btn-primary btn-lg">
                            @empty($order)
                                Solicitar
                            @else
                                Atualizar
                            @endempty
                        </button>
                    </div>
                @endif
            @endisset
            <div class="col-auto mr-auto mx-auto">
                <a href="{{ route('orders.my') }}" class="btn btn-info btn-lg" role="button">Voltar</a>
            </div>
        </div>

    </div>
</fieldset>
