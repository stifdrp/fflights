<fieldset>
    <legend><h6>Dados Financeiros</h6></legend>
    <div class="form-row">
        <div class="form-group col">
            <label for="price">Valor da passagem</label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">R$</span>
                </div>
                <input type="text" class="form-control money @error('price') is-invalid @enderror"
                    id="price"  name="price" value="{{ $ticket->price ?? old('price') }}">
            </div>
        </div>

        <div class="form-group col">
            <label for="boardingTax">Taxa de embarque</label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">R$</span>
                </div>
                <input type="text" class="form-control money @error('boardingTax') is-invalid @enderror"
                    id="boardingTax"  name="boardingTax" value="{{ $ticket->boardingTax ?? old('boardingTax') }}">
            </div>
        </div>

        <div class="form-group col">
            <label for="agencyTax">Taxa de agenciamento</label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">R$</span>
                </div>
                <input type="text" class="form-control money @error('agencyTax') is-invalid @enderror"
                    id="agencyTax"  name="agencyTax" value="{{ $ticket->agencyTax ?? old('agencyTax') }}">
            </div>
        </div>
    </div>
</fieldset>

<div class="box-footer mt-3">
    <div class="row justify-content-between no-gutters">
        @isset($ticket)
            @if($ticket->order->inProgress())
                <div class="col-auto mr-auto mx-auto">
                    <button type="submit" class="btn btn-primary btn-block">
                            Atualizar
                    </button>
                </div>
            @endif
            <div class="col-auto mr-auto mx-auto">
                <a class="btn btn-info btn-close" href="{{ route('order.show', ['order' => $ticket->order]) }}">Voltar</a>
            </div>
        @endisset
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.min.js"></script>
<script>
    $(document).ready(function () {
        bsCustomFileInput.init();
        $('.money').mask('000.000.000.000.000,00', {reverse: true});
    });
  </script>
