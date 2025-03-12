<div class="col-md-12">
    <label class="form-label" for="descricao">Descrição</label>
    <textarea class="form-control @error('descricao') is-invalid @enderror" id="descricao" name="descricao" rows="3"
        required>{{ isset($ordemDeServico) ? $ordemDeServico->descricao : old('descricao') }}</textarea>
    @error('descricao')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="col-md-6">
    <label class="form-label" for="user_id">Usuário</label>
    <select class="form-select @error('user_id') is-invalid @enderror" id="user_id" name="user_id" required>
        <option value="">Selecione um usuário</option>
        @foreach ($users as $user)
            <option value="{{ $user->id }}"
                {{ (isset($ordemDeServico) && $user->id == $ordemDeServico->user_id) || old('user_id') == $user->id ? 'selected' : '' }}>
                {{ $user->name }}
            </option>
        @endforeach
    </select>
    @error('user_id')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="col-md-6">
    <label class="form-label" for="status">Status</label>
    <select class="form-control form-select @error('status') is-invalid @enderror" id="status" name="status"
        required>
        <option value="">Selecione um status</option>
        @foreach ($statusValues as $status)
            <option value="{{ $status }}"
                {{ (isset($ordemDeServico) && $status == $ordemDeServico->status) || old('status') == $status ? 'selected' : '' }}>
                {{ $status }}
            </option>
        @endforeach
    </select>
    @error('status')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
