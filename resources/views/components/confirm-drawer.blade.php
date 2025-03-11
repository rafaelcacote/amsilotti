<div class="fixed inset-0 bg-black bg-opacity-50 z-50" x-data="{ isOpen: false }">
    <div class="fixed right-0 top-0 h-full w-96 bg-white shadow-lg transform transition-transform duration-300 ease-in-out" :class="{ 'translate-x-0': isOpen, 'translate-x-full': !isOpen }">
        <div class="p-6">
            <h3 class="text-lg font-semibold mb-4">Confirmar Exclusão</h3>
            <p class="mb-6">Tem certeza que deseja excluir este item?</p>
            <div class="flex justify-end space-x-4">
                <button @click="isOpen = false" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded hover:bg-gray-200">Cancelar</button>
                <button @click="$wire.deleteItem()" class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded hover:bg-red-700">Excluir</button>
            </div>
        </div>
    </div>
</div>
<style>
    @media (max-width: 640px) {
        .w-96 {
            width: 100%;
        }
    }
</style>