@props(['type', 'id'])

@auth
<button
    onclick="toggleWishlist('{{ $type }}', {{ $id }}, this)"
    data-in-wishlist="false"
    class="wishlist-btn absolute top-2 right-2 bg-white bg-opacity-90 hover:bg-opacity-100 rounded-full p-2 shadow-md transition-all duration-200 group z-10"
    title="Ajouter aux favoris">
    <svg class="w-6 h-6 text-gray-400 group-hover:text-red-500 transition-colors wishlist-icon" fill="none" stroke="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
    </svg>
</button>

<script>
// Check if item is already in wishlist on page load
(function() {
    const btn = document.querySelector('[data-in-wishlist][onclick*="{{ $type }}"][onclick*="{{ $id }}"]');
    if (btn) {
        checkWishlistStatus('{{ $type }}', {{ $id }}, btn);
    }
})();

function checkWishlistStatus(type, id, button) {
    fetch('{{ route("wishlist.check") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
        },
        body: JSON.stringify({ type: type, id: id })
    })
    .then(response => response.json())
    .then(data => {
        if (data.in_wishlist) {
            button.dataset.inWishlist = 'true';
            button.querySelector('.wishlist-icon').classList.add('text-red-500');
            button.querySelector('.wishlist-icon').setAttribute('fill', 'currentColor');
            button.title = 'Retirer des favoris';
        }
    })
    .catch(error => console.error('Error checking wishlist:', error));
}

function toggleWishlist(type, id, button) {
    const isInWishlist = button.dataset.inWishlist === 'true';
    const icon = button.querySelector('.wishlist-icon');

    if (isInWishlist) {
        // Remove from wishlist - we need to find the wishlist ID first
        // This is a simplified version - in production you'd want to store the wishlist ID
        console.log('Removing from wishlist not fully implemented - refresh wishlist page to remove');
        return;
    }

    // Add to wishlist
    fetch('{{ route("wishlist.store") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
        },
        body: JSON.stringify({ type: type, id: id })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            button.dataset.inWishlist = 'true';
            icon.classList.add('text-red-500');
            icon.setAttribute('fill', 'currentColor');
            button.title = 'Retirer des favoris';

            // Show success message
            showToast('Ajouté aux favoris', 'success');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('Erreur lors de l\'ajout aux favoris', 'error');
    });
}

function showToast(message, type) {
    const toast = document.createElement('div');
    toast.className = `fixed top-4 right-4 z-50 px-6 py-3 rounded-lg shadow-lg text-white ${type === 'success' ? 'bg-green-500' : 'bg-red-500'} transition-opacity duration-300`;
    toast.textContent = message;
    document.body.appendChild(toast);

    setTimeout(() => {
        toast.style.opacity = '0';
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}
</script>
@else
<a
    href="{{ route('login') }}"
    class="absolute top-2 right-2 bg-white bg-opacity-90 hover:bg-opacity-100 rounded-full p-2 shadow-md transition-all duration-200 group z-10"
    title="Connectez-vous pour ajouter aux favoris">
    <svg class="w-6 h-6 text-gray-400 group-hover:text-red-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
    </svg>
</a>
@endauth
