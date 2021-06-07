<div class="modal fade" id="trecho" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalLabel">Valores</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form method="POST" action="{{route('ticket.fs', ['ticket' => $ticket, 'flightSegment' => $segment ?? '' ])}}">
                @csrf

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
            
                    <div class="form-group col">
                        <label for="discount">Desconto</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">R$</span>
                            </div>
                            <input type="text" class="form-control money @error('discount') is-invalid @enderror"
                                id="discount"  name="discount" value="{{ $ticket->discount ?? old('discount') }}">
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
</div>
