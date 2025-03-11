<div class="mb-4">
    <form id="filterForm" class="bg-white p-3 rounded shadow-sm">
        <div class="row g-2 align-items-center">
            <div class="col">
                <label for="filterStatus" class="form-label">Status</label>
                <select class="form-select form-select-sm" id="filterStatus" name="status">
                    <option value="">Todos</option>
                    @foreach ($statusValues as $status)
                        <option value="{{ $status }}">{{ $status }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col">
                <label for="filterUser" class="form-label">Usuário</label>
                <select class="form-select form-select-sm" id="filterUser" name="user_id">
                    <option value="">Todos</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary btn-sm">Filtrar</button>
            </div>
        </div>
    </form>
</div>
