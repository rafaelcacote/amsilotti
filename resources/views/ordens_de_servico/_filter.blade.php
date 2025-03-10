<div class="accordion mb-4" id="filterAccordion">
    <div class="accordion-item">
        <h2 class="accordion-header" id="filterHeading">
            <button class="accordion-button" type="button" data-coreui-toggle="collapse" data-coreui-target="#filterCollapse" aria-expanded="true" aria-controls="filterCollapse">
                Filtro
            </button>
        </h2>
        <div id="filterCollapse" class="accordion-collapse collapse" aria-labelledby="filterHeading" data-coreui-parent="#filterAccordion">
            <div class="accordion-body">
                <form id="filterForm">
                    <div class="mb-3">
                        <label for="filterStatus" class="form-label">Status</label>
                        <select class="form-select" id="filterStatus" name="status">
                            <option value="">Todos</option>
                            @foreach($statusValues as $status)
                                <option value="{{ $status }}">{{ $status }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="filterUser" class="form-label">Usuário</label>
                        <select class="form-select" id="filterUser" name="user_id">
                            <option value="">Todos</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Filtrar</button>
                </form>
            </div>
        </div>
    </div>
</div>
