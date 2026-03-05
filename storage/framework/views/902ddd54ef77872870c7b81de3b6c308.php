<?php $__env->startSection('content'); ?>
    <div>
        <?php echo $__env->make('hima.hima', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </div>
     <!-- Modal Error -->
     <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('error')): ?>
     <div id="errorModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center z-50">
         <div class="bg-white rounded-lg shadow-lg w-full max-w-lg p-6">
             <!-- Header -->
             <div class="flex justify-between items-center border-b pb-3">
                 <h3 class="text-lg font-semibold text-red-600">Kesalahan</h3>
                 <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 transition">
                     <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                         <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                     </svg>
                 </button>
             </div>
     
             <!-- Body -->
             <div class="mt-4 text-gray-700">
                 <p><?php echo e(session('error')); ?></p>
             </div>
     
             <!-- Footer -->
             <div class="mt-6 flex justify-end">
                 <button onclick="closeModal()" class="bg-red-500 text-white px-4 py-2 rounded-lg shadow hover:bg-red-600 transition">
                     Tutup
                 </button>
             </div>
         </div>
     </div>
     <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('js'); ?>
    <!-- Script Modal -->
    <script>
        function closeModal() {
            document.getElementById('errorModal').classList.add('hidden');
        }
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Kegabutan\menyusahkan\pemira_26\resources\views\menu_vote.blade.php ENDPATH**/ ?>