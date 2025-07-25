   <!-- Modal Confirmar Exclusão -->
   <div class="modal fade" id="modalConfirmarExclusao" tabindex="-1" aria-labelledby="modalConfirmarExclusaoLabel"
       aria-hidden="true">
       <div class="modal-dialog">
           <div class="modal-content">
               <div class="modal-header bg-danger text-white">
                   <h5 class="modal-title" id="modalConfirmarExclusaoLabel">
                       <i class="fas fa-exclamation-triangle me-2"></i>Confirmar Exclusão
                   </h5>
                   <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                       aria-label="Close"></button>
               </div>
               <div class="modal-body">
                   <div class="text-center">
                       <i class="fas fa-exclamation-triangle text-danger mb-3" style="font-size: 3rem;"></i>
                       <h4 class="mb-3">Tem certeza?</h4>
                       <p class="mb-3">Você está prestes a excluir o compromisso:</p>
                       <p class="fw-bold text-danger" id="processo-exclusao"></p>
                       <p class="text-muted">Esta ação não pode ser desfeita!</p>
                   </div>
               </div>
               <div class="modal-footer">
                   <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                       <i class="fas fa-times me-1"></i>Cancelar
                   </button>
                   <button type="button" class="btn btn-danger" id="btnConfirmarExclusao">
                       <i class="fas fa-trash me-1"></i>Sim, Excluir
                   </button>
               </div>
           </div>
       </div>
   </div>
