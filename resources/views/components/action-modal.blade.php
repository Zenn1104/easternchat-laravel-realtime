<div>
    {{ $slot }}
</div>


@push('styles')
<style>
    .checkbox-label {
        cursor: pointer;
    }

    /* Styling when checkbox is checked */
    input[type="checkbox"]:checked + .checkbox-label {
        color: #3182ce; /* Change to your desired checked color */
        font-weight: bold; /* Optionally make it bold */
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('livewire:load', function () {
        Livewire.hook('message.processed', (message, component) => {
            // Handle checkbox changes after Livewire update
            const checkboxes = document.querySelectorAll('input[type="checkbox"]');
            checkboxes.forEach((checkbox) => {
                checkbox.addEventListener('change', function () {
                    if (this.checked) {
                        this.nextElementSibling.classList.add('checked');
                    } else {
                        this.nextElementSibling.classList.remove('checked');
                    }
                });
            });
        });
    });
</script>
@endpush